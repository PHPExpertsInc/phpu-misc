<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'GetInput.php';

if (empty($argv[1]))
{
    echo 'ERROR: No snippets list specified.\n';
    echo './' .basename(__FILE__) . ' SNIPPETS_FILE\n\n';
    exit;
}

$UserIO = new getInput();

$UserIO -> getUserinput($argv[1]);


?>
