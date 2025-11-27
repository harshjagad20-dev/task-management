$(document).ready(function () {
    loadTasks();
});


// Load tasks
function loadTasks(page = 1) {

    $.ajax({
        url: "/api/tasks",
        type: "GET",
        data: {
            status: $("#filter_status").val(),
            priority: $("#filter_priority").val(),
            search: $("#filter_search").val(),
            sort_by: "due_date",
            sort_dir: "desc",
            page: page
        },
        success: function (res) {
            renderTable(res.data);
            renderPagination(res.meta);
        }
    });
}


// Render table
function renderTable(tasks) {
    let rows = "";

    tasks.forEach(task => {
        rows += `
        <tr>
            <td id="task-title-${task.id}">${task.title}</td>

            <td>
                <select onchange="updateStatus(${task.id}, '${task.title.replace(/'/g, "\\'")}', this.value)" class="form-control">
                    <option value="TODO" ${task.status === "TODO" ? "selected" : ""}>TODO</option>
                    <option value="IN_PROGRESS" ${task.status === "IN_PROGRESS" ? "selected" : ""}>IN_PROGRESS</option>
                    <option value="DONE" ${task.status === "DONE" ? "selected" : ""}>DONE</option>
                </select>
            </td>

            <td>${task.priority}</td>
            <td>${task.due_date}</td>

            <td>
                <button class="btn btn-warning btn-sm" onclick="openEdit(${task.id})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})">Delete</button>
            </td>
        </tr>`;
    });

    $("#taskTable").html(rows);
}


// Pagination
function renderPagination(meta) {
    let buttons = "";
    for (let i = 1; i <= meta.last_page; i++) {
        buttons += `
        <li class="page-item ${i === meta.current_page ? 'active' : ''}">
            <a class="page-link" href="#" onclick="loadTasks(${i})">${i}</a>
        </li>`;
    }
    $("#pagination").html(buttons);
}



// ----------------------- CREATE ----------------------
function saveTask() {

    $.ajax({
        url: "/api/tasks",
        type: "POST",
        data: {
            title: $("#title").val(),
            description: $("#description").val(),
            status: $("#status").val(),
            priority: $("#priority").val(),
            due_date: $("#due_date").val()
        },
        success: function () {

            Swal.fire({
                icon: "success",
                title: "Task created successfully!",
                timer: 1500,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById("createModal"));
            modal.hide();

            $("#create_errors").addClass("d-none");
            loadTasks();
        },
        error: function (xhr) {

            let html = "";
            $.each(xhr.responseJSON.errors, function (key, value) {
                html += value + "<br>";
            });

            $("#create_errors").removeClass("d-none").html(html);

            Swal.fire({
                icon: "error",
                title: "Validation Error",
                html: html
            });
        }
    });
}



// ----------------------- OPEN EDIT MODAL ----------------------
function openEdit(id) {

    $.get("/api/tasks/" + id, function (res) {

        const t = res.data;

        $("#edit_id").val(t.id);
        $("#edit_title").val(t.title);
        $("#edit_description").val(t.description);
        $("#edit_priority").val(t.priority);
        $("#edit_status").val(t.status);
        $("#edit_due_date").val(t.due_date);

        $("#edit_errors").addClass("d-none");

        new bootstrap.Modal(document.getElementById("editModal")).show();
    });
}



// ----------------------- UPDATE ----------------------
function updateTask() {

    let id = $("#edit_id").val();

    $.ajax({
        url: "/api/tasks/" + id,
        type: "PUT",
        data: {
            title: $("#edit_title").val(),
            description: $("#edit_description").val(),
            status: $("#edit_status").val(),
            priority: $("#edit_priority").val(),
            due_date: $("#edit_due_date").val()
        },
        success: function () {

            Swal.fire({
                icon: "success",
                title: "Task updated!",
                timer: 1500,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById("editModal"));
            modal.hide();

            $("#edit_errors").addClass("d-none");
            loadTasks();
        },
        error: function (xhr) {

            let html = "";
            $.each(xhr.responseJSON.errors, function (key, value) {
                html += value + "<br>";
            });

            $("#edit_errors").removeClass("d-none").html(html);

            Swal.fire({
                icon: "error",
                title: "Update failed",
                html: html
            });
        }
    });
}



// ----------------------- UPDATE STATUS ONLY ----------------------
function updateStatus(id, title, status) {

    $.ajax({
        url: "/api/tasks/" + id,
        type: "PUT",
        data: {
            title: title,
            status: status
        },
        success: function () {

            Swal.fire({
                icon: "success",
                title: "Status updated!",
                timer: 1200,
                showConfirmButton: false
            });

            loadTasks();
        },
        error: function (xhr) {

            Swal.fire({
                icon: "error",
                title: "Status update failed",
                text: xhr.responseJSON.message
            });

            loadTasks();
        }
    });
}



// ----------------------- DELETE ----------------------
function deleteTask(id) {

    Swal.fire({
        title: "Are you sure?",
        text: "This task will be deleted permanently.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {

        if (result.isConfirmed) {

            $.ajax({
                url: "/api/tasks/" + id,
                type: "DELETE",
                success: function () {

                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: "Task deleted successfully",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    loadTasks();
                }
            });
        }

    });
}
