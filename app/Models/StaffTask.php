<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class StaffTask extends Model
{
    use SoftDeletes;
    
    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
