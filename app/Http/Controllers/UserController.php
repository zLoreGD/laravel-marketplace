<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => ['string','required','min:5','max:40'],
            'email' => ['string','required','email'],
            'password'=> ['string','required','min:6','max:100']
        ]);
        $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        ]);

        Auth::login($user);
        
        return redirect('/');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
    public function login(Request $request){
        $data = $request->validate([
            'name' => ['string','required','min:5','max:40'],
            'password'=> ['string','required','min:6','max:100']
        ]);
        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect('/');
        }
        return redirect('/')->withErrors([
            'name' =>"The provided login information is invalid."
        ]);;

        
    }
}
