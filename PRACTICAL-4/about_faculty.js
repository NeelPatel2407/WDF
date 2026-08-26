document.addEventListener("DOMContentLoaded", function () {

    const facultyCells = document.querySelectorAll(".faculty-table td");
    const buttons = document.querySelectorAll(".faculty-table button");

    buttons.forEach(function (button, index) {

        button.addEventListener("click", function () {

            const faculty = facultyCells[index];
            const name = faculty.querySelector("h3").textContent;
            const details = faculty.querySelectorAll("p");

            alert(
                "Faculty Profile\n\n" +
                "Name: " + name + "\n" +
                details[0].textContent + "\n" +
                details[1].textContent + "\n" +
                details[2].textContent + "\n" +
                details[3].textContent
            );
        });

    });

    facultyCells.forEach(function (faculty) {

        faculty.addEventListener("mouseenter", function () {
            faculty.style.cursor = "pointer";
        });

        faculty.addEventListener("click", function (event) {

            if (event.target.tagName === "BUTTON") {
                return;
            }

            const name = faculty.querySelector("h3").textContent;

            alert("Selected Faculty: " + name);
        });

    });

});