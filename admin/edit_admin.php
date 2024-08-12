<?php
// Assuming you have already established a database connection
include('connection.php');

// Check if an admin ID is provided in the URL
if (!isset($_GET['id'])) {
    die("Admin ID not provided.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the admin ID from the URL
    $admin_id = $_GET['id'];
    
    // Retrieve the current password, new password, and confirm password from the form
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Fetch admin details based on the ID from the URL
    $admin_id = $_GET['id'];
    $select_query = "SELECT * FROM admin WHERE id=$admin_id";
    $select_result = mysqli_query($conn, $select_query);
    $admin = mysqli_fetch_assoc($select_result);

    if (!$admin) {
        die("Admin not found.");
    }

    // Verify current password
    if (!password_verify($current_password, $admin['password'])) {
        die("Current password is incorrect.");
    }

    // Check if new password matches confirm password
    if ($new_password !== $confirm_password) {
        die("New password and confirm password do not match.");
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the admin's password in the database
    $update_query = "UPDATE admin SET password='$hashed_password' WHERE id=$admin_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Password updated successfully
        echo "<script>alert('Password updated successfully'); window.location.href = 'settings.php';</script>";
        exit();
    } else {
        // Error occurred while updating password
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Edit Admin Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="container-fluid mt-5 w-50">
    <h2 class="mb-4">Edit Admin Password</h2>
    <form method="post">
        <div class="form-group">
            <label for="current_password">Current Password:</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Password</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
