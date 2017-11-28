<?php
namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class WidgetEmployeeController extends Controller
{
    private $chain;

    public function __construct(Request $request)
    {
        $this->chain = $request->route('chain');
    }

    public function employees(Request $request) {
        $filter = $request->post();
        $employees = Employee::employees($this->chain,$filter);
        return response()->json(['data' => ['employees'=>$employees]], 200);
    }
}