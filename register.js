document.getElementById("registrationForm").addEventListener("submit", function (e) {
    const name = document.getElementById("name").value.trim();
    const post = document.getElementById("post").value;
    const email = document.getElementById("email").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    const errorMessage = document.getElementById("errorMessage");
    errorMessage.textContent = "";

    if (!name || !post || !email || !username || !password) {
        errorMessage.textContent = "All fields are required.";
        e.preventDefault();
        return;
    }

    if (password.length < 6) {
        errorMessage.textContent = "Password must be at least 6 characters long.";
        e.preventDefault();
        return;
    }

    if (!validateEmail(email)) {
        errorMessage.textContent = "Please enter a valid email address.";
        e.preventDefault();
        return;
    }
});

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
