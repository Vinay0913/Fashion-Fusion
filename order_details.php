<?php 
session_start();
include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Prepare and execute SQL query to fetch order details for the specific order_id
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $order_items_result = $stmt->get_result();
    
    // Check if any order details are found
    if($order_items_result->num_rows === 0) {
        // Redirect to account page with an error message
        header('Location: account.php?error=No order details found for this order.');
        exit;
    }

    // Fetch all rows into an array
    $order_items = [];
    while($row = $order_items_result->fetch_assoc()) {
        $order_items[] = $row;
    }

    // Calculate total order price
    $order_total_price = calculateTotalOrderPrice($order_items);
} else {
    // Redirect to account page if order ID is not provided
    header('Location: account.php');
    exit;
}

function calculateTotalOrderPrice($order_items) {
    $total = 0;
    foreach($order_items as $item) {
        $product_price =  $item['product_price'];
        $product_quantity = $item['product_quantity'];
        $total += ($product_price * $product_quantity);
    }
    return $total;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Orders</title>
</head>
<body>
<?php include('layouts/header.php')?>
<!--Orders Details-->
<section id="orders" class="orders container  mt-5">
    <div class="container">
        <h2 class="font-weight-bold text-center">Order Details</h2>
        <hr class="mx-auto">
    </div>
    <div class="container ">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                     
                   
                        <th>Product</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                        <th>Product Size</th>
                    
                     
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($order_items as $item): ?>
                        <tr>
                            <td><?php echo $item['order_id']; ?></td>
                         
                        
                            <td>
                                <div class="product_info">
                                    <img src="assets/img/<?php echo $item['product_image']; ?>" class="img-fluid" alt="Product Image"/>
                                    <div>
                                        <p class="mt-3"><?php echo $item['product_name']; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>₹ <?php echo $item['product_price']; ?></td>
                            <td><?php echo $item['product_quantity']; ?></td>
                            <td><?php echo $item['product_size']; ?></td>
                       
                          
                            <td><?php echo $item['order_date']; ?></td>
                            <td>₹ <?php echo $item['product_price'] * $item['product_quantity']; ?></td>
                            <td>
                              
                                    <button onclick="window.location.href = 'account.php';" class="btn btn-primary">Back</button>
                              
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include('layouts/footer.php')?>
</body>
</html>
