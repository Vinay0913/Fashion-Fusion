<?php
// Assuming you have already established a database connection
include('connection.php');

// Fetch data from the admin table
$query_admin = "SELECT * FROM admin";
$result_admin = mysqli_query($conn, $query_admin);

// Check if query executed successfully
if (!$result_admin) {
    die("Database query failed.");
}

// Fetch data from the settings table
$query_settings = "SELECT * FROM setting";
$result_settings = mysqli_query($conn, $query_settings);

// Check if query executed successfully
if (!$result_settings) {
    die("Database query failed.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Admin Table</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   

    <style>
        th, td {
            text-align: center;
            vertical-align: middle; /* Align content vertically */
        }

        .container {
            max-width: 100%; /* Full width for container */
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .table {
            width: 100%; /* Full width for table */
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <?php include('sidebar1.php'); ?>
    <h2 class="ml-5 mb-4">Admin Details</h2>
 
    <div class="ml-5 table-responsive"> <!-- Make table scrollable on small screens -->
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each row of the admin result set
                while ($row = mysqli_fetch_assoc($result_admin)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><a href='edit_admin.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="container mt-5">
    <h2 class="ml-5 mb-4">Settings</h2>
    <div class="ml-5 table-responsive"> <!-- Make table scrollable on small screens -->
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Mission</th>
                    <th>Image</th>
                    <th>Story</th>
                    <th>Team</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each row of the settings result set
                while ($row = mysqli_fetch_assoc($result_settings)) {
                    echo "<tr>";
                    echo "<td>" . $row['our_mission'] . "</td>";
                    echo "<td>" . $row['about_img'] . "</td>";
                    echo "<td>" . $row['our_story'] . "</td>";
                    echo "<td>" . $row['our_team'] . "</td>";
                    echo "<td><a href='edit_setting.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
// Free result sets
mysqli_free_result($result_admin);
mysqli_free_result($result_settings);

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>
