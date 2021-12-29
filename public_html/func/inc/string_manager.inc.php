<?php

function shortText($text, $length) : string {
    if(strlen($text) > $length) {
        $text = substr($text, 0, $length) . "...";
    }

    return $text;
}