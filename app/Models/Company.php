<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function customer(){
        return $this->hasMany(Customer::class);
    }
    public function warehouse(){
        return $this->hasMany(Warehouse::class);
    }
    public function worker(){
        return $this->hasMany(Worker::class);
    }
}
