
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Counseling Sessions - CGMIS</title>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">CGMIS</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
        <li class="nav-item"><a class="nav-link active" href="sessions.php">Sessions</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h2>Counseling Sessions</h2>
    <a href="session_edit.php" class="btn btn-primary mb-3">Add New Session</a>
    <table class="table table-striped" id="sessionsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Counselor Name</th>
                <th>Session Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script>
async function fetchSessions() {
    const response = await fetch('../backend/controllers/session.php');
    const sessions = await response.json();
    const tbody = document.querySelector('#sessionsTable tbody');
    tbody.innerHTML = '';
    sessions.forEach(s => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${s.id}</td>
            <td>${s.student_id}</td>
            <td>${s.counselor_name}</td>
            <td>${s.session_date}</td>
            <td>${s.notes || ''}</td>
            <td>
                <a href="session_edit.php?id=${s.id}" class="btn btn-sm btn-warning me-2">Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteSession(${s.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

async function deleteSession(id) {
    if (!confirm('Are you sure you want to delete this session?')) return;
    const response = await fetch(`../backend/controllers/session.php?action=delete&id=${id}`, {
        method: 'POST'
    });
    if (response.ok) {
        alert('Session deleted');
        fetchSessions();
    } else {
        alert('Failed to delete session');
    }
}

fetchSessions();
</script>
</body>
</html>
