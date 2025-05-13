<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Appointment extends Model
    {
        public function tutor() {
        return $this->belongsTo(Tutor::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
