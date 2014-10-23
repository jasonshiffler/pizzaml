<?php

#This page prints out the main categories for someone to select


$dom = simplexml_load_file("../model/menu.xml");                  #map the xml file to an array 

foreach ($dom->xpath("/menu/categories/category") as $category)   #iterate through all the categories 

     {
      print "<li>";
      print "<a href=http://".$GLOBALS['server_ref']."?categorynumber=".$category[@number]."&page=menusection>".$category[@title]."</a>"; # create a link for each option
      print "</li>";
    }

echo '<a href=http://'.$GLOBALS['server_ref'].'?page=viewcart> MyCart</a>';
?>


