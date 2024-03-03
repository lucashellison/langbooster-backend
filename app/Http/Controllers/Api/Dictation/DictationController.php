<?php

namespace App\Http\Controllers\Api\Dictation;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MainInfoRepository;
use App\Models\Dictation;
use App\Models\GuestDictation;
use App\Models\GuestListening;
use App\Models\UserDictation;
use App\Models\UserDictationsReview;
use App\Services\FineDiff\FineDiff;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\DictationTopic;
use App\Http\Repositories\CheckAnswer\CheckAnswerRepository;
use App\Rules\WordsCount;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class DictationController extends Controller
{

    public function checkAnswer(Request $request)
    {

        $validated = $request->validate([
            'userInput' => ['required','string','max:1500',new WordsCount(10)],
            'dictationId' => 'required|integer|exists:dictations,id',
            'userDictationId' => 'nullable|integer|exists:user_dictations,id',
            'guestDictationId' => 'nullable|integer|exists:guest_dictations,id',
        ]);

        $userInput = $validated['userInput'];
        $dictationId = $validated['dictationId'];
        $userDictationId = $validated['userDictationId'] ?? null;
        $guestDictationId = $validated['guestDictationId'] ?? null;

        $userInput = strip_tags($validated['userInput']);


        $checkAnswerRepository = new CheckAnswerRepository();

        $dictationInfo = Dictation::find($dictationId);
        $correctText = null;

        if($dictationInfo){
            $correctText = $dictationInfo->text;
        }

        $comparisonResult = $checkAnswerRepository->getComparisonResult($correctText,$userInput);

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
                if(!$userDictationId){
                    $userDictationModel = new UserDictation();

                    $userDictationModel->user_id = $userId;
                    $userDictationModel->ip_address = $ipAddress;
                    $userDictationModel->dictation_id = $dictationId;
                    $userDictationModel->dictation_date = $currentDateHour;
                    $userDictationModel->score = $score;

                    $userDictationModel->save();

                    $userDictationId = $userDictationModel->getKey();
                }else{
                    $userDictation = UserDictation::find($userDictationId);
                    $userDictation->dictation_date = $currentDateHour;
                    $userDictation->score = $score;
                    $userDictation->save();
                }
            }else{
                if(!$guestDictationId){

                    $guestDictationModel = new GuestDictation();

                    $guestDictationModel->ip_address = $ipAddress;
                    $guestDictationModel->dictation_id = $dictationId;
                    $guestDictationModel->dictation_date = $currentDateHour;
                    $guestDictationModel->score = $score;

                    $guestDictationModel->save();

                    $guestDictationId = $guestDictationModel->getKey();
                }else{
                    $guestDictation = GuestDictation::find($guestDictationId);
                    $guestDictation->dictation_date = $currentDateHour;
                    $guestDictation->score = $score;
                    $guestDictation->save();
                }
            }


            $comparisonResult = array_merge($comparisonResult,['userDictationId' => $userDictationId]);
            $comparisonResult = array_merge($comparisonResult,['guestDictationId' => $guestDictationId]);



        }



        return response()->json($comparisonResult);

    }



    public function getLessons(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'dictationTopicId' => 'nullable|integer|exists:dictation_topics,id',
            'languageVariantId' => 'required|integer|exists:language_variants,id',
            'quantityLessons' => 'required|integer|min:1',
            'reviewOnly' => 'required',
        ]);

        $dictationTopicId = $validated['dictationTopicId'];
        $languageVariantId = $validated['languageVariantId'];
        $quantityLessons = $validated['quantityLessons'];
        $reviewOnly = $validated['reviewOnly'];

        $reviewOnly = $reviewOnly === 'true' || $reviewOnly === true;

        $limitLessons = env('DICTATION_LESSONS_LIMIT',9999);
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

        if($quantityLessons > 1 && !$isPremium){
            return response()->json(['msgError' => 'Free plan users can only take 1 lesson at a time'], 400);
        }

        $dictations = $this->getLessonsList($dictationTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,true,$reviewOnly);

        $qtyLessonsFound = sizeof($dictations);

        if($quantityLessons > $qtyLessonsFound && $userId){
            $qtyStillNecessary = $quantityLessons - $qtyLessonsFound;
            $otherDictations = $this->getLessonsList($dictationTopicId,$languageVariantId,$qtyStillNecessary,$userId,$isPremium,false,$reviewOnly);
        }else {
            $otherDictations = collect();
        }

        $dictations = $dictations->merge($otherDictations);

        $qtyLessonsFound = sizeof($dictations);

        if(!$qtyLessonsFound){
            return response()->json($dictations);
        }

        $finalDictation = [];

        if($qtyLessonsFound < $quantityLessons){
            do {
                foreach ($dictations as $dataDictation){
                    if($qtyLessonsFound < $quantityLessons){
                        $finalDictation[] = $dataDictation;
                    }
                    $qtyLessonsFound = sizeof($finalDictation);
                }
            } while($qtyLessonsFound < $quantityLessons);
            $finalDictation = collect($finalDictation);
        }else{
            $finalDictation = $dictations;
        }

        return response()->json($finalDictation);
    }


    private function getLessonsList($dictationTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,$onlyNotDoneYet,$reviewOnly)
    {
        $query = DB::table('dictations')
            ->select('dictations.id', 'dictations.path_audio', 'dictations.title');

        if($userId){
            $query->addSelect(DB::raw("(SELECT review FROM user_dictations_review WHERE user_dictations_review.user_id = {$userId} and user_dictations_review.dictation_id = dictations.id LIMIT 1) as review"));
        }else{
            $query->addSelect(DB::raw("false as review"));
        }

        $query->where('enabled', 1)
        ->where('language_variant_id', $languageVariantId);

        if($userId) {
            if ($onlyNotDoneYet) {
                $query->whereRaw("(SELECT COUNT(*) FROM user_dictations WHERE user_dictations.user_id = {$userId} AND user_dictations.dictation_id = dictations.id) = 0");
            } else {
                $query->whereRaw("(SELECT COUNT(*) FROM user_dictations WHERE user_dictations.user_id = {$userId} AND user_dictations.dictation_id = dictations.id) > 0");
            }

            if ($reviewOnly) {
                $query->whereRaw("(SELECT review FROM user_dictations_review WHERE user_dictations_review.user_id = {$userId} and user_dictations_review.dictation_id = dictations.id LIMIT 1) = true");
            }
        }

        if ($dictationTopicId) {
            $query->where('dictations.dictation_topic_id', $dictationTopicId);
        }

        if(!$isPremium){
            $query->where('dictations.premium',0);
        }

        $dictations = $query->inRandomOrder()
            ->limit($quantityLessons)
            ->get();


        foreach ($dictations as $dictation){
            $dictation->review = (bool) $dictation->review;
        }

        return $dictations;
    }



    public function markToReview(Request $request)
    {

        $validated = $request->validate([
            'dictationId' => 'nullable|integer|exists:dictations,id',
            'mark' => 'required|boolean',
        ]);

        $dictationId = $validated['dictationId'];
        $mark = $validated['mark'];

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $reviewUser = UserDictationsReview::
            where('user_id',$userId)
            ->where('dictation_id',$dictationId)
            ->first();

        if(!$reviewUser){
            $userDictationsReviewModel = new UserDictationsReview();
            $userDictationsReviewModel->user_id = $userId;
            $userDictationsReviewModel->dictation_id = $dictationId;
            $userDictationsReviewModel->review = $mark;

            $userDictationsReviewModel->save();
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
