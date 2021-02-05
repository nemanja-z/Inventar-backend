<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
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
        
        $order = Order::create([
            'address'=> $request['address'],
            'email'=> $request['email'],
            'phone'=> $request['phone'],
            'discount'=> $request['discount']
            ]);
        $order = Company::where('company_name', $request['company_name'])->firstOrFail();
        $company->order()->save($order);
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
