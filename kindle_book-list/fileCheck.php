<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileRead
 *
 * @author michealmueller
 */
class fileCheck 
{   
    
    function fileExistCheck()
    {        
        if (file_exists($this -> filename))
        {
            return true;
        }
        
      return false;
    }
    
    
}

?>
