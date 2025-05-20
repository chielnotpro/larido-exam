<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Appointment extends Model
{
    protected $fillable = ['tutor_id', 'student_id', 'subject_id', 'date'];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
