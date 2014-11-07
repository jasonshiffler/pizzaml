<?php

if (isset($_SESSION['cart']))                                                          //check to see if anything is in the cart
  {
    echo '<form name="input" action="index.php?page=managecart" method="post">';       //Start building a form that allows the user to update cart or submit the order.
    echo '<table border = "3">';                                                       //if so start building a table to display what's in the cart
    echo '<tr><td>Item Description</td><td>Unit Price</td><td>Quantity</td></tr>';     //This is the top row with labels for each column   
    $dom = simplexml_load_file("../model/menu.xml");                                   //load the xml file so we can read it 
    $total_price = 0.0;                                                                //initialize a variable that will display the total cost of the order 
  

    foreach ($_SESSION['cart'] as $item)                                              //iterate through each item in the cart
      {
         $result = $dom->xpath("/menu/categories/category/item/variation[@objnum='$item->name']");                         //search the xml file for a variation with the correct object number
         echo '<tr>';                                                                                                      //begin the row
         echo '<td><input type ="hidden" name = "cart[]"  value='.$item->name.'>';
         echo  $result[0]['cart_description'].'</td>';
         echo '<td>'.$result[0]->price.'</td>';
         echo '<td><input type = "number" name = "cart[]" min = "0" max = "50"  value ='.$item->quantity.'></td>';
         echo '</tr>';                                                                                                       //end the row
         $total_price += ($item->quantity * floatval($result[0]->price));                                //keep track of the total price 
      }
    echo'</table>';                                                                           //end the table
    echo '<input type = "submit" name="buttontype" value="submitorder">';                                            //Button to submit the order
    echo '<input type = "submit" name ="buttontype" value="updatecart">';                                            //Button to Update the quantities. 
    echo'</form>';                                                                            //end the form
    echo '<br>'; 
    echo 'Total Price is.......... $'.number_format($total_price,2);                           //print out the total price of the order below the table

  }

else
  {
    echo 'Your cart is empty';                                                                //If there is nothing in the cart let the user know.
  }


echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Main Page</a></br>';                       //Give the user a link back to the main page
?>
