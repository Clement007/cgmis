<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Students - CGMIS</title>
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
          <li class="nav-item"><a class="nav-link active" href="students.php">Students</a></li>
          <li class="nav-item"><a class="nav-link" href="sessions.php">Sessions</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <h2>Students</h2>
    <a href="student_edit.php" class="btn btn-primary mb-3">Add New Student</a>
    <table class="table table-striped" id="studentsTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Career Interest</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Student rows will be inserted here -->
      </tbody>
    </table>
  </div>

  <script>
   async function fetchStudents() {
  const tbody = document.querySelector('#studentsTable tbody');
  tbody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';

  try {
    const response = await fetch('/cgmis/backend/controllers/student.php', { credentials: 'include' });
    const text = await response.text();
    console.log('Raw response:', text);
    const students = JSON.parse(text);

    if (!Array.isArray(students) || students.length === 0) {
      tbody.innerHTML = '<tr><td colspan="6" class="text-center">No students found.</td></tr>';
      return;
    }

    tbody.innerHTML = '';

    students.forEach(s => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${s.id}</td>
        <td>${s.first_name}</td>
        <td>${s.last_name}</td>
        <td>${s.email}</td>
        <td>${s.career_interest || ''}</td>
        <td>
          <a href="student_edit.php?id=${s.id}" class="btn btn-sm btn-warning me-2">Edit</a>
          <button class="btn btn-sm btn-danger" onclick="deleteStudent(${s.id})">Delete</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  } catch (error) {
    console.error('Failed to fetch students:', error);
    tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Failed to load students. Please try again later.</td></tr>`;
  }
}
    async function deleteStudent(id) {
      if (!confirm('Are you sure you want to delete this student?')) return;

      try {
        const response = await fetch(`/cgmis/backend/controllers/student.php?action=delete&id=${id}`, {
          method: 'POST',
          credentials: 'include'
        });
        if (!response.ok) throw new Error('Failed to delete student');

        alert('Student deleted');
        fetchStudents();
      } catch (error) {
        console.error('Delete error:', error);
        alert('Failed to delete student. Please try again.');
      }
    }

    // Initial fetch on page load
    fetchStudents();
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>