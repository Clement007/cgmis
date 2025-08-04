import React, { useEffect, useState } from 'react';
import { getStudents, deleteStudent } from '../api/students';
import useAuth from '../hooks/useAuth';
import { Link, useNavigate } from 'react-router-dom';

function StudentList() {
  const { token } = useAuth();
  const [students, setStudents] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    fetchStudents();
  }, []);

  const fetchStudents = async () => {
    const data = await getStudents(token);
    setStudents(data);
  };

  const handleDelete = async (id) => {
    if (window.confirm('Are you sure you want to delete this student?')) {
      await deleteStudent(id, token);
      fetchStudents();
    }
  };

  return (
    <div style={{ padding: 20 }}>
      <h2>Students</h2>
      <button onClick={() => navigate('/students/new')}>Add New Student</button>
      <table border="1" cellPadding="8" style={{ marginTop: 10, width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Career Interest</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {students.map(s => (
            <tr key={s.id}>
              <td>{s.id}</td>
              <td><Link to={`/students/${s.id}`}>{s.first_name} {s.last_name}</Link></td>
              <td>{s.email}</td>
              <td>{s.career_interest}</td>
              <td>
                <button onClick={() => navigate(`/students/${s.id}`)}>Edit</button>{' '}
                <button onClick={() => handleDelete(s.id)}>Delete</button>
              </td>
            </tr>
          ))}
          {students.length === 0 && <tr><td colSpan="5">No students found.</td></tr>}
        </tbody>
      </table>
    </div>
  );
}

export default StudentList;