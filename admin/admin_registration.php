<?php
session_start();
include('connection.php');

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header('Location: admin_registration.php?error=Passwords do not match');
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: admin_login.php?message=Registered successfully. Please log in.');
        exit;
    } else {
        header('Location: admin_registration.php?error=Registration failed. Please try again.');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border: none; /* Remove border */
            border-radius: 8px;
        }

        .register-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-form {
            padding: 20px;
        }

        .register-form .form-group {
            margin-bottom: 20px;
        }

        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="password"] {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
        }

        /* Updated CSS for the submit button */
        .register-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background-color: #007bff; /* Blue color */
            color: #fff; /* White text color */
            border: none; /* Remove border */
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        .register-form input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="register-container">
            <h2 class="register-title">Register</h2>
            <div class="register-form">
                <form id="register-form" method="post" action="">
                    <p class="text-center" style="color:red;">
                        <?php if (isset($_GET['error'])) {
                            echo $_GET['error'];
                        } ?>
                    </p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required />
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required />
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="register-btn" name="register" value="Register" />
                    </div>

                    <div class="login-link">
                        <a href="admin_login.php">Have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
