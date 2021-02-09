<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name'=>['required', 'string']
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        $name = $request['name'];
        $manager = User::where('name', $name)->firstOrFail();
        $company = Company::create([
            'company_name'=> $request['company_name']]);
        $company->user()->associate($manager);
        $company->save();
        if(!is_null($company))
        {
            return response()->json(['status'=>$this->status_code, 'success'=>true, 'message'=>'Company profile is created!', 'data'=>$company]);
        }
        return response()->json(['status'=>'failed', 'succes'=>false,
            'message'=>'Failed to create company profile']);
        
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

    public function view(Request $request, $id)
    {
        return Company::with(['user', 'product', 'worker', 'warehouse', 'customer'])->where('user_id', $id)->firstOrFail();
    }
}
