<?php 
    use core\Routing\URL;
?>

<!-- 
    ******  VARIABLES *****
        
    --- $title 
    <?= URL::link("postlogin"); ?>
-->


<div class="col-12 d-flex align-items-center justify-content-center">
    <div class="col-md-4 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header border-0">
                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span><strong>Ges-School</strong></span>
                </h6>
            </div>


            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"> <?= $error; ?></div>
            <?php endif; ?>
            
            
            <div class="card-content">
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="<?= URL::link("postlogin"); ?>" novalidate>
                        <div class="form-group position-relative has-icon-left mb-2">
                            <input type="text" class="form-control form-control-lg input-lg" id="user-name" name="user-name" placeholder="Utilisateur" required/>
                                                       
                            <div class="valid-feedback">Valide !!!</div>
                            <div class="invalid-feedback">
                                Veuillez remplir ce champ.
                            </div>
                            
                            <div class="form-control-position">
                                <i class="ft-user"></i>
                            </div>

                            <div class="valid-feedback">Valide !!!</div>
                            <div class="invalid-feedback">
                                Veuillez remplir ce champ.
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-1">                            
                            <input type="password" class="form-control form-control-lg input-lg" id="user-password" name="user-password" placeholder="Mot de passe" required/>
                           
                            <div class="valid-feedback">Valide !!!</div>
                            <div class="invalid-feedback">
                                Veuillez remplir ce champ.
                            </div>

                            <div class="form-control-position">
                                <i class="fa fa-key"></i>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-warning btn-lg btn-block"><i class="ft-unlock"></i> Se connecter</button>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>