
document.addEventListener("DOMContentLoaded", function () {

    const eventRow = document.getElementById("eventRow");

    eventRow.addEventListener("click", function (e) {

        const cell = e.target.closest("td");

        if (!cell || !eventRow.contains(cell)) {
            return;
        }

        const title = cell.querySelector("h3");

        if (!title) {
            return;
        }

        const eventName = title.textContent;
        const details = cell.querySelectorAll("p");

        let date = "";
        let venue = "";
        let category = "";

        details.forEach(function (detail) {
            const text = detail.textContent;

            if (text.startsWith("Date :")) {
                date = text.replace("Date :", "").trim();
            } else if (text.startsWith("Venue :")) {
                venue = text.replace("Venue :", "").trim();
            } else if (text.startsWith("Category :")) {
                category = text.replace("Category :", "").trim();
            }
        });

        if (e.target.tagName === "BUTTON") {

            const button = e.target;

            if (button.disabled) {
                return;
            }

            const choice = confirm(
                "Event: " + eventName + "\n" +
                "Date: " + date + "\n" +
                "Venue: " + venue +
                "\n\nDo you want to participate?"
            );

            if (choice) {

                if (!cell.dataset.eventId) {
                    alert("Event ID not found. Please refresh the page.");
                    return;
                }

                button.disabled = true;
                button.textContent = "Registering...";

                const formData = new URLSearchParams();
                formData.append("event_id", cell.dataset.eventId);
                formData.append("email", "neel@example.com");

                fetch("http://localhost/WDF/PRACTICAL-8/register_event.php", {
                    method: "POST",
                    body: formData
                })
                    .then(async function (response) {
                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(
                                data.message || "Registration failed."
                            );
                        }

                        button.textContent = "Registered";

                        alert(
                            "Registration Successful!\n\n" +
                            "You have registered for " + eventName + "."
                        );
                    })
                    .catch(function (error) {
                        button.disabled = false;
                        button.textContent = "Participate";
                        alert(error.message);
                    });
            }

            return;
        }

        alert(
            "Event Details\n\n" +
            eventName + "\n" +
            "Date: " + date + "\n" +
            "Venue: " + venue + "\n" +
            "Category: " + category
        );

    });

});
