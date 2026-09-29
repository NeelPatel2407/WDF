document.getElementById("feedbackForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let product = document.getElementById("product").value.trim();
    let rating = document.getElementById("rating").value;
    let feedback = document.getElementById("feedback").value.trim();

    let valid = true;

    document.getElementById("nameError").textContent = "";
    document.getElementById("emailError").textContent = "";
    document.getElementById("productError").textContent = "";
    document.getElementById("ratingError").textContent = "";
    document.getElementById("feedbackError").textContent = "";
    document.getElementById("successMessage").textContent = "";


    if (name === "") {
        document.getElementById("nameError").textContent =
            "Please enter your name.";
        valid = false;
    }


    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "") {
        document.getElementById("emailError").textContent =
            "Please enter your email.";
        valid = false;
    }
    else if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent =
            "Please enter a valid email.";
        valid = false;
    }


    if (product === "") {
        document.getElementById("productError").textContent =
            "Please enter the product name.";
        valid = false;
    }


    if (rating === "") {
        document.getElementById("ratingError").textContent =
            "Please select a rating.";
        valid = false;
    }


    if (feedback === "") {
        document.getElementById("feedbackError").textContent =
            "Please enter your feedback.";
        valid = false;
    }
    else if (feedback.length < 10) {
        document.getElementById("feedbackError").textContent =
            "Feedback must contain at least 10 characters.";
        valid = false;
    }


    if (valid) {

        document.getElementById("successMessage").textContent =
            "Thank you! Your feedback has been submitted.";

        document.getElementById("feedbackForm").reset();
    }

});