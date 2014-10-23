<?php

if (isset($_SESSION['cart']))                                                          //check to see if anything is in the cart
 {

  echo '<table border = "3">';                                                        //if so start building a table to display what's in the cart
  echo '<tr><td>Item Description</td><td>Unit Price</td><td>Quantity</td></tr>';        
  $dom = simplexml_load_file("../model/menu.xml");                                           //load the xml file so we can read it 

   

   foreach ($_SESSION['cart'] as $item)
     {
      $result = $dom->xpath("/menu/categories/category/item/variation[@objnum='$item->name']");  //search the xml file for a variation with the correct object number
      echo '<tr><td>'.$result[0]['cart_description'].'</td><td>'.$result[0]->price.'</td><td>'.$item->quantity.'</td></tr>';
     }
   echo'</table>';
 }

else
  {
  echo 'Your cart is empty';
  }


echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Main Page</a></br>';
?>
