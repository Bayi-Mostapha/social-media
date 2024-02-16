<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\profileMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $name = $validatedData['name'];
        $email = $validatedData['email'];
        $password = bcrypt($validatedData['password']);
        
        $user = User::create(compact('name', 'email', 'password'));
        Mail::to($email)->send(new profileMail($user));

        return redirect()->route('login.show')->with('success', 'account has been created, please verify your email');
    }

    public function verifyEmail(string $hash){
        [$id, $date] = explode('/', base64_decode($hash));
        $user = User::findOrFail($id);

        if($user->created_at->toDateTimeString() !== $date){
            abort(403);
        }

        if($user->email_verified_at !== null){
            return redirect()->route('login.show')->withErrors(['email' => 'email already verified!!']);
        }

        $user->fill(['email_verified_at' => time()])->save();
        return redirect()->route('login.show')->with('success', 'email verified');
    }

    public function showLogin(){
        return view('login');
    }

    public function login(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(compact('email', 'password'))) {
            $user = auth()->user();
            if ($user->hasVerifiedEmail()) {
                $request->session()->regenerate();
                return redirect()->route('home');
            } else {
                $user = User::where('email', $email)->firstOrFail();
                Mail::to($email)->send(new profileMail($user));
                Auth::logout();
                
                return redirect()->route('login.show')->withErrors(['email' => 'Verify your email. Check your inbox for the verification link.'])->onlyInput('email');
            }
        }
        return back()->withErrors(['email' => 'Email or password is incorrect'])->onlyInput('email');        
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
