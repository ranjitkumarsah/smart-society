<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Tower;

class Flat extends Model
{
    use SoftDeletes;

    protected $fillable = ['flat_no','tower_id','floor','area_sq_ft','status','resident_id'];

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }
    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id');
    }
}
