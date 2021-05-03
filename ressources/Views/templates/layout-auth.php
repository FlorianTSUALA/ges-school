<?php 

use App\App;
use Core\Routing\URL;

?>

<!DOCTYPE html>

<html class="loaded" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="KGS Framework, using to perform web application features">
    <meta name="keywords" content="">
    <meta name="author" content="Stéphane KAMGA">

    <title><?= App::getAppInstance()->getTitle(); ?></title>
	
    <link rel="apple-touch-icon" href="<?= URL::base() ?>assets/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= URL::base() ?>assets/app-assets/images/ico/favicon.ico">
    
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/css/font.css">

    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/vendors.css">

    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/core/menu/menu-types/vertical-menu.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/app.css">
</head>

<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"></div>

            <div class="content-body ">
                <section class="flexbox-container">
					<?= $content; ?>
				</section>
            </div>
        </div>
    </div>

<script src="<?= URL::base() ?>assets/app-assets/vendors/js/vendors.min.js"></script>
<script src="<?= URL::base() ?>assets/app-assets/js/core/app-menu.js"></script>
<script src="<?= URL::base() ?>assets/app-assets/js/core/app.js"></script>
</body>
</html>