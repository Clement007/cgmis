import axios from 'axios';

const API_URL = 'http://localhost/backend/api/students';

export async function getStudents(token) {
  const response = await axios.get(API_URL, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}

export async function getStudentById(id, token) {
  const response = await axios.get(`${API_URL}/${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}

export async function createStudent(data, token) {
  const response = await axios.post(API_URL, data, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}

export async function updateStudent(id, data, token) {
  const response = await axios.put(`${API_URL}/${id}`, data, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}

export async function deleteStudent(id, token) {
  const response = await axios.delete(`${API_URL}/${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}