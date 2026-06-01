<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// ADD MAINTENANCE
if (isset($_POST['add_maintenance'])) {
    $asset_id = $_POST['asset_id'];
    $issue_description = $_POST['issue_description'];
    $maintenance_date = $_POST['maintenance_date'];
    $technician = $_POST['technician'];
    $maintenance_status = $_POST['maintenance_status'];

    $query = "INSERT INTO maintenance (asset_id, issue_description, maintenance_date, technician, maintenance_status) VALUES ('$asset_id', '$issue_description', '$maintenance_date', '$technician', '$maintenance_status')";

    mysqli_query($conn, $query);
    header("Location: maintenance.php");
}

?>

<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="main-content p-4">
            <?php include('includes/navbar.php'); ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>
                            Maintenance Management
                        </h2>
                        <a href="dashboard.php" class="btn btn-dark">
                            Dashboard
                        </a>
                    </div>
                    <!-- Maintenance Form -->
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <h4 class="mb-3">
                                Add Maintenance Record
                            </h4>
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Select Asset:</label>
                                        <select class="form-control" name="asset_id" required>
                                            <option value="">Select Asset</option>
                                            <?php
                                            $query = "SELECT * FROM assets";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['id'] . '">' . $row['asset_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Technician</label>
                                        <input type="text" class="form-control" name="technician" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Issue Description</label>
                                        <textarea class="form-control" rows="3" name="issue_description"
                                            required></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Maintenance Date</label>
                                        <input type="date" class="form-control" name="maintenance_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Maintenance Status</label>
                                        <select class="form-control" name="maintenance_status" required>
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="add_maintenance" class="btn btn-primary">
                                    Add Maintenance Record
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Maintenance Record -->
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h4 class="mb-3">
                                Maintenance Records
                            </h4>
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Asset</th>
                                        <th>Issue</th>
                                        <th>Technician</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $records = mysqli_query($conn, "SELECT maintenance.*, assets.asset_name FROM maintenance JOIN assets ON maintenance.asset_id = assets.id ORDER BY maintenance.id DESC");
                                    while ($row = mysqli_fetch_assoc($records)) {
                                        echo '<tr>';
                                        echo '<td>' . $row['id'] . '</td>';
                                        echo '<td>' . $row['asset_name'] . '</td>';
                                        echo '<td>' . $row['issue_description'] . '</td>';
                                        echo '<td>' . $row['technician'] . '</td>';
                                        echo '<td>' . $row['maintenance_date'] . '</td>';
                                        $status = $row['maintenance_status'];
                                        if ($status == 'Pending') {
                                            echo '<td><span class="badge bg-warning text-dark">' . $status . '</span></td>';
                                        } elseif ($status == 'In Progress') {
                                            echo '<td><span class="badge bg-info text-dark">' . $status . '</span></td>';
                                        } elseif ($status == 'Completed') {
                                            echo '<td><span class="badge bg-success">' . $status . '</span></td>';
                                        } else {
                                            echo '<td>' . $status . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>