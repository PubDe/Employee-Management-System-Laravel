<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    //Page View - Sign Up
    public function signupPage(){
        return view('auth.sign-up');
    }

    //sign-up
    public function signup(Request $request) {
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:15'],
            'email' => ['required', 'email',  'unique:users,email'],
            'password' => 'required|string|min:3|confirmed',
        ]);

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);


        //log errors
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            return redirect()->intended('/dashboard')->with('success', 'Account created successfully!');

        } catch (QueryException $e) {
            logger()->error($e->getMessage());
            return back();
        } catch (Throwable $e) {
            logger()->critical($e->getMessage());
            return back();
        }

    }

    //sign-in
    public function login(Request $request){

        try {
            $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

                if (!Auth::attempt($request->only('email', 'password'))) {
                    $request->session()->regenerate();
                    //“intended” = the page the user wanted before login
                    return back()->withErrors(['submit' => 'Invalid credentials.']);
                    
                }

                return redirect()->intended('/dashboard');
            } catch (QueryException $e) {
                    logger()->error($e->getMessage());
            } catch (Throwable $e) {
                    logger()->critical($e->getMessage());
            }

        return back();

    }
}
