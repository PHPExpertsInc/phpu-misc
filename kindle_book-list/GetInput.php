<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getInput
 *
 * @author michealmueller
 */
require_once 'FileWork.php';

class GetInput extends FileWork
{
    
    protected $inputFile;
    public $errlog;
      
    //get user input from console using argv
    public function getUserinput()
    {
      global $argv;  //mustbe declaired as global since its in a class.
      
      $this -> inputFile = $argv['1'];  //set user input to variable.
      
      if ($this -> inputFile == NULL)   //make sure they entered the input.
      {
          $this -> errlog = 'Input was incorrect, Please try again.';
      }
      else  //they did so continue.
      {
          parent::reader();
      }
    }
}

?>
