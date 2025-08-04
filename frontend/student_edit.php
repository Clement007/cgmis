
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student - CGMIS</title>
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
    <h2 id="formTitle">Add New Student</h2>
    <form id="studentForm">
        <input type="hidden" id="studentId">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="careerInterest" class="form-label">Career Interest</label>
            <input type="text" class="form-control" id="careerInterest">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="students.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
<script>
const urlParams = new URLSearchParams(window.location.search);
const studentId = urlParams.get('id');

if (studentId) {
    document.getElementById('formTitle').textContent = 'Edit Student';
    fetch(`../backend/controllers/student.php?id=${studentId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('studentId').value = data.id;
            document.getElementById('firstName').value = data.first_name;
            document.getElementById('lastName').value = data.last_name;
            document.getElementById('email').value = data.email;
            document.getElementById('careerInterest').value = data.career_interest || '';
        });
}

document.getElementById('studentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('studentId').value;
    const first_name = document.getElementById('firstName').value;
    const last_name = document.getElementById('lastName').value;
    const email = document.getElementById('email').value;
    const career_interest = document.getElementById('careerInterest').value;

    const payload = { first_name, last_name, email, career_interest };
    let url = '../backend/controllers/student.php';
    if (id) {
        url += `?id=${id}`;
    }

    const response = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });

    if (response.ok) {
        alert('Student saved successfully');
        window.location.href = 'students.php';
    } else {
        alert('Failed to save student');
    }
});
</script>
</body>
</html>
