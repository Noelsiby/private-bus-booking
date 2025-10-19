// Validation for Registration Form
const registerForm = document.getElementById("registerForm");
if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        const username = document.querySelector('input[name="username"]').value;
        const phoneno = document.querySelector('input[name="phoneno"]').value;
        const password = document.querySelector('input[name="password"]').value;

        // Basic validation for registration
        if (!username || !phoneno || !password) {
            alert("Please fill in all fields.");
            event.preventDefault(); // Prevent form submission
        }
    });
}

// Validation for Login Form
const loginForm = document.getElementById("loginForm");
if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        const phoneno = document.querySelector('input[name="phoneno"]').value;
        const password = document.querySelector('input[name="password"]').value;

        // Basic validation for login
        if (!phoneno || !password) {
            alert("Please fill in all fields.");
            event.preventDefault(); // Prevent form submission
        }
    });
}
