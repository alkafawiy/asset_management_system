<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
<?php include('includes/header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <div class=" p-4">
                <?php include('includes/navbar.php'); ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Dashboard</h2>
                    <p>Welcome <strong><?php echo $_SESSION['fullname']; ?></strong></p>
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
                <!-- Asset Status Chart -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card card-box border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="mb-4">Asset Analytics</h4>
                                <canvas id="assetChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Assets -->
                <div class="card shadow border-0 mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Recent Assets</h4>
                            <a href="assets.php" class="btn btn-dark btn-sm">View All</a>
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
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('assetChart').getContext('2d');
        const assetChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Assigned', 'Damaged', 'Under Maintenance'],
                datasets: [{
                    label: 'Asset Status',
                    data: [
                        <?php echo $available_assets_result['total']; ?>,
                        <?php echo $assigned_assets_result['total']; ?>,
                        <?php echo $damaged_assets_result['total']; ?>,
                        <?php
                        $maintenance_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE asset_status='Under Maintenance'");
                        $maintenance_result = mysqli_fetch_assoc($maintenance_query);
                        echo $maintenance_result['total'];
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)', // Available - Green
                        'rgba(0, 123, 255, 0.7)', // Assigned - Blue
                        'rgba(220, 53, 69, 0.7)', // Damaged - Red
                        'rgba(255, 193, 7, 0.7)' // Under Maintenance - Yellow
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });
    });
</script>
<?php include('includes/footer.php'); ?>