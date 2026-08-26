document.addEventListener("DOMContentLoaded", function () {

    const heroHeading = document.querySelector(".hero h2");

    if (heroHeading) {
        heroHeading.addEventListener("click", function () {
            alert("Welcome to CampusCore Student Portal!");
        });
    }

    const statusElements = document.querySelectorAll(".status");

    statusElements.forEach(function (status) {
        status.addEventListener("click", function () {
            alert("Service Status: " + status.textContent);
        });
    });

    const serviceLinks = document.querySelectorAll(".quick-table a");

    serviceLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            const serviceName = link.textContent;

            if (serviceName !== "Help & FAQ") {
                alert("Opening " + serviceName + "...");
            }
        });
    });

    const notice = document.querySelector(".notice");

    if (notice) {
        notice.addEventListener("click", function () {
            alert(
                "Important Notice:\n\n" +
                "Course registration is currently open. " +
                "Please complete your registration before the deadline."
            );
        });
    }

    const cells = document.querySelectorAll(".quick-table td");

    cells.forEach(function (cell) {

        cell.addEventListener("mouseenter", function () {
            cell.style.transform = "scale(1.03)";
            cell.style.transition = "0.2s";
        });

        cell.addEventListener("mouseleave", function () {
            cell.style.transform = "scale(1)";
        });

    });

});