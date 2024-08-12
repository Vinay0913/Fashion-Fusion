<?php
// Include your database connection file
session_start();
include('server/connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $message = trim(mysqli_real_escape_string($conn, $_POST['message']));

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If no errors, proceed to insert data
    if (empty($errors)) {
        // SQL query to insert data into database
        $sql = "INSERT INTO contacts (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

        // Execute query
        if (mysqli_query($conn, $sql)) {
            // Close database connection
            mysqli_close($conn);

            // JavaScript to show notification
            echo '<script>alert("Thank You for your Feedback!");</script>';
            // Redirect to index.php
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Contact</title>
    <script>
        function validateForm() {
            var name = document.forms["contactForm"]["name"].value;
            var email = document.forms["contactForm"]["email"].value;
            var phone = document.forms["contactForm"]["phone"].value;
            var message = document.forms["contactForm"]["message"].value;
            var phonePattern = /^[0-9]{10}$/;

            if (name == "") {
                alert("Name must be filled out");
                return false;
            }
            if (email == "") {
                alert("Email must be filled out");
                return false;
            } else {
                var re = /\S+@\S+\.\S+/;
                if (!re.test(email)) {
                    alert("Invalid email format");
                    return false;
                }
            }
            if (phone == "") {
                alert("Phone number must be filled out");
                return false;
            } else if (!phonePattern.test(phone)) {
                alert("Phone number must be 10 digits");
                return false;
            }
            if (message == "") {
                alert("Message must be filled out");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<?php include('layouts/header.php')?>
<style>
/* Your existing CSS */
</style>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6">
            <h2>Contact Us</h2>
            <form name="contactForm" action="#" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone">Your Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" required pattern="[0-9]{10}">
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" class="form-control" required></textarea>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary btn-block">
            </form>
        </div>
        <div class="col-lg-6">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.288706060326!2d73.85545417501305!3d18.515851182576714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c06f1f44bba5%3A0xcabed207d0c1c9d2!2sKedari%20Chowk%2C%20Budhwar%20Peth%2C%20Pune%2C%20Maharashtra%20411002!5e0!3m2!1sen!2sin!4v1713619500050!5m2!1sen!2sin" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<?php include('layouts/footer.php')?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
