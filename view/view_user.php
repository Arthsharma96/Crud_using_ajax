<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD in CodeIgniter</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Some custom styling */
        .form-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            width: 400px;
        }
        .form-container input[type=text] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
        }
        .form-container input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
        }
        /* Blur effect */
        .blur {
            filter: blur(5px);
            pointer-events: none; /* Prevent clicking on blurred elements */
        }
    </style>
</head>
<body>

<div class="container">
    <button id="addUserBtn" class="btn btn-primary mb-3">Add User</button> <!-- Add this button -->
    <!-- <div class="form-container">
        <h2>Add Users</h2>
        <form id="userForm">
            <input type="hidden" name="id" id="id">
            <input type="text" name="name" id="name" class="form-control mb-2" placeholder="Name" required>
            <input type="text" name="email" id="email" class="form-control mb-2" placeholder="Email" required>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div> -->

    <div id="userTable">
        <h2>Users</h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userData">
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Modal for Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="addName">Name:</label>
                        <input type="text" class="form-control" id="addName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="addEmail">Email:</label>
                        <input type="text" class="form-control" id="addEmail" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" name="id" id="editId">
                    <div class="form-group">
                        <label for="editName">Name:</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input type="text" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load users on page load
    loadUsers();

    // Function to load users
    function loadUsers() {
        $.ajax({
            url: '<?php echo base_url('userc/fetch_users'); ?>',
            method: 'GET',
            success: function(data) {
                var users = JSON.parse(data);
                var html = '';
                users.forEach(function(user) {
                    html += '<tr>';
                    html += '<td>' + user.id + '</td>';
                    html += '<td>' + user.name + '</td>';
                    html += '<td>' + user.email + '</td>';
                    html += '<td><button class="editBtn btn btn-primary btn-sm" data-id="' + user.id + '">Edit</button> <button class="deleteBtn btn btn-danger btn-sm" data-id="' + user.id + '">Delete</button></td>';
                    html += '</tr>';
                });
                $('#userData').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Request failed. Status: ' + status);
            }
        });
    }

    // Open Add User Modal
    $('#addUserBtn').on('click', function() {
        $('#addUserModal').modal('show');
        $('#userTable').addClass('blur'); // Blur user table
    });

    // Submit Add User Form
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo base_url('userc/insert_user'); ?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('User added successfully');
                $('#addUserModal').modal('hide'); // Hide Bootstrap modal
                $('#userTable').removeClass('blur'); // Remove blur effect
                loadUsers();
            },
            error: function(xhr, status, error) {
                console.error('Request failed. Status: ' + status);
            }
        });
    });

    // Function to close modal and remove blur effect on modal close
    $('#addUserModal').on('hidden.bs.modal', function () {
        $('#userTable').removeClass('blur');
    });

    // Edit user (open modal with user data)
    $('#userData').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('userc/get_user'); ?>',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                var user = JSON.parse(response);
                $('#editId').val(user.id);
                $('#editName').val(user.name);
                $('#editEmail').val(user.email);
                $('#editUserModal').modal('show'); // Show Bootstrap modal
                $('#userTable').addClass('blur'); // Blur user table
            },
            error: function(xhr, status, error) {
                console.error('Request failed. Status: ' + status);
            }
        });
    });

    // Submit edited user
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = '<?php echo base_url('userc/update_user'); ?>';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('User updated successfully');
                $('#editUserModal').modal('hide'); // Hide Bootstrap modal
                $('#userTable').removeClass('blur'); // Remove blur effect
                loadUsers();
            },
            error: function(xhr, status, error) {
                console.error('Request failed. Status: ' + status);
            }
        });
    });

    // Delete user
    $('#userData').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '<?php echo base_url('userc/delete_user'); ?>',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    alert('User deleted successfully');
                    loadUsers();
                },
                error: function(xhr, status, error) {
                    console.error('Request failed. Status: ' + status);
                }
            });
        }
    });

    // Function to close modal and remove blur effect on modal close
    $('#editUserModal').on('hidden.bs.modal', function () {
        $('#userTable').removeClass('blur');
    });
});
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
