<?php
include('connection.php');

// Check if payment_id is provided
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    
    // Prepare the query
    $sql = "SELECT * FROM orders WHERE payment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $payment_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if order exists
    if (mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        echo "Payment not found.";
        exit;
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Payment ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .print-button {
            margin: 20px 0;
            text-align: center;
        }
        .print-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="../assets/img/Fashion-Fusion.png" style="width:50%; max-width:150px;">
                            </td>
                            <td>
                                Invoice #: <?php echo $order['id']; ?><br>
                                Created: <?php echo date("Y-m-d"); ?><br>
                                Payment ID: <?php echo $order['payment_id']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Customer Name: <?php echo $order['user_name']; ?><br>
                                Customer Phone: <?php echo $order['user_phone']; ?>
                            </td>
                            <td>
                                Order Date: <?php echo $order['order_date']; ?><br>
                                Payment Status: <?php echo $order['payment_status']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Item
                </td>
                <td>
                    Cost
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Order Cost
                </td>
                <td>
                    <?php echo $order['order_cost']; ?>
                </td>
            </tr>
            
            <tr class="total">
                <td></td>
                <td>
                   Total: <?php echo $order['order_cost']; ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="print-button">
        <button onclick="printInvoice()">Print Invoice</button>
    </div>
</body>
</html>
