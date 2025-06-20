<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
