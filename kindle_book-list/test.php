<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function teststrtok()
{
    $string = 'you = you dont = you (dont) know';
    $token = '=()';

    $mytestArray = strtok($string, $token);

    $num = count($mytestArray);

    for ($i=0; $i <= $num; $i++)
    {

        var_dump($mytestArray[$i]);

    }
}

function testargv()
{
    global $argv;
    var_dump($argv[1]);
}

function pregTest()
{
    
    $inputString = array('foo', array('(bar)'),'|foobar|');
    $pattern = '/[(|)]/U';
    $replace = ' ';
    
    var_dump($inputString);
    echo '<br><br>';
    $test = preg_replace_array($pattern, $replace, $inputString);
    var_dump($test);  
    
}

function preg_replace_array($pattern, $replacement, $subject, $limit=-1)
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

function testExplode()
{
    //will have to do multiple explodes for each piece of information.
    $string = 'you == you dont == you (dont) know';
    $delimiter = '=='; //dependant on file type
    $testarray = explode($delimiter, $string);
    
    var_dump($testarray);
    
}

//teststrtok();

//testargv();

pregTest();

//testExplode();

?>