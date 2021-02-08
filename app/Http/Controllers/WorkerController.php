<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;


class WorkerController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required', 'string'],
            'phone'=>'integer',
            'email'=>'email',

        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        
        $worker = Worker::create([
            'phone'=> $request['phone'],
            'name'=> $request['name'],
            'email'=>$request['email']
            ]);
        $company = Company::where('company_name', $request['company_name'])->firstOrFail();
        $company->worker()->save($worker);
        if(!is_null($worker))
        {
            return response()->json(['status'=>$this->status_code, 'succes'=>true, 'message'=>'Worker record is created!', 'data'=>$worker]);
        }
        return response()->json(['status'=>'failed', 'succes'=>false,
            'message'=>'Failed to create worker record!']);
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
