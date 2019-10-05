<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Get User
     *
     * @param Request $request
     * @return array
     */
    public function user(Request $request) {
        return $request->user();
    }

    /**
     * Register a user
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'user_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 200);
    }

    /**
     * Login a user
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user];
                return response($response, 200);
            } 
            else {
                $response = "Password missmatch";
                return response($response, 422);
            }
        } 
        else {
            $response = 'User does not exist';
            return response($response, 422);
        }
    }

    /**
     * Logout a user
     *
     * @param Request $request
     * @return void
     */
    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->each(function($token, $key) {
            $token->delete();
        });

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }
}
