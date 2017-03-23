<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\User;
use Auth;

class ProfileController extends Controller
{
    public function profile($username){
    	
    	$user = User::whereUsername($username)->first(); //first() returns first match user
    	$articles = $user->articles()->latest()->paginate(10);
    	//dd($user); //Dump and die -- dumps all information about the Object
    	//return $user;
    	//return view('user.profile', compact('user'));
    	return view('user.profile')
    		->with('user', $user)
    		->with('articles', $articles);
    }

    public function profileEdit($username){
        $user = User::whereUsername($username)->first();
        return view('user.profileEdit', ['user' => $user]);
    }

    public function profileUpdate(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);

        $user = Auth::user();
        $user->name = $request['name'];
        $user->dob = $request['dob'];
        $user->email = $request['email'];
        $user->update();

        $file = $request->file('image');
        $filename = $request['name'] . '-' . $user->id . '.jpg';

        if($file){
            Storage::disk('local')->put($filename, File::get($file)); //put(file_name, actual_file)
        }
        return redirect()->route('profile', ['username' => $user->username]);
    }

    public function getUserImage($filename){
        //$file = Storage::disk('local')->get('$filename');
        //return new Response($file, 200);
        return Storage::get($filename); 
    }
}
