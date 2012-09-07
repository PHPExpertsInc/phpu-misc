<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetFiles
 *
 * @author michealmueller
 */
class GetFiles 
{
    private $curret_dir;
    
    private $fileListArray;
    
    private $dirToClippings;
    
    public $errlog;
    
    function getDirFiles()
    {
        if ($this -> curret_dir = opendir($this -> dirToClippings) == false)
        {
            $this -> errlog = "Cannot Open directory.";
        }
        
        while($entry = readdir($this -> current_dir)) 
        {
            $this -> fileListArray = $entry; 
        }
        
    }
    
}

?>
