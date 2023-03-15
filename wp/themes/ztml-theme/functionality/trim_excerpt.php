<?php
function trim_excerpt($text)
{
    $text = str_replace('[&hellip;]', '...', $text);
    return $text;
}