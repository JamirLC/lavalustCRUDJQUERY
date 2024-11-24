<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <!-- Include Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">User Management</h1>

        <!-- Button to Open Create User Modal -->
        <button class="btn btn-primary mb-4" onclick="$('#createModal').modal('show')">Create User</button>

        <!-- User List Table -->
        <h2>User List</h2>
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal for Creating User -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="gender" placeholder="Gender" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Updating User -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm">
                        <input type="hidden" name="id" id="updateId">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="lname" id="updateLname" placeholder="Last Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="fname" id="updateFname" placeholder="First Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" id="updateEmail" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="gender" id="updateGender" placeholder="Gender" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="address" id="updateAddress" placeholder="Address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Fetch users from the server
        function fetchUsers() {
            $.ajax({
                url: '/user/read',
                type: 'GET',
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        const tbody = $('#userTable tbody');
                        tbody.empty();
                        res.data.forEach(user => {
                            tbody.append(`
                                <tr>
                                    <td>${user.jlmc_last_name}</td>
                                    <td>${user.jlmc_first_name}</td>
                                    <td>${user.jlmc_email}</td>
                                    <td>${user.jlmc_gender}</td>
                                    <td>${user.jlmc_address}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editUser(${user.id}, '${user.jlmc_last_name}', '${user.jlmc_first_name}', '${user.jlmc_email}', '${user.jlmc_gender}', '${user.jlmc_address}')">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                },
                error: function() {
                    alert('Failed to fetch users.');
                }
            });
        }

        // Show the Update Modal with user data
        function editUser(id, lname, fname, email, gender, address) {
            $('#updateId').val(id);
            $('#updateLname').val(lname);
            $('#updateFname').val(fname);
            $('#updateEmail').val(email);
            $('#updateGender').val(gender);
            $('#updateAddress').val(address);
            $('#updateModal').modal('show');
        }

        // Handle the form submission for creating a user
        $('#createUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/user/create',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        $('#createModal').modal('hide');
                        fetchUsers();
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        });

        // Handle the form submission for updating a user
        $('#updateUserForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#updateId').val();
            $.ajax({
                url: `/user/update/${id}`,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        $('#updateModal').modal('hide');
                        fetchUsers();
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        });

        // Handle user deletion
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: `/user/delete/${userId}`,
                    type: 'POST',
                    success: function(response) {
                        const res = JSON.parse(response);
                        alert(res.message);
                        if (res.status === 'success') {
                            fetchUsers();
                        }
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            }
        }

        // Fetch users when the page loads
        $(document).ready(function() {
            fetchUsers();
        });
    </script>
</body>

</html>