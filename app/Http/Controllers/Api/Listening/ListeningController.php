<?php

namespace App\Http\Controllers\Api\Listening;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MainInfoRepository;
use App\Models\GuestListening;
use App\Models\Listening;
use App\Models\UserListening;
use App\Models\UserListeningReview;
use App\Services\FineDiff\FineDiff;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ListeningTopic;
use App\Http\Repositories\CheckAnswer\CheckAnswerRepository;
use App\Rules\WordsCount;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ListeningController extends Controller
{


    public function checkAnswer(Request $request)
    {


        $validated = $request->validate([
            'userInput' => ['nullable','string','max:255'],
            'listeningId' => 'required|integer|exists:listening,id',
            'userListeningId' => 'nullable|integer|exists:user_listening,id',
            'guestListeningId' => 'nullable|integer|exists:guest_listening,id',
        ]);

        $userInput = $validated['userInput'] ?? null;
        $listeningId = $validated['listeningId'];
        $userListeningId = $validated['userListeningId'] ?? null;
        $guestListeningId = $validated['guestListeningId'] ?? null;


        $userInput = $userInput ? strip_tags($validated['userInput']) : null;


        $checkAnswerRepository = new CheckAnswerRepository();

        $listeningInfo = Listening::find($listeningId);

        $correctText = null;

        if($listeningInfo){
            $correctText = $listeningInfo->text;
        }


        $comparisonResult = $checkAnswerRepository->checkListeningResult($userInput,$correctText);



        if($comparisonResult){

            $userId = null;
            try {
                if ($token = JWTAuth::getToken()) {
                    $user = JWTAuth::parseToken()->authenticate();
                    $userId = $user ? $user->id : null;
                }
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {}

            $score = $comparisonResult['points'];
            $currentDateHour = Carbon::now();

            $ipAddress = $request->getClientIp();

            if($userId){
                if(!$userListeningId){
                    $userListeningModel = new UserListening();

                    $userListeningModel->user_id = $userId;
                    $userListeningModel->ip_address = $ipAddress;
                    $userListeningModel->listening_id = $listeningId;
                    $userListeningModel->listening_date = $currentDateHour;
                    $userListeningModel->score = $score;

                    $userListeningModel->save();

                    $userListeningId = $userListeningModel->getKey();
                }else{
                    $userListening = UserListening::find($userListeningId);
                    $userListening->listening_date = $currentDateHour;
                    $userListening->score = $score;
                    $userListening->save();
                }
            }else{
                if(!$guestListeningId){

                    $guestListeningModel = new GuestListening();

                    $guestListeningModel->ip_address = $ipAddress;
                    $guestListeningModel->listening_id = $listeningId;
                    $guestListeningModel->listening_date = $currentDateHour;
                    $guestListeningModel->score = $score;

                    $guestListeningModel->save();

                    $guestListeningId = $guestListeningModel->getKey();
                }else{
                    $guestListening = GuestListening::find($guestListeningId);
                    $guestListening->listening_date = $currentDateHour;
                    $guestListening->score = $score;
                    $guestListening->save();
                }

            }

            $comparisonResult = array_merge($comparisonResult,['userListeningId' => $userListeningId]);
            $comparisonResult = array_merge($comparisonResult,['guestListeningId' => $guestListeningId]);


        }



        return response()->json($comparisonResult);

    }



    public function getLessons(Request $request)
    {

        $validated = $request->validate([
            'listeningTopicId' => 'nullable|integer|exists:listening_topics,id',
            'languageVariantId' => 'required|integer|exists:language_variants,id',
            'quantityLessons' => 'required|integer|min:1',
            'reviewOnly' => 'required',
        ]);

        $listeningTopicId = $validated['listeningTopicId'];
        $languageVariantId = $validated['languageVariantId'];
        $quantityLessons = $validated['quantityLessons'];
        $reviewOnly = $validated['reviewOnly'];


        $reviewOnly = $reviewOnly === 'true' || $reviewOnly === true;


        $limitLessons = env('LISTENING_LESSONS_LIMIT',9999);
        if($quantityLessons > $limitLessons){
            return response()->json(['msgError' => "The maximum number of lessons allowed is $limitLessons. Please enter a smaller number"], 400);
        }

        $userId = null;
        try {
            if ($token = JWTAuth::getToken()) {
                $user = JWTAuth::parseToken()->authenticate();
                $userId = $user ? $user->id : null;
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {}



        $mainInfoRepository = new MainInfoRepository();
        $isPremium = $mainInfoRepository->isPremium();

        $listening = $this->getLessonsList($listeningTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,true,$reviewOnly);


        $qtyLessonsFound = sizeof($listening);


        if($quantityLessons > $qtyLessonsFound && $userId){
            $qtyStillNecessary = $quantityLessons - $qtyLessonsFound;
            $otherListenings = $this->getLessonsList($listeningTopicId,$languageVariantId,$qtyStillNecessary,$userId,$isPremium,false,$reviewOnly);
        }else {
            $otherListenings = collect();
        }

        $listening = $listening->merge($otherListenings);


        $qtyLessonsFound = sizeof($listening);

        if(!$qtyLessonsFound){
            return response()->json($listening);
        }

        $finalListening = [];

        if($qtyLessonsFound < $quantityLessons){
            do {
                foreach ($listening as $dataListening){
                    if($qtyLessonsFound < $quantityLessons){
                        $finalListening[] = $dataListening;
                    }
                    $qtyLessonsFound = sizeof($finalListening);
                }
            } while($qtyLessonsFound < $quantityLessons);
            $finalListening = collect($finalListening);
        }else{
            $finalListening = $listening;
        }

        return response()->json($finalListening);
    }


    private function getLessonsList($listeningTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,$onlyNotDoneYet,$reviewOnly)
    {
        $query = DB::table('listening')
            ->select('listening.id', 'listening.path_audio');

        if($userId){
            $query->addSelect(DB::raw("(SELECT review FROM user_listening_review WHERE user_listening_review.user_id = {$userId} and user_listening_review.listening_id = listening.id LIMIT 1) as review"));
        }else{
            $query->addSelect(DB::raw("false as review"));
        }

        $query->where('enabled', 1)
            ->where('language_variant_id', $languageVariantId);

        if($userId){
            if($onlyNotDoneYet){
                $query->whereRaw("(SELECT COUNT(*) FROM user_listening WHERE user_listening.user_id = {$userId} AND user_listening.listening_id = listening.id) = 0");
            }else{
                $query->whereRaw("(SELECT COUNT(*) FROM user_listening WHERE user_listening.user_id = {$userId} AND user_listening.listening_id = listening.id) > 0");
            }
            if($reviewOnly){
                $query->whereRaw("(SELECT review FROM user_listening_review WHERE user_listening_review.user_id = {$userId} and user_listening_review.listening_id = listening.id LIMIT 1) = true");
            }
        }


        if ($listeningTopicId) {
            $query->where('listening.listening_topic_id', $listeningTopicId);
        }

        if(!$isPremium){
            $query->where('listening.premium',0);
        }


        $listening = $query->inRandomOrder()
            ->limit($quantityLessons)
            ->get();

        foreach ($listening as $listeningData){
            $listeningData->review = (bool) $listeningData->review;
        }


        return $listening;
    }



    public function markToReview(Request $request)
    {

        $validated = $request->validate([
            'listeningId' => 'nullable|integer|exists:listening,id',
            'mark' => 'required|boolean',
        ]);

        $listeningId = $validated['listeningId'];
        $mark = $validated['mark'];

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $reviewUser = UserListeningReview::
            where('user_id',$userId)
            ->where('listening_id',$listeningId)
            ->first();

        if(!$reviewUser){
            $userListeningsReviewModel = new UserListeningReview();
            $userListeningsReviewModel->user_id = $userId;
            $userListeningsReviewModel->listening_id = $listeningId;
            $userListeningsReviewModel->review = $mark;

            $userListeningsReviewModel->save();
        }else{
            $reviewUser->review = $mark;
            $reviewUser->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Review status updated successfully.'
        ]);
    }





}
