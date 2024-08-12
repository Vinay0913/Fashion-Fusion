<?php
include('connection.php');

// Check if order_id is set in the URL
if (isset($_GET['order_id'])) {
    $orderId = $conn->real_escape_string($_GET['order_id']);

    // Query to retrieve data from the orders and order_items tables for the specific order_id
    $query = "
        SELECT 
            orders.id, orders.user_name, orders.order_id, orders.user_id, orders.user_phone, orders.user_address, orders.user_city, 
            orders.order_date, orders.payment_status, orders.order_cost, 
            order_items.product_id, order_items.product_name, order_items.product_price, 
            order_items.product_quantity, order_items.product_size, order_items.product_category
        FROM 
            orders 
        INNER JOIN 
            order_items ON orders.order_id = order_items.order_id
        WHERE 
            orders.order_id = '$orderId'";

    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "<script>alert('No order ID specified'); window.location.href='manage_orders.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Order Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
        .table-container {
            margin-top: 50px;
        }

        /* Style table rows on hover */
        tr:hover {
            background-color: #f5f5f5;
        }

        /* Add border to table */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: bold;
        }

        .btn-print {
            background-color: #007bff;
            color: #fff;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-back:hover {
            background-color: #bd2130;
        }

        /* Sidebar styling */
        .sidebar {
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
            padding: 20px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include('sidebar1.php'); ?>
            </div>
            <div class="col-md-10">
                <h2>Order Details</h2>
                <div class="table-responsive table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Order Cost</th>
                                <th>Order Date</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PHP code to display order details -->
                            <?php
                            // Loop through each row of the result set
                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $counter++ . "</td>";
                                echo "<td>" . $row['user_name'] . "</td>";
                                echo "<td>" . $row['user_phone'] . "</td>";
                                echo "<td>" . $row['user_address'] . "</td>";
                                echo "<td>" . $row['user_city'] . "</td>";
                                echo "<td>" . $row['order_id'] . "</td>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "<td>" . $row['product_price'] . "</td>";
                                echo "<td>" . $row['product_quantity'] . "</td>";
                                echo "<td>₹" .$row['order_cost'] . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "<td>" . $row['payment_status'] . "</td>";
                                echo "<td>";
                                // Check if payment status is not 'not paid' before displaying the button
                                if ($row['payment_status'] !== 'not paid') {
                                    echo "<a href='print_receipt.php?order_id=" . $row['order_id'] . "' class='btn btn-print btn-sm'><i class='fas fa-print'></i> Print Receipt</a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            // Free result set
                            mysqli_free_result($result);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
