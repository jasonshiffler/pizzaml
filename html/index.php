<?php

require_once('../includes/helpers.php');

// determine which page to render
if (isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = 'index';
    
// show page
switch ($page)
{
    case 'index':
        render('templates/header', array('title' => 'Welcome to 3 Aces'));
        render('index');
        render('templates/footer');
        break;

}

?>
