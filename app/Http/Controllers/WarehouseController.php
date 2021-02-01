<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'=>['required', 'string'],
            'name'=>'string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        
        $warehouse = Warehouse::create([
            'address'=> $request['address'],
            'name'=> $request['name'],
            ]);

        if(!is_null($warehouse))
        {
            return response()->json(['status'=>$this->status_code, 'succes'=>true, 'message'=>'Warehouse record is created!', 'data'=>$warehouse]);
        }
        return response()->json(['status'=>'failed', 'succes'=>false,
            'message'=>'Failed to create warehouse record!']);
    }

    public function delete(Request $request, $mode)
    {
        
    }

    public function update(Request $request, $mode)
    {
        
    }

    public function edit(Request $request, $mode)
    {
        
    }

    public function view(Request $request, $mode)
    {
        
    }
}
