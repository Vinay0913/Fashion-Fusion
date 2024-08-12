<?php
session_start();
include('connection.php');

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $stmt = $conn->prepare("SELECT id, name, email, password FROM admin WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['id'] = $admin['id'];
            $_SESSION['name'] = $admin['name'];
            $_SESSION['email'] = $admin['email'];

            header('Location: admin_dashboard.php');
            exit;
        } else {
            header('Location: admin_login.php?error=Incorrect password');
            exit;
        }
    } else {
        header('Location: admin_login.php?error=Could not verify your account');
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin-top: 15%;
            margin-left: 35%;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="login-container">
            <h2 class="login-title">Welcome Admin !</h2>
            <div class="login-form">
                <form id="login-form" method="POST" action="">
                    <p class="error-message">
                        <?php if (isset($_GET['error'])) {
                            echo $_GET['error'];
                        } ?>
                    </p>
                    <div class="form-group">
                        <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required />
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="login-btn" name="login_btn" value="Login" />
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
