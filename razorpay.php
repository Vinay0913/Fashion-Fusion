<?php

include('server/connection.php');
// Include Razorpay PHP Library
require_once('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

// Replace 'YOUR_KEY_ID' and 'YOUR_KEY_SECRET' with your actual Razorpay API keys
$keyId = 'rzp_test_VVsTzJoUgQnPJv';
$keySecret = 'oYu6DxDhfT0dehB9hn3e1S47';

$api = new Api($keyId, $keySecret);

$input = @file_get_contents("php://input");

// Debug: Print input data
echo "Input Data: ";
var_dump($input);

$event = null;
$response = [];

try {
    $event = $api->utility->verifyWebhookSignature($input, $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'], $_SERVER['HTTP_X_RAZORPAY_EVENT']);
} catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
    $response['status'] = 'error';
    $response['message'] = 'Signature verification failed';
    echo json_encode($response);
    http_response_code(400);
    exit();
}

// Debug: Print event data
echo "Event Data: ";
var_dump($event);

// Extract payment data
$payment = json_decode($input, true);
$payment_id = $payment['payload']['payment']['entity']['id'];
$amount = $payment['payload']['payment']['entity']['amount'];
$currency = $payment['payload']['payment']['entity']['currency'];

// Debug: Print payment data
echo "Payment ID: " . $payment_id . "\n";
echo "Amount: " . $amount . "\n";
echo "Currency: " . $currency . "\n";

// Insert payment data into database
$sql = "INSERT INTO payments (payment_id, amount, currency) VALUES ('$payment_id', '$amount', '$currency')";

if ($conn->query($sql) === TRUE) {
    $response['status'] = 'success';
    $response['message'] = 'Payment data stored successfully';
    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error storing payment data: ' . $conn->error;
    echo json_encode($response);
}

// Close database connection
$conn->close();
?>
