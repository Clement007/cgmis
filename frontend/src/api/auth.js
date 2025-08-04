import axios from 'axios';

const API_URL = 'http://localhost/backend/api/auth/login';

export async function login(email, password) {
  const response = await axios.post(API_URL, { email, password });
  return response.data;
}