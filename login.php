<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, user_name, user_username, user_email, user_password, user_phone, user_address, user_city FROM users WHERE user_email = ?");
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
            // Bind the result variables
            $stmt->bind_result($user_id,$user_name, $username, $user_email, $user_password, $user_phone, $user_address, $user_city);

            // Fetch the result
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $user_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name; 
                $_SESSION['user_username'] = $username; // Set user username in session
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_phone'] = $user_phone;
                $_SESSION['user_address'] = $user_address;
                $_SESSION['user_city'] = $user_city;
                $_SESSION['logged_in'] = true;

                header('location: account.php');
                exit;
            } else {
                header('location: login.php?error=Incorrect password');
                exit;
            }
        } else {
            header('location: login.php?error=Could not verify your account');
            exit;
        }
    } else {
        // Error handling for database query execution
        header('location: login.php?error=Something went wrong');
        exit;
    }
}

// Logout functionality
if (isset($_POST['logout_btn'])) {
    
    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header('location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include('layouts/header.php')?>
    <!--login-->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>

            <div class="mx-auto container">
                <form id="login-form" method="POST" action="login.php">
                    <p style="color:red" class="text-center"><?php if (isset($_GET['error'])) {
                                                                echo $_GET['error'];
                                                            } ?></p>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="Login-email" name="email" placeholder="Email" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="Login-password" name="password" placeholder="Password" required />
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn" id="login-btn" name="login_btn" value="login" />
                    </div>

                    <div class="form-group">
                        <a id="register-url" href="registration.php" class="btn">Don't have an account? Register</a>
                    </div>
                    <div class="form-group">
                        <a id="forgot-password-url" href="forgot_password.php" class="btn">Forgot your password?</a>
                    </div>



                </form>
            </div>
        </div>
    </section>

    <?php include('layouts/footer.php')?>
    <form method="POST" action="login.php">
        <input type="submit" name="logout_btn" value="Logout" />
    </form>
</body>

</html>
