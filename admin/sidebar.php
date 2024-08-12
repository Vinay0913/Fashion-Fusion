<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_style.css">
    <style>
        .sidebar ul ul {
            display: none;
        }

        .sidebar ul li:hover > ul {
            display: block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li><a href="transaction.php">Transaction</a></li>
            <li>
                <a href="#">Products <i class="fas fa-chevron-down"></i></a>
                <ul>
                    <li><a href="add_products.php">Add Products</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                </ul>
            </li>
            <li><a href="manage_orders.php">Orders</a></li>
            <li><a href="manage_users.php">Users</a></li>
            <li><a href="view_Feedback.php">FeedBack's</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="../index.php">Website</a></li>
            <li><a href="admin_logout.php">Logout</a></li> <!-- Updated Logout link -->
        </ul>
    </div>
</body>
</html>
