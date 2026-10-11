document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll(".form-table input");

    const firstName = inputs[0];
    const middleName = inputs[1];
    const lastName = inputs[2];
    const birthDate = inputs[3];
    const fatherName = inputs[4];
    const motherName = inputs[5];
    const contactNumber = inputs[6];
    const email = inputs[7];
    const password = inputs[8];
    const confirmPassword = inputs[9];

    const gender = document.querySelectorAll('input[name="gender"]');
    const course = document.querySelector("select");

    const buttons = document.querySelectorAll(".buttons button");

    const registerButton = buttons[0];
    const resetButton = buttons[1];

    registerButton.addEventListener("click", function () {

        if (firstName.value.trim() === "") {
            alert("Please enter your First Name.");
            firstName.focus();
            return;
        }

        if (!/^[A-Za-z ]+$/.test(firstName.value.trim())) {
            alert("First Name must contain letters only.");
            firstName.focus();
            return;
        }

        if (lastName.value.trim() === "") {
            alert("Please enter your Last Name.");
            lastName.focus();
            return;
        }

        if (!/^[A-Za-z ]+$/.test(lastName.value.trim())) {
            alert("Last Name must contain letters only.");
            lastName.focus();
            return;
        }

        if (birthDate.value === "") {
            alert("Please select your Birth Date.");
            birthDate.focus();
            return;
        }

        let selectedGender = false;

        gender.forEach(function (item) {
            if (item.checked) {
                selectedGender = true;
            }
        });

        if (!selectedGender) {
            alert("Please select your Gender.");
            return;
        }

        if (fatherName.value.trim() === "") {
            alert("Please enter Father's Name.");
            fatherName.focus();
            return;
        }

        if (!/^[A-Za-z ]+$/.test(fatherName.value.trim())) {
            alert("Father's Name must contain letters only.");
            fatherName.focus();
            return;
        }

        if (motherName.value.trim() === "") {
            alert("Please enter Mother's Name.");
            motherName.focus();
            return;
        }

        if (!/^[A-Za-z ]+$/.test(motherName.value.trim())) {
            alert("Mother's Name must contain letters only.");
            motherName.focus();
            return;
        }

        if (contactNumber.value.trim() === "") {
            alert("Please enter your Contact Number.");
            contactNumber.focus();
            return;
        }

        if (!/^[0-9]{10}$/.test(contactNumber.value)) {
            alert("Contact Number must contain exactly 10 digits.");
            contactNumber.focus();
            return;
        }

        if (email.value.trim() === "") {
            alert("Please enter your Email.");
            email.focus();
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            alert("Please enter a valid Email Address.");
            email.focus();
            return;
        }

        if (password.value === "") {
            alert("Please enter a Password.");
            password.focus();
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

        if (!/[a-z]/.test(password.value)) {
            alert("Password must contain at least one lowercase letter.");
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

        if (confirmPassword.value === "") {
            alert("Please confirm your Password.");
            confirmPassword.focus();
            return;
        }

        if (password.value !== confirmPassword.value) {
            alert("Passwords do not match.");
            confirmPassword.focus();
            return;
        }

        localStorage.setItem("studentId", contactNumber.value);
        localStorage.setItem("studentPassword", password.value);

        alert(
            "Registration Successful!\n\n" +
            "Welcome to CampusCore, " +
            firstName.value + " " + lastName.value + "."
        );

        window.location.href = "login.html";
    });

    resetButton.addEventListener("click", function () {

        setTimeout(function () {
            firstName.focus();
        }, 100);

    });

});