<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TutoringController extends Controller
{
    public function index()
{
    $tutors = collect([
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Carol'],
        ['id' => 4, 'name' => 'David'],
        ['id' => 5, 'name' => 'Eva'],
        ['id' => 6, 'name' => 'Frank'],
        ['id' => 7, 'name' => 'Grace'],
        ['id' => 8, 'name' => 'Henry'],
        ['id' => 9, 'name' => 'Ivy'],
        ['id' => 10, 'name' => 'Jack'],
    ]);

    $students = collect([
        ['id' => 1, 'name' => 'Liam'],
        ['id' => 2, 'name' => 'Mia'],
        ['id' => 3, 'name' => 'Noah'],
        ['id' => 4, 'name' => 'Olivia'],
        ['id' => 5, 'name' => 'Pam'],
        ['id' => 6, 'name' => 'Quinn'],
        ['id' => 7, 'name' => 'Riley'],
        ['id' => 8, 'name' => 'Sophia'],
        ['id' => 9, 'name' => 'Tom'],
        ['id' => 10, 'name' => 'Uma'],
    ]);

    $subjects = collect([
        ['id' => 1, 'name' => 'Math'],
        ['id' => 2, 'name' => 'Science'],
        ['id' => 3, 'name' => 'English'],
        ['id' => 4, 'name' => 'History'],
        ['id' => 5, 'name' => 'Geography'],
        ['id' => 6, 'name' => 'Biology'],
        ['id' => 7, 'name' => 'Chemistry'],
        ['id' => 8, 'name' => 'Physics'],
        ['id' => 9, 'name' => 'Economics'],
        ['id' => 10, 'name' => 'Art'],
    ]);

    // 👇 Generate random appointments
    $appointments = collect();
    for ($i = 0; $i < 10; $i++) {
        $appointments->push([
            'tutor_id' => rand(1, 10),
            'student_id' => rand(1, 10),
            'subject_id' => rand(1, 10),
            'date' => now()->addDays(rand(0, 30))->toDateString(),
        ]);
    }

    $totalAppointments = $appointments->count();
    $appointmentsByTutor = $appointments->groupBy('tutor_id')->map->count();
    $appointmentsByStudent = $appointments->groupBy('student_id')->map->count();
    $appointmentsBySubject = $appointments->groupBy('subject_id')->map->count();

    return view('dashboard', compact(
        'tutors', 'students', 'subjects', 'appointments',
        'totalAppointments', 'appointmentsByTutor', 'appointmentsByStudent', 'appointmentsBySubject'
    ));
}
}

