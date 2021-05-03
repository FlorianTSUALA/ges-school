<?php

    /**
    * SPECIAL CONFIG
    */
    define ('DIRECTORY_SEPARATOR_INVERSE', "/");
    define ('DIRECTORY_CURRENT', ".");
    define ('DIRECTORY_BACK_FORWARD', "..");

    /**
     * SERVER PAGINATION CONFIG
     */
    define("NBRE_ELEMENT_PAR_PAGE", 1000);
    define("NBRE_PAGE_MAX_GAUCHE_ET_DROITE", 3);
    

    /**
     * COOKIE TIME DURATION
     */
    define("TIME_COOKIE_LONG", time() + 86400);
    
    
    /**
     * REDIRECTION RESSOURCES
     */
    $dir1 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "ressources";
    $dir2 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "ressources";
    $dir3 = "ressources";
    $dir = (file_exists($dir1) && is_dir($dir1)) ? $dir1 : ((file_exists($dir2) && is_dir($dir2)) ? $dir2 : $dir3);
    define("RESSOURCES_DIRECTORY", $dir);
    define("RESSOURCES_JETRIP_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "jetrip");
    define("RESSOURCES_GULP_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "gulp");
    define("RESSOURCES_PM_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "img_pm");
    define("RESSOURCES_USER_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "img_user");
    define("RESSOURCES_IMG_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "img");
    define("RESSOURCES_LOG_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "log");
    $dir = RESSOURCES_GULP_DIRECTORY;
    

    /**
     * REDIRECTION VIEWS
     */
    $dir1 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR .DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "views";
    $dir2 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "views";
    $dir3 = "views";
    $dir = (file_exists($dir1) && is_dir($dir1)) ? $dir1 : ((file_exists($dir2) && is_dir($dir2)) ? $dir2 : $dir3);
    define("VIEWS_DIRECTORY", $dir);
    define("VIEWS_PROPRIETAIRE_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "proprietaire");
    define("VIEWS_ABONNE_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "abonne");
    define("VIEWS_ADMIN_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "admin");
   
    /**
     * REDIRECTION COMPONENTS
     */
    $dir1 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR .DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "components";
    $dir2 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "components";
    $dir3 = "components";
    $dir = (file_exists($dir1) && is_dir($dir1)) ? $dir1 : ((file_exists($dir2) && is_dir($dir2)) ? $dir2 : $dir3);
    define("COMPONENTS_DIRECTORY", $dir);
    define("COMPONENTS_VITRINE_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "vitrine");
    define("COMPONENTS_BACKEND_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "backend");

    /**
     * REDIRECTION CONTROLLERS
     */
    $dir1 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "controllers";
    $dir2 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "controllers";
    $dir3 = "controllers";
    $dir = (file_exists($dir1) && is_dir($dir1)) ? $dir1 : ((file_exists($dir2) && is_dir($dir2)) ? $dir2 : $dir3);
    define("CONTROLLERS_DIRECTORY", $dir);
    define("CONTROLLERS_PROPRIETAIRE_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "proprietaire");
    define("CONTROLLERS_ABONNE_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "abonne");
    define("CONTROLLERS_ADMIN_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "admin");
    define("CONTROLLERS_ZADMIN_DIRECTORY", $dir . DIRECTORY_SEPARATOR . "zadmin");

    /**
     * REDIRECTION MODELS ET FICHIERS MODELS
     */
    $dir1 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR .DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "models";
    $dir2 = DIRECTORY_BACK_FORWARD . DIRECTORY_SEPARATOR . "models";
    $dir3 = "models";
    $dir = (file_exists($dir1) && is_dir($dir1)) ? $dir1 : ((file_exists($dir2) && is_dir($dir2)) ? $dir2 : $dir3);
    define("MODELS_DIRECTORY", $dir);

    /**
     * APPS COLORS
     */
    define("NAVBAR_COLOR", "dark");
    define("BG_COLOR", "success");
    define("BUTTON_MAIN_COLOR", "secondary");

    /**
     * SUMBA CONFIG
     */
    define("VERT", "#34a553");
    define("BLEU", "#4285f4");
    define("BLANC", "#edf3fc");
    define("DEFAULT_PROFILE_IMAGE", "default-profil.jpg");
    define("DEFAULT_LOGO_IMAGE", "default-logo.jpg");
    define("DEFAULT_LOGO_PARTNER", "default-partenaire.png");
    define("DEFAULT_SLIDE_IMAGE", "default-slide.png");
    define("DEFAULT_COUNTRY_FLAG", "default-drapeau.jpg");
    define("DEFAULT_BACKGROUND_IMAGE", "default-background.jpg");


    /**
     * FULL NAMES OF GROUP'S USER
     */
    define("TITRE_ENSEIGANT", "ENSEIGANT");
    define("TITRE_SECRETAIRE", "SECRETAIRE");
    define("TITRE_DIRECTEUR", "DIRECTEUR");
    define("TITRE_ADMINISTRATEUR", "ADMINISTRATEUR");

    /**
     * ABBREVIATIONS NAMES OF SEX
     */
    define("SEXE_HOMME", "H");
    define("SEXE_FEMME", "F");

    /**
     * CIVILITIES
     */
    define("CIVILITE_MONSIEUR", "M.");
    define("CIVILITE_MADAME", "Mme");
    define("CIVILITE_MADEMOISELLE", "Mlle");

    /**
     * WORD ACCORD
     */
    define("BIENVENU_HOMME", "Bienvenu");
    define("BIENVENU_FEMME", "Bienvenue");

    /**
     * FULL NAME OF CIVILITIES
     */
    define("TITRE_MONSIEUR", "Monsieur");
    define("TITRE_MADAME", "Madame");
    define("TITRE_MADEMOISELLE", "Mademoiselle");

    /**
     * KIND OF REQUEST
     */
    define("REQUEST_POST", "POST");
    define("REQUEST_GET", "GET");

    /**
     * REFRESH TIME
     */
    define("REALTIME_TIME_RECENT_TRANSACTION", 4000);
    define("REALTIME_TOTAL_CHART_TRANSACTION", 5);
    define("REALTIME_CHART_TRANSACTION", 5000);


    /**
     * TIME TO REFRESH 
     */
    define("REFRESH_TIME", 55500);
    define("REFRESH_TIME_DATATABLE", 60000);
    define("REFRESH_TIME_", 55500);

    /**
     * KIND OF JOIN
    */
    define("JOIN_TYPE", "type");
    define("JOIN_TABLE", "table");
    define("JOIN_CLAUSE", "clause");

    define("JOIN_LEFT", "LEFT JOIN");
    define("JOIN_RIGHT", "RIGHT JOIN");

    /**
     * KIND OF USER SYSTEM
     */
    define("USER_ANDROID_SYSTEM", -1);
    define("USER_WEB_SYSTEM", 0);
    define("USER_PVIT_AGENT", -3);
    define("USER_ADMIN_SYSTEM", -2);

    /**
     * OTHERS CONSTANTS VARIABLES
     */
    define("UN", "1");
    define("SELECT_ALL", "*");
    define("IS_NULL", "is null");
    define("ZERO", "0");


    /**
     * TIME AND DATE CONSTANTS VARIABLES
     */
    define("DATE_FORMAT_LONG", "Y-m-d H:i:s");
    define("PERIOD_WEEK", 7);
    define("PERIOD_MONTH", 30);
    define("PERIOD_YEAR", 366);
?>
