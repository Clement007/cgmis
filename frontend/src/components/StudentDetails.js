import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getStudentById, createStudent, updateStudent } from '../api/students';
import useAuth from '../hooks/useAuth';

function StudentDetails() {
  const { id } = useParams();
  const { token } = useAuth();
  const navigate = useNavigate();

  const [student, setStudent] = useState({
    first_name: '',
    last_name: '',
    email: '',
    career_interest: ''
  });
  const [error, setError] = useState('');

  useEffect(() => {
    if (id && id !== 'new') {
      fetchStudent();
    }
  }, [id]);

  const fetchStudent = async () => {
    try {
      const data = await getStudentById(id, token);
      setStudent(data);
    } catch {
      setError('Failed to load student');
    }
  };

  const handleChange = (e) => {
    setStudent({ ...student, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    try {
      if (id === 'new') {
        await createStudent(student, token);
      } else {
        await updateStudent(id, student, token);
      }
      navigate('/students');
    } catch {
      setError('Failed to save student');
    }
  };

  return (
    <div style={{ maxWidth: 500, margin: 'auto', padding: 20 }}>
      <h2>{id === 'new' ? 'Add New Student' : 'Edit Student'}</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>First Name</label><br />
          <input name="first_name" value={student.first_name} onChange={handleChange} required />
        </div>
        <div>
          <label>Last Name</label><br />
          <input name="last_name" value={student.last_name} onChange={handleChange} required />
        </div>
        <div>
          <label>Email</label><br />
          <input type="email" name="email" value={student.email} onChange={handleChange} required />
        </div>
        <div>
          <label>Career Interest</label><br />
          <input name="career_interest" value={student.career_interest} onChange={handleChange} />
        </div>
        {error && <p style={{ color: 'red' }}>{error}</p>}
        <button type="submit" style={{ marginTop: 10 }}>{id === 'new' ? 'Create' : 'Update'}</button>{' '}
        <button type="button" onClick={() => navigate('/students')} style={{ marginTop: 10 }}>Cancel</button>
      </form>
    </div>
  );
}

export default StudentDetails;