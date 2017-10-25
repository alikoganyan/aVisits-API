<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chain\ChainStoreRequest;
use App\Http\Requests\Chain\ChainUpdateRequest;
use App\Models\ChainPriceLevel;
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
            foreach ($request->input('levels') as $key => $value) {
                $level = ChainPriceLevel::add($value['level'], $chain->id);
            }
            $chain=Chain::getById($chain->id);
            $data = [];
            $data['chain'] = $chain;
            $data['status'] = 'OK';
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
                $levelIds = [];
                foreach ($request->input('levels') as $key => $value) {
                    if (isset($value['id']) && ChainPriceLevel::getById($value['id'])) {
                        $level = ChainPriceLevel::edit($value['id'], $value['level'], $chain->id);
                    } else {
                        $level = ChainPriceLevel::add($value['level'], $chain->id);
                    }
                    $levelIds[$level->id] = $level->id;
                }
                ChainPriceLevel::deleteExceptIds($levelIds, $chain->id);
                $chain=Chain::getById($chain->id);
                $data = [];
                $data['chain'] = $chain;
                $data['status'] = 'OK';
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