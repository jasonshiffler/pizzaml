<?php

$dom = simplexml_load_file("../model/menu.xml");                                          //create an array to hold the menu data
$categoryref = $_GET['categorynumber'];                                                   //get the category number of the category that should be displayed

foreach ($dom->xpath("/menu/categories/category[@number=$categoryref]") as $title)       //Get the Category name of the Category number so we can display it

  {
    echo $title[@title];                                                                 //print the category name
  }

echo '<li>';

$category = $dom->xpath("/menu/categories/category[@number='$categoryref']");            //create an array with all of the category menu data so we can display it  

echo '<form name="input" action="index.php?page=addcart" method="post">';                              //create a form for order submission
echo '<table border = "1">';                                                                 //create a table for the form
echo '<tr><td>Item Description</td><td>Options</td><td>Quantity</td></tr>';                  //Create the top row of the form

foreach($category[0]->item as $item)                                                         //the html row for each item
  {
    echo '<tr><td>'.$item[@name].'</td>';                                                    //displays the name of each item 
    echo '<td><form action =""><select name ="'.$item['name'].'">';                           //create the pulldown form
    echo '<option value="Null">-Not Selected-</option>';                                      //the first option value is to not select an item
                                                                                             //This foreach populates each pulldown with the option       
    foreach ($item->variation as $variation)                                                 //populate the pull down with each possible variation
      {
        echo '<option value="'.$variation['objnum'].'">';                                    //create each option with the object id with the description and price
        echo '<pre>'.$variation['description'].' $</pre>';                                   //create the option tag that will be seen by the user
        echo(string)$variation->price;
        echo '</option>';                                                                     //done with this option
      }
    echo '</select>';                                                                         //done with this pull down 
    echo '</td>';
    echo '<td><input type="text" maxlength="2" value="0" name='.$item["name"].'qty></td>';   //create a text box to enter the quantity wanted
    echo '</tr>';
  }

echo '</table>';                                                                              //done with table
echo '<input type = "submit" value="Submit">';                                               //create a submit button
echo '</form>';                                                                              //done with form 
echo '<br>';
echo '<a href=http://'.$GLOBALS['server_ref'].'> Main Page </a>';                           //create a link back to the main page

?>
