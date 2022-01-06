<?php

    function validateBookType() {
        $bookType = array();
        $clean = array();

        $bookTypeNames = array("neu", "politics", "literature", "history", "theory", "comics", "art-books", "kids");
        $type = isset($_GET['type']) ? htmlentities($_GET['type']) : null;

        if($type != null && !in_array($type, $bookTypeNames)) {
            include_once 'error/not_allowed.html';
            exit;
        }
        else {
            $clean['type'] = $type;
        }

        switch($clean['type']) {
            case "neu":
                $bookType["shortname"] = "neu";
                $bookType["longname"] = "Neuerscheinungen";
                break;
            case "politics":
                $bookType["shortname"] = "politics";
                $bookType["longname"] = "Bahoe Politics";
                break;
            case "literature":
                $bookType["shortname"] = "literature";
                $bookType["longname"] = "Bahoe Literature";
                break;
            case "history":
                $bookType["shortname"] = "history";
                $bookType["longname"] = "Bahoe History";
                break;
            case "theory":
                $bookType["shortname"] = "theory";
                $bookType["longname"] = "Bahoe Theory";
                break;
            case "comics":
                $bookType["shortname"] = "comics";
                $bookType["longname"] = "Bahoe Comics";
                break;
            case "art-books":
                $bookType["shortname"] = "art-books";
                $bookType["longname"] = "Bahoe Art Books";
                break;
            case "kids":
                $bookType["shortname"] = "kids";
                $bookType["longname"] = "Bahoe Kids";
                break;
            default:
                $bookType = null;
                break;
        }

        return $bookType;
    }

    function previousSite() : string {
        $clean = array();

        $siteNames = array("buecher", "buchdetail");
        $siteName = isset($_GET['prev']) ? htmlentities($_GET['prev']) : null;

        if($siteName == null && !in_array($siteName, $siteNames)) {
            include_once 'error/not_allowed.html';
            exit;
        }
        else {
            $clean['prev'] = $siteName;
        }

        return $clean['prev'];
    }

    function validateSitesForSubmit() : string {
        $clean = array();

        $siteTypes = array("buchedit", "neues-buch");
        $siteType = isset($_GET['op']) ? htmlentities($_GET['op']) : null;

        if($siteType != null && !in_array($siteType, $siteTypes)) {
            include_once 'error/not_allowed.html';
            exit;
        }
        else {
            $clean['op'] = $siteType;
        }

        return $clean['op'];
    }