<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function storage(){
        return $this->hasMany(Warehouse::class);
    }
}
