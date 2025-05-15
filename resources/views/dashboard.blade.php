<!DOCTYPE html>
<html>
<head>
    <title>Tutoring Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Styles for Dark Mode */
        body {
            font-family: Arial, sans-serif;
            background-color: #181818; /* Dark background */
            color: #f5f5f5; /* Light text color */
            margin: 0;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #ecf0f1; /* Light color for headings */
        }

        /* Appointments Grid */
        .appointments-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .appointment-card {
            background-color: #2c3e50; /* Dark card background */
            border: 1px solid #34495e; /* Darker border */
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }

        .appointment-card:hover {
            transform: scale(1.02);
        }

        .appointment-card p {
            margin: 5px 0;
            color: #ecf0f1; /* Light text color */
        }

        /* Styling the charts */
        .chart-container {
            width: 100%;
            max-width: 500px; /* Set maximum width for charts */
            margin: 0 auto; /* Center the charts */
            padding: 10px;
        }

        canvas {
            background-color: #2c3e50; /* Dark canvas background */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            width: 100% !important; /* Ensure charts are responsive */
            height: auto !important; /* Auto adjust height */
        }

        /* Flexbox container for the charts */
        .charts-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        /* For Dark Mode Tooltip */
        .chartjs-tooltip {
            background-color: rgba(0, 0, 0, 0.7) !important; /* Dark background for tooltip */
            color: #f5f5f5; /* Light text color in tooltip */
            border-radius: 5px;
            padding: 5px 10px;
        }

        /* Additional Styles */
        .legend {
            color: #ecf0f1; /* Light color for legend text */
        }
    </style>
</head>
<body>
    <h1>Tutoring Appointments Dashboard</h1>

    <p><strong>Total Appointments:</strong> {{ $totalAppointments }}</p>

    <div class="charts-wrapper">
        <div class="chart-container">
            <h3>Appointments by Tutor</h3>
            <canvas id="tutorChart"></canvas>
        </div>

        <div class="chart-container">
            <h3>Appointments by Student</h3>
            <canvas id="studentChart"></canvas>
        </div>

        <div class="chart-container">
            <h3>Appointments by Subject</h3>
            <canvas id="subjectChart"></canvas>
        </div>
    </div>

    <h2>All Appointments</h2>
    <div class="appointments-container">
        @foreach($appointments as $a)
            <div class="appointment-card">
                <p><strong>Tutor:</strong> {{ $tutors->firstWhere('id', $a['tutor_id'])['name'] }}</p>
                <p><strong>Student:</strong> {{ $students->firstWhere('id', $a['student_id'])['name'] }}</p>
                <p><strong>Subject:</strong> {{ $subjects->firstWhere('id', $a['subject_id'])['name'] }}</p>
                <p><strong>Date:</strong> {{ $a['date'] }}</p>
            </div>
        @endforeach
    </div>

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
            plugins: { 
                legend: { position: 'bottom', labels: { color: '#ecf0f1' } }, // Light color for legend
                tooltip: { callbacks: { label: function(tooltipItem) { return tooltipItem.label + ': ' + tooltipItem.raw; } } }
            }
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
                    ticks: { stepSize: 1, color: '#ecf0f1' } // Light color for y-axis ticks
                },
                x: {
                    ticks: { color: '#ecf0f1' } // Light color for x-axis ticks
                }
            },
            plugins: { 
                legend: { display: false },
                tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.7)' }
            }
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
            plugins: { 
                legend: { position: 'bottom', labels: { color: '#ecf0f1' } },
                tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.7)' }
            }
        }
    });
    </script>
</body>
</html>
