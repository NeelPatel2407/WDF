document.addEventListener("DOMContentLoaded", function () {

    const faculty = document.querySelector(".feedback-table select");
    const teaching = document.querySelectorAll('input[name="teaching"]');
    const interaction = document.querySelectorAll('input[name="interaction"]');
    const knowledge = document.querySelectorAll('input[name="knowledge"]');
    const suggestions = document.querySelector("textarea");

    const buttons = document.querySelectorAll(".buttons button");
    const submitButton = buttons[0];
    const resetButton = buttons[1];

    submitButton.addEventListener("click", function () {

        let teachingSelected = false;
        let interactionSelected = false;
        let knowledgeSelected = false;

        teaching.forEach(function (item) {
            if (item.checked) {
                teachingSelected = true;
            }
        });

        interaction.forEach(function (item) {
            if (item.checked) {
                interactionSelected = true;
            }
        });

        knowledge.forEach(function (item) {
            if (item.checked) {
                knowledgeSelected = true;
            }
        });

        if (!teachingSelected) {
            alert("Please rate the Teaching Style.");
            return;
        }

        if (!interactionSelected) {
            alert("Please rate Student Interaction.");
            return;
        }

        if (!knowledgeSelected) {
            alert("Please rate Subject Knowledge.");
            return;
        }

        if (suggestions.value.trim() === "") {
            alert("Please enter your Suggestions.");
            suggestions.focus();
            return;
        }

        alert(
            "Feedback Submitted Successfully!\n\n" +
            "Faculty: " + faculty.value + "\n" +
            "Thank you for your valuable feedback."
        );

        suggestions.value = "";
        teaching.forEach(function (item) {
            item.checked = false;
        });

        interaction.forEach(function (item) {
            item.checked = false;
        });

        knowledge.forEach(function (item) {
            item.checked = false;
        });
    });

    resetButton.addEventListener("click", function () {
        setTimeout(function () {
            faculty.focus();
        }, 100);
    });

});