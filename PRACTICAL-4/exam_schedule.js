document.addEventListener("DOMContentLoaded", function () {

    const table = document.querySelector(".exam-table");
    const rows = document.querySelectorAll(".exam-table tr");
    const downloadButton = document.querySelector(".download button");

    rows.forEach(function (row, index) {

        if (index > 0) {

            row.addEventListener("click", function () {
                const cells = row.querySelectorAll("td");

                alert(
                    "Exam Details\n\n" +
                    "Date: " + cells[0].textContent + "\n" +
                    "Subject: " + cells[1].textContent + "\n" +
                    "Time: " + cells[2].textContent + "\n" +
                    "Room: " + cells[3].textContent
                );
            });

            row.addEventListener("mouseenter", function () {
                row.style.cursor = "pointer";
            });
        }
    });

    downloadButton.addEventListener("click", function () {

        let schedule = "CampusCore - Exam Schedule\n\n";

        rows.forEach(function (row, index) {

            if (index > 0) {

                const cells = row.querySelectorAll("td");

                schedule +=
                    "Date: " + cells[0].textContent + "\n" +
                    "Subject: " + cells[1].textContent + "\n" +
                    "Time: " + cells[2].textContent + "\n" +
                    "Room: " + cells[3].textContent + "\n\n";
            }
        });

        const file = new Blob([schedule], {
            type: "text/plain"
        });

        const link = document.createElement("a");

        link.href = URL.createObjectURL(file);
        link.download = "Exam_Schedule.txt";

        link.click();

        URL.revokeObjectURL(link.href);

        alert("Exam Schedule downloaded successfully.");
    });

});