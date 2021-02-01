<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarder = [];

    
    public function products(){
        return $this->hasMany(Product::class);
    }
}
