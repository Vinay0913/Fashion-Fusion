<?php include('connection.php');?>
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
  <title>Transaction Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h2>Transaction Details</h2>
      
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
  <?php
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
          ?>
          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Order ID</th>
                          <th>Order Cost</th>
                          <th>User Name</th>
                          <th>User Phone</th>
                          <th>Order Date</th>
                          <th>Payment ID</th>
                          <th>Payment Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      while ($order = mysqli_fetch_assoc($result)) {
                          ?>
                          <!-- Inside the while loop in transaction details page -->
<tr>
    <td><?php echo $order['id']; ?></td>
    <td><?php echo $order['order_id']; ?></td>
    <td><?php echo $order['order_cost']; ?></td>
    <td><?php echo $order['user_name']; ?></td>
    <td><?php echo $order['user_phone']; ?></td>
    <td><?php echo $order['order_date']; ?></td>
    <td><?php echo $order['payment_id']; ?></td>
    <td><?php echo $order['payment_status']; ?></td>
    <td>
        <a href="transaction.php" class="btn btn-primary">Back</a>
        <a href="invoice.php?payment_id=<?php echo $order['payment_id']; ?>" class="btn btn-info">Generate Invoice</a>
    </td>
</tr>

                          <?php
                      }
                      ?>
                  </tbody>
              </table>
            
          </div>
          <?php
      } else {
          echo "<div class='alert alert-warning'>Payment not found.</div>";
      }
      
      // Close statement
      mysqli_stmt_close($stmt);
  } else {
      echo "<div class='alert alert-danger'>Payment ID not provided.</div>";
  }
  ?>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
