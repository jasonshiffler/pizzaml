<?php


#This reference is for any local links that need to be created 

$GLOBALS['server_ref'] = '10.3.11.84';


/**
   Renders template.
 *
 * @param array $data
 */

function render($template, $data = array())
{
    $path = __DIR__ . '/../views/' . $template . '.php';
    if (file_exists($path))
    {
        extract($data);
        require($path);
    }
}


//This class defines an object for the items put in the cart.  
//Each object has a name and a qty


class Item
	{
		public $name;
		public $quantity;
		
		public function __construct($objnum,$quantity)
		{
			$this->name = $objnum;
			$this->quantity = $quantity;
		}
		public function getName()
		{
			return $this->name;
		}
				
		public function getQuantity()
		{
			return $this->quantity;
		}
		
		
	}






?>
