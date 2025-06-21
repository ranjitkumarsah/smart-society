<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Flat;

class Visitor extends Model
{
    use SoftDeletes;

    public function flat() 
    { 
        return $this->belongsTo(Flat::class); 
    }
    public function approvedBy() 
    { 
        return $this->belongsTo(User::class, 'approved_by'); 
    }
    public function enteredBy() 
    { 
        return $this->belongsTo(User::class, 'entered_by'); 
    }
}