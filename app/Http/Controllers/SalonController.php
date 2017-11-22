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

    public function index(Request $request, $chainId)
    {
        if ($chainId) {
            $salons = Salon::getByChainId($chainId);
        } else {
            $salons = Salon::getAll();
        }
        $response = [];
        foreach($salons as $salon){
            $temp = $salon->getAttributes();
            $temp['notify_about_appointments'] = explode(',',$temp['notify_about_appointments']);
            array_push($response,$temp);
        }
        return response()->json(["data" => $response], 200);
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
        $salon->notify_about_appointments = implode(',',$request->input('notify_about_appointments'));
        $imgName = str_random('16') . '.png';
        if ($request->input('photo')) {
            file_put_contents('images/'.$imgName, base64_decode($request->input('photo')));
            chmod('images/'.$imgName,'0777');
        }
        $salon->img=$imgName;
        if ($salon->save()) {
            if($request->input('schedule')) {
                foreach ($request->input('schedule') as $key => $value) {
                    SalonSchedule::add($salon->id, $value['num_of_day'], $value['working_status'], $value['start'], $value['end']);
                }
            }else {
                $default_schedules = SalonSchedule::default_schedules($salon->id);
                SalonSchedule::insert($default_schedules);
            }
            $salon->refresh();
            $salonRespone = Salon::find($salon->id);
            $salonRespone = $salonRespone->getAttributes();
            $salonRespone['notify_about_appointments'] = explode(',',$salonRespone['notify_about_appointments']);
            return response()->json(['success' => 'Created successfully', 'data' => $salonRespone, 'salon_schedule' => $salon->schedule], 200);
        }
        return response()->json(["error" => "any problem with storing data"], 400);
    }

    /**
     * Get salon
     *
     * @param $chainId
     * @param $salonId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($chainId, $salonId)
    {
        $salon = Salon::getById($salonId);
        return response()->json(["data" => $salon], 200);
    }

    public function edit(StoreSalonRequest $request, Salon $salon)
    {
        return "edit";
    }

    /**
     * Update salon
     *
     * @param UpdateSalonRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSalonRequest $request)
    {
        $salon = (integer)$request->route('salon');
        $model = Salon::find($salon);
        $model->fill($request->all());
        $model->img = null;
        $model->user_id = Auth::id();
        $salon->notify_about_appointments = serialize($request->input('notify_about_appointments'));
        $imgName = str_random('16') . '.png';
        if ($request->input('photo')) {
            file_put_contents('images/'.$imgName, base64_decode($request->input('photo')));
            chmod('images/'.$imgName,'0777');
        }
        $model->img=$imgName;
        $model->current_time = Carbon::parse($request->input('current_time'))->format('Y-m-d H:i:s');
        if ($request->hasFile('img')) {
            $file = $this->upload($request);
            if ($file) {
                $model->img = $file['fileName'];
            }
        }
        if ($model->save()) {
            foreach ($request->input('schedule') as $key => $value) {
                if (isset($value['id'])) {
                    SalonSchedule::edit($value['id'], $model->id, $value['num_of_day'], $value['working_status'], $value['start'], $value['end']);
                }
            }
            $model->refresh();
            $salon = Salon::getById($model->id);
            return response()->json(["data" => $salon], 200);
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

    public function destroy($chain, $salon)
    {
        $model = Salon::find($salon);
        $model->delete();
        return response()->json(["success" => "1"], 200);
    }

    public function haveAnySalon($chainId = 0)
    {
        $salons = Salon::join('chains', 'salons.chain_id', '=', 'chains.id')
            ->where(['chains.user_id' => Auth::id(), 'salons.user_id' => Auth::id()]);
        if ($chainId) {
            $salons = $salons->where('salons.chain_id', $chainId);
        }
        return $salons->count();
    }
}
