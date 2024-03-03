<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Currency;
use App\Models\DictationTopic;
use App\Models\LanguageVariant;
use App\Models\ListeningTopic;
use App\Models\Payment;
use App\Models\SpellingTopic;
use App\Models\NumberTopic;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Mailgun\Mailgun;
use App\Http\Repositories\MainInfoRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainInfoController extends Controller
{

    public function getLanguageVariant(): JsonResponse
    {
        $languageVariants = LanguageVariant::
            where('enabled', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json($languageVariants);
    }


    public function getTopics(): JsonResponse
    {

        $dictationTopics = DictationTopic::
        where('enabled', 1)
            ->where('learning_language_id',1)
            ->orderBy('sort_order')
            ->get();

        $listeningTopics = ListeningTopic::
        where('enabled', 1)
            ->where('learning_language_id',1)
            ->orderBy('sort_order')
            ->get();

        $spellingTopics = SpellingTopic::
        where('enabled', 1)
            ->where('learning_language_id',1)
            ->orderBy('sort_order')
            ->get();

        $numberTopics = NumberTopic::
        where('enabled', 1)
            ->where('learning_language_id',1)
            ->orderBy('sort_order')
            ->get();


        return response()->json([
            'dictation' => $dictationTopics,
            'listening' => $listeningTopics,
            'spelling' => $spellingTopics,
            'number' => $numberTopics,
        ]);

    }


    public function getCurrencies(): JsonResponse
    {
        $currencies = Currency::all();
        $defaultCurrencyId = null;
        foreach ($currencies as $currency){
            $currency->description = $currency->code . ' - ' . $currency->name;
            if($currency->code === env('CURRENCY_DEFAULT','USD')){
                $defaultCurrencyId = (int) $currency->id;
            }
        }
        return response()->json([
            'currencies' => $currencies,
            'defaultCurrencyId' => $defaultCurrencyId
        ]);
    }

    public function getCurrencyInfoById(Request $request)
    {

        $validated = $request->validate([
            'currencyId' => 'required|integer|exists:currencies,id'
        ]);

        $currencyId = $validated['currencyId'];


        $currency = Currency::find($currencyId);
        return response()->json($currency);
    }


    public function getUserCurrency(Request $request)
    {
        $mainInfoRepository = new MainInfoRepository();

        $clientIpAddress = $mainInfoRepository->getUserIp();
        $currencyUser = $mainInfoRepository->getCurrencyByIP($clientIpAddress);

        return response()->json(['currency' => $currencyUser]);
    }


    public function getUserOverview()
    {

        $user = JWTAuth::parseToken()->authenticate();

        $listeningAverageScore = $user->listening()->avg('score');
        $dictationAverageScore = $user->dictations()->avg('score');
        $spellingAverageScore = $user->spelling()->avg('score');
        $numberAverageScore = $user->number()->avg('score');

        $listeningQtyLessonsCompleted = $user->listening()->count();
        $dictationQtyLessonsCompleted = $user->dictations()->count();
        $spellingQtyLessonsCompleted = $user->spelling()->count();
        $numberQtyLessonsCompleted = $user->number()->count();

        if($listeningAverageScore) $listeningAverageScore = (float) round($listeningAverageScore,1);
        if($dictationAverageScore) $dictationAverageScore = (float) round($dictationAverageScore,1);
        if($spellingAverageScore) $spellingAverageScore = (float) round($spellingAverageScore,1);
        if($numberAverageScore) $numberAverageScore = (float) round($numberAverageScore,1);

        $data = [];

        $data[] = (object) [
            'name' => 'Listening',
            'score' => $listeningAverageScore,
            'lessonsCompleted' => $listeningQtyLessonsCompleted
        ];

        $data[] = (object) [
            'name' => 'Dictation',
            'score' => $dictationAverageScore,
            'lessonsCompleted' => $dictationQtyLessonsCompleted
        ];

        $data[] = (object) [
            'name' => 'Spelling',
            'score' => $spellingAverageScore,
            'lessonsCompleted' => $spellingQtyLessonsCompleted
        ];

        $data[] = (object) [
            'name' => 'Numbers',
            'score' => $numberAverageScore,
            'lessonsCompleted' => $numberQtyLessonsCompleted
        ];

        return response()->json($data);

    }

    public function getUserMembershipStatus()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user ? $user->id : null;

        $mainInfoRepository = new MainInfoRepository();

        $isPremium = $mainInfoRepository->isPremium();

        $membershipStatus = "Basic (free)";

        if ($isPremium) {
            $paymentInfo = Payment::where('user_id', $userId)
                ->orderBy('id', 'desc')
                ->first(['payment_date', 'subscription_end_date']);
            if($paymentInfo->payment_date && $paymentInfo->subscription_end_date){
                $paymentDate = Carbon::createFromFormat('Y-m-d H:i:s',$paymentInfo->payment_date)->format('Y.m.d');
                $subscriptionEndDate = Carbon::createFromFormat('Y-m-d H:i:s',$paymentInfo->subscription_end_date)->format('Y.m.d');

                $membershipStatus = "Premium ($paymentDate - $subscriptionEndDate)";
            }else{
                $membershipStatus = "Lifelong access to Premium features";
            }
        }

        return response()->json($membershipStatus);

    }





}
