import React, { useEffect, useState } from 'react';
import { getStudents, getSessions } from '../api/students';
import useAuth from '../hooks/useAuth';
import { Bar, Pie } from 'react-chartjs-2';
import { Chart, ArcElement, BarElement, CategoryScale, LinearScale, Tooltip, Legend } from 'chart.js';

Chart.register(ArcElement, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

function Dashboard() {
  const { token, logout } = useAuth();
  const [students, setStudents] = useState([]);
  const [sessions, setSessions] = useState([]);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    const studentsData = await getStudents(token);
    setStudents(studentsData);
    const sessionsData = await fetch('http://localhost/backend/api/sessions', {
      headers: { Authorization: `Bearer ${token}` }
    }).then(res => res.json());
    setSessions(sessionsData);
  };

  // Pie chart data: Career interests distribution
  const careerCounts = students.reduce((acc, s) => {
    acc[s.career_interest] = (acc[s.career_interest] || 0) + 1;
    return acc;
  }, {});

  const pieData = {
    labels: Object.keys(careerCounts),
    datasets: [{
      data: Object.values(careerCounts),
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
    }]
  };

  // Bar chart data: Sessions per counselor
  const counselorCounts = sessions.reduce((acc, s) => {
    acc[s.counselor_name] = (acc[s.counselor_name] || 0) + 1;
    return acc;
  }, {});

  const barData = {
    labels: Object.keys(counselorCounts),
    datasets: [{
      label: 'Sessions per Counselor',
      data: Object.values(counselorCounts),
      backgroundColor: '#36A2EB',
    }]
  };

  return (
    <div style={{ padding: 20 }}>
      <h1>Dashboard</h1>
      <button onClick={logout} style={{ marginBottom: 20 }}>Logout</button>

      <div style={{ maxWidth: 600, marginBottom: 40 }}>
        <h3>Career Interests Distribution</h3>
        <Pie data={pieData} />
      </div>

      <div style={{ maxWidth: 600 }}>
        <h3>Counseling Sessions per Counselor</h3>
        <Bar data={barData} options={{ scales: { y: { beginAtZero: true } } }} />
      </div>
    </div>
  );
}

export default Dashboard;