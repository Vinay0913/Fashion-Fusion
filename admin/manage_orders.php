<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        $orderId = $_POST['order_id'];
        $stmt = $conn->prepare("INSERT INTO confirmed_orders (order_id, order_status) VALUES (?, 'confirmed')");
        $stmt->bind_param("s", $orderId);
        $stmt->execute();
        echo "<script>alert('Order confirmed successfully');</script>";
    } elseif (isset($_POST['cancel'])) {
        $orderId = $_POST['order_id'];
        $stmt = $conn->prepare("INSERT INTO confirmed_orders (order_id, order_status) VALUES (?, 'canceled')");
        $stmt->bind_param("s", $orderId);
        $stmt->execute();
        echo "<script>alert('Order canceled successfully');</script>";
    }
}

$stmt = $conn->prepare("SELECT id, order_id, order_cost, user_id, user_email, order_date, payment_id, payment_status FROM orders");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Manage Orders</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            display: flex;
        }
        .sidebar-container {
            flex-shrink: 0;
            width: 220px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        /* Style table rows on hover */
        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-confirm {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-confirm:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-view {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-view:hover {
            background-color: #0056b3;
            border-color: #004d9e;
        }

        .btn-canceled {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-canceled:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Add border to table */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sidebar-container">
        <?php include('sidebar1.php'); ?>
    </div>
    <div class="content">
        <h1>Manage Orders</h1>
      
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Id</th>
                        <th>Order Id</th>
                        <th>User Email</th>
                        <th>Order Date</th>
                        <th>Order Cost</th>
                        <th>Payment ID</th>
                        <th>Payment Status</th>
                        <th>Action</th> <!-- New column for Action -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display orders in table rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>₹" . $row['order_cost'] . "</td>";
                        echo "<td>" . $row['payment_id'] . "</td>";
                        echo "<td>" . $row['payment_status'] . "</td>";
                        echo "<td>";
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                        
                        // Check if the order is confirmed or canceled
                        $orderStatus = ""; // Initialize order status variable
                        $checkStatus = $conn->prepare("SELECT order_status FROM confirmed_orders WHERE order_id = ?");
                        $checkStatus->bind_param("s", $row['order_id']);
                        $checkStatus->execute();
                        $checkStatusResult = $checkStatus->get_result();
                        if ($checkStatusResult->num_rows > 0) {
                            $statusRow = $checkStatusResult->fetch_assoc();
                            $orderStatus = $statusRow['order_status'];
                        }

                        if ($orderStatus == "confirmed") {
                            echo "<a href='order_details.php?order_id=" . $row['order_id'] . "' class='btn btn-view'><i class='fas fa-eye'></i> View</a>";

                        } elseif ($orderStatus == "canceled") {
                            echo "<button class='btn btn-canceled'><i class='fas fa-times'></i> Canceled</button>";
                        } else {
                            echo "<button type='submit' name='confirm' class='btn btn-confirm'><i class='fas fa-check'></i> Confirm</button>";
                            echo "<button type='submit' name='cancel' class='btn btn-danger'><i class='fas fa-times'></i> Cancel</button>";
                        }
                        
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
