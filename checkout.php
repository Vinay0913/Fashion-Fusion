<?php
session_start();

// Redirect to index if cart is empty
if (empty($_SESSION['cart'])) {
    header('location: index.php');
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    // Redirect to index with message if user is not logged in
    header('location: index.php?message=Please login to place an order');
    exit;
}

// Initialize error variables with empty values
$nameErr = $emailErr = $phoneErr = $cityErr = $addressErr = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate phone
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            $phoneErr = "Invalid phone number";
        }
    }

    // Validate city
    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    } else {
        $city = test_input($_POST["city"]);
    }

    // Validate address
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = test_input($_POST["address"]);
    }

    // If no errors, proceed to payment
    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($cityErr) && empty($addressErr)) {
        header('Location: payment.php');
        exit;
    }
}

// Sanitize input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .text-danger {
            color: red;
        }
    </style>
    <script>
        function validateForm() {
            var isValid = true;
            var name = document.forms["checkoutForm"]["name"].value;
            var email = document.forms["checkoutForm"]["email"].value;
            var phone = document.forms["checkoutForm"]["phone"].value;
            var city = document.forms["checkoutForm"]["city"].value;
            var address = document.forms["checkoutForm"]["address"].value;
            var phonePattern = /^[0-9]{10}$/;

            // Name validation
            if (name == "") {
                document.getElementById("nameErr").innerHTML = "Name is required";
                isValid = false;
            } else {
                document.getElementById("nameErr").innerHTML = "";
            }

            // Email validation
            if (email == "") {
                document.getElementById("emailErr").innerHTML = "Email is required";
                isValid = false;
            } else {
                var re = /\S+@\S+\.\S+/;
                if (!re.test(email)) {
                    document.getElementById("emailErr").innerHTML = "Invalid email format";
                    isValid = false;
                } else {
                    document.getElementById("emailErr").innerHTML = "";
                }
            }

            // Phone validation
            if (phone == "") {
                document.getElementById("phoneErr").innerHTML = "Phone number is required";
                isValid = false;
            } else if (!phonePattern.test(phone)) {
                document.getElementById("phoneErr").innerHTML = "Invalid phone number";
                isValid = false;
            } else {
                document.getElementById("phoneErr").innerHTML = "";
            }

            // City validation
            if (city == "") {
                document.getElementById("cityErr").innerHTML = "City is required";
                isValid = false;
            } else {
                document.getElementById("cityErr").innerHTML = "";
            }

            // Address validation
            if (address == "") {
                document.getElementById("addressErr").innerHTML = "Address is required";
                isValid = false;
            } else {
                document.getElementById("addressErr").innerHTML = "";
            }

            return isValid;
        }
    </script>
</head>
<body>
<?php include('layouts/header.php')?>

<section class="container mt-5">
    <div class="row">
        <!-- Cart Items Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4 font-weight-bold">Cart Items</h5>
                    <!-- Display cart items -->
                    <div class="cart-items">
                        <?php foreach ($_SESSION['cart'] as $product): ?>
                            <div class="cart-item mb-2">
                                <p><strong>Name : </strong><?php echo $product['product_name']; ?></p>
                                <p><strong>Price: </strong> ₹<?php echo $product['product_price']; ?></p>
                                <p><strong>Quantity: </strong><?php echo $product['product_quantity']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout Form Section -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4 font-weight-bold">Checkout</h5>
                    <!-- Checkout form -->
                    <form name="checkoutForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name" required>
                            <small id="nameErr" class="form-text text-danger"><?php echo $nameErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <small id="emailErr" class="form-text text-danger"><?php echo $emailErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <small id="phoneErr" class="form-text text-danger"><?php echo $phoneErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
                            <small id="cityErr" class="form-text text-danger"><?php echo $cityErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                            <small id="addressErr" class="form-text text-danger"><?php echo $addressErr; ?></small>
                        </div>
                        <p class="text-danger"><strong>Total: ₹ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0;?></strong></p>
                        <button type="submit" class="btn btn-primary btn-block">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('layouts/footer.php')?>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
