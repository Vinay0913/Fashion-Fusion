<?php
session_start();
include('connection.php');

// Function to verify user and move to verified users table
function verifyUser($conn, $userId) {
    // Sanitize the input to prevent SQL injection
    $userId = mysqli_real_escape_string($conn, $userId);

    // Insert or update the user in the users table
    $insertQuery = "INSERT INTO users (user_id) VALUES ('$userId') ON DUPLICATE KEY UPDATE user_id = '$userId'";
    $insertResult = mysqli_query($conn, $insertQuery);

    // Check if insertion was successful
    if($insertResult) {
        // Update the status of the user to 'verified' in users table
        $updateQuery = "UPDATE users SET status = 'verified' WHERE user_id = '$userId'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if($updateResult) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if(isset($_POST['verify'])) {
    $userId = $_POST['userId'];
    if(verifyUser($conn, $userId)) {
        // Redirect back to the same page after verifying the user
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } else {
        echo "Failed to verify user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Manage Users</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            display: flex;
        }
        .sidebar-container {
            flex-shrink: 0;
            width: 220px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        /* Style table rows on hover */
        tr:hover {
            background-color: #ddd;
        }
        /* Adjust table width */
        table {
            width: 100%;
        }
        /* Adjust back to dashboard button */
        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar-container">
        <?php include('sidebar1.php'); ?>
    </div>
    <div class="content">
        <div class="container mt-5">
            <h2>User Data</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Status / Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch user data from the database
                        $query = "SELECT * FROM users";
                        $result = mysqli_query($conn, $query);

                        // Check if query execution is successful
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                                echo "<td class='align-right'>" . htmlspecialchars($row['user_phone']) . "</td>"; // Align phone data to the right
                                echo "<td>" . htmlspecialchars($row['user_address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_city']) . "</td>";
                                echo "<td>";
                                if ($row['status'] == 'unverified') {
                                    echo "<form method='post'>";
                                    echo "<input type='hidden' name='userId' value='" . htmlspecialchars($row['user_id']) . "' />";
                                    echo "<button type='submit' name='verify' class='btn btn-primary'>Verify</button>";
                                    echo "</form>";
                                } else {
                                    echo htmlspecialchars($row['status']); // Display status if user is verified
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
