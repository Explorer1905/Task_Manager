// Function to update task status
function updateTaskStatus(taskId, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert('Task status updated!');
            document.getElementById('status_' + taskId).innerText = newStatus;
        }
    };
    xhr.send("id=" + taskId + "&status=" + newStatus);
}

// Function to filter tasks by status
function filterTasks() {
    var filter = document.getElementById("statusFilter").value;
    var rows = document.querySelectorAll(".taskRow");

    rows.forEach(function(row) {
        var status = row.querySelector(".taskStatus").innerText;
        if (filter === "All" || status === filter) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Function to validate task form
function validateTaskForm() {
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;

    if (title == "" || description == "") {
        alert("Title and Description are required!");
        event.preventDefault();
        return false;
    }
    return true;
}
