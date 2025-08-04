import React, { useEffect, useState } from 'react';
import { getSessions } from '../api/sessions';
import useAuth from '../hooks/useAuth';

function SessionList() {
  const { token } = useAuth();
  const [sessions, setSessions] = useState([]);

  useEffect(() => {
    fetchSessions();
  }, []);

  const fetchSessions = async () => {
    const data = await getSessions(token);
    setSessions(data);
  };

  return (
    <div style={{ padding: 20 }}>
      <h2>Counseling Sessions</h2>
      <table border="1" cellPadding="8" style={{ marginTop: 10, width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr>
            <th>ID</th><th>Student</th><th>Counselor</th><th>Date</th><th>Notes</th>
          </tr>
        </thead>
        <tbody>
          {sessions.map(s => (
            <tr key={s.id}>
              <td>{s.id}</td>
              <td>{s.first_name} {s.last_name}</td>
              <td>{s.counselor_name}</td>
              <td>{s.session_date}</td>
              <td>{s.notes}</td>
            </tr>
          ))}
          {sessions.length === 0 && <tr><td colSpan="5">No sessions found.</td></tr>}
        </tbody>
      </table>
    </div>
  );
}

export default SessionList;