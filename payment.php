<?php
session_start();


// Initialize other variables
$order_total_price = isset($_SESSION['order_total_price']) ? $_SESSION['order_total_price'] : 0;
$payment_status = isset($_SESSION['payment_status']) ? $_SESSION['payment_status'] : "";


if(isset($_POST['order_pay_btn'])){
    // Retrieve order details
    $payment_status = $_POST['payment_status'];
    $order_total_price = $_POST['order_total_price'];

    // Store order details in session
    $_SESSION['order_total_price'] = $order_total_price;
    $_SESSION['payment_status'] = $payment_status;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    
<?php include('layouts/header.php');?>

<!-- Payment Section -->
<section class="my-5 py-5">
    <div class="container mt-3 pt-5">
        <h2 class="form-weight-bold text-center mb-4">Payment Details</h2>
    </div>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <!-- Payment Details -->
                            <tr>
                                <td colspan="2" class="bg-light"><strong>Payment Details</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Total Payment:</strong></td>
                                <td>
                                    ₹ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0;?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <!-- Form to redirect to vinay.php -->
                                    <form id="paymentForm" method="post" action="razorpay_payment.php">
                                        <!-- Add total amount, order ID, and other necessary hidden fields -->
                                        <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
                                        <input type="hidden" name="payment_status" value="<?php echo $payment_status; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>"> <!-- Include order ID as a hidden field -->
                                        <a href="shop.php" class="btn btn-primary">Cancel</a>
                                        <button type="submit" name="pay_button" class="btn btn-primary">Pay</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</section>

<?php include('layouts/footer.php'); ?>
</body>
</html>
