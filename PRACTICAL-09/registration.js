
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("registrationForm");

    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const mobile = document.getElementById("mobile");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const course = document.getElementById("course");
    const year = document.getElementById("year");
    const gender = document.querySelectorAll('input[name="gender"]');
    const terms = document.getElementById("terms");

    const resetButton = form.querySelector('button[type="reset"]');

    document.querySelectorAll("input[required], select[required]").forEach(function (field) {
        const label = document.querySelector('label[for="' + field.id + '"]');

        if (label && !label.querySelector(".required-star")) {
            const star = document.createElement("span");
            star.className = "required-star";
            star.textContent = " *";
            star.style.color = "red";
            star.style.fontWeight = "bold";
            label.appendChild(star);
        }
    });

    const genderLegend = document.querySelector("fieldset legend");

    if (genderLegend && !genderLegend.querySelector(".required-star")) {
        const star = document.createElement("span");
        star.className = "required-star";
        star.textContent = " *";
        star.style.color = "red";
        star.style.fontWeight = "bold";
        genderLegend.appendChild(star);
    }

    const termsLabel = terms.closest("label");

    if (termsLabel && !termsLabel.querySelector(".required-star")) {
        const star = document.createElement("span");
        star.className = "required-star";
        star.textContent = " *";
        star.style.color = "red";
        star.style.fontWeight = "bold";
        termsLabel.appendChild(star);
    }

    password.addEventListener("input", function () {
        const value = password.value;
        let score = 0;

        if (value.length >= 8 && value.length <= 16) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[a-z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[!@#$%^&*(),.?":{}|<>\-]/.test(value)) score++;

        const bar = document.getElementById("strengthBar");
        const text = document.getElementById("strengthText");

        if (!bar || !text) return;

        bar.style.width = (score * 20) + "%";

        bar.style.background =
            score <= 2 ? "#dc3545" :
            score === 3 ? "#ffc107" :
            score === 4 ? "#28a745" : "#198754";

        const labels = [
            "Very Weak",
            "Weak",
            "Fair",
            "Good",
            "Strong",
            "Strong"
        ];

        text.textContent = value ? labels[score] : "";

        text.style.color =
            score <= 2 ? "#dc3545" :
            score === 3 ? "#c58b00" : "#198754";
    });

    function showError(id, message) {
        const error = document.getElementById(id);

        if (error) {
            error.textContent = message;
            error.style.color = "red";
        }
    }

    function clearErrors() {
        document.querySelectorAll(".error").forEach(function (error) {
            error.textContent = "";
        });
    }

    form.addEventListener("submit", function (event) {
        clearErrors();

        let valid = true;

        if (!/^[A-Za-z ]{1,50}$/.test(firstName.value.trim())) {
            showError("firstNameError", "Enter a valid first name.");
            valid = false;
        }

        if (!/^[A-Za-z ]{1,50}$/.test(lastName.value.trim())) {
            showError("lastNameError", "Enter a valid last name.");
            valid = false;
        }

        if (!/^[A-Za-z0-9_]{3,50}$/.test(username.value.trim())) {
            showError("usernameError", "Use 3-50 letters, numbers or underscores.");
            valid = false;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            showError("emailError", "Enter a valid email address.");
            valid = false;
        }

        if (!/^[0-9]{10}$/.test(mobile.value.trim())) {
            showError("mobileError", "Enter exactly 10 digits.");
            valid = false;
        }

        const passwordValid =
            password.value.length >= 8 &&
            password.value.length <= 16 &&
            /[A-Z]/.test(password.value) &&
            /[a-z]/.test(password.value) &&
            /[0-9]/.test(password.value) &&
            /[!@#$%^&*(),.?":{}|<>\-]/.test(password.value);

        if (!passwordValid) {
            showError(
                "passwordError",
                "Use 8-16 characters with uppercase, lowercase, a number and a special character."
            );
            valid = false;
        }

        if (confirmPassword.value === "") {
            showError("confirmPasswordError", "Please confirm your password.");
            valid = false;
        } else if (password.value !== confirmPassword.value) {
            showError("confirmPasswordError", "Passwords do not match.");
            valid = false;
        }

        if (course.value === "") {
            showError("courseError", "Please select your course.");
            valid = false;
        }

        if (year.value === "") {
            showError("yearError", "Please select your year.");
            valid = false;
        }

        let genderSelected = false;

        gender.forEach(function (item) {
            if (item.checked) genderSelected = true;
        });

        if (!genderSelected) {
            showError("genderError", "Please select your gender.");
            valid = false;
        }

        if (!terms.checked) {
            showError("termsError", "Please accept the Terms and Conditions.");
            valid = false;
        }

        if (!valid) {
            event.preventDefault();

            const firstError = document.querySelector(".error:not(:empty)");

            if (firstError) {
                const formGroup = firstError.closest(".form-group");
                const field = formGroup
                    ? formGroup.querySelector("input, select")
                    : null;

                if (field) field.focus();
            }
        }
    });

    resetButton.addEventListener("click", function () {
        setTimeout(function () {
            clearErrors();

            const bar = document.getElementById("strengthBar");
            const text = document.getElementById("strengthText");

            if (bar) {
                bar.style.width = "0%";
                bar.style.background = "#dc3545";
            }

            if (text) {
                text.textContent = "";
            }

            firstName.focus();
        }, 0);
    });

});