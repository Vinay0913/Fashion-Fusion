<?php
include('connection.php');

if(isset($_GET['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Check if an image is uploaded
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Handle image upload
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = "uploads/" . $image_name;

            // Move uploaded image to the specified folder
            move_uploaded_file($image_tmp, $image_path);

            // Update product details with the new image path
            $sql = "UPDATE products SET product_name = ?, product_description = ?, product_price = ?, product_image = ?, product_category = ? WHERE product_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdssi", $name, $description, $price, $image_path, $category, $product_id);
        } else {
            // Update product details without changing the image path
            $sql = "UPDATE products SET product_name = ?, product_description = ?, product_price = ?, product_category = ? WHERE product_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdsi", $name, $description, $price, $category, $product_id);
        }

        // Execute the update query
        if(mysqli_stmt_execute($stmt)) {
            // Success: display alert and redirect
            echo '<script>alert("Product updated successfully."); window.location.href = "manage_products.php";</script>';
            exit(); // Stop further execution
        } else {
            // Error updating product
            echo "Error updating product: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom CSS for the form border */
        .form-border {
            border: 1px solid #ced4da; /* Gray border */
            border-radius: 5px; /* Rounded corners */
            padding: 20px; /* Add some padding */
        }
    </style>
</head>
<body>
<div class="container mt-5">
<?php include('sidebar1.php'); ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Edit Product</h2>
              <!-- Back button to go back to edit_product.php page -->
              <a href="manage_products.php?id=<?php echo $product_id; ?>" class="btn btn-secondary mb-2"><i class="fas fa-arrow-left"></i>Back to Manage Product</a>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $product_id; ?>" method="POST" enctype="multipart/form-data" class="form-border">
                <!-- Form fields for product details -->
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['product_name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $product['product_description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['product_price']; ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <!-- Display current image -->
                    <?php if(!empty($product['product_image']) && file_exists($product['product_image'])): ?>
                        <img src="<?php echo $product['product_image']; ?>" alt="Current Image" class="mt-2" style="max-width: 200px;">
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                     <button type="button" class="btn btn-secondary" onclick="location.href='edit_product_inventory.php?id=<?php echo $product_id; ?>'">Update Product Inventory</button>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?php echo $product['product_category']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
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
    }
} else {
    // Product ID not provided
    echo "Product ID not provided.";
}
?>
