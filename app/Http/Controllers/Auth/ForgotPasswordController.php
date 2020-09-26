<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\PasswordReset;
use Illuminate\Http\Request;
use App\User;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // override email sent
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'User not found.'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();

        $code = verification_code(6);

        PasswordReset::create([
            'email' => $user->email,
            'token' => $code,
            'created_at' => \Carbon\Carbon::now(),
        ]);

        // send_email($user, 'ACCOUNT_RECOVERY_CODE', ['code' => $code]);
        $subject = "ACCOUNT_RECOVERY_CODE";
        $sender_email = "admin@mail.com";
        $sender_name = "Student Course";

        $message = $code;
        send_php_mail($user->email, $user->name, $sender_email, $sender_name, $subject, $message);

        $page_title = 'Account Recovery';
        $email = $user->email;
        $notify[] = ['success', 'Password reset email sent successfully'];
        return view('auth.passwords.confirm', compact('page_title', 'email'))->withNotify($notify);
    }
}
