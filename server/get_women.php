
<?php
include('connection.php');
$stmt = $conn->prepare("SELECT * FROM products where product_category='Women' LIMIT 4");
$stmt->execute();
$women_products = $stmt->get_result();

?>