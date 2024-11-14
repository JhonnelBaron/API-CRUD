<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Add any CSS framework like Bootstrap if needed -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>User Management</h1>

        <input type="text" id="userIdInput" placeholder="Enter User ID" class="form-control mb-2" />
        <button onclick="fetchUser()" class="btn btn-info mb-3">Fetch User</button>
        <h3>Fetched User:</h3>
        <div id="fetchedUser"></div>

        <button id="addUserBtn" class="btn btn-primary mb-3">Add User</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchUsers();
        });
        function fetchUsers() {
            axios.get('/api/users')
                .then(response => {
                    const users = response.data.users;
                    let userRows = '';

                    users.forEach(user => {
                        userRows += `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });

                    document.getElementById('userTableBody').innerHTML = userRows;
                })
                .catch(error => console.error(error));
        }

        function fetchUser() {
            const userId = document.getElementById('userIdInput').value;

            // Ensure that a user ID is provided
            if (!userId) {
                alert("Please enter a user ID.");
                return;
            }

            // Use Axios to make a GET request to your API endpoint
            axios.get(`/api/get/${userId}`)
                .then(response => {
                    const user = response.data.data;
                    // Display the user data in the #fetchedUser div
                    document.getElementById('fetchedUser').innerHTML = `
                        <p><strong>ID:</strong> ${user.id}</p>
                        <p><strong>Name:</strong> ${user.name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                    `;
                })
                .catch(error => {
                    console.error(error);
                    alert("User not found or an error occurred.");
                });
        }
        document.getElementById('addUserBtn').addEventListener('click', function () {
            const name = prompt("Enter the user's name:");
            const email = prompt("Enter the user's email:");
            const password = prompt("Enter the user's password:");

            if (!password || password.length < 8) {
                alert("Password is required and must be at least 8 characters.");
                return;
            }

            axios.post('/api/add', { name, email, password })
                .then(response => {
                    alert('User added successfully');
                    fetchUsers(); 
                })
                .catch(error => console.error(error));
        });
        function editUser(id) {
            const name = prompt("Enter the new name:");
            const email = prompt("Enter the new email:");
            const password = prompt("Enter the new password:");

            axios.post(`/api/edit/${id}`, { name, email })
                .then(response => {
                    alert('User updated successfully');
                    fetchUsers(); // Refresh the user list
                })
                .catch(error => console.error(error));
        }
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                axios.post(`/api/remove/${id}`)
                    .then(response => {
                        alert('User deleted successfully');
                        fetchUsers(); // Refresh the user list
                    })
                    .catch(error => console.error(error));
            }
        }
    </script>
</body>
</html>
