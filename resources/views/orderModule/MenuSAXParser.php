<?php
require_once 'C:\xampp\htdocs\RestaurantOrderingSystem\resources\views\OrderModule\Menu.php';

class MenuSAXParser {

  private $menu;
  private $filename;
  private $menuTmp; 
  private $tmpValue;

  public function __construct($filename) {
    $this->filename = $filename;
    $this->menu = array();
    $this->parseDocument();
  }
  
  public function startElement($parser, $name, $attr) {
    if (!empty($name)) {
      if ($name == 'FOODITEM') {
        $this->menuTmp = new Menu();
      }
    }
  }

  public function endElement($parser, $name) {
    if ($name == 'FOODITEM') {
      $this->menu[] = $this->menuTmp;
    } elseif ($name == 'NAME') {
      $this->menuTmp->setName($this->tmpValue);
    } elseif ($name == 'PRICE') {
      $this->menuTmp->setPrice($this->tmpValue);
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
  
  public function getMenuData() {
    return $this->menu;
}

}

?>

