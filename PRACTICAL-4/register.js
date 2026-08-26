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

        if (lastName.value.trim() === "") {
            alert("Please enter your Last Name.");
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

        if (motherName.value.trim() === "") {
            alert("Please enter Mother's Name.");
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

        if (password.value === "") {
            alert("Please enter a Password.");
            password.focus();
            return;
        }

        if (password.value.length < 6) {
            alert("Password must contain at least 6 characters.");
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