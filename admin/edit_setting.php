<?php
// Assuming you have already established a database connection
include('connection.php');

// Check if ID is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the setting based on ID
    $query = "SELECT * FROM setting WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Check if query executed successfully
    if($result) {
        $setting = mysqli_fetch_assoc($result);
    } else {
        die("Database query failed.");
    }
} else {
    die("ID parameter is missing.");
}

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Get form data
    $mission = $_POST['mission'];
    $image = $_POST['image'];
    $story = $_POST['story'];
    $team = $_POST['team'];

    // Update the setting in the database
    $update_query = "UPDATE setting SET our_mission = '$mission', about_img = '$image', our_story = '$story', our_team = '$team' WHERE id = $id";

    $update_result = mysqli_query($conn, $update_query);

    // Check if update was successful
    if($update_result) {
        echo "<script>alert('Setting updated successfully!'); window.location='settings.php';</script>";
    } else {
        echo "Error updating setting: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Edit Setting</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class=" container mt-5">
<?php include('sidebar1.php'); ?>
    <h2 class="ml-5">Edit Setting</h2>
    <form method="POST">
        <div class=" ml-5 form-group">
            <label for="mission">Mission:</label>
            <input type="text" class="form-control" id="mission" name="mission" value="<?php echo $setting['our_mission']; ?>">
        </div>
        <div class="ml-5 form-group">
            <label for="image">Image:</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $setting['about_img']; ?>">
        </div>
        <div class="ml-5 form-group">
            <label for="story">Story:</label>
            <input type="text" class="form-control" id="story" name="story" value="<?php echo $setting['our_story']; ?>">
        </div>
        <div class="ml-5 form-group">
            <label for="team">Team:</label>
            <input type="text" class="form-control" id="team" name="team" value="<?php echo $setting['our_team']; ?>">
        </div>
        <button type="submit" class="ml-5 btn btn-primary" name="submit">Submit</button>
    </form>
</div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
