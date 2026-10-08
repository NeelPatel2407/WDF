const students = [];

const addBtn = document.getElementById("addBtn");
const resultTable = document.getElementById("resultTable");
const error = document.getElementById("error");

function getGrade(percentage) {
    if (percentage >= 90) return "A+";
    if (percentage >= 80) return "A";
    if (percentage >= 70) return "B";
    if (percentage >= 60) return "C";
    if (percentage >= 50) return "D";
    if (percentage >= 35) return "E";
    return "F";
}

function displayResults() {
    resultTable.innerHTML = "";

    students.forEach(function(student) {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${student.roll}</td>
            <td>${student.name}</td>
            <td>${student.total}</td>
            <td>${student.percentage.toFixed(2)}%</td>
            <td>${student.grade}</td>
            <td>${student.result}</td>
        `;

        resultTable.appendChild(row);
    });
}

function addStudent() {
    const name = document.getElementById("name").value.trim();
    const roll = document.getElementById("roll").value.trim();

    const marks = [
        Number(document.getElementById("dsa").value),
        Number(document.getElementById("oop").value),
        Number(document.getElementById("wdf").value),
        Number(document.getElementById("fcn").value),
        Number(document.getElementById("maths").value)
    ];

    if (name === "" || roll === "") {
        error.textContent = "Please enter student name and roll number.";
        return;
    }

    if (marks.some(mark => mark < 0 || mark > 100)) {
        error.textContent = "Marks must be between 0 and 100.";
        return;
    }

    const total = marks.reduce((sum, mark) => sum + mark, 0);
    const percentage = total / marks.length;
    const grade = getGrade(percentage);
    const result = marks.some(mark => mark < 35) ? "Fail" : "Pass";

    students.push({
        name,
        roll,
        total,
        percentage,
        grade,
        result
    });

    error.textContent = "";
    displayResults();

    document.getElementById("name").value = "";
    document.getElementById("roll").value = "";
    document.querySelectorAll(".marks input").forEach(input => {
        input.value = "";
    });
}

addBtn.addEventListener("click", addStudent);