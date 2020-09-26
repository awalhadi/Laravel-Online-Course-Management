<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AuthorizationController extends Controller
{

    public function checkValidCode($user, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$user->ver_code_send_at) return false;
        if (Carbon::parse($user->ver_code_send_at)->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->ver_code !== $code) return false;
        return true;
    }

    public function authorizeForm()
    {
        $view = 'auth.authorize';
        $sender_email = "admin@main.com";
        $sender_name = "Online Courser";
        if (auth()->check()) {
            $user = auth()->user();
                if (!$user->ev) {
                if (!$this->checkValidCode($user, $user->ver_code)) {
                    $user->ver_code = verification_code(6);
                    $user->ver_code_send_at = Carbon::now();
                    $user->save();
                    $subject = "Email verifucation code";
                    send_php_mail($user->email, $user->name, $sender_email, $sender_name, $subject, $user->ver_code);
                }
                $page_title = 'Email verification form';
                return view($view, compact('user', 'page_title'));
            }
        }
        return redirect()->route('user.login');
    }


    // varification code sent
    public function sendVerifyCode(Request $request)
    {
        $user = Auth::user();
        if (!$this->checkValidCode($user, $user->ver_code)) {
            $user->ver_code = verification_code(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        } else {
            $user->ver_code = $user->ver_code;
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        }
        $sender_email = "admin@main.com";
        $sender_name = "Online Courser";
        $subject = "Verification Code";

        if ($request->type === 'email') {
            send_php_mail($user->email, $user->name, $sender_email, $sender_name, $subject, $user->ver_code);

            $notify[] = ['success', 'Email verification code sent successfully'];
            return back()->withNotify($notify);
        } else {
            throw ValidationException::withMessages(['resend' => 'Sending Failed']);
        }
    }

    // email varification
    public function emailVerification(Request $request)
    {
        $request->validate([
            'email_verified_code' => 'required',
        ], [
            'email_verified_code.required' => 'Email verification code is required',
        ]);
            
        $user = Auth::user();
        if ($this->checkValidCode($user, $request->email_verified_code)) {
            $user->ev = 1;
            $user->status = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->route('user.home');
        }
        throw ValidationException::withMessages(['email_verified_code' => 'Verification code didn\'t match!']);
    }
}
