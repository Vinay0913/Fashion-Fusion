<?php
// Receive and process webhook request from Razorpay
$webhookData = json_decode(file_get_contents('php://input'), true);

// Verify webhook signature to ensure authenticity (optional but recommended)

// Extract relevant data from the webhook payload
$paymentId = $webhookData['payload']['payment']['entity']['id'];
$orderAmount = $webhookData['payload']['payment']['entity']['amount'];
// Extract other relevant data as needed

// Store data in your database

$sql = "INSERT INTO payments (payment_id, amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $paymentId, $orderAmount);
$stmt->execute();
//Perform error handling and logging as needed

// Respond to Razorpay with HTTP 200 status code to acknowledge receipt of webhook
http_response_code(200);
?>
