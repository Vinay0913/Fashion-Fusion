<?php
session_start();
include('server/connection.php');

// Unset cart session on page load if needed
// unset($_SESSION['cart']); 

// Initialize cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['add_to_cart'])) {
    // If user already added to cart
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        // Check if product has already been added to cart
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Fetch available quantities for the selected product size
                $availableQuantities = getAvailableQuantities($product_id);

                $product_array = array(
                    'product_id' => $row['product_id'],
                    'product_name' =>  $row['product_name'],
                    'product_price' => $row['product_price'],
                    'product_image' => $row['product_image'],
                    'product_quantity' => $_POST['product_quantity'],
                    'product_category' => $row['product_category'], // Added product category
                    'product_size' => $_POST['product_size'], // Added product size
                    'available_quantities' => $availableQuantities // Added available quantities
                );
                $_SESSION['cart'][$product_id] = $product_array;
                calculateTotalCart();
            } else {
                echo '<script>alert("Product not found");</script>';
            }
        } else {
            echo '<script>alert("Product already added");</script>';
        }
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        // Fetch available quantities for the selected product size
        $availableQuantities = getAvailableQuantities($product_id);

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity,
            'product_category' => $_POST['product_category'], // Added product category
            'product_size' => $_POST['product_size'], // Added product size
            'available_quantities' => $availableQuantities // Added available quantities
        );
        $_SESSION['cart'][$product_id] = $product_array;
    }
    calculateTotalCart();
} elseif (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    calculateTotalCart();
} elseif (isset($_POST['edit_quantity'])) {
    // Update product quantity
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
    calculateTotalCart();
} elseif (isset($_POST['checkout'])) {
    // Redirect to checkout page
    header('location: checkout.php');
    exit;
}

function calculateTotalCart()
{
    $total_price = 0;
    $total_quantity = 0;

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $product) {
            if (isset($product['product_price']) && isset($product['product_quantity'])) {
                $price = $product['product_price'];
                $quantity = $product['product_quantity'];
                $total_price += ($price * $quantity);
                $total_quantity += $quantity;
            }
        }
    }
    $_SESSION['total'] = $total_price; // Store total price in session
    $_SESSION['quantity'] = $total_quantity;
}

// Function to fetch available quantities for the selected product size
function getAvailableQuantities($product_id)
{
    global $conn;
    $availableQuantities = array();
    $stmt_sizes = $conn->prepare("SELECT product_size, product_quantity FROM product_inventory WHERE product_id = ?");
    $stmt_sizes->bind_param("i", $product_id);
    $stmt_sizes->execute();
    $result_sizes = $stmt_sizes->get_result();
    while ($row_sizes = $result_sizes->fetch_assoc()) {
        $availableQuantities[$row_sizes['product_size']] = $row_sizes['product_quantity'];
    }
    return $availableQuantities;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Cart</title>
    <!-- Add your CSS links and other meta tags here -->
</head>
<body>
    <?php include('layouts/header.php'); ?>

    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
            <hr>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php if (!empty($_SESSION['cart'])) { ?>
                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="assets/img/<?php echo isset($value['product_image']) ? $value['product_image'] : ''; ?>"/>
                                <div>
                                    <p><?php echo isset($value['product_name']) ? $value['product_name'] : ''; ?></p>
                                    <small><span>₹ </span><?php echo isset($value['product_price']) ? $value['product_price'] : ''; ?></small>
                                    <br>
                                    <form method="POST" action="cart.php">
                                        <input type="hidden" name="product_id" value="<?php echo $key; ?>"/>
                                        <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                                    </form>
                                </div>
                            </div>
                        </td>

                        <td>
                            <?php echo isset($value['product_size']) ? $value['product_size'] : ''; ?>
                        </td>

                        <td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $key; ?>"/>
                                <input type="number" name="product_quantity" value="<?php echo isset($value['product_quantity']) ? $value['product_quantity'] : ''; ?>" max="<?php echo isset($value['available_quantities'][$value['product_size']]) ? $value['available_quantities'][$value['product_size']] : 0; ?>"/>
                                <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>
                            </form>
                        </td>

                        <td>
                            <span>₹</span>
                            <span class="product-price"><?php echo isset($value['product_price']) && isset($value['product_quantity']) ? ($value['product_quantity'] * $value['product_price']) : ''; ?></span>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Your cart is empty.</td>
                </tr>
            <?php } ?>
        </table>

        <?php if (!empty($_SESSION['cart'])) { ?>
            <div class="cart-total">
                <table>
                    <tr>
                        <td>Total</td>
                        <td>₹ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0;?></td>
                    </tr>
                </table>
            </div>
        <?php } ?>

        <div class="checkout-container">
            <div class="shop-button">
                <a href="shop.php" class="btn back-to-shop">Back to Shop</a>
            </div>

            <form method="POST" action="cart.php">
                <input type="submit" class="btn checkout-btn" value="checkout" name="checkout">
            </form>
        </div>
    </section>

    <?php include('layouts/footer.php'); ?>
</body>
</html>
