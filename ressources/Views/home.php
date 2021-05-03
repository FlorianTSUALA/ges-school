<?php
    use Core\Routing\URL;
?>
<style>
    #mydiv:hover {
        background-color: #f5a663;

    }
</style>

<!-- 
    ******  VARIABLES *****
        
    --- $title 

-->

<div class="app-content content  ">
			<div class="content-wrapper">
				<div class="content-body">

                    <div class="row">
                        <div  class="col-4">

                            <a href='<?= URL::link('scolarite_accueil');?>' style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow bg-Orange  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-graduation-cap fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Scolarite</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('emploi_temps_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="icon-calendar fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Emploi de temps</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('biblio_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-book fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Bibliothèque</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>



                    <div class="row">


                        <div class="col-4">
                            <a href="<?= URL::link('bulletin_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="icon-notebook fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Bulletin</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('cantine_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-cutlery fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Cantine</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('club_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div  id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-trophy fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Club</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="row">



                    </div>

                    <div class="row">
                        <div class="col-4">
                            <a href="<?= URL::link('personnel_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-users fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Personnel</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('enseignement_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-graduation-cap fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Enseignement</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="<?= URL::link('comptabilite_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="ft-search fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Aperçus</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-4">
                        <a href="<?= URL::link('parametrage_accueil') ?>" style="cursor:pointer; text-decoration: none;">
                            <div id="mydiv" class="card border-0 shadow  ">
                                <div class="card-body kgs-bg-yellow">
                                    <div class="row align-items-end h3 kgs-green">
                                        <div class="col-12 text-center">
                                            <span class="fa fa-cog fa-5x"></span>
                                        </div>

                                        <div class="col">
                                            <h1 align="center" class="text-uppercase pt-1"><strong>Paramètrage</strong></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
				</div>
			</div>
		</div>
