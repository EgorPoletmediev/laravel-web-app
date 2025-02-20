<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $temp = $request->validate([
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|unique:users',
            'password'=>'required|min:8|confirmed'
        ]);

        $user = User::create($temp);

        Auth::login($user);

        $token = $user->createToken($user->name)->plainTextToken;
        //response()->json(['message' => 'Authenticated'])->cookie('auth_token', $token, 1440);

        //$request->session()->put('api_token', $token);
        //dd($token);

        return redirect()->route('files.index');
            //->cookie('auth_token', $token, 1440);
    }

    public function login(Request $request){

        $temp = $request->validate([
            'email'=> 'required|email|exists:users',
            'password'=>'required'
        ]);

        if (Auth::attempt($temp)){
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken($user->name);
            return redirect()->route('files.index');
        }
        else{
            return back()->withErrors([
                'failed' =>'The provided credentials do not match our records.'
            ]);
        }
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        //Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');

    }
}
