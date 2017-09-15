<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Exception;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        try {
            return $this->validate($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }
        catch (\Exception $e){
            return response()->json(["ExceptionHandler"=>$e],400);
        }
    }

    protected function signup(Request $request)
    {
        $data = $request->only('name', 'email', 'password');

        if ($this->validator($request)) {
            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            if($user->save()){
                if($token = JWTAuth::attempt($data)){
                    return response()->json(['token'=>$token],201);
                }
            }
            else{
                return response()->json(["error"=>"saving error"],400);
            }
        }
        else {
            return response()->json(["error"=>"validation error"],400);
        }
    }

    public function signin(Request $request){
        $credentials = $request->only('email','password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'Invalid Credentials!'],401);
            }
        }
        catch (JWTException $e){
            return response()->json(['error'=>'Exception!'],401);
        }
        return response()->json(['token'=>$token],200);
    }

}
