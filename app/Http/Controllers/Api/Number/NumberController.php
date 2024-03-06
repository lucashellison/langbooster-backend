<?php

namespace App\Http\Controllers\Api\Number;

use App\Http\Controllers\Controller;
use App\Http\Repositories\MainInfoRepository;
use App\Models\GuestNumber;
use App\Models\Number;
use App\Models\UserNumber;
use App\Models\UserNumberReview;
use App\Services\FineDiff\FineDiff;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\NumberTopic;
use App\Http\Repositories\CheckAnswer\CheckAnswerRepository;
use App\Rules\WordsCount;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class NumberController extends Controller
{

    public function checkAnswer(Request $request)
    {


        $validated = $request->validate([
            'userInput' => ['nullable','string','max:255'],
            'numberId' => 'required|integer|exists:number,id',
            'userNumberId' => 'nullable|integer|exists:user_number,id',
            'guestNumberId' => 'nullable|integer|exists:guest_number,id',
        ]);

        $userInput = $validated['userInput'] ?? null;
        $numberId = $validated['numberId'];
        $userNumberId = $validated['userNumberId'] ?? null;
        $guestNumberId = $validated['guestNumberId'] ?? null;

        $userInput = $userInput ? strip_tags($validated['userInput']) : null;

        $checkAnswerRepository = new CheckAnswerRepository();

        $numberInfo = Number::find($numberId);

        $correctText = null;

        if($numberInfo){
            $correctText = $numberInfo->text;
        }

        $comparisonResult = $checkAnswerRepository->checkNumberResult($userInput,$correctText);

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
                if(!$userNumberId){
                    $userNumberModel = new UserNumber();

                    $userNumberModel->user_id = $userId;
                    $userNumberModel->ip_address = $ipAddress;
                    $userNumberModel->number_id = $numberId;
                    $userNumberModel->number_date = $currentDateHour;
                    $userNumberModel->score = $score;

                    $userNumberModel->save();

                    $userNumberId = $userNumberModel->getKey();
                }else{
                    $userNumber = UserNumber::find($userNumberId);
                    $userNumber->number_date = $currentDateHour;
                    $userNumber->score = $score;
                    $userNumber->save();
                }
            }else{
                if(!$guestNumberId){

                    $guestNumberModel = new GuestNumber();

                    $guestNumberModel->ip_address = $ipAddress;
                    $guestNumberModel->number_id = $numberId;
                    $guestNumberModel->number_date = $currentDateHour;
                    $guestNumberModel->score = $score;

                    $guestNumberModel->save();

                    $guestNumberId = $guestNumberModel->getKey();
                }else{
                    $guestNumber = GuestNumber::find($guestNumberId);
                    $guestNumber->number_date = $currentDateHour;
                    $guestNumber->score = $score;
                    $guestNumber->save();
                }

            }

            $comparisonResult = array_merge($comparisonResult,['userNumberId' => $userNumberId]);
            $comparisonResult = array_merge($comparisonResult,['guestNumberId' => $guestNumberId]);


        }



        return response()->json($comparisonResult);

    }



    public function getLessons(Request $request)
    {

        $validated = $request->validate([
            'numberTopicId' => 'nullable|integer|exists:number_topics,id',
            'languageVariantId' => 'required|integer|exists:language_variants,id',
            'quantityLessons' => 'required|integer|min:1',
            'reviewOnly' => 'required',
        ]);

        $numberTopicId = $validated['numberTopicId'];
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

        $number = $this->getLessonsList($numberTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,true,$reviewOnly);


        $qtyLessonsFound = sizeof($number);


        if($quantityLessons > $qtyLessonsFound && $userId){
            $qtyStillNecessary = $quantityLessons - $qtyLessonsFound;
            $otherNumbers = $this->getLessonsList($numberTopicId,$languageVariantId,$qtyStillNecessary,$userId,$isPremium,false,$reviewOnly);
        }else {
            $otherNumbers = collect();
        }

        $number = $number->merge($otherNumbers);


        $qtyLessonsFound = sizeof($number);

        if(!$qtyLessonsFound){
            return response()->json($number);
        }

        $finalNumber = [];

        if($qtyLessonsFound < $quantityLessons){
            do {
                foreach ($number as $dataNumber){
                    if($qtyLessonsFound < $quantityLessons){
                        $finalNumber[] = $dataNumber;
                    }
                    $qtyLessonsFound = sizeof($finalNumber);
                }
            } while($qtyLessonsFound < $quantityLessons);
            $finalNumber = collect($finalNumber);
        }else{
            $finalNumber = $number;
        }

        return response()->json($finalNumber);
    }


    private function getLessonsList($numberTopicId,$languageVariantId,$quantityLessons,$userId,$isPremium,$onlyNotDoneYet,$reviewOnly)
    {
        $query = DB::table('number')
            ->select('number.id', 'number.path_audio');

        if($userId){
            $query->addSelect(DB::raw("(SELECT review FROM user_number_review WHERE user_number_review.user_id = {$userId} and user_number_review.number_id = number.id LIMIT 1) as review"));
        }else{
            $query->addSelect(DB::raw("false as review"));
        }

        $query->where('enabled', 1)
            ->where('language_variant_id', $languageVariantId);

        if($userId){
            if($onlyNotDoneYet){
                $query->whereRaw("(SELECT COUNT(*) FROM user_number WHERE user_number.user_id = {$userId} AND user_number.number_id = number.id) = 0");
            }else{
                $query->whereRaw("(SELECT COUNT(*) FROM user_number WHERE user_number.user_id = {$userId} AND user_number.number_id = number.id) > 0");
            }
            if($reviewOnly){
                $query->whereRaw("(SELECT review FROM user_number_review WHERE user_number_review.user_id = {$userId} and user_number_review.number_id = number.id LIMIT 1) = true");
            }
        }


        if ($numberTopicId) {
            $query->where('number.number_topic_id', $numberTopicId);
        }

        if(!$isPremium){
            $query->where('number.premium',0);
        }


        $number = $query->inRandomOrder()
            ->limit($quantityLessons)
            ->get();

        foreach ($number as $numberData){
            $numberData->review = (bool) $numberData->review;
        }


        return $number;
    }



    public function markToReview(Request $request)
    {

        $validated = $request->validate([
            'numberId' => 'nullable|integer|exists:number,id',
            'mark' => 'required|boolean',
        ]);

        $numberId = $validated['numberId'];
        $mark = $validated['mark'];

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        $reviewUser = UserNumberReview::
            where('user_id',$userId)
            ->where('number_id',$numberId)
            ->first();

        if(!$reviewUser){
            $userNumbersReviewModel = new UserNumberReview();
            $userNumbersReviewModel->user_id = $userId;
            $userNumbersReviewModel->number_id = $numberId;
            $userNumbersReviewModel->review = $mark;

            $userNumbersReviewModel->save();
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
