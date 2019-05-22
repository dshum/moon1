<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Moonlight\Utils\ErrorMessage;
use App\Mail\FeedbackMessage;
use App\Message;

class WelcomeController extends Controller
{
    public function message(Request $request)
    {
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
        $message->service_section_id = 2;

        DB::beginTransaction();

        try {
            $message->save();

            Mail::send(new FeedbackMessage($message));

            DB::commit();
        } catch (ErrorException $e) {
            ErrorMessage::send($e);

            DB::rollBack();
        }
        
        return redirect()->back()->with('status', 'sent');
    }

    public function index(Request $request)
    {
        return view('welcome');
    }
}
