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
            
            preg_match_all($this -> locationAuthorDelim, $this -> bufferstring, $this -> matches, PREG_PATTERN_ORDER);
            
            $this -> replacePattern = '/[(|)]/U';
            $this -> replace = '';
            //use preg replace now for replace () and ||
            
            $this -> matches = $this -> preg_replace_multi_array($this->replacePattern, $this->replace, $this->matches);
            //preg_replace_array($this -> replacePattern, '', $this -> matches);
            
            var_dump($this -> matches);
            
            //figure out a way to not use a ulti array and finsh this damn thing!@!!!!!!!!!!!!!!!!!!!!!!!
            
            
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
    //i do not take credit for this function i found it here : http://forums.devshed.com/php-development-5/how-to-preg-replace-on-multi-dimensional-array-463318.html
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
