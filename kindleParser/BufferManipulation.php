<?php
/**
 * Description of FileWork
 * Kindle Snippets Parser, a PHPExperts.pro Project.
 * Copyright © 2012 PHP Experts, Inc.
 * Author: (Primary) Micheal Mueller <michealm@PHPU.cc>
 *         (Secondary) Theodore R. Smith <theodore@phpexperts.pro>
 *          http://users.phpexperts.pro/tsmith/
 *
 */
require_once 'HtmlOutput.php';

class BufferManipulation extends HtmlOutput
{
    protected $inputFileArray;
    protected $inputFileArrayToString;
    protected $inputFileArraySplitByEqual;
    protected $authorArray;
    protected $titleAuthorArray;
    protected $titleArray;
    protected $locationArray;
    protected $quoteArray;
    protected $typeTwoInput;


    protected function bufferStringToArray()
    {
        if ($this -> fileType == 1)
        {
//split by every line into an array
            $delimiter = '/\r\n|\r|\n/';
            $this -> inputFileArray = preg_split($delimiter, $this -> bufferstring);

            $this -> inputFileArrayToString = implode('*', $this -> inputFileArray);
        }
        elseif($this -> fileType == 2)
        {
            $pattern='/(.+?)[\r\n]+([^\r\n]+)[\r\n]+=====/is';
            preg_match_all($pattern, $this -> bufferstring, $this -> typeTwoInput);
//$this -> typeTwoInput[1] = quote, [2] = author - title - Location string.
        }

        self::getTitle();
        self::getAuthors();
        self::getLocation();
        self::getQuote();
        parent::createHTML();
    }

    protected function getTitle()
    {
        if($this -> fileType == 1)
        {
//pull out every 5th item from inputFileArray (titles (authors))
            $this -> titleAuthorArray = pick_Specific_elements($this -> inputFileArray, 5, 0);
//implode and remove title from strings.
            $titleAuthorArrayToString = implode('*', $this -> titleAuthorArray);

            $titleDelimiter = '/\(?[^(*]+/';
            preg_match_all($titleDelimiter, $titleAuthorArrayToString, $this -> titleArray);

//flatten multi-array created by preg_match_all
            $this -> titleArray = flattenArray($this -> titleArray);

//pick even items which is titles odd are authors.
            $this -> titleArray = pick_Specific_elements($this -> titleArray, 2, 0);

            $this -> titleArray = array_merge($this -> titleArray);

//*************** finished - titles are in array $this -> titleArray *************
        }
        elseif($this -> fileType == 2)
        {
            $titleString = implode("\n", $this -> typeTwoInput[2]);
            preg_match_all('#^(.+?)(?: \(([^\)]+)\))?\. (.+?)(?: \(([^\)]+)\))?\.(.+)$#im', $titleString, $matches);
            $this -> titleArray = $matches[3];
        }

    }

    protected function getAuthors()
    {
        if($this -> fileType == 1)
        {
//implode to string and pull authors out
            $authorDelimiter = '/={10}.+(\(.+\))/U';
            preg_match_all($authorDelimiter, $this -> inputFileArrayToString, $matches);
//remove ( and ) from author names.
            $this -> authorArray = preg_replace('/[()]/U', '', $matches[1]);
        }
        elseif($this -> fileType == 2)
        {
            $authorString = implode("\n", $this -> typeTwoInput[2]);
            preg_match_all('#^(.+?)(?: \(([^\)]+)\))?\. (.+?)(?: \(([^\)]+)\))?\.(.+)$#im', $authorString, $matches);
            $this -> authorArray = $matches[1];
        }
    }

    protected function getLocation()
    {

        if ($this -> fileType == 1)
        {
//get location line first then turn array into string to run through preg_match_all then split.

            $locationLineArray = preg_grep('/(\|.+\|)/', $this -> inputFileArray);

            $locationLineArrayToString = implode("*", $locationLineArray);

            preg_match_all('/\|.+\|/U', $locationLineArrayToString, $locationLineArray);

            $this -> locationArray = flattenArray($locationLineArray);

            $this -> locationArray = preg_replace('/\|/', "", $this -> locationArray);
        }
        elseif($this -> fileType = 2)
        {
            $locationString = implode('*', $this -> typeTwoInput[2]);
            preg_match_all('/(\(p.+?\)|\(Kindle\sLocation\s.+?\))/', $locationString, $matches);

            $this -> locationArray = $matches[1];
        }


    }

    protected function getQuote()
    {
        if($this -> fileType == 1)
        {
            $this -> quoteArray = pick_Specific_elements($this -> inputFileArray, 5, 7);
            $this -> quoteArray = array_merge($this -> quoteArray);
        }
        elseif($this -> fileType == 2)
        {
//split by ===== and clean text to remove html and other random characters.
            $this -> quoteArray = $this -> typeTwoInput[1];
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
            preg_replace('/\s/', 'No Quote', $input);
        }
        return true;
    }
}

//i take no credit for this function*******
function flattenArray($multi_array)
{
    $flat_array = array();
    foreach(new RecursiveIteratorIterator(new RecursiveArrayIterator($multi_array)) as $k => $v)
    {
        $flat_array[$k] = $v;
    }
    return $flat_array;
}

//$source = input array , $num = number of element wanted from array.
function pick_specific_elements($source, $num, $start)
{

    $result = array();
    $i = $start;
    foreach($source as $value)
    {
        if ($i++ % $num == 0)
        {
            $result[$i] = $value;
        }
    }
    return $result;
}

