<?php

function checkPostRequest() : array {
    $bookstoreArray = array();

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['street'])) {
            $bookstoreArray['LAG_STRASSE'] = sanitizeInput($_POST['street']);
        }

        if(isset($_POST['zip'])) {
            $bookstoreArray['LAG_PLZ'] = sanitizeInput($_POST['zip']);
        }

        if(isset($_POST['place'])) {
            $bookstoreArray['LAG_ORT'] = sanitizeInput($_POST['place']);
        }

        if(isset($_POST['country'])) {
            $bookstoreArray['LAG_LAND'] = sanitizeInput($_POST['country']);
        }
    }

    return $bookstoreArray;
}
