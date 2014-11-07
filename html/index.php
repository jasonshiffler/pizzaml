<?php
require_once('../includes/helpers.php'); //make sure we do the includes before session start since it ends up in the session variable
session_start();



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

     case 'managecart':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('managecart');
        render('templates/footer');
        break;

    case 'viewcart':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('viewcart');
        render('templates/footer');
        break; 

}

?>
