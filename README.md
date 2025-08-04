 CGMIS - Career Guidance Management Information System

 Project Overview

CGMIS is a web application designed to manage student career guidance and counseling sessions. It provides an admin interface to manage students, schedule and record counseling sessions, and visualize career interest data.

 Technologies Used

- Backend: PHP (MySQLi), MySQL, WAMP stack
- Frontend: HTML, Bootstrap, Vanilla JavaScript, Chart.js
- Authentication: PHP sessions with password hashing
- Database: MySQL

 Setup Instructions

1. Install WAMP/XAMPP or any PHP-MySQL server stack.
2. Import the database schema from `sql/cgmis_schema.sql` into your MySQL server.
3. Configure database credentials in `backend/config/db.php`.
4. Start Apache and MySQL services.
5. Access the application via `public/index.php` in your browser.

 Usage

- Login with admin credentials.
- Manage students: add, edit, delete student records.
- Manage counseling sessions: schedule, edit, delete sessions.
- View dashboard analytics on career interests.

 File Structure
cgmis/
│
├── backend/
│ ├── config/
│ │ └── db.php  MySQLi connection setup
│ ├── controllers/
│ │ ├── auth.php  Admin login logic
│ │ ├── student.php  Student CRUD logic
│ │ └── session.php  Counseling session CRUD logic
│ ├── models/  (Optional) Data models
│ ├── middleware/  (Optional) Middleware for auth
│ └── index.php  (Optional) Main router
│
├── public/
│ ├── css/
│ │ └── bootstrap.min.css  Bootstrap CSS
│ ├── js/
│ │ └── main.js  (Optional) Frontend JS
│ ├── images/  Images
│ ├── index.php  Login page
│ ├── dashboard.php  Dashboard with charts
│ ├── students.php  Student list and management
│ ├── student_edit.php  Student create/edit form
│ ├── sessions.php  Counseling sessions list
│ └── session_edit.php  Session create/edit form
│
├── sql/
│ └── cgmis_schema.sql  Database schema
│
└── README.md  Project documentation


 Database Schema

- `admins`: Stores admin users with hashed passwords.
- `students`: Stores student information including career interests.
- `counseling_sessions`: Stores counseling session details linked to students.

Indexes are added on career interest and session date for performance.

 API Endpoints

- `POST /backend/controllers/auth.php` — Admin login.
- `GET /backend/controllers/student.php` — List or get student.
- `POST /backend/controllers/student.php` — Create, update, or delete student.
- `GET /backend/controllers/session.php` — List or get session.
- `POST /backend/controllers/session.php` — Create, update, or delete session.

All endpoints require admin session authentication.

 Security Notes

- Passwords are hashed using PHP's `password_hash`.
- Session-based authentication protects backend routes.
- Input is sanitized using MySQLi real escape string.
- CORS headers can be added if frontend is served separately.

 Future Improvements

- Implement JWT-based authentication for stateless API.
- Add role-based access control.
- Improve UI with React or Vue.js.
- Add search and filtering on lists.
- Implement export/import features for data.
- Add email notifications for sessions.

 Contact

For questions or support, contact the maintainer at ambitieux.clement@gmail.com.
