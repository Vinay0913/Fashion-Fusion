<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('connection.php');

// Check if user is not logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../checkout.php?message=Please login to place an order');
    exit;
} else {
    // Check if user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../checkout.php?message=User ID is missing');
        exit;
    }

    // Process order if the place_order button is clicked
    if (isset($_POST['place_order'])) {
        // Get user info
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];

        // Order details
        $order_cost = $_SESSION['total'];
        $payment_status = "not paid";
        $user_id = $_SESSION['user_id'];
        $order_date = date('Y-m-d H:i:s');

        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (order_cost, payment_status, user_id, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('dssssss', $order_cost, $payment_status, $user_id, $phone, $city, $address, $order_date); // Changed 'i' to 'd' for order_cost
        $stmt_status = $stmt->execute();

        if (!$stmt_status) {
            header('Location: ../index.php?message=Error placing order');
            exit;
        }

        // Get the order ID
        $order_id = $stmt->insert_id;

        // Store order_id in session
        $_SESSION['order_id'] = $order_id;

        // Insert into order_items table
        foreach ($_SESSION['cart'] as $product) {
            // Check if all required fields are set
            if (isset($product['product_id'], $product['product_name'], $product['product_image'], $product['product_price'], $product['product_quantity'], $product['product_size'])) {
                $product_id = $product['product_id'];
                $product_name = $product['product_name'];
                $product_image = $product['product_image'];
                $product_price = $product['product_price'];
                $product_quantity = $product['product_quantity'];
                $product_size = $product['product_size'];

                // Fetch category information from products table
                $stmt_category = $conn->prepare("SELECT product_category FROM products WHERE product_id = ?");
                $stmt_category->bind_param("i", $product_id);
                $stmt_category->execute();
                $result_category = $stmt_category->get_result();

                if ($result_category->num_rows > 0) {
                    $row_category = $result_category->fetch_assoc();
                    $product_category = $row_category['product_category'];
                } else {
                    // Handle if category information is not found
                    // For example, you could set a default category or log an error
                    $product_category = "Uncategorized";
                    // Log error
                    error_log("Category information not found for product ID: $product_id");
                }

                // Insert into order_items table
                $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, user_id, product_id, product_name, product_image, product_price, product_quantity, product_size, product_category, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bind_param("iiisssisss", $order_id, $user_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $product_size, $product_category, $order_date);
                $stmt1->execute();

              
            }
        }

        // Clear cart session
        unset($_SESSION['cart']);

        // Redirect to payment page
        header('Location: ../account.php');
        exit;
    }
}
?>
