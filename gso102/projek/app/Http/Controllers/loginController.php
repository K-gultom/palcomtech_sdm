<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function register(){

        return view('user.register');
    }
    public function store_register(Request $req){

        $req -> validate([
            "name" => 'required|min:3',
            "email" => 'required|min:5|max:50|unique:users,email',
            "password" => 'required|min:6',
        ]);

        $new = new User();
        $new -> name = $req -> name;
        $new -> email = $req -> email;
        $new -> password = Hash::make($req -> password);
        $new -> save();

        return redirect('/register')->with('message', 'Register Sukses...');

    }


    public function login(){
        
        return view('user.login');
    }

    public function store_login(Request $req){

        $req -> validate([
            "email" => 'required|min:5|max:50|email|exists:users,email',
            "password" => 'required|min:6',
        ]);

        $user = User::where('email', $req->email)->first();

        if (Hash::check($req->password, $user->password)) {
            Auth::attempt(['email' => $req->email, 'password' => $req->password]);
            return redirect('/dashboard');
        }else {
            return redirect()->back()->withErrors(['password' => 'Password is Invalid...']);
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
