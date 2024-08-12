<?php
session_start();
// Initialize variables with empty values
$name = $email = $phone = $city = $address = '';

// Check if the variables are set in the session and assign their values
if (isset($_SESSION['user_name'])) {
    $name = $_SESSION['user_name'];
}
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
}
if (isset($_SESSION['user_phone'])) {
    $phone = $_SESSION['user_phone'];
}
if (isset($_SESSION['user_city'])) {
    $city = $_SESSION['user_city'];
}
if (isset($_SESSION['user_address'])) {
    $address = $_SESSION['user_address'];
}
// Include database connection
include('server/connection.php');

// Retrieve payment details from query parameters
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';

// Generate a random 5-digit number and pad it with zeros for the order number
$order_number = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

// Construct the order ID with the format "ORDER_XXXXX"
$order_id = 'ORDER_' . $order_number;

// Get current date and time
$order_date = date('Y-m-d H:i:s');
$payment_status = "paid";

// Retrieve order cost from session
$order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : 0;

// Prepare and execute SQL query to insert the order details into the orders table
$stmt = $conn->prepare("INSERT INTO orders (order_id, order_cost, payment_status, user_id, user_name, user_email, user_phone, user_city, user_address, order_date, payment_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sdsssssssss', $order_id, $order_cost, $payment_status, $_SESSION['user_id'], $name, $email, $phone, $city, $address, $order_date, $payment_id);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

// Execute the statement
$stmt_status = $stmt->execute();

// Check if the execution was successful
if ($stmt_status === TRUE) {
    // Order details inserted successfully
    // Now insert order items into the order_items table

    // Retrieve order items from session
    $order_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    // Prepare and execute SQL query to insert order items into the order_items table
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $product_name = $item['product_name'];
        $product_price = $item['product_price'];
        $product_quantity = $item['product_quantity'];
        $product_size = $item['product_size'];
        $product_image = $item['product_image'];
        $product_category = $item['product_category'];

        // Insert order item
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, user_id, product_id, product_name, product_price, product_quantity, product_size, product_image, product_category, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sddsddssss', $order_id, $_SESSION['user_id'], $product_id, $product_name, $product_price, $product_quantity, $product_size, $product_image, $product_category, $order_date);
        $stmt->execute();

        // Update product quantity in the products table
        $stmt_update = $conn->prepare("UPDATE product_inventory SET product_quantity = product_quantity - ? WHERE product_id = ? && product_size = ?");
        $stmt_update->bind_param('dds', $product_quantity, $product_id, $product_size);
        $stmt_update->execute();
    }

    // Clear the cart after successful order placement
    unset($_SESSION['cart']);

} else {
    // Error inserting order details
    echo "Error inserting order details: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Success</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .payment-id {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="card-title">Payment Successful</h2>
                        <p class="card-text">Your Order ID: <span class="payment-id"><?php echo $order_id; ?></span></p>
                        <p class="card-text">Payment ID: <span class="payment-id"><?php echo $payment_id; ?></span></p>
                       
                        <p class="card-text">Total Amount: ₹<?php echo $order_cost; ?></p>
                        <p class="card-text">Thank you for shopping with us!</p>
                        <button class="btn btn-primary" onclick="window.location.href = 'shop.php';">Shop More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
