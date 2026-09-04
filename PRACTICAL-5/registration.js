document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registrationForm");
    const id = document.getElementById("studentId");
    const first = document.getElementById("firstName");
    const last = document.getElementById("lastName");
    const email = document.getElementById("email");
    const mobile = document.getElementById("mobile");
    const pass = document.getElementById("password");
    const confirm = document.getElementById("confirmPassword");
    const course = document.getElementById("course");
    const year = document.getElementById("year");
    const terms = document.getElementById("terms");

    function error(input, msg) {
        document.getElementById(input.id + "Error").textContent = msg;
        input.classList.add("input-error");
        input.classList.remove("input-success");
        return false;
    }

    function ok(input) {
        document.getElementById(input.id + "Error").textContent = "";
        input.classList.remove("input-error");
        input.classList.add("input-success");
        return true;
    }

    function check(input, pattern, msg) {
        if (!input.value.trim()) return error(input, "This field is required.");
        if (!pattern.test(input.value.trim())) return error(input, msg);
        return ok(input);
    }

    function passwordCheck() {
        let p = pass.value;

        if (!p) return error(pass, "Password is required.");
        if (p.length < 8 || p.length > 16)
            return error(pass, "Password must be 8-16 characters.");
        if (!/[A-Z]/.test(p))
            return error(pass, "Add an uppercase letter.");
        if (!/[a-z]/.test(p))
            return error(pass, "Add a lowercase letter.");
        if (!/[0-9]/.test(p))
            return error(pass, "Add a number.");
        if (!/[!@#$%^&*]/.test(p))
            return error(pass, "Add a special character.");

        return ok(pass);
    }

    function strength() {
        let p = pass.value, score = 0;

        if (p.length >= 8) score++;
        if (/[A-Z]/.test(p)) score++;
        if (/[a-z]/.test(p)) score++;
        if (/[0-9]/.test(p)) score++;
        if (/[!@#$%^&*]/.test(p)) score++;
        if (p.length >= 12) score++;

        const bar = document.getElementById("strengthBar");
        const text = document.getElementById("strengthText");

        bar.style.width = p ? (score <= 2 ? "30%" : score <= 4 ? "65%" : "100%") : "0%";
        text.textContent = p ? (score <= 2 ? "Weak" : score <= 4 ? "Medium" : "Strong") : "";
    }

    function selectCheck(input, msg) {
        return input.value ? ok(input) : error(input, msg);
    }

    function genderCheck() {
        let gender = document.querySelector('input[name="gender"]:checked');
        document.getElementById("genderError").textContent =
            gender ? "" : "Please select your gender.";
        return !!gender;
    }

    function termsCheck() {
        document.getElementById("termsError").textContent =
            terms.checked ? "" : "You must accept the Terms and Conditions.";
        return terms.checked;
    }

    id.addEventListener("input", () =>
        check(id, /^[A-Za-z0-9]{4,20}$/, "Use 4-20 letters or numbers.")
    );

    first.addEventListener("input", () =>
        check(first, /^[A-Za-z ]+$/, "Use letters only.")
    );

    last.addEventListener("input", () =>
        check(last, /^[A-Za-z ]+$/, "Use letters only.")
    );

    email.addEventListener("input", () =>
        check(email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, "Enter a valid email.")
    );

    mobile.addEventListener("input", () =>
        check(mobile, /^[0-9]{10}$/, "Enter exactly 10 digits.")
    );

    pass.addEventListener("input", () => {
        strength();
        passwordCheck();
        if (confirm.value) confirmCheck();
    });

    function confirmCheck() {
        if (!confirm.value) return error(confirm, "Please confirm your password.");
        if (confirm.value !== pass.value)
            return error(confirm, "Passwords do not match.");
        return ok(confirm);
    }

    confirm.addEventListener("input", confirmCheck);

    course.addEventListener("change", () =>
        selectCheck(course, "Please select a course.")
    );

    year.addEventListener("change", () =>
        selectCheck(year, "Please select your year.")
    );

    document.querySelectorAll('input[name="gender"]').forEach(x =>
        x.addEventListener("change", genderCheck)
    );

    terms.addEventListener("change", termsCheck);

    form.addEventListener("submit", e => {
        e.preventDefault();

        let valid =
            check(id, /^[A-Za-z0-9]{4,20}$/, "Use 4-20 letters or numbers.") &&
            check(first, /^[A-Za-z ]+$/, "Use letters only.") &&
            check(last, /^[A-Za-z ]+$/, "Use letters only.") &&
            check(email, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, "Enter a valid email.") &&
            check(mobile, /^[0-9]{10}$/, "Enter exactly 10 digits.") &&
            passwordCheck() &&
            confirmCheck() &&
            selectCheck(course, "Please select a course.") &&
            selectCheck(year, "Please select your year.") &&
            genderCheck() &&
            termsCheck();

        if (valid) {
            localStorage.setItem("registeredStudentId", id.value.trim());
            localStorage.setItem("registeredPassword", pass.value);
            localStorage.setItem("registeredName", first.value.trim() + " " + last.value.trim());

            document.getElementById("successMessage").textContent =
                "Registration successful! Redirecting to Login...";

            alert("Registration Successful!");
            window.location.href = "../PRACTICAL-2/login.html";
        }
    });

    form.addEventListener("reset", () => {
        setTimeout(() => {
            document.querySelectorAll(".error").forEach(x => x.textContent = "");
            document.querySelectorAll("input,select").forEach(x =>
                x.classList.remove("input-error", "input-success")
            );
            document.getElementById("strengthBar").style.width = "0%";
            document.getElementById("strengthText").textContent = "";
            document.getElementById("successMessage").textContent = "";
        }, 10);
    });

});