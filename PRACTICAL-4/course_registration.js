document.addEventListener("DOMContentLoaded", function () {

    const compulsoryCourses = document.querySelectorAll(".compulsory input[type='checkbox']");
    const electiveCourses = document.querySelectorAll(".elective input[type='radio']");
    const buttons = document.querySelectorAll(".buttons button");

    const registerButton = buttons[0];
    const resetButton = buttons[1];

    registerButton.addEventListener("click", function () {

        let compulsorySelected = 0;
        let selectedElective = "";

        compulsoryCourses.forEach(function (course) {
            if (course.checked) {
                compulsorySelected++;
            }
        });

        electiveCourses.forEach(function (course) {
            if (course.checked) {
                selectedElective = course.parentElement.previousElementSibling.textContent;
            }
        });

        if (compulsorySelected !== compulsoryCourses.length) {
            alert("Please select all compulsory courses.");
            return;
        }

        if (selectedElective === "") {
            alert("Please select one elective course.");
            return;
        }

        alert(
            "Course Registration Successful!\n\n" +
            "Compulsory Courses: " + compulsorySelected + "\n" +
            "Elective Course: " + selectedElective
        );
    });

    resetButton.addEventListener("click", function () {

        compulsoryCourses.forEach(function (course) {
            course.checked = false;
        });

        electiveCourses.forEach(function (course) {
            course.checked = false;
        });

    });

});
