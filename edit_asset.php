<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");

}

// GET ASSET DATA
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query = "SELECT * FROM assets WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $asset = mysqli_fetch_assoc($result);
}
// UPDATE ASSET
if (isset($_POST['update_asset'])) {
    $id = $_POST['id'];
    $asset_name = $_POST['asset_name'];
    $category = $_POST['category'];
    $serial_number = $_POST['serial_number'];
    $department = $_POST['department'];
    $purchase_date = $_POST['purchase_date'];
    $asset_status = $_POST['asset_status'];

    $update_query = "UPDATE assets SET asset_name='$asset_name', category='$category', serial_number='$serial_number', department='$department', purchase_date='$purchase_date', asset_status='$asset_status' WHERE id='$id'";

    mysqli_query($conn, $update_query);
    header("Location: assets.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Asset</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="mb-4">
                    Edit Asset
                </h3>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $asset['id']; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Asset Name:</label>
                            <input type="text" class="form-control" name="asset_name"
                                value="<?php echo $asset['asset_name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Category:</label>
                            <input type="text" class="form-control" name="category"
                                value="<?php echo $asset['category']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Serial Number:</label>
                            <input type="text" class="form-control" name="serial_number"
                                value="<?php echo $asset['serial_number']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Department:</label>
                            <input type="text" class="form-control" name="department"
                                value="<?php echo $asset['department']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Purchase Date:</label>
                            <input type="date" class="form-control" name="purchase_date"
                                value="<?php echo $asset['purchase_date']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Asset Status:</label>
                            <select name="asset_status" class="form-control" required>
                                <option><?php echo $asset['asset_status']; ?></option>
                                <option>Available</option>
                                <option>Assigned</option>
                                <option>Damaged</option>
                                <option>Under Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="update_asset">
                        Update Asset
                    </button>
                    <a href="assets.php" class="btn btn-secondary">
                        Back
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>