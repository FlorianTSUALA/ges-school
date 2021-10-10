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
                        <div  class="col">

                            <a href='<?= URL::link('loader_eleve');?>' style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow bg-Orange  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-graduation-cap fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Chargement Eleves</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>

                        <div class="col">
                            <a href="<?= "#" ?>" style="cursor:pointer; text-decoration: none;">
                                <div  id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-trophy fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Chargement des Notes</strong></h1>
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
