<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\PasswordMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function showForgotPassword(){
        return view('forgot-password');
    }

    public function getEmail(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);
    
        $email = $validatedData['email'];
        $token = Str::random(64);

        $user = User::where('email', $email);
        if($user){
            PasswordResetToken::create(compact('email', 'token'));
            Mail::to($email)->send(new PasswordMail($email, $token));
            return redirect()->route('login.show')->with('success', 'please check your email to reset your password');
        } else {
            return redirect()->route('forgot.show')->withErrors(['email' => 'email does not exist!']);
        }
    }

    public function getNewPassword(string $hash){
        [$email, $token] = explode('/', base64_decode($hash));
        return view('get-password', compact('email', 'token'));
    }

    public function updatePassword(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $email = $validatedData['email'];
        $token = $validatedData['token'];
        $password = $validatedData['password'];

        $prt = PasswordResetToken::where('email', '=', $email)->where('token', '=', $token)->first();
        if($prt && $prt->created_at->addMinutes(10)->isFuture()){
            $user = User::where('email', '=', $email)->first();
            if(!$user){
                return redirect()->route('login.show')->withErrors(['email' => 'email doesnt exist!']);
            }
            $user->fill(['password' => $password])->save();
            PasswordResetToken::where('email', $email)->where('token', $token)->delete();

            return redirect()->route('login.show')->with('success', 'password changed successfully');
        } else {
            PasswordResetToken::where('email', $email)->where('token', $token)->delete();
            return redirect()->route('login.show')->withErrors(['email' => 'token expired or email does not exist, try again!']);
        }
    }
}
