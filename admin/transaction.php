<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
  <title>Transaction</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    /* Custom CSS for styling */
    body {
      display: flex;
    }
    .btn-view {
      padding: 6px 12px;
      margin: 3px;
    }
    /* Add borders to table */
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    th {
      background-color: #f2f2f2;
    }
    .content {
      margin-left: 220px; /* Adjust according to sidebar width */
      padding: 20px;
      width: calc(100% - 220px);
    }
  </style>
</head>
<body>

  <?php include('sidebar1.php'); ?>

  <div class="content">
    <h2>Transaction</h2>
   

    <table class="table table-striped">
      <thead>
        <tr>
          <th>User Name</th>
          <th>Payment ID</th>
          <th>Quantity</th>
          <th>Action</th> <!-- New column for Action -->
        </tr>
      </thead>
      <tbody>
        <?php
        include('connection.php');

        // Query to fetch data from the orders and order_items tables
        $sql = "SELECT o.order_id, o.user_name, o.payment_id, oi.product_quantity 
                FROM orders o
                INNER JOIN order_items oi ON o.order_id = oi.order_id";
        $result = mysqli_query($conn, $sql);

        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['user_name'] . "</td>";
          echo "<td>" . $row['payment_id'] . "</td>";
          echo "<td>" . $row['product_quantity'] . "</td>";
          echo "<td><a href='view_order.php?payment_id=" . $row['payment_id'] . "' class='btn btn-primary btn-view'>View Details</a></td>"; // Link to view order details
          echo "</tr>";
        }

        // Close connection
        mysqli_close($conn);
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
