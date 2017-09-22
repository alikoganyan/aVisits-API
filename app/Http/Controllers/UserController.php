<?php

namespace App\Http\Controllers;

use App\Models\Chain;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Exception;
use App\Http\Requests\CreateUserRequest;

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


    public function signup(CreateUserRequest $request)
    {
        $data = $request->only('name', 'email', 'password', 'phone');
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] || "",
            'password' => bcrypt($data['password']),
        ]);
        if ($user->save()) {
            if ($token = JWTAuth::attempt(["email" => $data['email'],'password' => $data['password']])
            ) {
                $chain = app('App\Http\Controllers\ChainController')->firstChain();
                return response()->json(['token' => $token,'chain'=>$chain], 201);
            } else {
                return response()->json(["signin_error" => "authentication failed"], 400);
            }
        } else {
            return response()->json(["error" => "saving error"], 400);
        }
    }

    public function signin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid Credentials!'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Exception!'], 401);
        }
        $havSalon = app('App\Http\Controllers\SalonController')->haveAnySalon();
        $response = ['token' => $token,"user"=>Auth::User()];
        if($havSalon === 0){
            $response['redirect_to_create_salon'] = 1;
        }
        else{
            $response['redirect_to_create_salon'] = 0;
        }
        $response['chain'] = Chain::where(['user_id'=>Auth::id()])->select("id")->first();
        return response()->json($response, 200);

    }

    public function users(){
        return response()->json(User::all(),200);
    }

}
