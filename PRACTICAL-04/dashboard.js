document.addEventListener("DOMContentLoaded", function () {

    const boxes = document.querySelectorAll(".dashboard-table td");

    boxes.forEach(function (box) {

        box.addEventListener("click", function () {

            const heading = box.querySelector("h2").textContent;

            if (heading === "Attendance") {
                const text = box.textContent;

                const percentages = text.match(/\d+%/g);

                let message = "Attendance Details\n\n";

                if (percentages) {
                    message += "Web Development: " + percentages[0] + "\n";
                    message += "Java: " + percentages[1] + "\n";
                    message += "DSA: " + percentages[2] + "\n";
                    message += "Computer Networks: " + percentages[3];
                }

                alert(message);
            }

            else if (heading === "Fees Details") {
                alert(
                    "Fees Details\n\n" +
                    "Total Fees: ₹1,59,000\n" +
                    "Paid: ₹77,500\n" +
                    "Remaining: ₹81,500\n" +
                    "Status: Paid"
                );
            }

            else if (heading === "University Result") {
                alert(
                    "University Result\n\n" +
                    "Semester: 2\n" +
                    "SGPA: 7.64\n" +
                    "Result: Pass"
                );
            }

            else if (heading === "Today's Classes") {
                alert(
                    "Class Schedule\n\n" +
                    "Monday: Web Development\n" +
                    "Tuesday: Java\n" +
                    "Wednesday: Data Structures\n" +
                    "Thursday: Computer Networks"
                );
            }

        });

        box.addEventListener("mouseenter", function () {
            box.style.cursor = "pointer";
        });

    });

});