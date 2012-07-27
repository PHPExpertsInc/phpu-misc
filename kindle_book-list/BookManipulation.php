<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this script will split the $bufferstring into its individual books by the = 
 * 
 * signs in the file, refer to DetectFileType.php for Type Explanations.
 * 
 * 
 * @author Micheal Mueller 
 * 
 */
require_once 'HtmlOutput.php';

class BookManipulation extends HtmlOutput
{
    private $delimiterType;
    protected $bookArray;
    protected $bookString;
    protected $authorlocation;
    protected $quote;
    protected $locationAuthorDelim;
    protected $locationAuthorArray;
    Protected $replacePattern;
    protected $replace;
    protected $matches;

    function createBook()
    {
        if ($this -> fileType  == '1')
        {
            //do splits accordingly for Type 1
            //set delimiter
            $this -> delimiterType = '/\r\n|\r|\n/';
            
            $this -> bookArray = preg_split($this -> delimiterType, $this ->  bufferstring);
            
            $this -> bookArray = array_filter($this -> bookArray, array($this, "createfalse"));
            
            $this -> locationAuthorDelim = '/(?:\(.+\)|\|.+\|)/U';
            
            //creates multidimentional array, need to either flatten or ... something.
            
            preg_match_all($this -> locationAuthorDelim, $this -> bufferstring, 
                     $this -> locationAuthorArray, PREG_PATTERN_ORDER);
            
            //TODO: figure this out!!!!
            //repalce symbols 
            
            $this -> replacePattern = '/[(|)]/U';
            $this -> replace = '';
                      
            //use preg replace now for replace () and ||
            preg_replace($this->replacePattern, $this->replace, $this->locationAuthorArray);
            
            var_dump($this -> locationAuthorArray);           
            
        }
        else 
        {
            //do splits accordingly for Type 2
            //set delimiter
            $this -> delimiterType = '/\r\n|\r|\n/';
            
            $this -> bookArray = preg_split($this -> delimiterType, $this -> 
                    bufferstring);
        }
        
        $this -> bookArray = array_filter($this -> bookArray, array($this, 
            "createfalse"));
        
        //var_dump($this -> bookArray);
        
        //parent::createAuthor();
        //parent::createQuote();
    }  
    
    //useless ******************************************************
    protected function array_flatten(array $array)
    {
        $flat = array(); // initialize return array
        $stack = array_values($array); // initialize stack
        while($stack) // process stack until done
        {
            $value = array_shift($stack);
            if (is_array($value)) // a value to further process
            {
                $stack = array_merge(array_values($value), $stack);
            }
            else // a value to take
            {
            $flat[] = $value;
            }
        }
        return $flat;
    }

    protected function preg_replace_array($pattern, $replacement, $subject, $limit=-1)
    { 
        if (is_array($subject)) 
        { 
            foreach ($subject as &$value) $value=preg_replace_array($pattern, $replacement, $value, $limit); 
            return $subject; 
        } 
        else 
        { 
            return preg_replace($pattern, $replacement, $subject, $limit); 
        } 

}
    //this one is needed*************************************************
    protected function createfalse($input)
        {
            $exclude = '==========';
            
            if ($input == $exclude)
            {
                return false;
            }
            elseif ($input == "")
            {
                return false;
            }
            return true;
        }
    
    
}

?>                                                                              
