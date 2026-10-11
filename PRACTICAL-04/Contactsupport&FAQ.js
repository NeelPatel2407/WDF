document.addEventListener("DOMContentLoaded", function () {

    const faqRows = document.querySelectorAll(".faq-table tr");

    faqRows.forEach(function (row, index) {

        if (index > 0) {

            row.addEventListener("click", function () {

                const question = row.querySelector("b");

                if (question) {
                    const answer = question.nextSibling.nextSibling;

                    if (answer) {
                        alert(
                            question.textContent + "\n\n" +
                            answer.textContent.trim()
                        );
                    }
                }

            });

            row.addEventListener("mouseenter", function () {
                row.style.cursor = "pointer";
            });
        }
    });

    const contactRows = document.querySelectorAll(".contact-table tr");

    contactRows.forEach(function (row, index) {

        if (index > 0) {

            row.addEventListener("click", function () {

                const cells = row.querySelectorAll("td");

                alert(
                    cells[0].textContent.trim() + ":\n\n" +
                    cells[1].textContent.trim()
                );
            });

            row.addEventListener("mouseenter", function () {
                row.style.cursor = "pointer";
            });
        }
    });

});