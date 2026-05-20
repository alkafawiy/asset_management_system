<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
// ADD ASSET
if (isset($_POST['add_asset'])) {
    $asset_name = mysqli_real_escape_string($conn, $_POST['asset_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $serial_number = mysqli_real_escape_string($conn, $_POST['serial_number']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $asset_status = mysqli_real_escape_string($conn, $_POST['asset_status']);

    $query = "INSERT INTO assets (asset_name, category, serial_number, department, purchase_date, asset_status) VALUES ('$asset_name', '$category', '$serial_number', '$department', '$purchase_date', '$asset_status')";

    if (mysqli_query($conn, $query)) {
        header("Location: assets.php");
    } else {
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets Management</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                Assets Management
            </h2>
            <a href="dashboard.php" class="btn btn-dark">
                Dashboard
            </a>
        </div>
        <!-- Add Asset Form -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3">
                    Add New Asset
                </h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Asset Name
                            </label>
                            <input type="text" class="form-control" name="asset_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Category
                            </label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Serial Number
                            </label>
                            <input type="text" class="form-control" name="serial_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Department
                            </label>
                            <input type="text" class="form-control" name="department" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Purchase Date
                            </label>
                            <input type="date" class="form-control" name="purchase_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status
                            </label>
                            <select class="form-control" name="asset_status" required>
                                <option>Available</option>
                                <option>Assigned</option>
                                <option>Damaged</option>
                                <option>Under Maintenance</option>
                            </select>
                        </div>
                        <button type="submit" name="add_asset" class="btn btn-primary">Add Asset</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Asset Table -->
        <!-- SEARCH FORM  -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3">
                    Search Assets
                </h4>
                <form method="GET">
                    <div class="row">
                        <div class="col-md-10">

                            <input type="text" name="search" class="form-control me-2"
                                placeholder="Search asset by name, category, department or status">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="mb-3">
                    Asset Records
                </h4>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Asset Name</th>
                            <th>Category</th>
                            <th>Serial Number</th>
                            <th>Department</th>
                            <th>Purchase Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['search'])) {
                            $search = mysqli_real_escape_string($conn, $_GET['search']);
                            $assets = mysqli_query($conn, "SELECT * FROM assets WHERE asset_name LIKE '%$search%' OR category LIKE '%$search%' OR department LIKE '%$search%' OR serial_number LIKE '%$search%' OR asset_status LIKE '%$search%' ORDER BY id DESC");
                        } else {
                            $assets = mysqli_query($conn, "SELECT * FROM assets ORDER BY id DESC");
                        }
                        while ($row = mysqli_fetch_assoc($assets)) { ?>
                            <tr>
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['asset_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['category']; ?>
                                </td>
                                <td>
                                    <?php echo $row['serial_number']; ?>
                                </td>
                                <td>
                                    <?php echo $row['department']; ?>
                                </td>
                                <td>
                                    <?php echo $row['purchase_date']; ?>
                                </td>
                                <td>
                                    <?php

                                    $status = $row['asset_status'];

                                    if ($status == 'Available') {
                                        echo '<span class="badge bg-success">' . $status . '</span>';
                                    } elseif ($status == 'Assigned') {
                                        echo '<span class="badge bg-primary">' . $status . '</span>';
                                    } elseif ($status == 'Damaged') {
                                        echo '<span class="badge bg-danger">' . $status . '</span>';
                                    } else {
                                        echo "<span class='badge bg-warning text-dark'>Under Maintenance</span>";
                                    }

                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo '<a href="edit_asset.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning me-2">Edit</a>';
                                    echo '<a href="delete_asset.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this asset?\')">Delete</a>';
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
</body>

</html>