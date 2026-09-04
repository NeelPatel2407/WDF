document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll(".fees-table input");
    const studentName = inputs[0];
    const studentId = inputs[1];
    const institute = inputs[2];
    const branch = inputs[3];
    const feesAmount = inputs[4];
    const upiAccount = inputs[8];
    const ifsc = inputs[9];
    const captcha = inputs[10];

    const semester = document.querySelector("select");
    const paymentMethods = document.querySelectorAll('input[name="pay"]');
    const buttons = document.querySelectorAll(".buttons button");
    const payButton = buttons[0];
    const resetButton = buttons[1];

    const captchaValue = "CC2026";

    captcha.placeholder = "Enter " + captchaValue;

    payButton.addEventListener("click", function () {

        if (studentName.value.trim() === "") {
            alert("Please enter Student Name.");
            studentName.focus();
            return;
        }

        if (studentId.value.trim() === "") {
            alert("Please enter Student ID.");
            studentId.focus();
            return;
        }

        if (institute.value.trim() === "") {
            alert("Please enter Institute name.");
            institute.focus();
            return;
        }

        if (branch.value.trim() === "") {
            alert("Please enter your Branch.");
            branch.focus();
            return;
        }

        if (feesAmount.value.trim() === "") {
            alert("Please enter Fees Amount.");
            feesAmount.focus();
            return;
        }

        if (isNaN(feesAmount.value) || Number(feesAmount.value) <= 0) {
            alert("Please enter a valid Fees Amount.");
            feesAmount.focus();
            return;
        }

        let selectedPayment = false;

        paymentMethods.forEach(function (method) {
            if (method.checked) {
                selectedPayment = true;
            }
        });

        if (!selectedPayment) {
            alert("Please select a Payment Method.");
            return;
        }

        if (upiAccount.value.trim() === "") {
            alert("Please enter UPI ID or Account Number.");
            upiAccount.focus();
            return;
        }

        if (ifsc.value.trim() === "") {
            alert("Please enter IFSC Code.");
            ifsc.focus();
            return;
        }

        if (captcha.value.trim() === "") {
            alert("Please enter Captcha.");
            captcha.focus();
            return;
        }

        if (captcha.value.trim().toUpperCase() !== captchaValue) {
            alert("Incorrect Captcha.");
            captcha.focus();
            return;
        }

        alert(
            "Payment Successful!\n\n" +
            "Student: " + studentName.value + "\n" +
            "Student ID: " + studentId.value + "\n" +
            "Semester: " + semester.value + "\n" +
            "Amount Paid: ₹" + feesAmount.value
        );
    });

    resetButton.addEventListener("click", function () {
        setTimeout(function () {
            studentName.focus();
        }, 100);
    });

});