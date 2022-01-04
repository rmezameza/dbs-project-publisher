<?php

/*
 * This php file includes functions which manage string inputs.
 */

/**
 * <p>If the text is longer than the length of given variable / parameter "$length" then
 * this function will cut the text. Only text with that length will be shown.</p>
 *
 * @param $text : string
 * @param $length : int
 * @return string
 */

function shortText($text, $length) : string {
    if(strlen($text) > $length) {
        $text = substr($text, 0, $length) . "...";
    }

    return $text;
}