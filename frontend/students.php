<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students - CGMIS</title>
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
        <tbody></tbody>
    </table>
</div>
<script>
async function fetchStudents() {
    const response = await fetch('../backend/controllers/student.php');
    const students = await response.json();
    const tbody = document.querySelector('#studentsTable tbody');
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
}

async function deleteStudent(id) {
    if (!confirm('Are you sure you want to delete this student?')) return;
    const response = await fetch(`../backend/controllers/student.php?action=delete&id=${id}`, {
        method: 'POST'
    });
    if (response.ok) {
        alert('Student deleted');
        fetchStudents();
    } else {
        alert('Failed to delete student');
    }
}

fetchStudents();
</script>
</body>
</html>
