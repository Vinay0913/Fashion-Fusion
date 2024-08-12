<?php
session_start();
include('server/connection.php');

// If user already registered, redirect to account page
if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    
    // Server-side validation
    if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($address) || empty($city)) {
        header('Location: registration.php?error=All fields are required');
        exit;
    }

    // Name validation
    if (!preg_match('/^[A-Za-z]+$/', $name)) {
        header('Location: registration.php?error=Name must contain only alphabets');
        exit;
    }

    // If passwords don't match
    if ($password !== $confirmPassword) {
        header('Location: registration.php?error=Passwords don\'t match');
        exit;
    }

    // If password is less than 6 characters
    else if(strlen($password) < 6){
        header('Location: registration.php?error=Password must be at least 6 characters');
        exit;
    }

    // If phone number does not have exactly 10 digits
    else if (strlen($phone) !== 10 || !is_numeric($phone)) {
        header('Location: registration.php?error=Phone number must be exactly 10 digits and contain only numbers');
        exit;
    }

    // Check whether there is a user with this email or not
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    // If there is already a registered user
    if($num_rows != 0){
        header('Location: registration.php?error=User with this email already exists');
        exit;
    } else {
        // Create a new user
        $stmt = $conn->prepare("INSERT INTO users (user_name, user_username, user_email, user_phone, user_password, user_address, user_city) VALUES (?,?,?,?,?,?,?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('sssssss', $name, $username, $email, $phone, $hashed_password, $address, $city);

        // If account was created successfully
        if($stmt->execute()){
            $user_id = $stmt->insert_id;
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name; // Store the name in the session
            $_SESSION['user_username'] = $username;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_address'] = $address;
            $_SESSION['user_city'] = $city;
            $_SESSION['logged_in'] = true;
            header('Location: account.php?register=Registered Successfully');
            exit;
        } else {
            header('location: registration.php?error=Could not create an account at the moment');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Registration</title>
    <script>
        function validateForm() {
            var name = document.getElementById("register-name").value.trim();
            var username = document.getElementById("register-username").value.trim();
            var email = document.getElementById("register-email").value.trim();
            var phone = document.getElementById("register-phone").value.trim();
            var password = document.getElementById("register-password").value;
            var confirmPassword = document.getElementById("register-confirm-password").value;
            var address = document.getElementById("register-address").value.trim();
            var city = document.getElementById("register-city").value.trim();

            // Name validation
            if (name == "") {
                alert("Name must not be empty");
                return false;
            }
            var alphabetRegex = /^[A-Za-z]+$/;
            if (!alphabetRegex.test(name)) {
                alert("Name must contain only alphabets");
                return false;
            }

            // Username validation
            if (username == "") {
                alert("Username must not be empty");
                return false;
            }

            // Email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email address");
                return false;
            }

            // Phone number validation
            if (phone.length !== 10 || isNaN(phone)) {
                alert("Phone number must be exactly 10 digits and contain only numbers");
                return false;
            }

            // Password validation
            if (password.length < 6) {
                alert("Password must be at least 6 characters long");
                return false;
            }

            // Confirm password validation
            if (password !== confirmPassword) {
                alert("Passwords do not match");
                return false;
            }

            // Address validation
            if (address == "") {
                alert("Address must not be empty");
                return false;
            }

            // City validation
            if (city == "") {
                alert("City must not be empty");
                return false;
            }

            return true; // Form submission will proceed if all validations pass
        }
    </script>
</head>
<body>

<!-- Your HTML content here -->

<?php include('layouts/header.php')?>
<!--Register-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Register</h2>

        <div class="mx-auto container">
            <form id="register-form" method="post" action="registration.php" onsubmit="return validateForm()">
                <p style="color:red"><?php if(isset($_GET['error'])) { echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="register-username" name="username" placeholder="Username" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" id="register-phone" name="phone" placeholder="Phone Number" required maxlength="10"/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" id="register-address" name="address" placeholder="Address" required/>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" id="register-city" name="city" placeholder="City" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                   <a id="login-url" href="login.php" class="btn">Have an account? Login</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include('layouts/footer.php')?>

<!-- Your HTML content here -->

</body>
</html>
