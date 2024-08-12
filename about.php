<?php
include('server/connection.php');
session_start();

// Fetch data from the database for "Our Story", "Our Mission", and "Our Team"
$query = "SELECT * FROM setting";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if (!$result) {
    die("Database query failed.");
}

// Fetch the settings data
$settings = mysqli_fetch_assoc($result);

// Extracting data for each section
$ourStory = $settings['our_story'];
$ourMission = $settings['our_mission'];
$ourTeam = $settings['our_team'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php include 'layouts/header.php';?>

    <div class="container my-5">
        <h1 class="text-center">About Us</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Our Story</h3>
                <p><?php echo $ourStory; ?></p>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <a href="shop.php">
                    <img src="assets/img/about.jpeg" class="img-fluid" alt="About Us Image">
                </a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h3>Our Mission</h3>
                <p><?php echo $ourMission; ?></p>
            </div>
            <div class="col-md-6">
                <h3>Our Team</h3>
                <p><?php echo $ourTeam; ?></p>
            </div>
        </div>
        <!-- Shop More Button -->
        <div class="row mt-5">
            <div class="col text-center">
                <a href="shop.php" class="btn btn-primary btn-lg">Shop More</a>
            </div>
        </div>
    </div>

    <?php include 'layouts/footer.php';?>
    
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
