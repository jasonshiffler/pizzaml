<?php
session_start();
require_once('../includes/helpers.php');



// determine which page to render
if (isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = 'main';
    
// show page
switch ($page)
{
    case 'main':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('main');
        render('templates/footer');
        break;

     case 'menusection':
        render('templates/header',array('title' => 'Welcome to 3 Aces'));
        render('menusection');
        render('templates/footer');
        break;

     case 'addcart':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('addcart');
        render('templates/footer');
        break;

    case 'viewcart':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('viewcart');
        render('templates/footer');
        break; 
}

?>
