<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;


class SalonController extends Controller
{

    public function index(Request $request){
        if (Auth::check()) {
            dd(Auth::user());
        }
        else{
            dd("have not user");
        }
        return "index";
    }
    public function create(){
        return "create";
    }
    public function store(){
        return "store";
    }
    public function show(){
        return "show";
    }
    public function edit(){
        return "edit";
    }
    public function update(){
        return "update";
    }
    public function destroy(){
        return "destroy";
    }
}
