<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chain\ChainStoreRequest;
use App\Http\Requests\Chain\ChainUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chain;

Class ChainController extends Controller
{
    public function index()
    {
        $chains = Chain::where(["user_id" => Auth::id()])->orderBy('id', 'desc')->get();
        return response()->json(['data' => $chains], 200);
    }

    public function store(ChainStoreRequest $request)
    {
        $chain = new Chain($request->all());
        $chain->user_id = Auth::id();
        if ($chain->save()) {
            return response()->json(["data" => ["chain" => $chain]], 200);
        }
        return response()->json(['error' => 'The chain saving failed!'], 400);
    }

    public function update(ChainUpdateRequest $request)
    {
        $params = $request->route()->parameters();
        $chain = Chain::where(["id" => $params['chain'], "user_id" => Auth::id()])->first();
        if ($chain) {
            $chain->fill($request->all());
            if ($chain->save()) {
                return response()->json($chain, 200);
            } else {
                return response()->json(['error' => 'The process of saving data failed!'], 400);
            }
        } else {
            return response()->json(['error' => 'The chain not found or permission failed!'], 400);
        }

    }

    public function show(Request $request)
    {
        $params = $request->route()->parameters();
        $chain = Chain::where(["id" => $params['chain'], "user_id" => Auth::id()])->first();
        if ($chain) {
            return response()->json(['data' => ["chain" => $chain]], 200);
        } else {
            return response()->json(['error' => "The chain not found or permission failed!"], 400);
        }

    }

    public function destroy(Request $request)
    {
        $params = $request->route()->parameters();
        $chain = Chain::where(["id" => $params['chain'], "user_id" => Auth::id()])->first();
        if ($chain) {
            if ($chain->delete()) {
                return response()->json(['success' => 1], 200);
            } else {
                return response()->json(['error' => "Failed to delete!"], 400);
            }
        } else {
            return response()->json(['error' => "The chain not found or permission failed!"], 400);
        }
    }

    public function firstChain()
    {
        $chain = new Chain();
        $chain->fill(["title" => "Сеть 1", "description" => "First Chain", "user_id" => Auth::id()]);
        $chain->user_id = Auth::id();
        if ($chain->save()) {
            return $chain;
        }
        return [];
    }
}