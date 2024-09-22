<?php

// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Alternatively, allow only a specific origin
// header("Access-Control-Allow-Origin: http://127.0.0.1:8000");

// Allow specific methods and headers if needed
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



header('Content-Type: application/json'); // Set content type to JSON

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $cardNumber = strip_tags($_POST['cc-number-input']);
    $cardName = strip_tags($_POST['cc-name-input']);
    $expiryDate = strip_tags($_POST['cc-expiry-input']);
$cvvCode = strip_tags($_POST['cc-cvc-input']);


} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}







$host = "127.0.0.1";        //localhost
$dbName = "restaurant-ordering-system";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $password);
$paymentMethodId = 'PM001';

$pstmt = $db->prepare("INSERT INTO paymentMethod VALUES (?,?,sha1(?))");

          
// $cardNumber=substr($_POST['cc-number-input' ],-4);
echo $cardNumber;

$customerId = "CU001";

$pstmt->bindParam(1, $paymentMethodId, PDO::PARAM_STR);
$pstmt->bindParam(2, $customerId, PDO::PARAM_STR);
$pstmt->bindParam(3, $cardNumber, PDO::PARAM_STR);

$success = $pstmt->execute();

if (!$success) {
    return "Card data add succesfully";
} 






