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
	<meta name="description" content="GES-SCHOOL, using to perform web application features">
	<meta name="keywords" content="">
	<meta name="author" content="PRO Elite Team">

	<title><?= 'Hello Guys' ?></title>

	<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/css/font.css">

	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/vendors/css/forms/selects/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/core/menu/menu-types/vertical-menu.css">


    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/vendors/css/extensions/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/vendors/css/extensions/toastr.css">

	<!--<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/css/style.css"> -->
	<link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?= URL::base() ?>assets/app-assets/css/core/menu/menu-types/vertical-multi-level-menu.css">

	<!-- ############# -->
	<?= $include_res_header??""; ?>

    <style>
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color:    #909;
            opacity:  1;
        }
    </style>

</head>
<!-- <body class="vertical-layout vertical-mmenu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-mmenu" data-col="2-columns"> -->
<body class="vertical-layout vertical-mmenu content-detached-left-sidebar   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-mmenu" data-col="content-detached-left-sidebar">
	<?php require "layouts/flash_message.php" ?>


	<!-- ############# -->
	<?= $content; ?>
	

	<script src="<?= URL::base() ?>assets/app-assets/vendors/js/vendors.min.js"></script>
	<script src="<?= URL::base() ?>assets/app-assets/vendors/js/extensions/sweetalert.min.js"></script>
    <script src="<?= URL::base() ?>assets/app-assets/vendors/js/menu/jquery.mmenu.all.min.js"></script>
	<?php require "common/javascript_function.php" ?>
	
	<?= $include_res_footer??""; ?>
	<script src="<?= URL::base() ?>assets/app-assets/js/core/app-menu.js"></script>
	<script src="<?= URL::base() ?>assets/app-assets/js/core/app.js"></script>
	<script src="<?= URL::base() ?>assets/app-assets/vendors/js/extensions/toastr.min.js"></script>
	<script src="<?= URL::base() ?>assets/app-assets/vendors/js/extensions/moment.min.js"></script>
	
	
	<!-- ############# -->
	<?= $include_footer_script??""; ?>
	<!-- ############# -->
	<?php require  dirname(__DIR__)."/alert/alert.php" ?>
	
</body>

</html>