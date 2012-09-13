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
require_once 'DetectFileType.php';

class FileWork extends DetectFileType
{
    private $filename; 
    private $mode = 'rb';
    private $buffer;
    
    protected $bufferstring;
    
    protected function reader()
    {

        $this->filename = $this->inputFile;
//open file
        $this->buffer = fopen($this->filename, $this->mode);
//turn buffer into one giant string.
        $this->bufferstring = stream_get_contents($this->buffer);

        fclose($this->buffer);
        parent::setFileType();
    }        
}
?>
