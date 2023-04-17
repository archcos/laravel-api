<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illiuminate\Support\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|unique:users',
        'password' => 'required|string|min:6',
        'device_name' => '',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request['password'])
    ]);

    $token = $user->createToken('Personal Access Token')->plainTextToken;

    return response()->json(['token' => $token], 201);
}

    public function verify($email)
    {
        if(auth()->user()){

            User::where('email',$email)->get();
            if(count($user) > 0){

                $data['email'] = $email;
                $data['title'] = "Email Verification";
                $data['body'] = "Please click here below to verify your email.";

                Mail::send('')

            }  
            else{
            return response()->json(['success'=>false,'msg'=>'User is not Found']);
        }   
        }
          else{
            return response()->json(['success'=>false,'msg'=>'User is not Authenticated.']);
        }   

    }
}
