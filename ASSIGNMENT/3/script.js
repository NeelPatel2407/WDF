document.getElementById("gradeForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let marks = [];
    let valid = true;

    document.getElementById("nameError").textContent = "";
    document.getElementById("marksError").textContent = "";

    if (name === "") {
        document.getElementById("nameError").textContent =
            "Please enter student name.";
        valid = false;
    }

    for (let i = 1; i <= 5; i++) {
        let input = document.getElementById("sub" + i);
        let mark = Number(input.value);

        if (input.value === "" || mark < 0 || mark > 100) {
            valid = false;
        }

        marks.push(mark);
    }

    if (!valid) {
        document.getElementById("marksError").textContent =
            "Please enter valid marks between 0 and 100.";
        document.getElementById("result").style.display = "none";
        return;
    }

    let total = 0;

    for (let i = 0; i < marks.length; i++) {
        total += marks[i];
    }

    let percentage = total / 5;
    let grade;
    let status;

    if (marks.some(mark => mark < 35)) {
        grade = "F";
        status = "Fail";
    }
    else if (percentage >= 90) {
        grade = "A+";
        status = "Pass";
    }
    else if (percentage >= 80) {
        grade = "A";
        status = "Pass";
    }
    else if (percentage >= 70) {
        grade = "B";
        status = "Pass";
    }
    else if (percentage >= 60) {
        grade = "C";
        status = "Pass";
    }
    else if (percentage >= 50) {
        grade = "D";
        status = "Pass";
    }
    else {
        grade = "E";
        status = "Pass";
    }

    document.getElementById("resultName").textContent = name;
    document.getElementById("total").textContent = total;
    document.getElementById("percentage").textContent = percentage.toFixed(2);
    document.getElementById("grade").textContent = grade;
    document.getElementById("status").textContent = status;

    document.getElementById("result").style.display = "block";
});