<?php

/*
 * This inc php file manages all functions for security, like input sanitation from
 * forms.
 */

/**
 * This function sanitize and neutralize the input data, especially from forms,
 * and returns a clean variable.
 *
 * @param $inputData : string
 *
 * @return string
 */

function sanitizeInput($inputData) : string {
    trim($inputData);
    stripslashes($inputData);
    htmlentities($inputData);

    return $inputData;
}

function checkInputValueForNull($inputData) : void {
    if(is_null($inputData)) {
        include_once 'error/not_allowed.html';
        exit;
    }
}
