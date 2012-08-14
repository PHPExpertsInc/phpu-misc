<?php

/**
 * Description of getInput
 * Kindle Snippets Parser, a PHPExperts.pro Project.
 * Copyright © 2012 PHP Experts, Inc.
 * Author: (Primary) Micheal Mueller <michealm@PHPU.cc>
 *         (Secondary) Theodore R. Smith <theodore@phpexperts.pro>
 *          http://users.phpexperts.pro/tsmith/
 *
 */
require_once 'FileWork.php';

class GetInput extends FileWork
{
    
    protected $inputFile;
    protected $outputFile;

    //get user input from console using argv
    public function getUserinput($snippetFile, $htmlOutput)
    {

      $this -> inputFile = $snippetFile;  //set user input to variable.
      $this -> outputFile = $htmlOutput;  //set user chosen output file

      parent::reader();
    }
}

?>
