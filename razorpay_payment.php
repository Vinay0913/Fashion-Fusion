<?php
session_start();

// Retrieve the order ID from the session
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : '';

// Retrieve the total amount from the session or any other source
$total_amount =  isset($_SESSION['total']) ? $_SESSION['total'] : '';


// Ensure that the order total is numeric
if (!is_numeric($total_amount)) {
    // Handle the case where order total is not numeric
    // You can set a default value or display an error message
    $total_amount = 0;
}

// Ensure that the order total is in the correct currency format
$total_amount_formatted = number_format($total_amount, 2); // Assuming the order total is in INR

// Convert amount to paise
$amount_in_paise = $total_amount * 100;

// Set amount and currency
$amount = $total_amount_formatted; // Amount in INR
$currency = "INR"; // Currency
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/Fashion-Fusion.png" type="image/icon type">
    <title>Razorpay Payment</title>
</head>
<body>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_VVsTzJoUgQnPJv",
            "amount": <?php echo $amount_in_paise; ?>,
            "currency": "<?php echo $currency; ?>",
            "name": "Fashion Fusion",
            "description": "Test Transaction",
            "image": "assets/img/Fashion-Fusion.png",
            "handler": function (response) {
                // Handle Razorpay payment success
                // Redirect user to success.php with payment details and order_id
                var paymentDetails = {
                    payment_id: response.razorpay_payment_id,
                    currency: response.currency,
                    status: response.razorpay_signature ? 'success' : 'success', // Assuming signature presence indicates success
                    order_id: '<?php echo $order_id; ?>', // Include the order ID
                };
                var queryString = Object.keys(paymentDetails).map(key => key + '=' + paymentDetails[key]).join('&');
                window.location.href = 'success.php?' + queryString;
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    </script>

</body>
</html>
