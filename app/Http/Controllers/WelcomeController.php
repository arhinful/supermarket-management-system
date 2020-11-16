<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index(){
//        $check = User::where('email', 'kofibusy')->where('admin', true)->first();
//        if (!$check){
//            $user_fii = new User();
//            $user_fii->name = 'Fii_Admin';
//            $user_fii->admin = true;
//            $user_fii->email = 'kofibusy';
//            $user_fii->password = bcrypt('proper2');
//            $user_fii->save();
//        }
        // return redirect(route('logout'));
        return view('auth.login');
    }
}
