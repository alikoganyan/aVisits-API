<?php

namespace App\Http\Controllers;

use \App\Http\Requests\StoreSalonRequest;
use \App\Http\Requests\UpdateSalonRequest;
use App\Models\Salon;
use App\Models\SalonSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use File;
use Exception;

class SalonController extends Controller
{

    public function index(Request $request)
    {
        $salons = Salon::getAll();
        return response()->json(["data" => $salons], 200);
    }

    public function create(Request $request)
    {
        return "create";
    }

    /**
     * Create salon
     *
     * @param StoreSalonRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSalonRequest $request)
    {
        $salon = new Salon();
        $salon->fill($request->all());
        $salon->user_id = Auth::id();
        $salon->chain_id = $request->route('chain');
        $salon->current_time = Carbon::parse($request->input('current_time'))->format('Y-m-d H:i:s');
        if ($salon->save()) {
            for ($i = 1; $i <= 7; $i++) {
                $schedule = [];
                $schedule['salon_id'] = $salon->id;
                $schedule['num_of_day'] = $request->input('schedule[' . $i . '][num_of_day]');
                $schedule['working_status'] = $request->input('schedule[' . $i . '][working_status]');
                $schedule['start'] = $request->input('schedule[' . $i . '][start]');
                $schedule['end'] = $request->input('schedule[' . $i . '][end]');
                SalonSchedule::add($schedule);
            }
            $salon->refresh();
            return response()->json(['success' => 'Created successfully', 'data' => Salon::find($salon->id), 'salon_schedule' => $salon->schedule], 200);
        }
        return response()->json(["error" => "any problem with storing data"], 400);
    }

    public function show($salon)
    {
        $model = Salon::find($salon);
        return response()->json(["data" => $model], 200);
    }

    public function edit(StoreSalonRequest $request, Salon $salon)
    {
        return "edit";
    }

    /**
     * Update salon
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSalonRequest $request)
    {
        $salon = (integer)$request->route('salon');
        $model = Salon::find($salon);
        $model->fill($request->all());
        $model->img = null;
        $model->user_id = Auth::id();
        $model->current_time = Carbon::parse($request->input('current_time'))->format('Y-m-d H:i:s');
        if ($request->hasFile('img')) {
            $file = $this->upload($request);
            if ($file) {
                $model->img = $file['fileName'];
            }
        }
        if ($model->save()) {
            foreach ($model->schedule as $key => $value) {
                if ($request->input('schedule[' . $value->id . '][num_of_day]')) {
                    $schedule = [];
                    $schedule['salon_id'] = $model->id;
                    $schedule['num_of_day'] = $request->input('schedule[' . $value->id . '][num_of_day]');
                    $schedule['working_status'] = $request->input('schedule[' . $value->id . '][working_status]');
                    $schedule['start'] = $request->input('schedule[' . $value->id . '][start]');
                    $schedule['end'] = $request->input('schedule[' . $value->id . '][end]');
                    SalonSchedule::edit($value->id, $schedule);
                }
            }
            $model->refresh();
            return response()->json(["data" => $model], 200);
        }
        return response()->json(["error" => "any problem with storing data!"], 400);
    }

    public function upload(Request $request)
    {
        $ds = DIRECTORY_SEPARATOR;
        $file = $request->file('img');
        $path = public_path("files" . $ds . "salons" . $ds . "images" . $ds . "main");
        $fileName = time() . "_" . md5($file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        if ($file->move($path, $fileName)) {
            return [
                "fileName" => $fileName,
                "path" => $path
            ];
        } else {
            return false;
        }

    }

    public function destroy($salon)
    {
        $model = Salon::find($salon);
        $model->delete();
        return response()->json(["success" => "1"], 200);
    }

    public function haveAnySalon()
    {
        return Salon::join('chains', 'salons.chain_id', '=', 'chains.id')
            ->where(['chains.user_id' => Auth::id(), 'salons.user_id' => Auth::id()])
            ->count();
    }
}
