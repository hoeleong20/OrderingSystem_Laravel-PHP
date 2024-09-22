<?php
if (isset($_POST['itemID'])) {
    // Load the menu.xml file
    $menuXML = new DOMDocument();
    $menuXML->load('orderModule/Menu.xml');

    // Use XPath to search for the selected item in the menu
    $xpath = new DOMXPath($menuXML);
    $itemID = $_POST['itemID']; // Get the selected item ID from the POST request
    $query = "//item[id='$itemID']";
    $menuItem = $xpath->query($query)->item(0);

    if ($menuItem) {
        // Get item details
        $name = $menuItem->getElementsByTagName('name')->item(0)->nodeValue;
        $price = $menuItem->getElementsByTagName('price')->item(0)->nodeValue;

        // Return the item as a JSON response
        echo json_encode(['name' => $name, 'price' => $price]);
    } else {
        // Item not found
        echo json_encode(['error' => 'Item not found']);
    }
} else {
    echo json_encode(['error' => 'No item ID provided']);
}
?>
