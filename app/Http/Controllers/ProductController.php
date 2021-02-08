<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required', 'string'],
            'category'=>'string',
            'stock'=>['required', 'integer'],
            'min_stock'=>'integer',
            'max_stock'=>'integer',
            'price'=>['required','integer'],
            'distributor'=>'string',
            'manufacturer'=>'string',
            'picture'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'failed', 'message'=>'validation_error', 'errors'=>$validator->errors()]);
        }
        if($request->hasFile('picture'))
        {
            $destinationPath = 'public/images/picture/';
            $picture_name = time().'.'.$request->picture->extension();
            $request->picture->move($destinationPath, $picture_name);
            $path = $destinationPath.'/'.$picture_name;
        }
        $product = Product::create([
            'name'=> $request['name'],
            'category'=> $request['category'],
            'stock'=> $request['stock'],
            'min_stock'=> $request['min_stock'],
            'max_stock'=> $request['max_stock'],
            'price'=>$request['price'],
            'distributor' => $request['distributor'],
            'manufacturer' => $request['manufacturer'],
            'picture'=>$path??null
            ]);
        $company = Company::where('company_name', $request['company_name'])->firstOrFail();
        $company->product()->save($product);
        if(!is_null($product))
        {
            return response()->json(['status'=>$this->status_code, 'succes'=>true, 'message'=>'Product is created!', 'data'=>$product]);
        }
        return response()->json(['status'=>'failed', 'succes'=>false,
            'message'=>'Failed to create product!']);
        
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