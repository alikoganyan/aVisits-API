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
            if ($token = JWTAuth::attempt(["email" => $data['email'], 'password' => $data['password']])
            ) {
                $chain = app('App\Http\Controllers\ChainController')->firstChain();
                return response()->json(['token' => $token, 'chain' => $chain], 201);
            } else {
                return response()->json(["signin_error" => "authentication failed"], 400);
            }
        } else {
            return response()->json(["error" => "saving error"], 400);
        }
    }

    public function signin(Request $request)
    {
        $credentials = $request->only('phone', 'email');
        $where = [];
        if (isset($credentials['email']) && !empty($credentials['email'])) {
            $where = ['email' => $credentials['email']];
        } elseif (isset($credentials['phone']) && !empty($credentials['phone'])) {
            $where = ['phone' => $credentials['phone']];
        }
        if (count($where) > 0) {
            $user = User::with('chains')->where($where)->first();
            if($user){
                return response()->json(["data"=>["user"=>$user],"status"=>"OK"],200);
            }else{
                return response()->json(["data"=>["user"=>[]],"status"=>"USER NOT FOUND"],200);
            }
        }
        return response()->json(['error'=>'Phone or Email is empty'], 400);
    }

    public function login(Request $request){
        $chainId = (integer)$request->route('chain');
        if(empty($chainId)){
            return response()->json(['error'=>'The id of chain into route is required'],400);
        }
        $credentials = $request->only('phone', 'email', 'password');
        if(!empty($credentials['password']) && ( !empty($credentials['email']) || !empty($credentials['phone']) )) {
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'Invalid Credentials!'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'Exception!'], 401);
            }
            $havSalon = app('App\Http\Controllers\SalonController')->haveAnySalon();
            $response = ['token' => $token, "user" => Auth::User()];
            if ($havSalon === 0) {
                $response['redirect_to_create_salon'] = 1;
            } else {
                $response['redirect_to_create_salon'] = 0;
            }
            $ownChain = Chain::where(['user_id' => Auth::id()])->select("id")->where(['id'=>$chainId])->first();
            if(!$ownChain || $ownChain->id !== $chainId){
                return response()->json(["error"=>"Incorrect the ID of chain or permission denied!"],400);
            }
            $response["chain"] = $ownChain;
            return response()->json($response, 200);
        }
        return response()->json(['error'=>'One and may be all fields: email, phone, password, are empty.'], 400);
    }

    public function users()
    {
        return response()->json(User::all(), 200);
    }

}
