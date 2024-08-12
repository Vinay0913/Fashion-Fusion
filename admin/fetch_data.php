<?php
// fetch_data.php

// Include the database connection file
include('connection.php');

// Get the selected year from the request and escape it
$selectedYear = $conn->real_escape_string($_GET['year']);

// Prepare and execute the SQL query to fetch data for the selected year
$sql = "SELECT product_category, SUM(Product_quantity) AS total_quantity FROM order_items WHERE YEAR(order_date) = '$selectedYear' GROUP BY product_category";
$result = $conn->query($sql);

// Initialize arrays to store category and quantity data
$categories = [];
$quantities = [];

// Process the result and populate the arrays
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row["product_category"];
        $quantities[] = $row["total_quantity"];
    }
}

// Close the database connection
$conn->close();

// Create an associative array to hold the category and quantity data
$data = [
    'categories' => $categories,
    'quantities' => $quantities
];

// Convert the array to JSON and output it
echo json_encode($data);
?>
