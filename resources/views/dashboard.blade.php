<!DOCTYPE html>
<html>
<head>
    <title>Tutoring Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Tutoring Appointments Dashboard</h1>

    <p><strong>Total Appointments:</strong> {{ $totalAppointments }}</p>

    <div style="display: flex; flex-wrap: wrap;">
        <div style="width: 33%;">
            <h3>Appointments by Tutor</h3>
            <canvas id="tutorChart"></canvas>
        </div>

        <div style="width: 33%;">
            <h3>Appointments by Student</h3>
            <canvas id="studentChart"></canvas>
        </div>

        <div style="width: 33%;">
            <h3>Appointments by Subject</h3>
            <canvas id="subjectChart"></canvas>
        </div>
    </div>

    <h2>All Appointments</h2>
    <ul>
        @foreach($appointments as $a)
            <li>
                {{ $tutors->firstWhere('id', $a['tutor_id'])['name'] }} teaches 
                {{ $students->firstWhere('id', $a['student_id'])['name'] }} 
                {{ $subjects->firstWhere('id', $a['subject_id'])['name'] }} 
                on {{ $a['date'] }}
            </li>
        @endforeach
    </ul>

    <script>
    // Prepare PHP data for JS
    const tutorLabels = {!! json_encode($appointmentsByTutor->keys()->map(fn($id) => $tutors->firstWhere('id', $id)['name'])) !!};
    const tutorData = {!! json_encode($appointmentsByTutor->values()) !!};

    const studentLabels = {!! json_encode($appointmentsByStudent->keys()->map(fn($id) => $students->firstWhere('id', $id)['name'])) !!};
    const studentData = {!! json_encode($appointmentsByStudent->values()) !!};

    const subjectLabels = {!! json_encode($appointmentsBySubject->keys()->map(fn($id) => $subjects->firstWhere('id', $id)['name'])) !!};
    const subjectData = {!! json_encode($appointmentsBySubject->values()) !!};

    const chartColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#9CCC65', '#FF7043',
        '#26C6DA', '#AB47BC', '#EC407A', '#FFA726', '#66BB6A'
    ];

    // PIE chart for Tutors
    new Chart(document.getElementById('tutorChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: tutorLabels,
            datasets: [{
                label: 'Appointments by Tutor',
                data: tutorData,
                backgroundColor: chartColors
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // BAR chart for Students
    new Chart(document.getElementById('studentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: studentLabels,
            datasets: [{
                label: 'Appointments by Student',
                data: studentData,
                backgroundColor: chartColors
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    // DOUGHNUT chart for Subjects
    new Chart(document.getElementById('subjectChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: subjectLabels,
            datasets: [{
                label: 'Appointments by Subject',
                data: subjectData,
                backgroundColor: chartColors
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
</body>
</html>
