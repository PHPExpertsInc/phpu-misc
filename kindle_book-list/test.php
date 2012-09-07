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
    echo '************************';
    $test = preg_replace_array($pattern, $replace, $inputString);
    $test2 = array_flatten($test);
    var_dump($test);
    echo '************************';
    var_dump($test2);
    
    
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

function array_flatten(array $array)
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
//teststrtok();

//testargv();

pregTest();

//testExplode();

?>