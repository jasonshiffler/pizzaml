<?php

if (isset($_SESSION['cart']))                                                          //check to see if anything is in the cart
  {

    echo '<table border = "3">';                                                        //if so start building a table to display what's in the cart
    echo '<tr><td>Item Description</td><td>Unit Price</td><td>Quantity</td></tr>';        
    $dom = simplexml_load_file("../model/menu.xml");                                           //load the xml file so we can read it 
    $total_price = 0.0;                                                                  //initialize a variable that will display the total cost of the order 
   

    foreach ($_SESSION['cart'] as $item)
       {
         $result = $dom->xpath("/menu/categories/category/item/variation[@objnum='$item->name']");  //search the xml file for a variation with the correct object number
         echo '<tr><td>'.$result[0]['cart_description'].'</td><td>'.$result[0]->price.'</td><td>'.$item->quantity.'</td></tr>';
         $total_price += ($item->quantity * floatval($result[0]->price)); 
       }
    echo'</table>';
    echo '<br>'; 
    echo 'Total Price is.......... $'.number_format($total_price,2);                           //print out the total price of the order below the table
}

else
  {
    echo 'Your cart is empty';                                                                //If there is nothing in the cart let the user know.
  }


echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Main Page</a></br>';
?>
