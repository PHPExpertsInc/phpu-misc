<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of amznProductLinkCode
 *
 * @author michealmueller
 */
class ShortURL

{
    function getShortAmznProductLinkCode($ASIN, $title = 'Lorem ipsum Dolor Sit')
{
    $link = <<<HTML
<a href="#">$title</a>
HTML;

    return $link;
}
}

?>
