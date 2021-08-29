<?php

use App\Helpers\Helpers;

// var_dump($eleves);
    // var_dump($title);

?>
<!-- 
    ******  VARIABLES *****
        
    --- $title 

-->

    <div class="app-content content bg-warningcreated22">
        <div class="content-wrapper">

            <div class="content-body">

                <section class="row">
                    <div class="col-sm-12">
                        <!-- ESPACE DE TRAVAIL -->
                        <div id="kick-start" class="border-2 border-warning card box-shadow-2">
                            <div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">

                            <h4 class="card-title center text-uppercase">
                                <?= $title; ?>
                            </h4>
                        </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <!-- <div class="card-text">
                                        <p >Renseigner toutes les informations concernant l'élève.</p>
                                    </div> -->

                                    <div class="row" >


                                        <div class="col-2" >
                                            <button type="button" class="btn btn-sm btn-warning btn-darken"> Trier par Classe</button>

                                        </div>

                                        <div class="col-2" >

                                            <button type="button" class="btn btn-sm btn-warning btn-darken"> Trier par Classe</button>

                                        </div>

                                        <div class="col-2" >

                                            <button type="button" class="btn btn-sm btn-warning btn-darken"> Trier par Classe</button>

                                        </div>

                                        <div class="col-6" >

                                            <fieldset class="form-group relative has-icon-left col-md-5  float-right p-0">
                                                <input class="form-control" id="iconLeft" type="text" placeholder="Rechercher..."/>
                                                <div class="form-control-position"><i class="fa fa-search"></i></div>
                                            </fieldset>

                                        </div>

                                        </div>

                                    <div class="">
                                        <section id="content">
											<?php 
												$i = 0;
												foreach( $eleves as $eleve ) {
                                                   
												// for($i = 0; $i < 7; $i++) {
													// Begin FOR 
													if( $i%4 == 0 ){ // Begin IF #1
														if( $i != 0 ){ // Begin IF #2 ?>
											</div>
															<?php  } // End IF #2 ?>
											<div class="row">
														<?php } // End IF #1 ?>		
												<div class="col-3">
													<div class="card bg-light" style= "">
														<div class="card-content">
															<div class="card-body">
																<img class="card-img img-fluid mb-1" src="../ressources/uploads/img/<?= $eleve->photo_eleve ;?>" alt="Card image cap">
																<h5 align="center"><strong> <?= $eleve->nom_eleve ." ".$eleve->prenom_eleve ;?> </strong></h5>
																<ul class="list-inline clearfix mt-1" align="center">
																	<li class="mr-3"><?= $eleve->classe ;?></li><br>
																	<li class="mr-3"><?= Helpers::getYearOld($eleve->date_naissance_eleve) ." ans" ;?></li><br>
																	<li class="mr-3"><?= ($eleve->sexe_eleve == 'H')? "Genre : Masculin": "Genre : Feminin";?> </li>
                                                                    <li> </li><br><br>
																	<a href="#" class="btn mr-1 mb-1 btn-sm  btn-outline-twitter"><span class="ft-trash-2"></span></a>
																	<a href="#" class="btn mr-1 mb-1 btn-sm  btn-outline-twitter"><span class="ft-edit-2"></span></a>
																	<a href="#" class="btn  mr-1 mb-1 btn-sm btn-outline-linkedin"><span class="ft-eye"></span></a>
																</ul>
															</div>

															<div class="card-footer bg-light border-top-blue-grey border-top-lighten-5 text-muted">
																<span class="badge badge-pill badge-primary"><?= $eleve->statut_apprenant ;?></span>
																<span class="badge badge-pill badge-danger"><?= $eleve->annee_scolaire ;?></span>

															</div>
														</div>
													</div>
												</div>
												<?php $i++; } // End FOR ?>

											<?php if( $i%3 != 0 ){ // Begin IF #3 ?>
											</div>
											 
											<?php } // End IF #3 ?>

										</section>
										
										<section id="pagination">
                                            <div class="row">
                                                <div class="col-4">
                                                </div>
                                                <div class="col-4">
                                                </div>
                                                <div class="col-4">

                                                    <div class="text-center mb-3">
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination justify-content-center pagination-round">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#" aria-label="Previous">
                                                                        <span aria-hidden="true">&laquo;</span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </a>
                                                                </li>
                                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#" aria-label="Next">
                                                                        <span aria-hidden="true">&raquo;</span>
                                                                        <span class="sr-only">Next</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>

                                                    </div>
                                                </div>

                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer border-top-2 border-top-warning">
                                <span>Ges-School</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

