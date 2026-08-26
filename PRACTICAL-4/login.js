document.addEventListener("DOMContentLoaded", function () {

    const studentId = document.querySelector('input[type="text"]');
    const password = document.querySelector('input[type="password"]');
    const rememberMe = document.querySelector('input[type="checkbox"]');
    const loginButton = document.querySelector("button");

    loginButton.addEventListener("click", function () {

        if (studentId.value.trim() === "") {
            alert("Please enter your Student ID.");
            studentId.focus();
            return;
        }

        if (password.value.trim() === "") {
            alert("Please enter your Password.");
            password.focus();
            return;
        }

        if (studentId.value.length < 4) {
            alert("Student ID must contain at least 4 characters.");
            studentId.focus();
            return;
        }

        if (password.value.length < 8 || password.value.length > 16) {
            alert("Password must be between 8 and 16 characters.");
            password.focus();
            return;
        }

        if (!/[A-Z]/.test(password.value)) {
            alert("Password must contain at least one uppercase letter.");
            password.focus();
            return;
        }

        if (!/[0-9]/.test(password.value)) {
            alert("Password must contain at least one number.");
            password.focus();
            return;
        }

        if (!/[!@#$%^&*(),.?":{}|<>_\-]/.test(password.value)) {
            alert("Password must contain at least one special character.");
            password.focus();
            return;
        }

        if (rememberMe.checked) {
            localStorage.setItem("studentId", studentId.value);
        } else {
            localStorage.removeItem("studentId");
        }

        alert("Login successful! Welcome to CampusCore.");

        window.location.href = "dashboard.html";
    });

    const savedStudentId = localStorage.getItem("studentId");

    if (savedStudentId) {
        studentId.value = savedStudentId;
        rememberMe.checked = true;
    }

});