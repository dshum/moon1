<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMessage;
use App\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Moonlight\Utils\ErrorMessage;

class WelcomeController extends Controller
{
    public function message(Request $request)
    {
        $recaptchaResponse = 'success';

        try {
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $data = [
                'secret' => config('services.recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response'),
            ];

            $options = [
                'http' => [
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $resultJson = json_decode($result);

            if ($resultJson->success !== true) {
                $recaptchaResponse = 'fail';
                // return redirect()->back()->with('error', 'recaptcha');
            }
        } catch (Exception $e) {
            ErrorMessage::send($e);

            return redirect()->back()->with('error', 'recaptcha');
        }

        $request->validate([
            'message' => 'required',
            'face' => 'required',
            'email' => 'required|email',
        ], [
            'message.required' => 'Введите сообщение.',
            'face.required' => 'Введите имя.',
            'email.required' => 'Укажите электронную почту для ответа.',
            'email.email' => 'Некорректный адрес электронной почты.',
        ]);

        $message = new Message;

        $message->name = 'Сообщение';
        $message->face = $request->input('face');
        $message->email = $request->input('email');
        $message->message = $request->input('message');
        $message->recaptcha_response = $recaptchaResponse;
        $message->ip = $request->ip();
        $message->service_section_id = 2;

        DB::beginTransaction();

        try {
            $message->save();

            Mail::send(new FeedbackMessage($message));

            DB::commit();
        } catch (Exception $e) {
            ErrorMessage::send($e);

            DB::rollBack();
        }

        return redirect()->back()->with('status', 'sent');
    }

    public function index(Request $request)
    {
        $key = config('services.recaptcha.key');

        return view('welcome', [
            'key' => $key,
        ]);
    }
}
