<?php

$count = 0;                                                  //Keep track of which item we're in in the POST array
$objnumcount=0;
$qtycount=0;
$negativeqty=0;                                              //Boolean to track if the user entered a negative qty
$ordered_something = FALSE;                                    //Boolean to track if something had a qty greater that 0

print_r($_POST);

foreach($_POST as $item)                                     //This foreach splits the data from the POST into two arrays, one for objnums and one for qtys.
  {
    if ($count % 2 == 0)                                    //if the count is even its the objnum
      {
        $tmp_objnums[$objnumcount]=$item;                    //This variable holds all of the objnum values of each item
        $objnumcount = $objnumcount +1;
      }
    else                                                    //if the count is odd its the quantity.
       {
        $tmp_qtys[$qtycount]=$item;
        $qtycount = $qtycount +1;         
        if ($item<0)                                        //check to make sure the quanitities are not negative.
          {
            $negativeqty=1;
          }
        if($item>0)                                         //keep track if at least one item has a qty >0 (the actually ordered something) 
          {
            $ordered_something = TRUE; 
          
          }
       }            
     $count=$count+1;                                       //Keep track of where we are in the $_POST array   
  }



if ($negativeqty==1)                                        //Check to see if they tried to order a negative qty
  {
   echo '<h2> Quantities must be positive!</h2>';
   echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Create a link so the user can go back to the previous page
  }

elseif($ordered_something == FALSE)                                           //Check to make sure at least one item had a qty >0
  {
  
   echo "<h2>You hit submit but didn't order anything!</h2>";

   echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Create a link so the user can go back to the previous page
  }

else                                                                          //if they didn't order a negtive qty proceed with adding the items to the cart
  { 
    $count = 0;                                                 //reinitialize count so we can use it again. This gets used to line up the qty array with the objnum array
    $itemcount = 0;                                                             //number of items that will be added to the cart.
    $ordered_something = FALSE;                                                 //Keep track of if something was actually ordered 
    $num_item_incart = 0;                                                       //start by assuming nothing is in the cart
    $cartitem = array();    

  foreach($tmp_objnums as $item)                                 //This foreach creates an array of item objects but only if the item was actually ordered (no zero qtys) 
    {
      if (($item != 'Null') and ($tmp_qtys[$count] !=0))
        {
           $objnums[$itemcount]=$item;
           $qtys[$itemcount]=$tmp_qtys[$count];
           $cartitem[$itemcount] = new Item($item,$qtys[$itemcount]);
        }
    }   


  if (isset($_SESSION['cart']))                                               //check to see if the cart already has something in it
    {
      $num_item_incart = count($_SESSION['cart']);                               //if so figure out how many items are already in the cart so we don't overwrite them.
    }

  foreach($cartitem as $item)
    {
      if (isset($_SESSION['cart']) == FALSE)    
        {
          $_SESSION['cart'][$itemcount+$num_item_incart] = $item;  //add item object to the cart without overwriting what was already there.
          ++$itemcount; 
        }
    
      elseif (array_search($item->name,$_SESSION['cart']) == FALSE )                    //if the item doesn't already exist in the cart
        {
          $_SESSION['cart'][$itemcount+$num_item_incart] = $item;  //add item object to the cart without overwriting what was already there.      
         $itemcount = $itemcount+1;                                                            //increment the number of items in the cart because we just put something in there
        } 
    }



  }

?>
