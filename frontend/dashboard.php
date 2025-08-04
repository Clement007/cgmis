<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - CGMIS</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .chart-container {
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
      margin-bottom: 2rem;
    }
    h2 {
      margin-bottom: 1.5rem;
      color: #357ABD;
      font-weight: 700;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="dashboard.php">CGMIS</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
          <li class="nav-item"><a class="nav-link" href="sessions.php">Sessions</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <h2>Dashboard</h2>

    <div class="row">
      <div class="col-lg-6">
        <div class="chart-container">
          <h5>Career Interests Distribution</h5>
          <canvas id="careerChart" width="400" height="300"></canvas>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="chart-container">
          <h5>Counseling Sessions by Counselor</h5>
          <canvas id="sessionChart" width="400" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function fetchCareerData() {
      const response = await fetch('/cgmis/backend/controllers/student.php');
      const students = await response.json();
      const careerCounts = {};
      students.forEach(s => {
        const career = s.career_interest || 'Unknown';
        careerCounts[career] = (careerCounts[career] || 0) + 1;
      });
      return careerCounts;
    }

    async function fetchSessionData() {
      const response = await fetch('/cgmis/backend/controllers/session.php');
      const sessions = await response.json();
      const counselorCounts = {};
      sessions.forEach(s => {
        const counselor = s.counselor_name || 'Unknown';
        counselorCounts[counselor] = (counselorCounts[counselor] || 0) + 1;
      });
      return counselorCounts;
    }

    async function renderCareerChart() {
      const data = await fetchCareerData();
      const ctx = document.getElementById('careerChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: Object.keys(data),
          datasets: [{
            label: 'Number of Students',
            data: Object.values(data),
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 5,
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 }
            }
          }
        }
      });
    }

    async function renderSessionChart() {
      const data = await fetchSessionData();
      const ctx = document.getElementById('sessionChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: Object.keys(data),
          datasets: [{
            label: 'Sessions',
            data: Object.values(data),
            backgroundColor: [
              '#357ABD',
              '#4A90E2',
              '#7BAAF7',
              '#A3C1FF',
              '#C9D9FF',
              '#E6F0FF'
            ],
            borderWidth: 1,
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'right' },
            tooltip: { enabled: true }
          }
        }
      });
    }

    // Render both charts
    renderCareerChart();
    renderSessionChart();
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>