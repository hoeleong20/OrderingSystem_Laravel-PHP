<?php
require_once 'C:\xampp\htdocs\RestaurantOrderingSystem\resources\views\OrderModule\Order.php';

class OrderSAXParser {

    private $order;
    private $filename;
    private $orderTmp; 
    private $tmpValue;
  
    public function __construct($filename) {
      $this->filename = $filename;
      $this->order = array();
      $this->parseDocument();
    }
    
    public function startElement($parser, $name, $attr) {
      if (!empty($name)) {
        if ($name == 'FOODITEM') {
          $this->orderTmp = new Order();
          $this->orderTmp->setOrderId("OR001");
        }
      }
    }
  
    public function endElement($parser, $name) {
      if ($name == 'FOODITEM') {
        $this->order[] = $this->orderTmp;
      } elseif ($name == 'FOODID') {
        $this->orderTmp->setFoodId($this->tmpValue);
      }elseif ($name == 'PRICE') {
        $this->orderTmp->setPrice($this->tmpValue);
      }elseif ($name == 'QUANTITY') {
        $this->orderTmp->setQuantity($this->tmpValue);
      }
    }
  
    public function characters($parser, $data) {
      if (!empty($data)) {
        $this->tmpValue = trim($data);
      }
    }
  
    private function parseDocument() {
      $parser = xml_parser_create();
      xml_set_element_handler($parser, 
                              array($this, "startElement"), 
                              array($this, "endElement"));
      
      xml_set_character_data_handler($parser, array($this, "characters"));
      
      if (!($handle = fopen($this->filename, "r"))) {
        die("could not open XML input");
      }
  
      while ($data = fread($handle, 4096)) {
        xml_parse($parser, $data);
      }
  
      fclose($handle);
  
    }
    
    public function getOrderData() {
      return $this->order;
  }
  
  }