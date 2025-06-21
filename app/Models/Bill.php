<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Flat;

class Bill extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['flat_id','month','amount','due_date','status','generated_by'];


    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
