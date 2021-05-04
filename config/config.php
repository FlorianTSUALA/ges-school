<?php


define('APP_MODE', 'DEVELOPMENT'); //PRODUCTION


define('BASE_PATH', "ges-school/public/");

define("OFFLINE_DB", true);

define('APP_DIR_ABORT', '/ressources/views/abort/');

define('APP_DIR_REPORT', '/ressources/views/report/');

define('APP_LOGO', '/ressources/data/logo.png');

define('APP_RES_IMG_PROFILE', '/ressources/uploads/');

define("APP_SESSION_TIME_OUT", 1440);

 //if (!OFFLINE_DB) {
    if (OFFLINE_DB) {
        return array(        
        "ORGANISATION" => "Ges-School",
        "db_user" => "root",
        "db_pass" => "",
        "db_host" => "localhost",
        "db_charset" => "UTF-8",
        "db_name" => "nkap-scour"
    );
    } else {
        //PHP ADMIN http://www.phpmyadmin.co/
        return array(
        "ORGANISATION" => "Ges-School",
        "db_user" => "Fqy2hYVwUB",
        "db_pass" => "hdG3urVvRi",
        "db_host" => "remotemysql.com",
        "db_charset" => "UTF-8",
        "db_name" => "Fqy2hYVwUB",
        "port" => "3306"

        // ACTIVE
        // Username: Fqy2hYVwUB

        // Database name: Fqy2hYVwUB

        // Password: hdG3urVvRi

        // Server: remotemysql.com

        // Port: 3306

        // OLD
        // Server: sql9.freemysqlhosting.net
        // Name: sql9362831
        // Username: sql9362831
        // Password: idnWuEmSze
        // Port number: 3306
    );
    }
