<?php
session_start(); // Start the session



// Function to recursively print array elements
function print_array($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            echo "$key => ";
            print_array($value);
        } else {
            echo "$key => $value<br>";
        }
    }
}

// Check if session data exists
if(isset($_SESSION) && !empty($_SESSION)) {
    // Display all session data
    foreach ($_SESSION as $key => $value) {
        if (is_array($value)) {
            echo "$key => ";
            print_array($value);
        } else {
            echo "$key => $value<br>";
        }
    }
} else {
    echo "Session data is empty.";
}
?>
