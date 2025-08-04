// Logout function: redirects to login page
function logout() {
    // Optionally, you can call backend logout API here to destroy session
    window.location.href = 'index.php';
}

// Show alert message dynamically
function showAlert(message, type = 'info', timeout = 3000) {
    const alertPlaceholder = document.getElementById('alert-placeholder');
    if (!alertPlaceholder) return;

    const wrapper = document.createElement('div');
    wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertPlaceholder.append(wrapper);

    if (timeout > 0) {
        setTimeout(() => {
            wrapper.remove();
        }, timeout);
    }
}

// Fetch wrapper with error handling
async function fetchJSON(url, options = {}) {
    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Request failed');
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        showAlert(error.message, 'danger');
        throw error;
    }
}

// Confirm dialog helper
function confirmAction(message) {
    return window.confirm(message);
}

// Example usage:
// fetchJSON('/api/some-endpoint')
//   .then(data => console.log(data))
//   .catch(err => console.error(err));