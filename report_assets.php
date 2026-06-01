<?php
include('config/db.php');

$result = mysqli_query($conn, "SELECT * FROM assets ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Report</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<style>
    body {
        padding: 30px;
    }

    h2 {
        margin-bottom: 30px;
        text-align: center;
    }
</style>

<body>
    <h2>Asset Management System Report</h2>
    <table class="table table-bordered">
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
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['asset_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['asset_status']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>window.print();</script>
</body>

</html>