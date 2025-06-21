<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class FamilyMember extends Model
{
    use SoftDeletes;

    protected $fillable = ['resident_id', 'name', 'relation', 'dob'];

    public function resident()
    {
        return $this->belongsTo(User::class);
    }
}
