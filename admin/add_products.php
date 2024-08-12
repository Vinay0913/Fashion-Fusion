<?php
include('connection.php'); // Include database connection file

$message = ""; // Variable to store success/error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sizes = $_POST['sizes']; // Array of product sizes
    $quantities = $_POST['quantities']; // Array of product quantities

    // File upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
   
                // Insert product data into database
                $sql = "INSERT INTO products (product_name, product_category, product_description, product_image, product_price) VALUES ('$name', '$category', '$description', '$fileName', '$price')";
                if (mysqli_query($conn, $sql)) {
                    // Retrieve the product ID of the newly inserted product
                    $product_id = mysqli_insert_id($conn);
                    
                    // Insert product sizes and quantities into product_inventory table
                    for ($i = 0; $i < count($sizes); $i++) {
                        $size = $sizes[$i];
                        $quantity = $quantities[$i];
                        $sql_inventory = "INSERT INTO product_inventory (product_id, product_size, product_quantity) VALUES ('$product_id', '$size', '$quantity')";
                        mysqli_query($conn, $sql_inventory);
                    }

                    $message = "Product added successfully.";
                    echo '<script>alert("Product added successfully.");</script>'; // Display JavaScript alert
                } else {
                    $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
          
        } else {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $message = "File is not an image.";
    }
} else {
    $sizes = array(); // Initialize empty array for sizes
    $quantities = array(); // Initialize empty array for quantities
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Add Product</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include('sidebar1.php'); ?>
            </div>
            <div class="col-md-6">
                <div class="container mt-5">
                    <div class="row mb-3">
                      
                    </div>
                    <h2>Add New Product</h2>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <input type="text" id="category" name="category" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="sizes" class="form-label">Sizes and Quantities:</label>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" id="size1" name="sizes[]" placeholder="Size S" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="quantity1" name="quantities[]" placeholder="Quantity S" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" id="size2" name="sizes[]" placeholder="Size M" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="quantity2" name="quantities[]" placeholder="Quantity M" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" id="size3" name="sizes[]" placeholder="Size L" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="quantity3" name="quantities[]" placeholder="Quantity L" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" id="size4" name="sizes[]" placeholder="Size XL" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="quantity4" name="quantities[]" placeholder="Quantity XL" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" id="size5" name="sizes[]" placeholder="Size 2XL" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" id="quantity5" name="quantities[]" placeholder="Quantity 2XL" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
