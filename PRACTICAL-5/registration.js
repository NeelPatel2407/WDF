document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("registrationForm");

    const studentId = document.getElementById("studentId");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const email = document.getElementById("email");
    const mobile = document.getElementById("mobile");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const course = document.getElementById("course");
    const year = document.getElementById("year");
    const terms = document.getElementById("terms");

    const studentIdError = document.getElementById("studentIdError");
    const firstNameError = document.getElementById("firstNameError");
    const lastNameError = document.getElementById("lastNameError");
    const emailError = document.getElementById("emailError");
    const mobileError = document.getElementById("mobileError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    const courseError = document.getElementById("courseError");
    const yearError = document.getElementById("yearError");
    const genderError = document.getElementById("genderError");
    const termsError = document.getElementById("termsError");

    const strengthBar = document.getElementById("strengthBar");
    const strengthText = document.getElementById("strengthText");
    const successMessage = document.getElementById("successMessage");

    const idPattern = /^[A-Za-z0-9]{4,20}$/;
    const namePattern = /^[A-Za-z ]+$/;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const mobilePattern = /^[0-9]{10}$/;

    function setError(input, errorElement, message) {
        errorElement.textContent = message;
        input.classList.add("input-error");
        input.classList.remove("input-success");
    }

    function setSuccess(input, errorElement) {
        input.classList.remove("input-error");
        input.classList.add("input-success");
        errorElement.textContent = "";
    }

    function validateStudentId() {

        if (studentId.value.trim() === "") {
            setError(studentId, studentIdError, "Student ID is required.");
            return false;
        }

        if (!idPattern.test(studentId.value.trim())) {
            setError(
                studentId,
                studentIdError,
                "Student ID must contain 4-20 letters or numbers."
            );
            return false;
        }

        setSuccess(studentId, studentIdError);
        return true;
    }

    function validateFirstName() {

        if (firstName.value.trim() === "") {
            setError(firstName, firstNameError, "First name is required.");
            return false;
        }

        if (!namePattern.test(firstName.value.trim())) {
            setError(firstName, firstNameError, "Use letters only.");
            return false;
        }

        setSuccess(firstName, firstNameError);
        return true;
    }

    function validateLastName() {

        if (lastName.value.trim() === "") {
            setError(lastName, lastNameError, "Last name is required.");
            return false;
        }

        if (!namePattern.test(lastName.value.trim())) {
            setError(lastName, lastNameError, "Use letters only.");
            return false;
        }

        setSuccess(lastName, lastNameError);
        return true;
    }

    function validateEmail() {

        if (email.value.trim() === "") {
            setError(email, emailError, "Email address is required.");
            return false;
        }

        if (!emailPattern.test(email.value.trim())) {
            setError(email, emailError, "Enter a valid email address.");
            return false;
        }

        setSuccess(email, emailError);
        return true;
    }

    function validateMobile() {

        if (mobile.value.trim() === "") {
            setError(mobile, mobileError, "Mobile number is required.");
            return false;
        }

        if (!mobilePattern.test(mobile.value.trim())) {
            setError(
                mobile,
                mobileError,
                "Mobile number must contain exactly 10 digits."
            );
            return false;
        }

        setSuccess(mobile, mobileError);
        return true;
    }

    function validatePassword() {

        const value = password.value;

        if (value === "") {
            setError(password, passwordError, "Password is required.");
            return false;
        }

        if (value.length < 8 || value.length > 16) {
            setError(
                password,
                passwordError,
                "Password must be 8-16 characters."
            );
            return false;
        }

        if (!/[A-Z]/.test(value)) {
            setError(
                password,
                passwordError,
                "Password needs at least one uppercase letter."
            );
            return false;
        }

        if (!/[a-z]/.test(value)) {
            setError(
                password,
                passwordError,
                "Password needs at least one lowercase letter."
            );
            return false;
        }

        if (!/[0-9]/.test(value)) {
            setError(
                password,
                passwordError,
                "Password needs at least one number."
            );
            return false;
        }

        if (!/[!@#$%^&*(),.?":{}|<>_\-]/.test(value)) {
            setError(
                password,
                passwordError,
                "Password needs at least one special character."
            );
            return false;
        }

        setSuccess(password, passwordError);
        return true;
    }

    function updatePasswordStrength() {

        const value = password.value;
        let score = 0;

        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[a-z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[!@#$%^&*]/.test(value)) score++;
        if (value.length >= 12) score++;

        if (value === "") {
            strengthBar.style.width = "0%";
            strengthText.textContent = "";
        } else if (score <= 2) {
            strengthBar.style.width = "30%";
            strengthText.textContent = "Weak";
        } else if (score <= 4) {
            strengthBar.style.width = "65%";
            strengthText.textContent = "Medium";
        } else {
            strengthBar.style.width = "100%";
            strengthText.textContent = "Strong";
        }
    }

    function validateConfirmPassword() {

        if (confirmPassword.value === "") {
            setError(
                confirmPassword,
                confirmPasswordError,
                "Please confirm your password."
            );
            return false;
        }

        if (confirmPassword.value !== password.value) {
            setError(
                confirmPassword,
                confirmPasswordError,
                "Passwords do not match."
            );
            return false;
        }

        setSuccess(confirmPassword, confirmPasswordError);
        return true;
    }

    function validateCourse() {

        if (course.value === "") {
            courseError.textContent = "Please select a course.";
            course.classList.add("input-error");
            return false;
        }

        courseError.textContent = "";
        course.classList.add("input-success");
        course.classList.remove("input-error");

        return true;
    }

    function validateYear() {

        if (year.value === "") {
            yearError.textContent = "Please select your year.";
            year.classList.add("input-error");
            return false;
        }

        yearError.textContent = "";
        year.classList.add("input-success");
        year.classList.remove("input-error");

        return true;
    }

    function validateGender() {

        const gender = document.querySelector(
            'input[name="gender"]:checked'
        );

        if (!gender) {
            genderError.textContent = "Please select your gender.";
            return false;
        }

        genderError.textContent = "";
        return true;
    }

    function validateTerms() {

        if (!terms.checked) {
            termsError.textContent =
                "You must accept the Terms and Conditions.";
            return false;
        }

        termsError.textContent = "";
        return true;
    }

    studentId.addEventListener("input", validateStudentId);
    firstName.addEventListener("input", validateFirstName);
    lastName.addEventListener("input", validateLastName);
    email.addEventListener("input", validateEmail);
    mobile.addEventListener("input", validateMobile);

    password.addEventListener("input", function () {
        updatePasswordStrength();
        validatePassword();

        if (confirmPassword.value !== "") {
            validateConfirmPassword();
        }
    });

    confirmPassword.addEventListener("input", validateConfirmPassword);
    course.addEventListener("change", validateCourse);
    year.addEventListener("change", validateYear);
    terms.addEventListener("change", validateTerms);

    document.querySelectorAll('input[name="gender"]').forEach(function (gender) {
        gender.addEventListener("change", validateGender);
    });

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        const validStudentId = validateStudentId();
        const validFirstName = validateFirstName();
        const validLastName = validateLastName();
        const validEmail = validateEmail();
        const validMobile = validateMobile();
        const validPassword = validatePassword();
        const validConfirmPassword = validateConfirmPassword();
        const validCourse = validateCourse();
        const validYear = validateYear();
        const validGender = validateGender();
        const validTerms = validateTerms();

        if (
            validStudentId &&
            validFirstName &&
            validLastName &&
            validEmail &&
            validMobile &&
            validPassword &&
            validConfirmPassword &&
            validCourse &&
            validYear &&
            validGender &&
            validTerms
        ) {

            localStorage.setItem(
                "registeredStudentId",
                studentId.value.trim()
            );

            localStorage.setItem(
                "registeredPassword",
                password.value
            );

            localStorage.setItem(
                "registeredName",
                firstName.value.trim() + " " + lastName.value.trim()
            );

            successMessage.textContent =
                "Registration successful! Redirecting to Login...";

            alert("Registration Successful!");

            window.location.href = "../PRACTICAL-2/login.html";
        }
    });

    form.addEventListener("reset", function () {

        setTimeout(function () {

            document.querySelectorAll(".error").forEach(function (error) {
                error.textContent = "";
            });

            document.querySelectorAll("input, select").forEach(function (input) {
                input.classList.remove("input-error");
                input.classList.remove("input-success");
            });

            strengthBar.style.width = "0%";
            strengthText.textContent = "";
            successMessage.textContent = "";

        }, 10);
    });

});