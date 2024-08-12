<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      .navbar {
            background-color: #000;
            padding-top: 5px; /* Adjust top padding */
            padding-bottom: 5px; /* Adjust bottom padding */
        }

        .logo-container {
            padding-right: 15px;
            border-right: 1px solid #ccc;
        }

        .logo {
            width: 100px;
            height: 80px;
            margin-top: 2px;
        }

        .navbar-toggler {
            border: none;
            padding: 0;
            color: #fff;
        }

        .navbar-toggler-icon {
            background-color: #fff;
        }

        .navbar-nav .nav-link {
            color: white;
            margin-right: 20px;
            font-weight: bold;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar-nav .nav-link:last-child {
            margin-right: 0;
        }

        /* Adjusting icon color */
        .navbar-nav .nav-link .fas {
            color: white;
            margin-right: 5px;
        }

        /* Apply styles to specific text */
        .navbar-nav .nav-link[href="index.php"] {
            font-style: normal; 
            color: white;  
        }

        .navbar-nav .nav-link[href="shop.php"] {
            font-style: normal; 
            color: white; 
        }

        .navbar-nav .nav-link[href="blog.php"] {
            font-style: normal; 
            color: white;  
        }

        .navbar-nav .nav-link[href="contact.php"] {
            font-style: normal; 
            color: white; 
        }
        .navbar-nav .nav-link[href="cart.php"] {
            font-style: normal; 
            color: white;  
        }

        .navbar-nav .nav-link[href="account.php"] {
            font-style: normal; 
            color: white; 
        }

        .navbar-text {
            color: white;
            font-weight: bold;
            margin-top: 5px;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container">
        <!-- Logo container -->
        <div class="logo-container">
            <!-- Navbar brand/logo -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/Fashion-Fusion.png" class="logo" alt="Fashion Fusion Logo">
            </a>
            <!-- Display user "orderid_name" if logged in -->
            <?php if(isset($_SESSION['user_username'])): ?>
                <span class="navbar-text">Welcome <?php echo $_SESSION['user_username']; ?></span>
            <?php endif; ?>
        </div>
        <!-- Toggler button for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> <!-- Home icon -->
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">
                        <i class="fas fa-store"></i> <!-- Shop icon -->
                        Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blog.php">
                        <i class="fas fa-blog"></i> <!-- Blog icon -->
                        Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">
                        <i class="fas fa-envelope"></i> <!-- Contact icon -->
                        Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                      <i class="fas fa-info-circle"></i> <!-- About icon -->
                      About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-bag"></i> <!-- Shopping bag icon -->
                        Shopping Bag
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="account.php">
                        <i class="fas fa-user"></i> <!-- Account icon -->
                        Account
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>
