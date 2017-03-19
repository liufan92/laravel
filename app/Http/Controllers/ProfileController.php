<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function profile($username){
    	
    	$user = User::whereUsername($username)->first(); //first() returns first match user
    	//dd($user); //Dump and die -- dumps all information about the Object
    	//return $user;
    	return view('user.profile', compact('user'));
    }
}
