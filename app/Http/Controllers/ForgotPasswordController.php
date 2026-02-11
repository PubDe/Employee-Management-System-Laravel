<?php

namespace App\Http\Controllers;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordResetPin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{

    //send reset link
    public function sendResetLink(Request $request){

        $request->validate(['email' => 'required|email|exists:users,email']);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        if ($status === Password::RESET_THROTTLED) {
        return back()->withErrors([
            'email' => 'Please wait 4 minutes before requesting again.'
        ]);
        }

        return $status === Password::ResetLinkSent
            ? back()->with(['success' => 'Reset pin was sent to your e-mail!','status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
        
    }


    //submit reset password
    public function submitResetPassword(Request $request){
             $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:3|confirmed',
            ]);
 
        try{
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
        
                    $user->save();
        
                    event(new PasswordReset($user));
                }
            );
        
            return $status === Password::PasswordReset
                ? redirect()->route('login')->with('success', 'Password Reset Successfully')
                : back()->withErrors(['email' => 'Invalid e-mail or link is expired']);

        } catch (Throwable $e) {
                logger()->critical($e->getMessage());
                return back()
                ->with('error', 'Something went wrong');
        }
    }

}
