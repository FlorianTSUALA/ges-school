<?php
$root_app_url = ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on')) ? "https" : "http") . "://htmlentities($_SERVER[HTTP_HOST])/";

switch ($root_app_url):
// replace production-url with the server name for your production site
    case 'https://ges-school.com/':
        require_once('production.config.php');
    break;

// replace development-url with the server name for your development site
    case 'http://test.ges-school.com/':
        require_once('development.config.php');
    break;

// assuming your local server name is 'localhost,' leave this section alone
    default:
	require_once('local.config.php');

endswitch;
// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!