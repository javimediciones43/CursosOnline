<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'enrollment_id',
        'score',
        'feedback',
        'evaluated_at',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
