<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Receipt</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        /* Print button style */
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
  
    <div class="container">
        <h1>Receipt</h1>
        <?php
        // Include the database connection file
        include('connection.php');

        // Check if the order ID is received from the previous page
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];

            // Perform a database query to retrieve data for the specific order ID
            $query = "SELECT orders.order_id, orders.user_id, users.user_name, users.user_email, orders.order_date, orders.order_cost
                      FROM orders
                      INNER JOIN users ON orders.user_id = users.user_id
                      WHERE orders.order_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the query was successful
            if ($result) {
                $order_data = $result->fetch_assoc();
                echo "<p><strong>Order ID:</strong> " . $order_data['order_id'] . "</p>";
                echo "<p><strong>User ID:</strong> " . $order_data['user_id'] . "</p>";
                echo "<p><strong>User Name:</strong> " . $order_data['user_name'] . "</p>";
                echo "<p><strong>User Email:</strong> " . $order_data['user_email'] . "</p>";
                echo "<p><strong>Order Date:</strong> " . $order_data['order_date'] . "</p>";

                // Perform a query to get the order items
                $query_items = "SELECT product_name, product_quantity, product_price
                                FROM order_items
                                WHERE order_id = ?";
                $stmt_items = $conn->prepare($query_items);
                $stmt_items->bind_param("s", $order_id);
                $stmt_items->execute();
                $result_items = $stmt_items->get_result();

                // Display order items in a table
                if ($result_items) {
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Product Name</th>";
                    echo "<th>Quantity</th>";
                    echo "<th>Price</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $result_items->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['product_quantity'] . "</td>";
                        echo "<td>₹ " . $row['product_price'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    // Display an error message if the query fails
                    echo "<p>Error retrieving order items from the database.</p>";
                }
                $stmt_items->close();

                // Display the order cost below the table
                echo "<p><strong>Order Cost:</strong> ₹ " . $order_data['order_cost'] . "</p>";
            } else {
                // Display an error message if the query fails
                echo "<p>Error retrieving order data from the database.</p>";
            }
            $stmt->close();
        } else {
            // If order ID is not received, display a message
            echo "<p>No order ID received.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        <!-- Print button -->
        <div class="print-button">
            <button onclick="printReceipt()">Print Receipt</button>
        </div>
    </div>

    <script>
        function printReceipt() {
            var printContents = document.querySelector('.container').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
