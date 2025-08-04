 CGMIS (Career Guidance Management Information System)

This project is a web-based Career Guidance Management Information System (CGMIS) built with:
- PHP (WAMP stack) for the backend
- React for the frontend
- MySQL for the database



 Project Structure


cgmis/
│
├── backend/                   PHP + MySQL backend (WAMP)
├── frontend/                  React frontend
└── README.md                  This file




 Backend Setup (PHP + MySQL - WAMP)

 Requirements
- [WAMP Server](https://www.wampserver.com/en/) or XAMPP
- PHP 7.4 or later
- Composer (for PHP dependencies, if any)
- MySQL

 Backend Folder Structure
- backend/config/db.php – Database configuration
- backend/controllers/ – Main logic controllers
- backend/models/ – Data models
- backend/routes/ – API routing
- backend/middleware/ – Authentication middleware
- backend/index.php – Entry point for API

 Setup Instructions

1. Clone or copy cgmis/backend into your www or htdocs folder:
   bash
   cp -r cgmis/backend/ C:/wamp64/www/cgmis-backend/
   

2. Set up MySQL database:
   - Open phpMyAdmin
   - Create a new database, e.g., cgmis_db
   - Import your database schema if provided (e.g., cgmis_db.sql)

3. Edit the DB configuration:
   - File: backend/config/db.php
   - Update DB name, username, password

4. (Optional) Install Composer dependencies:
   bash
   cd C:/wamp64/www/cgmis-backend/
   composer install
   

5. Start WAMP or XAMPP

6. Access API in browser or Postman:
   
   http://localhost/cgmis-backend/
   

 Frontend Setup (React)

 Requirements
- Node.js (v16 or later)
- npm or yarn

 Frontend Folder Structure
- src/api/ – API service functions
- src/components/ – React UI components
- src/context/ – React context (auth management)
- src/hooks/ – Custom hooks
- public/index.html – HTML template
- src/App.js – Main App router

 Setup Instructions

1. Navigate to the frontend folder:
   bash
   cd cgmis/frontend
   

2. Install dependencies:
   bash
   npm install
   

3. Configure API base URL:
   - Inside src/api/*.js, ensure the base URL points to your backend:
     js
     const API_URL = "http://localhost/cgmis-backend/";
     

4. Start the React development server:
   bash
   npm start
   

5. Open in browser:
   
   http://localhost:3000
   

Summary of Commands

 Backend (PHP)
bash
 Go to backend folder (inside www or htdocs)
cd C:/wamp64/www/cgmis-backend/

 Optional: Install PHP dependencies
composer install

 Start WAMP/XAMPP and go to:
http://localhost/cgmis-backend/


 Frontend (React)
bash
cd cgmis/frontend
npm install
npm start




Contact
For any issues or support, please contact the project maintainer(+25078807133).
