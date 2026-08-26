document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll(".forgot-box input");

    const studentId = inputs[0];
    const email = inputs[1];
    const mobile = inputs[2];
    const newPassword = inputs[3];
    const confirmPassword = inputs[4];

    const buttons = document.querySelectorAll(".forgot-box button");
    const resetButton = buttons[0];
    const cancelButton = buttons[1];

    resetButton.addEventListener("click", function () {

        if (studentId.value.trim() === "") {
            alert("Please enter your Student ID.");
            studentId.focus();
            return;
        }

        if (email.value.trim() === "") {
            alert("Please enter your Email Address.");
            email.focus();
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            alert("Please enter a valid Email Address.");
            email.focus();
            return;
        }

        if (mobile.value.trim() === "") {
            alert("Please enter your Mobile Number.");
            mobile.focus();
            return;
        }

        if (!/^[0-9]{10}$/.test(mobile.value)) {
            alert("Mobile Number must contain exactly 10 digits.");
            mobile.focus();
            return;
        }

        if (newPassword.value === "") {
            alert("Please enter a New Password.");
            newPassword.focus();
            return;
        }

        if (newPassword.value.length < 6) {
            alert("New Password must contain at least 6 characters.");
            newPassword.focus();
            return;
        }

        if (confirmPassword.value === "") {
            alert("Please confirm your Password.");
            confirmPassword.focus();
            return;
        }

        if (newPassword.value !== confirmPassword.value) {
            alert("Passwords do not match.");
            confirmPassword.focus();
            return;
        }

        alert("Password reset successfully!");

        window.location.href = "login.html";
    });

    cancelButton.addEventListener("click", function () {
        studentId.value = "";
        email.value = "";
        mobile.value = "";
        newPassword.value = "";
        confirmPassword.value = "";

        studentId.focus();
    });

});