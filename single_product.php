<?php
session_start();
include('server/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in'])) {
    echo '<script>
            alert("Please login first");
            window.location.href = "login.php"; // Redirect to the login page
          </script>';
}

// Check if product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result();
} else {
    header('location: index.php');
    exit; // Added exit to stop further execution
}

// Fetch available quantities for each size
$stmt_sizes = $conn->prepare("SELECT product_size, product_quantity FROM product_inventory WHERE product_id = ?");
$stmt_sizes->bind_param("i", $product_id);
$stmt_sizes->execute();
$result_sizes = $stmt_sizes->get_result();

// Initialize an associative array to store available quantities for each size
$availableQuantities = array();

// Loop through each available size and store the quantity in the array
while ($row_sizes = $result_sizes->fetch_assoc()) {
    $availableQuantities[$row_sizes['product_size']] = $row_sizes['product_quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Product</title>
</head>
<body>
 
<?php include('layouts/header.php')?>

<!-- Single product -->
<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <?php while ($row = $product->fetch_assoc()) { ?>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/img/<?php echo $row['product_image']; ?>" id="mainImg" />
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                <h2>₹ <?php echo $row['product_price']; ?></h2>
                <form method="POST" action="cart.php" onsubmit="return validateForm()">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>" />
                    <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>" />
                    <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?> " />
                    <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?> " />
                    <!-- Add hidden input field for product category -->
                    <input type="hidden" name="product_category" value="<?php echo $row['product_category']; ?>" />
                    <div class="form-group">
                        <label for="size">Select Size:</label>
                        <select class="form-control" id="size" name="product_size" style="width: 50%; border: 1px solid black; padding: 8px; margin-bottom: 5px;" placeholder="Select Size" onchange="updateMaxQuantity()">
                            <option value="" disabled selected>Size</option>
                            <?php
                            // Loop through each available size and display as an option
                            foreach ($availableQuantities as $size => $quantity) {
                                if ($quantity <= 0) {
                                    echo '<option value="' . $size . '" disabled>' . $size . ' (out of stock)</option>';
                                } else {
                                    echo '<option value="' . $size . '">' . $size . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <input type="number" id="quantity" name="product_quantity" value="1" />
                    <?php if (isset($_SESSION['logged_in'])) { ?>
                        <button class="buy-btn" type="submit" name="add_to_cart">Add to cart</button>
                    <?php } else { ?>
                        <button class="buy-btn" type="button" onclick="alertRedirect()">Add to cart</button>
                    <?php } ?>
                </form>
                <h4 class="mt-5 mb-5">Product Details</h4>
                <span><?php echo $row['product_description']; ?></span>

            </div>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php') ?>

<script>
    function alertRedirect() {
        alert("Please login first");
        window.location.href = "login.php"; // Redirect to the login page
    }

    function updateMaxQuantity() {
        var size = document.getElementById("size").value;
        var quantityInput = document.getElementById("quantity");
        var availableQuantities = <?php echo json_encode($availableQuantities); ?>;

        if (size === "") {
            quantityInput.value = 1;
            quantityInput.setAttribute("max", 1);
            quantityInput.setAttribute("disabled", true);
        } else {
            quantityInput.removeAttribute("disabled");

            // Set maximum allowed quantity based on available quantity for the selected size
            var availableQuantity = availableQuantities[size];
            if (availableQuantity <= 0) {
                quantityInput.value = 0;
                quantityInput.setAttribute("max", 0);
            } else {
                quantityInput.setAttribute("max", availableQuantity);
                if (parseInt(quantityInput.value) > availableQuantity) {
                    quantityInput.value = availableQuantity;
                }
            }
        }
    }

    function validateForm() {
        var size = document.getElementById("size").value;
        if (size === "") {
            alert("Please select a size");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
