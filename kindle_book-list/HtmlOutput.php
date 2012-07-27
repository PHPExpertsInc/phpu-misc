<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlOutput
 *
 * @author michealmueller
 */

class HtmlOutput 
{
    function createQuote()
    {
       if ($this -> fileType == '1') //strip html tags
       {
           
       }
       elseif ($this -> fileType == '2')
       {
           
       }
    }
    
    function createAuthor()
    {
        if ($this -> fileType == '1')
       {
           $pattern = '/\(.+\)/';
           
       }
       elseif ($this -> fileType == '2')
       {
           
       }
    }
}

?>
