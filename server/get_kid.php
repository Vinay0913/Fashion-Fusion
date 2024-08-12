
<?php
include('connection.php');
$stmt = $conn->prepare("SELECT * FROM products where product_category='Kid' LIMIT 4");
$stmt->execute();
$kid_products = $stmt->get_result();

?>