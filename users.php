<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// ADD USER 
if (isset($_POST['add_user'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";

    mysqli_query($conn, $query);
    header("Location: users.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management </title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icon -->
    <link rel="icon" type="image/x-icon" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/favicon.ico">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="bi bi-people"></i>
                User Management
            </h2>
            <a href="dashboard.php" class="btn btn-dark">
                Dashboard
            </a>
        </div>
        <!-- Add User Form -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3">
                    Add New User
                </h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Full Name:</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Role:</label>
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option>Admin</option>
                                <option>Staff</option>
                                <option>ICT</option>
                                <option>Officer</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Add User
                    </button>
                </form>
            </div>
        </div>
        <!-- Users Table -->
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="mb-3">
                    System Users
                </h4>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                        while ($user = mysqli_fetch_assoc($users)) {
                            echo "<tr>";
                            echo "<td>" . $user['id'] . "</td>";
                            echo "<td>" . $user['fullname'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            if ($user['role'] == 'Admin') {
                                echo "<td><span class='badge bg-danger'>" . $user['role'] . "</span></td>";
                            } elseif ($user['role'] == 'Staff') {
                                echo "<td><span class='badge bg-success'>" . $user['role'] . "</span></td>";
                            } elseif ($user['role'] == 'ICT') {
                                echo "<td><span class='badge bg-info'>" . $user['role'] . "</span></td>";
                            } elseif ($user['role'] == 'Officer') {
                                echo "<td><span class='badge bg-warning text-dark'>" . $user['role'] . "</span></td>";
                            } else {
                                echo "<td>" . $user['role'] . "</td>";
                            }
                            echo "<td>" . $user['created_at'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>