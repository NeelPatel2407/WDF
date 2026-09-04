document.addEventListener("DOMContentLoaded", function () {

    const eventCells = document.querySelectorAll(".event-table td");
    const buttons = document.querySelectorAll(".event-table button");

    buttons.forEach(function (button, index) {

        button.addEventListener("click", function () {

            const event = eventCells[index];
            const eventName = event.querySelector("h3").textContent;
            const details = event.querySelectorAll("p");

            const date = details[0].textContent.replace("Date :", "").trim();
            const venue = details[1].textContent.replace("Venue :", "").trim();

            const choice = confirm(
                "Event: " + eventName + "\n" +
                "Date: " + date + "\n" +
                "Venue: " + venue +
                "\n\nDo you want to participate?"
            );

            if (choice) {
                button.textContent = "Registered";
                button.disabled = true;

                alert(
                    "Registration Successful!\n\n" +
                    "You have registered for " + eventName + "."
                );
            }
        });

    });

    eventCells.forEach(function (cell) {

        cell.addEventListener("click", function (event) {

            if (event.target.tagName === "BUTTON") {
                return;
            }

            const eventName = cell.querySelector("h3").textContent;
            const details = cell.querySelectorAll("p");

            alert(
                "Event Details\n\n" +
                eventName + "\n" +
                details[0].textContent + "\n" +
                details[1].textContent
            );
        });

    });

});