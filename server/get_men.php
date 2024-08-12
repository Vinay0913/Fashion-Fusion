
<?php
include('connection.php');
$stmt = $conn->prepare("SELECT * FROM products where product_category='Men' LIMIT 4");
$stmt->execute();
$men_products = $stmt->get_result();

?>