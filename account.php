<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        // Unset necessary session variables
      session_destroy();
    }
    header('location: login.php');
    exit;
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header('Location: account.php?error=Passwords do not match');
        exit;
    }

    // Check password length
    if (strlen($password) < 6) {
        header('Location: account.php?error=Password must be at least 6 characters');
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', $hashedPassword, $user_email);
    if ($stmt->execute()) {
        header('Location: account.php?message=Password has been updated successfully');
        exit;
    } else {
        header('Location: account.php?error=Could not update password');
        exit;
    }
}

// Get unpaid orders
if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? AND payment_status != 'paid'"); // Modify the query to exclude paid orders
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $unpaid_order = $stmt->get_result();

    // Initialize an array to store order IDs
    $unpaid_order_ids = array();

    // Fetch order IDs and store them in the array
    while ($row = $unpaid_order->fetch_assoc()) {
        $unpaid_order_ids[] = $row['order_id'];
    }

    // Store the order IDs array in the session
    $_SESSION['unpaid_order_ids'] = $unpaid_order_ids;
}

// Get paid orders
if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? AND payment_status = 'paid'"); // Query to fetch paid orders
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $paid_order = $stmt->get_result();

    // Initialize an array to store order IDs
    $paid_order_ids = array();

    // Fetch order IDs and store them in the array
    while ($row = $paid_order->fetch_assoc()) {
        $paid_order_ids[] = $row['order_id'];
    }

    // Store the order IDs array in the session
    $_SESSION['paid_order_ids'] = $paid_order_ids;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Account</title>
    <!-- Add your CSS links here -->
</head>
<body>
    
<?php include('layouts/header.php')?>

<section class="mt-5 py-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="text-center mt-5 pt-5">
                    <h3 class="font-weight-bold">Account Info</h3>
                    <hr class="mx-auto">
                    <div class="account-info">
                        <p>Name: <span><?php if (isset($_SESSION['user_name'])) {
                                            echo $_SESSION['user_name'];
                                        } ?></span></p>
                        <p>Email: <span><?php if (isset($_SESSION['user_email'])) {
                                            echo $_SESSION['user_email'];
                                        } ?></span></p>
                        <p><a href="#paid-orders" id="order-btn">Your Order</a></p>
                        <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 mt-5">
                <form id="account-form" method="POST" action="account.php">
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <!-- Display error or success message here -->
                        <?php if(isset($_GET['error'])): ?>
                            <p class="text-center" style="color:red"><?php echo $_GET['error']; ?></p>
                        <?php endif; ?>
                        <?php if(isset($_GET['message'])): ?>
                            <p class="text-center" style="color:green"><?php echo $_GET['message']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Confirm Password" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" class="btn btn-primary" name="change_password" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- Paid Orders -->
<section id="paid-orders" class="orders container">
    <div class="container mt-3">
        <h2 class="font-weight-bold text-center">Orders</h2>
        <hr class="mx-auto">
    </div>
    <div class="container mt-2 pt-2">
        <table>
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Order Cost</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Order Details</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Check if user_id is available (replace $_SESSION['user_id'] with your actual session variable)
                if(isset($_SESSION['user_id'])):
                   
                    
                    // Prepare and execute SQL query to fetch orders for the user
                    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");
                    $stmt->bind_param('i', $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if orders exist for the user
                    if($result->num_rows > 0):
                        // Loop through each order
                        while($row = $result->fetch_assoc()):
                ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['order_cost']; ?></td>
                                <td><?php echo $row['payment_status']; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td>
    <form method="POST" action="order_details.php">
        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
        <input type="submit" class="btn order-details-btn" name="order_details_btn" value="Details">
    </form>
</td>
                            </tr>
                <?php 
                        endwhile;
                    else:
                        // Display message if no orders found for the user
                        echo "<tr><td colspan='5' style='text-align: center;'>You don't have any orders</td></tr>";
                    endif;
                    // Close statement
                    $stmt->close();
                else:
                    // Display message if user_id is not available
                    echo "<tr><td colspan='5' style='text-align: center;'>User ID not found</td></tr>";
                endif;
                ?>
            </tbody>
        </table>
    </div>
</section>


<?php include('layouts/footer.php')?>

</body>
</html>
