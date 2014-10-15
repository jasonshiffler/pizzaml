<?php


#This reference is for any local links that need to be created 

$GLOBALS['server_ref'] = '10.3.11.84';


/**
   Renders template.
 *
 * @param array $data
 */

function render($template, $data = array())
{
    $path = __DIR__ . '/../views/' . $template . '.php';
    if (file_exists($path))
    {
        extract($data);
        require($path);
    }
}

?>
