<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MainInfoController;
use App\Http\Controllers\Api\Dictation\DictationController;
use App\Http\Controllers\Api\Listening\ListeningController;
use App\Http\Controllers\Api\Number\NumberController;
use App\Http\Controllers\Api\Spelling\SpellingController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('sendEmailResetPassword',[AuthController::class,'sendEmailResetPassword'])->middleware('throttle:5,1');
    Route::get('checkResetPasswordTokenIsValid',[AuthController::class,'checkResetPasswordTokenIsValid']);
    Route::post('resetPassword',[AuthController::class,'resetPassword']);
    Route::get('isPremium', [AuthController::class, 'isPremium']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::prefix('mainInfo')->group(function (){

    Route::get('getLanguageVariant',[MainInfoController::class,'getLanguageVariant']);
    Route::get('getTopics',[MainInfoController::class,'getTopics']);


    Route::get('getUserCurrency',[MainInfoController::class,'getUserCurrency']);
    Route::get('getCurrencies',[MainInfoController::class,'getCurrencies']);
    Route::get('getCurrencyInfoById',[MainInfoController::class,'getCurrencyInfoById']);


    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('getUserOverview',[MainInfoController::class,'getUserOverview']);
        Route::get('getUserMembershipStatus',[MainInfoController::class,'getUserMembershipStatus']);
    });

});

Route::prefix('listening')->group(function (){

    Route::get('checkAnswer',[ListeningController::class,'checkAnswer']);
    Route::get('getLessons',[ListeningController::class,'getLessons']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('markToReview',[ListeningController::class,'markToReview']);
    });

});




Route::prefix('dictation')->group(function (){

    Route::get('checkAnswer',[DictationController::class,'checkAnswer']);
    Route::get('getLessons',[DictationController::class,'getLessons']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('markToReview',[DictationController::class,'markToReview']);
    });

});


Route::prefix('spelling')->group(function (){

    Route::get('checkAnswer',[SpellingController::class,'checkAnswer']);
    Route::get('getLessons',[SpellingController::class,'getLessons']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('markToReview',[SpellingController::class,'markToReview']);
    });

});


Route::prefix('number')->group(function (){

    Route::get('checkAnswer',[NumberController::class,'checkAnswer']);
    Route::get('getLessons',[NumberController::class,'getLessons']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('markToReview',[NumberController::class,'markToReview']);
    });

});


Route::prefix('user')->group(function (){
    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('updateUserName',[UserController::class,'updateUserName']);
    });
});


Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/createPaymentIntent', [PaymentController::class, 'createPaymentIntent']);
    Route::post('/paymentUpdateStatus', [PaymentController::class, 'paymentUpdateStatus']);
});


Route::post('sendContactMail',[ContactController::class,'sendContactMail'])->middleware('throttle:5,1');
