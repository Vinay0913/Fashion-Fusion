<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
  <title>Sidebar</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* Sidebar styling */
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 220px;
      padding: 20px;
      background-color: #343a40;
      color: #fff;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .dropdown-toggle::after {
      display: none;
    }
    .dropdown-menu {
      background-color: #343a40;
      border: none;
    }
    .dropdown-item {
      color: #fff;
      padding: 10px 20px;
    }
    .dropdown-item:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="sales.php"><i class="fas fa-chart-line"></i> Sales</a>
    <a href="transaction.php"><i class="fas fa-money-bill-wave"></i> Transactions</a>
    <a href="#"><i class="fas fa-box"></i>Products</i></a>
                    <a href="add_products.php">Add Products</a>
                    <a href="manage_products.php">Manage Products</a>
               
    <a href="manage_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a href="manage_users.php"><i class="fas fa-users"></i> Users</a>
    <a href="view_Feedback.php"><i class="fas fa-comments"></i> Feedback</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="../index.php"><i class="fas fa-globe"></i> Website</a>
    <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
