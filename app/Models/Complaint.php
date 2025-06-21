<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Complaint extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'resident_id', 'assigned_to','status'];

    public function resident() 
    { 
        return $this->belongsTo(User::class, 'resident_id'); 
    }
    public function staff() 
    { 
        return $this->belongsTo(User::class, 'assigned_to'); 
    }

    protected static function booted()
    {
        static::updating(function ($complaint) {
            if (
                $complaint->isDirty('assigned_to') && 
                filled($complaint->assigned_to) &&
                $complaint->status === 'open'
            ) {
                $complaint->status = 'in_progress';
            }
        });
    }
}