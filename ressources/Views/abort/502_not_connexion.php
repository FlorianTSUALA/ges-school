<?php 
    use Core\Routing\URL; 
    use App\App;
    use Core\BaseApp;
?>

    <?php require_once "partials/head.php"; ?>

   <!-- ////////////////////////////////////////////////////////////////////////////-->
   <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <svg style="fill: #D94453 ;   height: 100%; position: absolute; width: 280px; right: 15%; bottom: 25%; z-index: 1;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 120.54" style="enable-background:new 0 0 122.88 120.54" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M95.7,65.5c15.01,0,27.18,12.17,27.18,27.18c0,15.01-12.17,27.18-27.18,27.18 c-15.01,0-27.18-12.17-27.18-27.18C68.52,77.67,80.69,65.5,95.7,65.5L95.7,65.5z M92.35,102.95h6.49v5.74h-6.49V102.95 L92.35,102.95z M98.83,99.04h-6.48c-0.64-7.88-2-9.59-2-17.45c0-2.9,2.35-5.26,5.26-5.26c2.9,0,5.26,2.35,5.26,5.26 C100.86,89.45,99.49,91.17,98.83,99.04L98.83,99.04z M17.69,26.67c8.1,2.71,19.38,4.38,31.91,4.38s23.81-1.67,31.91-4.38 c7.11-2.37,11.51-5.25,11.51-8.06c0-2.81-4.4-5.69-11.51-8.06c-8.1-2.7-19.38-4.38-31.91-4.38s-23.81,1.67-31.91,4.38 C2.6,15.59,2.18,21.5,17.69,26.67L17.69,26.67z M6.24,47.86c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.71,19.38,4.38,31.91,4.38 s23.81-1.67,31.91-4.38c7.11-2.37,11.51-5.25,11.51-8.06h0.03v-19.3c-2.53,1.73-5.78,3.26-9.59,4.53 c-8.73,2.91-20.71,4.72-33.86,4.72c-13.16,0-25.13-1.8-33.86-4.72c-3.77-1.26-6.98-2.76-9.49-4.47V47.86L6.24,47.86z M63.3,92.54 c-4.35,0.44-8.95,0.67-13.7,0.67c-13.16,0-25.13-1.8-33.86-4.72c-3.77-1.26-6.98-2.76-9.49-4.47v18.49 c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.7,19.38,4.38,31.91,4.38c7.52,0,14.58-0.6,20.78-1.67c1.56,1.94,3.33,3.7,5.29,5.24 c-7.53,1.65-16.49,2.6-26.07,2.6c-13.16,0-25.13-1.8-33.86-4.72c-4.6-1.54-15.67-6.58-15.67-12.62c0-0.71,0-1.3,0-1.98 C0.06,73.69,0,46.15,0,18.61c0-5.76,6.01-10.65,15.73-13.9C24.46,1.8,36.44,0,49.6,0c13.16,0,25.13,1.8,33.86,4.72 c8.85,2.95,14.62,7.27,15.59,12.37c0.12,0.32,0.18,0.67,0.18,1.04v42.37c-1.2-0.14-2.42-0.21-3.66-0.21c-0.85,0-1.68,0.03-2.51,0.1 v-3.74c-2.53,1.73-5.78,3.26-9.59,4.53c-8.73,2.91-20.71,4.72-33.86,4.72c-13.16,0-25.13-1.8-33.86-4.72 c-3.77-1.26-6.98-2.76-9.49-4.47v18.49c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.7,19.38,4.38,31.91,4.38c5.01,0,9.82-0.27,14.31-0.76 C63.51,88.3,63.3,90.4,63.3,92.54L63.3,92.54z"/></g></svg>
                    <svg style="fill: #F5A663 ;   height: 100%; position: absolute; width: 280px; right: 65%; bottom: 25%; z-index: 1;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 120.54" style="enable-background:new 0 0 122.88 120.54" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M95.7,65.5c15.01,0,27.18,12.17,27.18,27.18c0,15.01-12.17,27.18-27.18,27.18 c-15.01,0-27.18-12.17-27.18-27.18C68.52,77.67,80.69,65.5,95.7,65.5L95.7,65.5z M92.35,102.95h6.49v5.74h-6.49V102.95 L92.35,102.95z M98.83,99.04h-6.48c-0.64-7.88-2-9.59-2-17.45c0-2.9,2.35-5.26,5.26-5.26c2.9,0,5.26,2.35,5.26,5.26 C100.86,89.45,99.49,91.17,98.83,99.04L98.83,99.04z M17.69,26.67c8.1,2.71,19.38,4.38,31.91,4.38s23.81-1.67,31.91-4.38 c7.11-2.37,11.51-5.25,11.51-8.06c0-2.81-4.4-5.69-11.51-8.06c-8.1-2.7-19.38-4.38-31.91-4.38s-23.81,1.67-31.91,4.38 C2.6,15.59,2.18,21.5,17.69,26.67L17.69,26.67z M6.24,47.86c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.71,19.38,4.38,31.91,4.38 s23.81-1.67,31.91-4.38c7.11-2.37,11.51-5.25,11.51-8.06h0.03v-19.3c-2.53,1.73-5.78,3.26-9.59,4.53 c-8.73,2.91-20.71,4.72-33.86,4.72c-13.16,0-25.13-1.8-33.86-4.72c-3.77-1.26-6.98-2.76-9.49-4.47V47.86L6.24,47.86z M63.3,92.54 c-4.35,0.44-8.95,0.67-13.7,0.67c-13.16,0-25.13-1.8-33.86-4.72c-3.77-1.26-6.98-2.76-9.49-4.47v18.49 c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.7,19.38,4.38,31.91,4.38c7.52,0,14.58-0.6,20.78-1.67c1.56,1.94,3.33,3.7,5.29,5.24 c-7.53,1.65-16.49,2.6-26.07,2.6c-13.16,0-25.13-1.8-33.86-4.72c-4.6-1.54-15.67-6.58-15.67-12.62c0-0.71,0-1.3,0-1.98 C0.06,73.69,0,46.15,0,18.61c0-5.76,6.01-10.65,15.73-13.9C24.46,1.8,36.44,0,49.6,0c13.16,0,25.13,1.8,33.86,4.72 c8.85,2.95,14.62,7.27,15.59,12.37c0.12,0.32,0.18,0.67,0.18,1.04v42.37c-1.2-0.14-2.42-0.21-3.66-0.21c-0.85,0-1.68,0.03-2.51,0.1 v-3.74c-2.53,1.73-5.78,3.26-9.59,4.53c-8.73,2.91-20.71,4.72-33.86,4.72c-13.16,0-25.13-1.8-33.86-4.72 c-3.77-1.26-6.98-2.76-9.49-4.47v18.49c0.56,2.62,4.83,5.26,11.45,7.47c8.1,2.7,19.38,4.38,31.91,4.38c5.01,0,9.82-0.27,14.31-0.76 C63.51,88.3,63.3,90.4,63.3,92.54L63.3,92.54z"/></g></svg>

                    <div class="col-md-4 col-10 p-0">
                        <div class="card-header bg-transparent border-0">
                            <h2 class="error-code text-center mb-2">502</h2>
                            <h3 class="text-uppercase text-center">Erreur du serveur de Base de données interne</h3>
                        </div>
                        <div class="card-content">
                            <fieldset class="row py-2">
                                <div class="input-group col-12">
                                    <input type="text" class="form-control form-control-xl input-xl border-grey border-lighten-1 " placeholder="Recherche..." aria-describedby="button-addon2">
                                    <span class="input-group-append" id="button-addon2">
                                    <button class="btn btn-lg btn-secondary border-grey border-lighten-1" type="button"><i class="ft-search"></i></button>
                                </span>
                            </div>
                            </fieldset>
                            <div class="row py-2">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a href="<?= URL::link('accueil') ?>" class="btn btn-warning btn-block"><i class="ft-home"></i> accueil</a>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <a href="<?= URL::link('login') ?>" class="btn btn-danger btn-block"><i class="ft-user"></i>  Connexion</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <p class="text-muted text-center col-12 py-1">© 2020 <a href="#">Les Comilines </a> Notre devise : <i class="ft-heart pink"> </i> by <a href="#" target="_blank"> <?= BaseApp::TEAM ?> </a></p>
                                <div class="col-12 text-center">
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

<?php require_once "partials/footer.php"; ?>

