<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

include('config/db.php');
// TOTAL ASSETS
$total_assets_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets");

$total_assets_result = mysqli_fetch_assoc($total_assets_query);

// ASSIGNED ASSETS
$assigned_assets_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE asset_status='Assigned'");
$assigned_assets_result = mysqli_fetch_assoc($assigned_assets_query);
// DAMAGED ASSETS
$damaged_assets_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE asset_status='Damaged'");
$damaged_assets_result = mysqli_fetch_assoc($damaged_assets_query);
// AVAILABLE ASSETS
$available_assets_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE asset_status='Available'");
$available_assets_result = mysqli_fetch_assoc($available_assets_query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark text-white min-vh-100 p-3">
                <h4 class="text-center mb-4">
                    <i class="bi bi-pc-display"></i>
                    AMS
                </h4>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="dashboard.php" class="nav-link text-white">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="assets.php" class="nav-link text-white">
                            <i class="bi bi-box-seam"></i>
                            Assets
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="users.php" class="nav-link text-white">
                            <i class="bi bi-people"></i>
                            Users
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="maintenance.php" class="nav-link text-white">
                            <i class="bi bi-tools"></i>
                            Maintenance
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        Dashboard
                    </h2>
                    <p>Welcome <strong><?php echo $_SESSION['fullname']; ?></strong></p>
                </div>
            </div>
            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5>Assets</h5>
                            <h2 class="text-primary"><?php echo $total_assets_result['total']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5>Assigned Assets</h5>
                            <h2 class="text-success"><?php echo $assigned_assets_result['total']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5>Damaged Assets</h5>
                            <h2 class="text-info"><?php echo $damaged_assets_result['total']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5>Available Assets</h5>
                            <h2 class="text-warning"><?php echo $available_assets_result['total']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Assets -->
            <div class="card shadow border-0 mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>
                            Recent Assets
                        </h4>
                        <a href="assets.php" class="btn btn-dark btn-sm">
                            View All
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Serial Number</th>
                                <th>Department</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_assets = mysqli_query($conn, "SELECT * FROM assets ORDER BY id DESC LIMIT 5");
                            while ($row = mysqli_fetch_assoc($recent_assets)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['asset_name']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['serial_number']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
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
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</body>

</html>