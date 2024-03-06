<?php

namespace App\Http\Controllers\Api\Spelling;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MainInfoRepository;
use App\Models\GuestSpelling;
use App\Models\Spelling;
use App\Models\UserSpelling;
use App\Models\UserSpellingReview;
use App\Services\FineDiff\FineDiff;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\SpellingTopic;
use App\Http\Repositories\CheckAnswer\CheckAnswerRepository;
use App\Rules\WordsCount;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class SpellingController extends Controller
{

    public function checkAnswer(Request $request)
    {


        $validated = $request->validate([
            'userInput' => ['nullable','string','max:255'],
            'spellingId' => 'required|integer|exists:spelling,id',
            'userSpellingId' => 'nullable|integer|exists:user_spelling,id',
            'guestSpellingId' => 'nullable|integer|exists:guest_spelling,id',
        ]);

        $userInput = $validated['userInput'] ?? null;
        $spellingId = $validated['spellingId'];
        $userSpellingId = $validated['userSpellingId'] ?? null;
        $guestSpellingId = $validated['guestSpellingId'] ?? null;

        $userInput = $userInput ? strip_tags($validated['userInput']) : null;


        $checkAnswerRepository = new CheckAnswerRepository();

        $spellingInfo = Spelling::find($spellingId);

        $correctText = null;

        if($spellingInfo){
            $correctText = $spellingInfo->text;
        }

        $comparisonResult = $checkAnswerRepository->checkSpellingResult($userInput,$correctText);

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
                if(!$userSpellingId){
                    $userSpellingModel = new UserSpelling();

                    $userSpellingModel->user_id = $userId;
                    $userSpellingModel->ip_address = $ipAddress;
                    $userSpellingModel->spelling_id = $spellingId;
                    $userSpellingModel->spelling_date = $currentDateHour;
                    $userSpellingModel->score = $score;

                    $userSpellingModel->save();

                    $userSpellingId = $userSpellingModel->getKey();
                }else{
                    $userSpelling = UserSpelling::find($userSpellingId);
                    $userSpelling->spelling_date = $currentDateHour;
                    $userSpelling->score = $score;
                    $userSpelling->save();
                }
            }else{
                if(!$guestSpellingId){

                    $guestSpellingModel = new GuestSpelling();

                    $guestSpellingModel->ip_address = $ipAddress;
                    $guestSpellingModel->spelling_id = $spellingId;
                    $guestSpellingModel->spelling_date = $currentDateHour;
                    $guestSpellingModel->score = $score;

                    $guestSpellingModel->save();

                    $guestSpellingId = $guestSpellingModel->getKey();
                }else{
                    $guestSpelling = GuestSpelling::find($guestSpellingId);
                    $guestSpelling->spelling_date = $currentDateHour;
                    $guestSpelling->score = $score;
                    $guestSpelling->save();
                }

            }

            $comparisonResult = array_merge($comparisonResult,['userSpellingId' => $userSpellingId]);
            $comparisonResult = array_merge($comparisonResult,['guestSpellingId' => $guestSpellingId]);


        }



        return response()->json($comparisonResult);

    }



    public function getLessons(Request $request)
    {

        $validated = $request->validate([
            'spellingTopicId' => 'nullable|integer|exists:spelling_topics,id',
            'languageVariantId' => 'required|integer|exists:language_variants,id',
            'quantityLessons' => 'required|integer|min:1',
            'reviewOnly' => 'required',
        ]);

        $spellingTopicId = $validated['spellingTopicId'];
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

        $spelling = $this->getLessonsList($spellingTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,true,$reviewOnly);


        $qtyLessonsFound = sizeof($spelling);


        if($quantityLessons > $qtyLessonsFound && $userId){
            $qtyStillNecessary = $quantityLessons - $qtyLessonsFound;
            $otherSpellings = $this->getLessonsList($spellingTopicId,$languageVariantId,$qtyStillNecessary,$userId,$isPremium,false,$reviewOnly);
        }else {
            $otherSpellings = collect();
        }

        $spelling = $spelling->merge($otherSpellings);


        $qtyLessonsFound = sizeof($spelling);

        if(!$qtyLessonsFound){
            return response()->json($spelling);
        }

        $finalSpelling = [];

        if($qtyLessonsFound < $quantityLessons){
            do {
                foreach ($spelling as $dataSpelling){
                    if($qtyLessonsFound < $quantityLessons){
                        $finalSpelling[] = $dataSpelling;
                    }
                    $qtyLessonsFound = sizeof($finalSpelling);
                }
            } while($qtyLessonsFound < $quantityLessons);
            $finalSpelling = collect($finalSpelling);
        }else{
            $finalSpelling = $spelling;
        }

        return response()->json($finalSpelling);
    }


    private function getLessonsList($spellingTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,$onlyNotDoneYet,$reviewOnly)
    {
        $query = DB::table('spelling')
            ->select('spelling.id', 'spelling.path_normal_audio', 'spelling.path_spelled_audio');

        if($userId){
            $query->addSelect(DB::raw("(SELECT review FROM user_spelling_review WHERE user_spelling_review.user_id = {$userId} and user_spelling_review.spelling_id = spelling.id LIMIT 1) as review"));
        }else{
            $query->addSelect(DB::raw("false as review"));
        }

        $query->where('enabled', 1)
            ->where('language_variant_id', $languageVariantId);

        if($userId){
            if($onlyNotDoneYet){
                $query->whereRaw("(SELECT COUNT(*) FROM user_spelling WHERE user_spelling.user_id = {$userId} AND user_spelling.spelling_id = spelling.id) = 0");
            }else{
                $query->whereRaw("(SELECT COUNT(*) FROM user_spelling WHERE user_spelling.user_id = {$userId} AND user_spelling.spelling_id = spelling.id) > 0");
            }
            if($reviewOnly){
                $query->whereRaw("(SELECT review FROM user_spelling_review WHERE user_spelling_review.user_id = {$userId} and user_spelling_review.spelling_id = spelling.id LIMIT 1) = true");
            }
        }


        if ($spellingTopicId) {
            $query->where('spelling.spelling_topic_id', $spellingTopicId);
        }

        if(!$isPremium){
            $query->where('spelling.premium',0);
        }


        $spelling = $query->inRandomOrder()
            ->limit($quantityLessons)
            ->get();

        foreach ($spelling as $spellingData){
            $spellingData->review = (bool) $spellingData->review;
        }


        return $spelling;
    }



    public function markToReview(Request $request)
    {

        $validated = $request->validate([
            'spellingId' => 'nullable|integer|exists:spelling,id',
            'mark' => 'required|boolean',
        ]);

        $spellingId = $validated['spellingId'];
        $mark = $validated['mark'];

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $reviewUser = UserSpellingReview::
            where('user_id',$userId)
            ->where('spelling_id',$spellingId)
            ->first();

        if(!$reviewUser){
            $userSpellingsReviewModel = new UserSpellingReview();
            $userSpellingsReviewModel->user_id = $userId;
            $userSpellingsReviewModel->spelling_id = $spellingId;
            $userSpellingsReviewModel->review = $mark;

            $userSpellingsReviewModel->save();
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
