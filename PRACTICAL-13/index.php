<?php
require_once __DIR__ . "/../PRACTICAL-10/auth.php";
requireRole("admin");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - Practical 13</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Student Management</h1>
        <p>PHP JSON API and Fetch-Based CRUD</p>

        <div class="admin-bar">
            <span>Welcome, Admin!</span>
            <form action="../PRACTICAL-10/logout.php" method="POST" class="logout-form">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <form id="studentForm">
            <input type="hidden" id="studentId">
            <input type="text" id="name" placeholder="Student Name" required>
            <input type="email" id="email" placeholder="Email Address" required>
            <input type="text" id="course" placeholder="Course" required>
            <button type="submit" id="saveBtn">Add Student</button>
            <button type="button" id="cancelBtn" hidden>Cancel Edit</button>
        </form>

        <input type="text" id="search" placeholder="Search students...">
        <p id="message"></p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="studentList">
                    <tr><td colspan="5">Loading students...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const api = "api.php";
        const form = document.getElementById("studentForm");
        const studentList = document.getElementById("studentList");
        const message = document.getElementById("message");
        const saveBtn = document.getElementById("saveBtn");
        const cancelBtn = document.getElementById("cancelBtn");
        const studentId = document.getElementById("studentId");
        const search = document.getElementById("search");

        let students = [];

        async function request(url, options = {}) {
            const response = await fetch(url, options);
            const text = await response.text();
            let result;

            try {
                result = JSON.parse(text);
            } catch {
                console.error("API response:", text);
                throw new Error(
                    "PHP returned an empty or invalid JSON response. Check api.php."
                );
            }

            if (!response.ok) {
                throw new Error(result.error || "Request failed");
            }

            return result;
        }

        async function loadStudents() {
            studentList.innerHTML =
                '<tr><td colspan="5">Loading students...</td></tr>';

            try {
                students = await request(api);
                students.sort((a, b) => Number(a.id) - Number(b.id));
                displayStudents(students);
            } catch (error) {
                studentList.innerHTML =
                    '<tr><td colspan="5">Failed to load students.</td></tr>';
                showMessage(error.message, "error");
            }
        }

        function displayStudents(data) {
            studentList.innerHTML = "";

            if (data.length === 0) {
                studentList.innerHTML =
                    '<tr><td colspan="5">No students found.</td></tr>';
                return;
            }

            data.forEach((student, index) => {
                const row = document.createElement("tr");

                [
                    index + 1,
                    student.name,
                    student.email,
                    student.course
                ].forEach(value => {
                    const cell = document.createElement("td");
                    cell.textContent = value;
                    row.appendChild(cell);
                });

                const actions = document.createElement("td");

                const editBtn = document.createElement("button");
                editBtn.textContent = "Edit";
                editBtn.type = "button";
                editBtn.onclick = () => editStudent(student.id);

                const deleteBtn = document.createElement("button");
                deleteBtn.textContent = "Delete";
                deleteBtn.type = "button";
                deleteBtn.onclick = () => deleteStudent(student.id);

                actions.append(editBtn, deleteBtn);
                row.appendChild(actions);
                studentList.appendChild(row);
            });
        }

        function showMessage(text, type = "success") {
            message.textContent = text;
            message.className = type;
        }

        function editStudent(id) {
            const student = students.find(item => item.id == id);
            if (!student) return;

            studentId.value = student.id;
            document.getElementById("name").value = student.name;
            document.getElementById("email").value = student.email;
            document.getElementById("course").value = student.course;

            saveBtn.textContent = "Update Student";
            cancelBtn.hidden = false;
            showMessage("Editing student #" + student.id);

            form.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        }

        function resetForm() {
            form.reset();
            studentId.value = "";
            saveBtn.textContent = "Add Student";
            cancelBtn.hidden = true;
        }

        cancelBtn.addEventListener("click", () => {
            resetForm();
            showMessage("");
        });

        form.addEventListener("submit", async event => {
            event.preventDefault();

            const id = studentId.value;

            const data = {
                name: document.getElementById("name").value.trim(),
                email: document.getElementById("email").value.trim(),
                course: document.getElementById("course").value.trim()
            };

            if (!data.name || !data.email || !data.course) {
                showMessage("Please fill in all fields.", "error");
                return;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
                showMessage("Please enter a valid email address.", "error");
                return;
            }

            if (id) data.id = Number(id);

            saveBtn.disabled = true;
            saveBtn.textContent = id ? "Updating..." : "Adding...";

            try {
                const result = await request(api, {
                    method: id ? "PUT" : "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                });

                resetForm();
                await loadStudents();

                if (!message.classList.contains("error")) {
                    showMessage(result.message, "success");
                }
            } catch (error) {
                showMessage(error.message, "error");
            } finally {
                saveBtn.disabled = false;
                saveBtn.textContent = studentId.value
                    ? "Update Student"
                    : "Add Student";
            }
        });

        async function deleteStudent(id) {
            if (!confirm("Are you sure you want to delete this student?")) {
                return;
            }

            try {
                const result = await request(api, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id: Number(id) })
                });

                await loadStudents();

                if (!message.classList.contains("error")) {
                    showMessage(result.message, "success");
                }
            } catch (error) {
                showMessage(error.message, "error");
            }
        }

        let searchTimer;

        search.addEventListener("input", () => {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                const term = search.value.trim().toLowerCase();

                const filtered = students.filter((student, index) =>
                    String(index + 1).includes(term) ||
                    String(student.id).includes(term) ||
                    student.name.toLowerCase().includes(term) ||
                    student.email.toLowerCase().includes(term) ||
                    student.course.toLowerCase().includes(term)
                );

                displayStudents(filtered);
            }, 300);
        });

        loadStudents();
    </script>
</body>
</html>