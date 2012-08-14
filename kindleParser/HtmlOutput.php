<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlOutput
 *
 * @author michealmueller
 */

class HtmlOutput 
{
    protected $bookCount;

    function createHTML()
    {

        $bareHTML = <<<HTML
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Wisdom Project - Kindle Parser Output.</title>
</head>
<body>

</body>
</html>
HTML;


        $this -> bookCount = count($this -> titleArray);
        $htmlArray = array();
        for($i=0; $i <= $this -> bookCount; $i++)
        {

            $htmlArray[$i] = "<h2>" . $this -> titleArray[$i] . "</h2>
                        <blockquote>" . $this -> quoteArray[$i] . "</blockquote>
                        <p>— <a rel=\"external\" href=\"\">" . $this -> authorArray[$i] . "</a>, <a rel=\"external\" href=\"\">Author 2</a>. <a rel=\"external\" href=\"SHORT_URL\">" . $this -> titleArray[$i] . "</a> " . $this -> locationArray[$i] . "</p>\n<br>\n<!---NEW BOOK-->\n";
        }
//convert to string
        $htmlArrayToString = implode($htmlArray);
//concat start html and end html to above
        $fullHTML = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
<title>Wisdom Project - Kindle Parser Output.</title>
</head>
<body>
" . $htmlArrayToString . "
</body>
</html>";
        file_put_contents($this -> outputFile, $fullHTML);
        /*if (file_put_contents($this -> outputFile, $htmlArray) == false)
        {
            echo 'ERROR: File Could Not Be Written Please Contact Author for Support..\n';
            echo './' .basename(__FILE__) . ' OUTPUT_FILE_WRITE_ERROR\n\n';
            exit;
        }*/

    }
}

?>
