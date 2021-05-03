<?php ?>
<?php ?>
<!-- 
    ******  VARIABLES *****
        
    --- $title 

-->

<div class="col-12 d-flex align-items-center justify-content-center">
    <div class="col-md-4 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header border-0">
                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Ges-School</span>
                </h6>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form class="form-horizontal form-simple" action="<?= URL::link('accueil') ?>" novalidate>
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="Utilisateur">
                            <div class="form-control-position">
                                <i class="ft-user"></i>
                            </div>
                        </fieldset>

                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Mot de passe">
                            <div class="form-control-position">
                                <i class="fa fa-key"></i>
                            </div>
                        </fieldset>

                        <a href="<?= URL::link('accueil') ?>" class="btn btn-warning btn-lg btn-block"><i class="ft-unlock"></i> Se connecter</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>