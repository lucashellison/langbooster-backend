<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mailgun\Mailgun;

class ContactController extends Controller
{
    public function sendContactMail(Request $request)
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:10000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Recupera os dados do request
        $name = $request->name;
        $email = $request->email;
        $userMessage = $request->message;

        $userMessage = nl2br(e($userMessage));

        // Instancia o cliente do Mailgun
        $mgClient = Mailgun::create(env('MAILGUN_API_KEY'));
        $domain = env('MAILGUN_DOMAIN');

        // Renderiza o corpo do e-mail a partir de uma view Blade
        $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));
        $html = $markdown->render('emails.contact', ['name' => $name, 'email' => $email, 'message' => $userMessage]);

        // Faz a chamada para o cliente Mailgun
        $result = $mgClient->messages()->send($domain, [
            'from'    => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
            'to'      => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
            'subject' => "New Contact Message from {$name}",
            'html'    => $html
        ]);





        $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));
        $html = $markdown->render('emails.contactReplyUser', []);

        // Faz a chamada para o cliente Mailgun
        $result = $mgClient->messages()->send($domain, [
            'from'    => 'LangBooster <'.env('EMAIL_ADDRESS_CONTACT').'>',
            'to'      => $email,
            'subject' => "Thank You for Contacting LangBooster!",
            'html'    => $html
        ]);

        dd('here');


        // Resposta após o envio do e-mail
        if ($result) {
            return response()->json(['message' => 'Your message has been sent successfully!'], 200);
        } else {
            return response()->json(['message' => 'There was a problem sending your message. Please try again later.'], 500);
        }
    }
}
