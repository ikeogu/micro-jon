<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['job_title','job_type','job_condition','job_category','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}