<?php
// Enable CORS to allow AJAX requests from the browser
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);





$host = "127.0.0.1";        //localhost
$dbName = "restaurant-ordering-system";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $password);




$xmlFilePath = 'Order.xml'; 

// Check if the XML file exists
if (file_exists($xmlFilePath)) {
  // Load the XML file
  $orderXML = new DOMDocument();
  if ($orderXML->load($xmlFilePath)) {


          require_once 'C:\xampp\htdocs\RestaurantOrderingSystem\resources\views\OrderModule\OrderSAXParser.php';  // Include the SAXParser class
          require_once 'C:\xampp\htdocs\RestaurantOrderingSystem\resources\views\OrderModule\Order.php'; 
          // Initialize the parser with the XML file
          $parser = new OrderSAXParser($xmlFilePath);

          // Get the menu data from the parser
          $orderItems = $parser->getOrderData();
          
          $orderId="OR003";
          $customerId = "CU001";
          $paymentTotal= 25;
          $paymentMethod = "debit_card";

          $addOrderSuccess=insertOrderToDB($db,$orderId,$customerId,$paymentTotal,$paymentMethod);
          echo $addOrderSuccess;

          $addFoodListSuccess=insertFoodListToDB($db,$orderItems);
          echo $addFoodListSuccess;

          echo "Load XML file successfully.";
  } else {
      echo "Failed to load XML file.";
  }
} else {
  echo "XML file not found in the specified folder.";
}

function insertOrderToDB($db,$orderId,$customerId,$paymentTotal, $paymentMethod){


    $pstmt = $db->prepare("INSERT INTO orders VALUES (?, ?, ?, ?)");
    


    $pstmt->bindParam(1, $orderId, PDO::PARAM_STR);
    $pstmt->bindParam(2, $customerId, PDO::PARAM_STR);
    $pstmt->bindParam(3, $paymentTotal, PDO::PARAM_INT);
    $pstmt->bindParam(4, $paymentMethod, PDO::PARAM_STR);

    $success = $pstmt->execute();

    if (!$success) {
        return "Order data add succesfully";
    } 
  
}

function insertFoodListToDB($db,$orderItems){

  $failCount=0;
  foreach ($orderItems as $orderItem) {
    echo $orderItem;

    $pstmt = $db->prepare("INSERT INTO orderFoodList VALUES (?, ?, ?)");
    
    $orderId=$orderItem->getOrderId();
    $foodId=$orderItem->getFoodId();
    $quantity=$orderItem->getQuantity();

    $pstmt->bindParam(1, $orderId, PDO::PARAM_STR);
    $pstmt->bindParam(2, $foodId, PDO::PARAM_STR);
    $pstmt->bindParam(3, $quantity, PDO::PARAM_INT);

    $success = $pstmt->execute();

    if (!$success) {
        $failCount++;
    } 
  }
  
  if($failCount==0){
    return "All order add successfully";
  }
  else {
    return "Not all order add successfully";
  }
}

