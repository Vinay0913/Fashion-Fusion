<?php
// Include your database connection file
include('connection.php');

// Initialize delete message variable
$delete_message = '';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete product if ID is provided and the delete request is sent
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    // Check if the delete action is confirmed
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $sql = "DELETE FROM products WHERE product_id = $id";
        if (mysqli_query($conn, $sql)) {
            // Set delete message
            $delete_message = "Product deleted successfully";
        } else {
            $delete_message = "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        // If the deletion is not confirmed, redirect back to the same page without deleting
        echo '<script>window.location.href = "manage_products.php";</script>';
        exit();
    }
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check if query execution is successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Manage Products</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom CSS for product table */
        .product-table img {
            max-width: 100px;
            height: auto;
        }

        .action-buttons {
            white-space: nowrap;
        }

        /* Sidebar styling */
        .sidebar {
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include('sidebar1.php'); ?>
            </div>
            <div class="col-md-9">
                <div class="container mt-4">
                    <div class="row mb-3">
                       
                        <div class="col-auto">
                            <h2>Manage Products</h2>
                        </div>
                        <div class="col">
                            <?php if ($delete_message): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $delete_message; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped product-table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display products in table rows
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['product_id'] . "</td>";
                                    echo "<td>" . $row['product_name'] . "</td>";
                                    echo "<td>" . $row['product_category'] . "</td>";
                                    echo "<td>" . $row['product_description'] . "</td>";
                                    echo "<td><img src='../assets/img/" . $row['product_image'] . "' alt='" . $row['product_name'] . "'></td>";
                                    echo "<td>₹" . $row['product_price'] . "</td>";
                                    echo "<td class='action-buttons'>
                                            <a href='edit_product.php?id=" . $row['product_id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                            <a href='?id=" . $row['product_id'] . "&action=delete&confirm=yes' class='btn btn-danger btn-sm' onclick='return confirmDelete(" . $row['product_id'] . ")'>Delete</a>
                                          </td>"; 
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript function to confirm product deletion
        function confirmDelete(id) {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
</body>
</html>
