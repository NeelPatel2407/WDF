document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll(".profile-table input");
    const firstName = inputs[0];
    const middleName = inputs[1];
    const lastName = inputs[2];
    const birthDate = inputs[3];
    const fatherName = inputs[5];
    const motherName = inputs[6];
    const contact = inputs[7];
    const email = inputs[8];
    const hobby = inputs[9];

    const gender = document.querySelectorAll('input[name="gender"]');
    const selects = document.querySelectorAll(".profile-table select");
    const program = selects[0];
    const semester = selects[1];
    const address = document.querySelector(".profile-table textarea");

    const buttons = document.querySelectorAll(".profile-table button");
    const uploadButton = buttons[0];
    const saveButton = buttons[1];
    const resetButton = buttons[2];

    uploadButton.addEventListener("click", function () {
        alert("Photo upload option selected.");
    });

    saveButton.addEventListener("click", function () {

        if (firstName.value.trim() === "") {
            alert("Please enter First Name.");
            firstName.focus();
            return;
        }

        if (lastName.value.trim() === "") {
            alert("Please enter Last Name.");
            lastName.focus();
            return;
        }

        if (birthDate.value === "") {
            alert("Please select Birth Date.");
            birthDate.focus();
            return;
        }

        let genderSelected = false;

        gender.forEach(function (item) {
            if (item.checked) {
                genderSelected = true;
            }
        });

        if (!genderSelected) {
            alert("Please select Gender.");
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

        if (contact.value.trim() === "") {
            alert("Please enter Contact Number.");
            contact.focus();
            return;
        }

        if (!/^[0-9]{10}$/.test(contact.value)) {
            alert("Contact Number must contain exactly 10 digits.");
            contact.focus();
            return;
        }

        if (email.value.trim() === "") {
            alert("Please enter Email.");
            email.focus();
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            alert("Please enter a valid Email.");
            email.focus();
            return;
        }

        if (address.value.trim() === "") {
            alert("Please enter Address.");
            address.focus();
            return;
        }

        alert(
            "Profile Saved Successfully!\n\n" +
            "Name: " + firstName.value + " " + lastName.value + "\n" +
            "Program: " + program.value + "\n" +
            "Semester: " + semester.value
        );
    });

    resetButton.addEventListener("click", function () {
        setTimeout(function () {
            firstName.focus();
        }, 100);
    });

});