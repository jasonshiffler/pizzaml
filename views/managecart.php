<?php

$count = 0;                                                  //Keep track of which item we're in in the POST array
$objnumcount=0;
$qtycount=0;
$negativeqty=0;                                              //Boolean to track if the user entered a negative qty
$ordered_something = FALSE;                                    //Boolean to track if something had a qty greater that 0

if ($_POST['buttontype'] == 'updatecart')                    //If we're updating the cart clear the $_SESSION['cart'] var so we don't double our order
  {
    unset($_SESSION['cart']);
  }


foreach($_POST['cart'] as $item)                                     //This foreach splits the data from the POST into two arrays, one for objnums and one for qtys.
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

if(($ordered_something == FALSE)&&($_POST['buttontype'] == 'addtocart'))   //Check to make sure at least one item had a qty >0
  {
  
   echo "<h2>You hit submit but didn't order anything!</h2>";
   echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Create a link so the user can go back to the previous page
  }

else                                                                          //if they didn't order a negtive qty proceed with adding the items to the cart
  { 
    $itemcount = 0;                                                             //number of items that will be added to the cart.
    $ordered_something = FALSE;                                                 //Keep track of if something was actually ordered 
    $num_item_incart = 0;                                                       //start by assuming nothing is in the cart
    $cartitem = array();    
    $count = 0;
  foreach($tmp_objnums as $item)                                 //This foreach creates an array of item objects but only if the item was actually ordered (no zero qtys) 
    {
      if (($item != 'Null') and ($tmp_qtys[$itemcount] !=0))
        {
           $objnums[$itemcount]=$item;
           $qtys[$itemcount]=$tmp_qtys[$itemcount];
           $cartitem[$itemcount] = new Item($item,$qtys[$itemcount]);
        }
      ++$itemcount;    

    }   


  if (isset($_SESSION['cart']))                                               //check to see if the cart already has something in it
    {
      $num_item_incart = count($_SESSION['cart']);                               //if so figure out how many items are already in the cart so we don't overwrite them.
    }

  foreach($cartitem as $item)
    {
      if (isset($_SESSION['cart']) == FALSE)                              //if the cart is empty 
        {
          $_SESSION['cart'][0] = $item;                                  //add item object to the cart without overwriting what was already there.
          ++$num_item_incart;                                            //we just put an item in the cart so we need to increment the number of items in the cart 
        }
    
      else                                                              //if the cart isn't empty 
        {
          $existsincart = FALSE;                                         //initialize the variable
          $count = 0;

          while($count<$num_item_incart)                                //were going to check all of the items in the cart to see if what we want to add is already
            {                                                            //in the cart 
            
           if ($_SESSION['cart'][$count]->name == $item->name)            //the item already exists in the cart, just increase the qty
                {
                  $existsincart = TRUE;                                   //note that the item does exist in cart so we don't add again later on
                  $_SESSION['cart'][$count]->quantity += $item->quantity; //increase the qty of the item in the cart 
                }
              ++$count;                                                   //increment the counter  
            } 

          if ($existsincart == FALSE)                                    //we didn't find the item in the cart so append it to the end 
            {
             $_SESSION['cart'][$num_item_incart] = $item;             
             ++$num_item_incart;                                        //we added another item in the cart so increment this number 
            }

        }  
       
    }

if ($_POST['buttontype'] == 'updatecart')
  {
    echo '<h2> Your order was updated </h2>'; 
    echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Need to fix this part 
  }

elseif($_POST['buttontype'] == 'addtocart')
  {
    echo '<h2> Your items were added to the cart</h2>';
    echo '<br><a href="'.$_SERVER['HTTP_REFERER'] .'">Previous Page</a></br>'; //Create a link so the user can go back to the previous page and keep ordering
  }  

  
}  

?>
