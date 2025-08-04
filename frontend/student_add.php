<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Student - CGMIS</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">CGMIS</a>
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
    <h2>Add New Student</h2>
    <form id="addStudentForm">
      <div class="mb-3">
        <label for="firstName" class="form-label">First Name *</label>
        <input type="text" class="form-control" id="firstName" required />
      </div>
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name *</label>
        <input type="text" class="form-control" id="lastName" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email *</label>
        <input type="email" class="form-control" id="email" required />
      </div>
      <div class="mb-3">
        <label for="careerInterest" class="form-label">Career Interest</label>
        <input type="text" class="form-control" id="careerInterest" />
      </div>
      <button type="submit" class="btn btn-primary">Add Student</button>
      <a href="students.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
  </div>

  <script>
    document.getElementById('addStudentForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const first_name = document.getElementById('firstName').value.trim();
      const last_name = document.getElementById('lastName').value.trim();
      const email = document.getElementById('email').value.trim();
      const career_interest = document.getElementById('careerInterest').value.trim();

      if (!first_name || !last_name || !email) {
        alert('Please fill in all required fields.');
        return;
      }

      const payload = { first_name, last_name, email, career_interest };

      try {
        const response = await fetch('/cgmis/backend/controllers/student.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'include',
          body: JSON.stringify(payload),
        });

        const data = await response.json();

        if (response.ok) {
          alert('Student added successfully');
          window.location.href = 'students.php';
        } else {
          alert('Failed to add student: ' + (data.error || 'Unknown error'));
        }
      } catch (error) {
        alert('Network error. Please try again.');
        console.error(error);
      }
    });
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>