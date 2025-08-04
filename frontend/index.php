<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - CGMIS</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #4a90e2, #357ABD);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-container {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }
    .login-title {
      font-weight: 700;
      color: #357ABD;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    #alert-placeholder {
      margin-bottom: 1rem;
    }
    button:disabled {
      cursor: not-allowed;
      opacity: 0.7;
    }
  </style>
</head>
<body>
  <main class="login-container" role="main" aria-labelledby="loginTitle">
    <h1 id="loginTitle" class="login-title">User Login</h1>
    <div id="alert-placeholder" aria-live="polite" aria-atomic="true"></div>
    <form id="loginForm" novalidate>
      <div class="mb-3">
        <label for="role" class="form-label">Select Role</label>
        <select id="role" name="role" class="form-select" required>
          <option value="" disabled selected>Select your role</option>
          <option value="Admin">Admin</option>
          <option value="Counselor">Counselor</option>
          <option value="Viewer">Viewer</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="xyz@cgmis.org"
          required
          autocomplete="username"
          aria-describedby="emailHelp"
        />
        <div id="emailHelp" class="form-text">
          We'll never share your email with anyone else.
        </div>
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Enter your password"
          required
          autocomplete="current-password"
        />
      </div>
      <button type="submit" class="btn btn-primary w-100" id="loginBtn">
        Login
      </button>
    </form>
  </main>

  <script>
    const loginForm = document.getElementById('loginForm');
    const alertPlaceholder = document.getElementById('alert-placeholder');
    const loginBtn = document.getElementById('loginBtn');

    function showAlert(message, type = 'danger') {
      alertPlaceholder.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    }

    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      if (!loginForm.checkValidity()) {
        showAlert('Please fill in all required fields correctly.', 'warning');
        return;
      }

      loginBtn.disabled = true;
      alertPlaceholder.innerHTML = '';

      const role = loginForm.role.value;
      const email = loginForm.email.value.trim();
      const password = loginForm.password.value;

      try {
        const response = await fetch('/cgmis/backend/controllers/auth.php', {
  		method: 'POST',
  		headers: { 'Content-Type': 'application/json' },
 	 	body: JSON.stringify({ role, email, password }),
		});

        const data = await response.json();

        if (response.ok) {
          showAlert('Login successful! Redirecting...', 'success');
          // Redirect based on role
         setTimeout(() => {
		  if (role === 'Admin' || role === 'Counselor') {
		    window.location.href = '/cgmis/public/dashboard.php';
		  } else if (role === 'Viewer') {
		    window.location.href = '/cgmis/public/viewer_dashboard.php'; // create if needed
		  } else {
		    window.location.href = '/cgmis/public/dashboard.php';
		  }
		}, 1000);
        } else {
          showAlert(data.error || 'Login failed. Please try again.');
        }
      } catch (error) {
        showAlert('Network error. Please try again later.');
      } finally {
        loginBtn.disabled = false;
      }
    });
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>