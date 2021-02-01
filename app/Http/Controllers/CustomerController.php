<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'=>['required', 'string'],
            'phone'=>['integer', 'required'],
            'discount'=>'integer',
            'email'=>'string'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        
        $customer = Customer::create([
            'address'=> $request['address'],
            'email'=> $request['email'],
            'phone'=> $request['phone'],
            'discount'=> $request['discount']
            ]);

        if(!is_null($customer))
        {
            return response()->json(['status'=>$this->status_code, 'succes'=>true, 'message'=>'Customer account is created!', 'data'=>$customer]);
        }
        return response()->json(['status'=>'failed', 'succes'=>false,
            'message'=>'Failed to create customer profile!']);
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
