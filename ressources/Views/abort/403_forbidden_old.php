<?php

use Core\Routing\URL;

?>
<!DOCTYPE html>

<html class="loaded" data-textdirection="ltr">
    <?php
        require_once "partials/head.php";
        // require_once "partials/../app/Helpers/_magic_tools.php";
    ?>

    <style>
        .button1 {background-color: #f5a663;}
        a {color: #f55555;}
    </style>

    <body class="vertical-layout vertical-mmenu content-detached-left-sidebar   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-mmenu" data-col="content-detached-left-sidebar">
    <?php
        require_once "partials/navbar.php";
    ?>
    <div class="app-content content bg-warningcreated22">
        <div class="content-wrapper">

            <div class="content-body">

                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body"><section class="col-sm-5 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 box-shadow-2">
                            <div class="card border-grey border-lighten-3 px-2 my-0 row">
                                <div class="card-header no-border pb-1">
                                    <div class="card-body">

                                        <h3 class="text-uppercase text-center">Page non disponible</h3>
                                        <h3 class="text-warning  text-center"> <?= $message;?> </h3>
                                    </div>
                                </div>
                                <div class="card-content px-2">
                                    <fieldset class="row py-2">
                                        <div class="input-group col-12">
                                            <input type="text" class="form-control border-grey border-lighten-1 " placeholder="Search..." aria-describedby="button-addon2">
                                            <span class="input-group-append" id="button-addon2">
                                                <button class="btn btn-lg btn-secondary border-grey border-lighten-1" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </fieldset>
                                    <div class="row py-2">
                                        <div class="col-12">
                                            <a href="<?= URL::link('accueil') ?>" class="btn button1 btn-block btn-lg"><i class="fa fa-home"></i> accueil </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer no-border pb-1">
                                    <div class="text-center">

                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
        require_once "partials/footer.php";
    ?>
    </body>
</html>