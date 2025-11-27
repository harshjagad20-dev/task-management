<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Restricting old dates -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const today = new Date().toISOString().split("T")[0];
            document.querySelectorAll("input[type=date]").forEach(d => d.setAttribute("min", today));
        });
    </script>
</head>

<body class="p-4">

<div class="container">

    <h2 class="mb-4">Task Management</h2>

    <!-- Filters -->
    <div class="card p-3 mb-4">
        <div class="row">

            <div class="col-md-3">
                <label>Status</label>
                <select id="filter_status" class="form-control">
                    <option value="">All</option>
                    <option value="TODO">TODO</option>
                    <option value="IN_PROGRESS">IN_PROGRESS</option>
                    <option value="DONE">DONE</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Priority</label>
                <select id="filter_priority" class="form-control">
                    <option value="">All</option>
                    <option value="LOW">LOW</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="HIGH">HIGH</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Search</label>
                <input type="text" id="filter_search" class="form-control" placeholder="Search title...">
            </div>

            <div class="col-md-3 mt-4">
                <button class="btn btn-primary mt-1" onclick="loadTasks()">Apply</button>
                <button class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#createModal">Create Task</button>
            </div>

        </div>
    </div>

    <!-- Tasks Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="taskTable"></tbody>
    </table>

    <nav>
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>


<!-- Create Modal -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">

            <h5>Create Task</h5>

            <div id="create_errors" class="alert alert-danger d-none"></div>

            <label>Title</label>
            <input type="text" id="title" class="form-control mb-2" placeholder="Title">

            <label>Description</label>
            <textarea id="description" class="form-control mb-2" placeholder="Description"></textarea>

            <label>Status</label>
            <select id="status" class="form-control mb-2">
                <option value="TODO">Todo</option>
                <option value="IN_PROGRESS">In Progress</option>
                <option value="DONE">Done</option>
            </select>

            <label>Priority</label>
            <select id="priority" class="form-control mb-2">
                <option value="LOW">Low</option>
                <option value="MEDIUM">Medium</option>
                <option value="HIGH">High</option>
            </select>

            <label>Due Date</label>
            <input type="date" id="due_date" class="form-control mb-2">

            <button class="btn btn-primary" onclick="saveTask()">Save</button>

        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">

            <h5>Edit Task</h5>

            <div id="edit_errors" class="alert alert-danger d-none"></div>

            <input type="hidden" id="edit_id">

            <label>Title</label>
            <input type="text" id="edit_title" class="form-control mb-2" placeholder="Title">

            <label>Description</label>
            <textarea id="edit_description" class="form-control mb-2" placeholder="Description"></textarea>

            <label>Status</label>
            <select id="edit_status" class="form-control mb-2">
                <option value="TODO">Todo</option>
                <option value="IN_PROGRESS">In Progress</option>
                <option value="DONE">Done</option>
            </select>

            <label>Priority</label>
            <select id="edit_priority" class="form-control mb-2">
                <option value="LOW">LOW</option>
                <option value="MEDIUM">MEDIUM</option>
                <option value="HIGH">HIGH</option>
            </select>

            <label>Due Date</label>
            <input type="date" id="edit_due_date" class="form-control mb-2">

            <button class="btn btn-primary" onclick="updateTask()">Update</button>

        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="/js/tasks.js"></script>

</body>
</html>
