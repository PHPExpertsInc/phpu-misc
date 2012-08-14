<?php

/*
 * Kindle Snippets Parser, a PHPExperts.pro Project.
 * Copyright © 2012 PHP Experts, Inc.
 * Author: (Primary) Micheal Mueller <michealm@PHPU.cc>
 *         (Secondary) Theodore R. Smith <theodore@phpexperts.pro>
 *          http://users.phpexperts.pro/tsmith/
 *
 */
require 'GetInput.php';

if (empty($argv[1]))
{
    echo "ERROR: No snippets list specified.\n";
    echo './' .basename(__FILE__) . " SNIPPETS_FILE \n\n";
    exit;
}
elseif(empty($argv[2]))
{
    echo "ERROR: No output file specified.\n";
    echo './' .basename(__FILE__) . " OUTPUT_FILE \n\n";
    exit;

}
elseif(preg_match('/.+\.html/', $argv[2]) !== 1)
{
    echo "ERROR: Output File is not an html document.\n";
    echo './' .basename(__FILE__) . " OUTPUT_FILE_LOCATION\n\n";
    exit;
}

$UserIO = new getInput();

$UserIO -> getUserinput($argv[1], $argv[2]);


?>
