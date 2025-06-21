<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Tower extends Model
{
    use SoftDeletes;
    protected $fillable = ['tower_no','tower_name'];
   
    public function getDisplayNameAttribute(): string
    {
        return "{$this->tower_name} ({$this->tower_no})";
    }
}