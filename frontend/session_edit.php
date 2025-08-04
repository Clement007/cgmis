
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Counseling Session - CGMIS</title>
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
        <li class="nav-item"><a class="nav-link" href="sessions.php">Sessions</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h2 id="formTitle">Add New Session</h2>
    <form id="sessionForm">
        <input type="hidden" id="sessionId">
        <div class="mb-3">
            <label for="studentId" class="form-label">Student ID</label>
            <input type="number" class="form-control" id="studentId" required>
        </div>
        <div class="mb-3">
            <label for="counselorName" class="form-label">Counselor Name</label>
            <input type="text" class="form-control" id="counselorName" required>
        </div>
        <div class="mb-3">
            <label for="sessionDate" class="form-label">Session Date</label>
            <input type="date" class="form-control" id="sessionDate" required>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="sessions.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
<script>
const urlParams = new URLSearchParams(window.location.search);
const sessionId = urlParams.get('id');

if (sessionId) {
    document.getElementById('formTitle').textContent = 'Edit Session';
    fetch(`../backend/controllers/session.php?id=${sessionId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('sessionId').value = data.id;
            document.getElementById('studentId').value = data.student_id;
            document.getElementById('counselorName').value = data.counselor_name;
            document.getElementById('sessionDate').value = data.session_date;
            document.getElementById('notes').value = data.notes || '';
        });
}

document.getElementById('sessionForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('sessionId').value;
    const student_id = document.getElementById('studentId').value;
    const counselor_name = document.getElementById('counselorName').value;
    const session_date = document.getElementById('sessionDate').value;
    const notes = document.getElementById('notes').value;

    const payload = { student_id, counselor_name, session_date, notes };
    let url = '../backend/controllers/session.php';
    if (id) {
        url += `?id=${id}`;
    }

    const response = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });

    if (response.ok) {
        alert('Session saved successfully');
        window.location.href = 'sessions.php';
    } else {
        alert('Failed to save session');
    }
});
</script>
</body>
</html>
