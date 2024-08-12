<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantities = $_POST['quantity'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    $success = true;

    foreach ($quantities as $size => $quantity) {
        // Update quantity in the database
        $update_sql = "UPDATE product_inventory SET product_quantity = ? WHERE product_id = ? AND product_size = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "iis", $quantity, $product_id, $size);
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
            // Print error message for debugging
            echo "Error updating quantity: " . mysqli_error($conn);
            // Rollback the transaction
            mysqli_rollback($conn);
            break; // Exit the loop on error
        }
    }

    if ($success) {
        // Commit the transaction
        mysqli_commit($conn);
        // Display alert box and redirect
        echo '<script>alert("Quantities updated successfully."); window.location.href = "manage_products.php";</script>';
        exit(); // Stop further execution
    }
} elseif (isset($_GET['id'])) {
    // Fetch product details from the database based on product ID
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        // Product found, fetch its details
        $product = mysqli_fetch_assoc($result);

        // Fetch sizes and quantities for the product
        $size_sql = "SELECT product_size, product_quantity FROM product_inventory WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $size_sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $size_result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Product Inventory</title>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom CSS for the table */
        .table-container {
            margin-top: 50px;
        }
        /* Add border to table */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #dddddd;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
   
<div class="container-fluid mt-5 w-50">
<?php include('sidebar1.php'); ?>
        <div class="row">
            <div class="col">
                <h2>Product Inventory</h2>
                  <!-- Back button to go back to edit_product.php page -->
                  <a href="edit_product.php?id=<?php echo $product_id; ?>" class="btn btn-secondary mb-2"><i class="fas fa-arrow-left"></i>Back to Edit Product</a>
                <p>Product Name : <?php echo $product['product_name']; ?></p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($size_result)): ?>
                                <tr>
                                    <td><?php echo $row['product_size']; ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $row['product_size']; ?>]" value="<?php echo $row['product_quantity']; ?>">
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Update Quantities</button>
                  
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    } else {
        // Product not found
        echo "Product not found.";
    }
} else {
    // Product ID not provided
    echo "Product ID not provided.";
}
?>
