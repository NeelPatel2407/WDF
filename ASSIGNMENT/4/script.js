const taskInput = document.getElementById("taskInput");
const addBtn = document.getElementById("addBtn");
const taskList = document.getElementById("taskList");
const error = document.getElementById("error");
const total = document.getElementById("total");
const completed = document.getElementById("completed");

function addTask() {
    const taskText = taskInput.value.trim();

    if (taskText === "") {
        error.textContent = "Please enter a task.";
        return;
    }

    error.textContent = "";

    const li = document.createElement("li");
    li.className = "task";

    const span = document.createElement("span");
    span.textContent = taskText;

    const doneBtn = document.createElement("button");
    doneBtn.textContent = "Done";
    doneBtn.className = "done";

    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.className = "delete";

    doneBtn.addEventListener("click", function() {
        li.classList.toggle("completed");
        updateCount();
    });

    deleteBtn.addEventListener("click", function() {
        li.remove();
        updateCount();
    });

    li.appendChild(span);
    li.appendChild(doneBtn);
    li.appendChild(deleteBtn);

    taskList.appendChild(li);

    taskInput.value = "";
    updateCount();
}

function updateCount() {
    const tasks = document.querySelectorAll(".task");
    const completedTasks = document.querySelectorAll(".task.completed");

    total.textContent = tasks.length;
    completed.textContent = completedTasks.length;
}

addBtn.addEventListener("click", addTask);

taskInput.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        addTask();
    }
});