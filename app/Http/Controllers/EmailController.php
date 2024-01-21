<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\SendEmail;
use App\Mail\TwoFACode;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class EmailController extends Controller
{
    public function GoToFeedback()
    {
        return redirect('/feedback');
    }

    public function newCode(Request $request)
    {
        $email = $request->input('email');
        $sevendigit = rand(1000000, 9999999);
        $secretcode = bcrypt($sevendigit);

        $checkEmailQuery = DB::table('users')->where('email', $email)->value('email');
        if ($checkEmailQuery != "") {
            $mailData = [
                'title' => 'Secret Code Change',
                'body' => "Since you forgot yours, here's a new one just for you :D",
                'code' => $sevendigit
            ];

            Mail::to($email)->send(new SendEmail($mailData));
            $updateCodeQuery = DB::table('users')
                ->where('email', $email)
                ->limit(1)
                ->update(['secretcode' => $secretcode]);

            if ($updateCodeQuery > 0) {
                return redirect('/login')->withErrors(['codereset' => 'Please check your email for the new code!']);
            }
        } else {
            return back()->withErrors(['resetcodeerror' => 'Account does not exist'])->onlyInput('email');
        }
    }

    public function verifyEmail()
    {
        $email = Session::get('email');

        if ($email != NULL) {
            $checkEmailQuery = DB::table('users')->where('email', $email)->value('email');
            if ($checkEmailQuery != "") {
                $checkVerifyStatusQuery = DB::table('users')->where('email', $email)->value('verified_acc');
                if ($checkVerifyStatusQuery == "false") {
                    $link = URL::temporarySignedRoute(
                        'verifyaccount',
                        now()->addMinutes(5),
                        ['email' => $email]
                    );

                    $verify = [
                        'title' => 'Verify your account',
                        'body' => "Click the button to verify your account:",
                        'link' => $link,
                        'email' => $email
                    ];

                    Mail::to($email)->send(new VerifyEmail($verify));
                    return back()->withErrors(['accountverified' => 'Check your email to complete the account verification. Also, check the SPAM and TRASH folders.']);
                } else {
                    return redirect('/login');
                }
            } else {
                return response()->json('error', 404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function send2fa()
    {
        $email = Session::get('email');

        if ($email != NULL) {
            $sevendigit = rand(1000000, 9999999);
            $twofacode = bcrypt($sevendigit);

            $checkEmailQuery = DB::table('users')->where('email', $email)->value('email');
            if ($checkEmailQuery != "") {
                $codeData = [
                    'title' => '2 Factor Authentication Code',
                    'body' => "Security code can be found below.",
                    'code' => $sevendigit
                ];

                Mail::to($email)->send(new TwoFACode($codeData));
                $update2FACodeQuery = DB::table('users')
                    ->where('email', $email)
                    ->limit(1)
                    ->update(['2facode' => $twofacode]);

                if ($update2FACodeQuery > 0) {
                    return redirect('/users/authenticate/2facodeForm');
                }
                return back();
            } else {
                return response()->json('Error', 404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function sendfeedback(Request $request)
    {
        $request->validate([
            'sender_email' => 'required|email',
            'email_title' => 'min:3',
            'email_content' => 'min:10'
        ]);

        $data = [
            'email' => $request->input('sender_email'),
            'title' => $request->input('email_title'),
            'content' => $request->input('email_content')
        ];

        Mail::send('emails.feedback', $data, function ($email) use ($data) {
            $email->from($data['email']);
            $email->to('dventura@dventura.pt');
            $email->subject($data['title']);
        });

        return back()->withErrors(['SendSuccess' => 'Email sent successfully']);
    }
}
