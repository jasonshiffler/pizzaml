<?php

$count = 0;                                                  //Keep track of which item we're in in the POST array
$objnumcount=0;
$qtycount=0;
$negativeqty=0;                                              //Boolean to track if the user entered a negative qty

foreach($_POST as $item)                                     //This foreach splits the data from the POST into two arrays, one for objnums and one for qtys.
    {
     if ($count % 2 == 0)                                    //if the count is even its the objnum
       {
        $tmp_objnums[$objnumcount]=$item;
        $objnumcount = $objnumcount +1;
       }
     else //if the count is odd its the quantity.
       {
        $tmp_qtys[$qtycount]=$item;
        $qtycount = $qtycount +1;         
        if ($item<0)                                        //check to make sure the quanitities are not negative.
         {
          $negativeqty=1;
         }
       }            
     $count=$count+1;                                       //Keep track of where we are in the $_POST array   
    }

if ($negativeqty==1)                                        //Check to see if they tried to order a negative qty
  {
   echo '<h2> Quantities must be positive!</h2>';
   echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Create a link so the user can go back to the previous page
  }
else                                                                          //if they didn't order a negtive qty proceed with adding the items to the cart
{ 
  $count = 0;                                                                 //reinitialize count so we can use it again. This gets used to line up the qty array with the objnum array
  $itemcount = 0;                                                             //number of items that will be added to the cart.
  $ordered_something = FALSE;                                                 //Keep track of if something was actually ordered 
  $num_item_incart = 0;                                                       //start by assuming nothing is in the cart
  
 if (isset($_SESSION['cart']))                                               //check to see if the cart already has something in it
  {
   $num_item_incart = count($_SESSION['cart']);                               //if so figure out how many items are already in the cart so we don't overwrite them.
  }
  

  
  foreach ($tmp_objnums as $item)                                             //Look through all tmp obj num array, create another array pair without entries of zero qty or no selection.
   {   
      if (($item != 'Null') and ($tmp_qtys[$count] !=0))
         {
           $objnums[$itemcount]=$item;
           $qtys[$itemcount]=$tmp_qtys[$count];
           $cartitem[$itemcount] = new Item($item,$qtys[$itemcount]);
           
           
           $alreadyincart = FALSE;                                                  //Track if the same item is already in the cart 
           if (isset($_SESSION['cart']))                                                //This section is to see if the item already exists in the cart
             {
          
              $whereinsession = 0;                                                 //Keep track of where we are in the cart 
          
              foreach ($_SESSION['cart'] as $entry)
                {
                  if ($item == $entry->name) 
                    { 
                      $alreadyincart = TRUE;                                          //if these two items match up, the same item type is already in the cart
                      echo 'Item is already in cart '.$whereinsession; 
                    }
                  else  
                    {
                  ++$whereinsession;
                    }

                 }  
             } 


          if($alreadyincart == FALSE)
            { 
             $_SESSION['cart'][$itemcount+$num_item_incart] = $cartitem[$itemcount];  //add item object to the cart without overwriting what was already there.      
             $count = $count +1;
             $itemcount = $itemcount+1;                                               //only increment the new array index if we put something in it
             $ordered_something = TRUE;                                               //note that something was put in there cart
            } 
           else
            {
             $_SESSION['cart'][$whereinsession]->quantity+=$cartitem[$itemcount]->quantity;
             $count = $count +1;
             $ordered_something = TRUE;
            }
         } 
      else
        {
         $count=$count+1;                                                           //either the item was Null or the qty was 0
        }
    }
                                                                                    //Let them know if something was placed into there cart after ordering
    if ($ordered_something == FALSE)
      {
       echo '<h2> You hit submit but nothing was added to your cart!</h2>';
       echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>';   //Create a link so the user can go back to the previous page
      }
    elseif ($ordered_something == TRUE)  
      {
        echo '<h3> The following items were added to your cart:</h3>';
        echo '<table border = "3">';                                                                 //create a table to show what was ordered 
        echo '<tr><td>Item Description</td><td>Quantity</td></tr>';
   
      foreach ($cartitem as $item)
        {
         $dom = simplexml_load_file("../model/menu.xml");                                           //load the xml file so we can read it 
         $result = $dom->xpath("/menu/categories/category/item/variation[@objnum='$item->name']");  //search the xml file for a variation with the correct object number
         echo '<tr><td>'.$result[0]['cart_description'].'</td><td>'.$item->quantity.'</td></tr>';   //create a table row that outputs the cart description and quantity 
        }   

     echo '</table>';                                                                                //go ahead and end the table
     echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>';                     //Create a link so the user can go back to the previous page
      }
      
}   
?>
