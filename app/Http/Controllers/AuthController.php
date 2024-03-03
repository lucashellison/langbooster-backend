<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MainInfoRepository;
use App\Models\Currency;
use App\Models\PasswordReset;
use App\Models\Payment;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mailgun\Mailgun;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        if($request['email']){
            $request['email'] = trim(strtolower($request['email']));
        }

        if($request['name']){
            $request['name'] = ucwords(strtolower(trim(preg_replace('/\s+/', ' ', $request['name']))));
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'captcha' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $recaptchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . env('RECAPTCHA_SECRET_KEY') . '&response=' . $request->captcha);
        $recaptchaData = json_decode($recaptchaResponse);

        if (!$recaptchaData->success) {
            return response()->json(['captcha' => 'Invalid reCAPTCHA response.'], 400);
        }


        $mainInfoRepository = new MainInfoRepository();

        if (env('APP_ENV') !== 'local') {
            $clientIpAddress = $request->getClientIp();
        }else{
            $clientIpAddress = $mainInfoRepository->getUserIp();
        }


        $currencyUser = $mainInfoRepository->getCurrencyByIP($clientIpAddress);

        $currencyId = null;

        if(!$currencyUser) $currencyUser = env('CURRENCY_DEFAULT','USD');

        if($currencyUser){
            $currencyInfo = Currency::where('code',$currencyUser)->first();
            if($currencyInfo){
                $currencyId = $currencyInfo->id;
            }else{
                $currencyInfo = Currency::where('code',env('CURRENCY_DEFAULT','USD'))->first();
                if($currencyInfo){
                    $currencyId = $currencyInfo->id;
                }
            }
        }

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'currency_id' => $currencyId
            ]
        ));

        $names = explode(' ',$request['name']);
        $firstName = $names[0];


        $mgClient = Mailgun::create(env('MAILGUN_API_KEY'));
        $domain = env('MAILGUN_DOMAIN');
        $url = env('APP_URL_PAGE');

        # Render the email body from a Blade view.
        $markdown = new Markdown(view(), config('mail.markdown'));
        $html = $markdown->render('emails.welcome', ['firstName' => $firstName,'url' => $url]);

        # Make the call to the client.
        $result = $mgClient->messages()->send($domain, [
            'from'    => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
            'to'      => $request['email'],
            'subject' => "🚀 Welcome aboard, {$firstName}! Your journey to English mastery starts now",
            'html'    => $html
        ]);


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {

        if($request['email']){
            $request['email'] = strtolower($request['email']);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials. Please try again.'], 401);
        }

        return $this->createNewToken(auth()->user());
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    protected function createNewToken($user){
        $token = Auth::tokenById($user->id);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * (env('JWT_TTL')),
            'user' => auth()->user()
        ]);
    }


    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }

        $newRefreshToken = $this->createRefreshToken();

        return response()->json([
            'access_token' => $newToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * env('JWT_REFRESH_TOKEN_TTL')
        ]);
    }

    protected function createRefreshToken()
    {
        $newRefreshToken = Str::random(60);
        return $newRefreshToken;
    }


    public function isPremium()
    {

        $mainInfoRepository = new MainInfoRepository();
        $isPremium = $mainInfoRepository->isPremium();
        return response()->json([
           'isPremium' => $isPremium
        ]);

    }


    public function sendEmailResetPassword(Request $request)
    {
        if($request['email']){
            $request['email'] = trim(strtolower($request['email']));
        }

        $messages = [
            'email.exists' => 'The provided email address is not registered with us.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users,email',
        ], $messages);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        $token = Str::random(30);

        $user = User::where('email', $request['email'])->first();
        $userId = $user->id;


        $names = explode(' ',$user->name);
        $firstName = $names[0];



        $nowMinusOneSecond = Carbon::now()->subSecond();
        PasswordReset::
            where('user_id',$userId)
            ->where('used',false)
            ->update(['expires_at' => $nowMinusOneSecond]);



        $expiresAt = Carbon::now()->addDay();

        $passwordResetModel = new PasswordReset();

        $passwordResetModel->user_id = $userId;
        $passwordResetModel->token = $token;
        $passwordResetModel->expires_at = $expiresAt;

        $passwordResetModel->save();

        $resetPasswordId = $passwordResetModel->getKey();



        $mgClient = Mailgun::create(env('MAILGUN_API_KEY'));
        $domain = env('MAILGUN_DOMAIN');
        $url = env('APP_URL_PAGE') . '/resetPassword?id=' . base64_encode($resetPasswordId) . '&token=' . $token;


        # Render the email body from a Blade view.
        $markdown = new Markdown(view(), config('mail.markdown'));
        $html = $markdown->render('emails.resetPassword', ['firstName' => $firstName,'url' => $url]);

        # Make the call to the client.
        $result = $mgClient->messages()->send($domain, [
            'from'    => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
            'to'      => $request['email'],
            'subject' => "Password Reset Request",
            'html'    => $html
        ]);





        return response()->json([
            'message' => 'Success! The link to reset your password has been sent to your email.'
        ], 201);
    }

    public function checkResetPasswordTokenIsValid(Request $request)
    {
        try {
            if(!$request->id || !$request->token){
                return response()->json(['validToken' => false]);
            }

            $isValid = $this->isValidResetToken($request->id,$request->token);

            return response()->json(['validToken' => $isValid]);
        }catch (\Exception $e){
            return response()->json(['validToken' => false]);
        };
    }

    private function isValidResetToken(string $id,string $token): bool{
        try {

            $resetPasswordId = base64_decode($id);

            $isValid = (bool) PasswordReset::
            where('id',$resetPasswordId)
                ->where('token',$token)
                ->where('used',false)
                ->where('expires_at','>',now())
                ->first();

            return $isValid;
        }catch (\Exception $e){
            return false;
        };
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tokenId' => 'required|string',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if($validator->fails()){
            $firstError = $validator->errors()->first();
            return response()->json(['msgError' => $firstError], 400);
        }

        $validToken = $this->isValidResetToken($request['tokenId'],$request['token']);

        if(!$validToken){
            return response()->json(['msgError' => 'The token is invalid or has expired.'], 403);
        }

        $resetPasswordId = base64_decode($request['tokenId']);

        $userId =  PasswordReset::find($resetPasswordId)->user->id;

        $user = User::find($userId);
        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset = PasswordReset::find($resetPasswordId);
        $passwordReset->used = true;
        $passwordReset->save();

        return response()->json(['message' => 'Password successfully changed! You can now log in with your new password.']);

    }



}
