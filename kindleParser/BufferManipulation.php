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
    protected $typeOneInput;
    protected $typeTwoInput;


    protected function bufferStringToArray()
    {
        if ($this -> fileType == 1)
        {
//split by every line into an array
            $delimiter = '/(?:^|==========[\r\n]+)([^(\r\n]+) \(([^)]+)\)[\r\n]+- ([^|\r\n]+)(?: \|)? (Location ([^|]+)) \| Added on ([^\r\n]+)[\r\n]+([^=]+)/';
            //'/(?:^|==========[\r\n]+)([^(\r\n]+) \(([^)]+)\)[\r\n]+- ([^|\r\n]+)(?: \|)? (Location ([^|]+)) \| Added on ([^\r\n]+)[\r\n]+([^\r\n]*)[\r\n+]/';
                //'/\r\n|\r|\n/';
            preg_match_all($delimiter, $this -> bufferstring, $this -> typeOneInput);

            //$this -> inputFileArrayToString = implode('*', $this -> inputFileArray);
            //var_dump($this -> typeOneInput[7]);
        }
        elseif($this -> fileType == 2)
        {
            $pattern = '/(.+?)[\r\n]+([^\r\n]+)[\r\n]+=====/is';
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
            $this -> titleArray = $this -> typeOneInput[1];

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

            $this -> authorArray = $this -> typeOneInput[2];
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
            $this -> locationArray = $this -> typeOneInput[4];
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
            foreach( $this -> typeOneInput[7] as &$value)
            {
                if($value == null)
                {
                    $value = 'No Quote Available.';
                }
            }
            $this -> quoteArray = $this -> typeOneInput[7];
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

