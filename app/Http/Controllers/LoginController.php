<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {  
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            if (Auth::User()->role == "1")
            {
                return \Redirect::to('/admin/home');
            }
            else
            {
                return \Redirect::to('/gudang/home');
            }

        }
        else
        {
            \Session::flash('msg_login','Email Atau Password Salah!');
            return \Redirect::to('/');
        }
    }
    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }
}
