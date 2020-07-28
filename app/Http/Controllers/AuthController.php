<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     protected function generateAccessToken($user){
      $token = $user->createToken($user->email.'-'.now());

       return $token->accessToken;
    }
      // Registration Controller Function
    public function register(Request $request)
    {
        // Validation
        $validate = $request -> validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'gender'=>'nullable|string',
            'phone_number' => 'required|string|min:10',
            'local_government_of_residence' => 'required|string',
            'state' => 'required|string',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request-> email,
            'gender' => $request-> gender,
            'phone_number' => $request->phone_number,
            'local_government_of_residence' => $request ->local_government_of_residence,
            'state' => $request -> state,
            'password' =>bcrypt($request ->password)
        ]);

        $success_array = [
            'status' =>'200',
            'success' => 'true',
            'message' => 'Successfully registered'
        ];
        return response()->json(array('user'=>$user,'status'=>$success_array));
    }

    // Login Controller Function
        public function login( Request $request ){
            $login =  $request -> validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);

            if ( !Auth::attempt( $login )) {
                return response(['status' => '400','message' =>'invalid login credentials.',  'success' => 'false']);
            }


            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return response(['user' => Auth::user(), 'access_token' => $accessToken, 'status' => '200', 'message' =>'Successfully login', 'success' => 'true']);

            }
}



