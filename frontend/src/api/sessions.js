import axios from 'axios';

const API_URL = 'http://localhost/backend/api/sessions';

export async function getSessions(token) {
  const response = await axios.get(API_URL, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}

export async function createSession(data, token) {
  const response = await axios.post(API_URL, data, {
    headers: { Authorization: `Bearer ${token}` }
  });
  return response.data;
}