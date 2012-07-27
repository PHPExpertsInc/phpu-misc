<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileWork
 *
 *
 * @author michealmueller
 */
require_once 'DetectFileType.php';

class FileWork extends DetectFileType
{
    private $filename; 
    private $mode = 'r';
    private $buffer;
    
    protected $bufferstring;
    
    protected function reader()
    {    
        $this -> filename = $this -> inputFile;
        var_dump($this -> filename);
        
        if (file_exists($this -> filename) == FALSE)
        {
            $this -> errlog = 'the File does not exist.';
            echo 'this file does not exist.' ;
        }
        
        
        $this -> buffer = fopen($this -> filename, $this -> mode);
        
        
        if ($this -> buffer == false)
        {
            $this -> errlog = 'there is a problem with the buffer';
            echo 'there is a problem with the buffer\n';
        }
        
        
        $this -> bufferstring = stream_get_contents($this -> buffer);
        
        
        if ($this -> bufferstring == FALSE)
        {
            $this -> errlog = 'could not put buffer into string.';
            echo 'could not put the buffer into string.\n';
        }
        
        
        fclose($this -> buffer);
        
        parent::detectFileType();
    }        
}
?>
