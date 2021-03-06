<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $guarded = [];
    
    
    public function employer(){
        return $this->belongsTo(Company::class);
    }
}
