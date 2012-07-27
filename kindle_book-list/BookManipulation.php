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
    protected $flatLocationAuthorArray;
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
            
            $this -> flatLocationAuthorArray = $this -> flattenArray($this -> locationAuthorArray);

//TODO: figure this out!!!!
            //repalce symbols 
            
            //$this -> replacePattern = '/[(|)]/U';
            //$this -> replace = '';
                      
            //use preg replace now for replace () and ||
            //preg_replace($this->replacePattern, $this->replace, $this->locationAuthorArray);
            
            var_dump($this -> flatlocationAuthorArray);           
            
        }
        else 
        {
            //do splits accordingly for Type 2
            //set delimiter
            $this -> delimiterType = '/\r\n|\r|\n/';
            
            $this -> bookArray = preg_split($this -> delimiterType, $this ->   bufferstring);
        }
        
        $this -> bookArray = array_filter($this -> bookArray, array($this, 
            "createfalse"));
        
        //var_dump($this -> bookArray);
        
        //parent::createAuthor();
        //parent::createQuote();
    }  
    
    protected function flattenArray($multi_array)
    {
        $flat_array = array();
        foreach(new RecursiveIteratorIterator(new RecursiveArrayIterator($multi_array)) as $k => $v)
        {
            $flat_array[$k] = $v;
        }
        return $flat_array();
    }
    
//    function array_flatten($nested, $preserve_keys = false) {
//$flat = array();
//$collector = $preserve_keys ? function ($v, $k) use (&$flat) {
//$flat[$k] = $v;
//} : function ($v) use (&$flat) {
//        $flat[] = $v;
//};
//array_walk_recursive($nested);
//return $flat;
//}
    
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
