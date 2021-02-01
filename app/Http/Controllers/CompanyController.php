<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required', 'string'],
            'headquarter'=>'string',
            'founded'=>'integer',
            'owner'=>'string',
            'website'=>'string',
            'logo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        if($request->hasFile('logo'))
        {
            $destinationPath = 'public/images/logo/';
            $logo_name = time().'logo';
            $request->logo->move($destinationPath, $logo_name);
            $path = $destinationPath.'/'.$logo_name;
        }
        $company = Company::create([
            'name'=> $request['name'],
            'headquarter'=> $request['headquarter'],
            'founded'=> $request['founded'],
            'owner'=> $request['owner'],
            'website'=> $request['website'],
            'logo'=>$path,
            'user_id'=>$user->id]);
        if(!is_null($company))
        {
            return response()->json(['status'=>$this->status_code, 'succes'=>true, 'message'=>'Company profile is created!', 'data'=>$company]);
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

    public function view(Request $request, $mode)
    {
        
    }
}
