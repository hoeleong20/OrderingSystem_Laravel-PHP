<?php


// Allow from any origin
header("Access-Control-Allow-Origin: *");


// Allow specific methods and headers if needed
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json'); // Set content type to JSON

$host = "127.0.0.1";        //localhost
$dbName = "restaurant-ordering-system";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $password);

// Define the paymentMethodId to search for
$paymentMethodId = 'PM001'; // Example ID, can be replaced with dynamic input if needed

// Prepare a SELECT statement
$pstmt = $db->prepare("SELECT * FROM paymentMethod WHERE paymentMethodId = :paymentMethodId");

// Bind the parameter
$pstmt->bindParam(':paymentMethodId', $paymentMethodId, PDO::PARAM_STR);

// Execute the query
$pstmt->execute();

// Fetch the results
$result = $pstmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the response
$response = [];

if ($result) {
    // If records were found, format them into the response
    foreach ($result as $row) {
        $response[] = [
            'paymentMethodId' => htmlspecialchars($row['paymentMethodId']),
            'customerId' => htmlspecialchars($row['customerId']),
            'cardNumber' => htmlspecialchars($row['cardNumber'])
            // Add other fields as necessary
        ];
    }
    // Add success status
    echo json_encode([
        'status' => 'success',
        'data' => $response
    ]);
} else {
    // If no records were found, return an appropriate message
    echo json_encode([
        'status' => 'error',
        'message' => 'No records found.'
    ]);
}