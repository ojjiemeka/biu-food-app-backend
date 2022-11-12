<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected function register(Request $request)
    {
        $user = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'other_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // 'avatar' => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
        ]);


        $now = Carbon::today()->toDateString();

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->other_name = $request->input('other_name');
        $user->email = $request->input('email');
        $user->phonenumber = $request->input('phonenumber');
        $user->mat_no = $request->input('mat_no');
        $user->password = Hash::make($request->input('password')) ;
        // $user->avatar = "null";
        $user->avatar = $request->input('avatar');
        $user->created_at = $now;
        $user->save();

        $message = 'User Created';

        /* Creating a token for the user. */
        $token = $user->createToken('app_token')->plainTextToken;

        // $user->notify(new WelcomeEmailNotification);


        $response = [
            'message' => $message,
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 200);

        // echo 'hello';

    }

    protected function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        //$inputVal = $request->all();
        $email = $request->input('email');
        $pass = $request->input('password');

        $credentials = $request->only('email', 'password');

        // CHECK CREDENTIALS
        if(Auth::attempt($credentials)){  
              // the next line must be addeded
          /** @var \App\Models\MyUserModel $user **/

            $user = Auth::user();

                $token = $user->createToken('app_token')->plainTextToken;

                $response = [
                    'user' => $user,
                    'token' => $token,
                    'message' => 'Signin Succeccful'

                ];
            
                    return response($response, 200);

        }else{

            $response = [
                'message' => 'Bad Credentials'
            ];

        return response($response, 401);
        }

    }
    
    public function logout(Request $request){
        /** @var \App\Models\MyUserModel $user **/
        // the next line must be addeded
        $user = Auth::user();

        // Revoke and delete all tokens...
        $user->tokens()->delete();

        // echo $user;s

        $response = [
            'message' => 'Logged Out'
        ];

        return response($response, 200);
    }
}
