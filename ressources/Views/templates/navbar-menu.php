<?php

use App\Helpers\S;
use Core\Routing\URL;
use App\Repository\AnneeScolaireRepository;

//@TODO
//LA GESTION DES ANNEE SCOLAIRE DOIT ETRE LOCALE
//ON DOIT GERER CELA AVEC LES SESSIONS. POUR NE PAS BASCULER TOUS LES UTILISATEURS
//VERS UNE ANNEE SCOLAIRE DONNEE
$annee_scolaire_courante = ( new AnneeScolaireRepository() )->getActive('libelle')??'non définie';
$annee_scolaires = ( new AnneeScolaireRepository() )->getAll();

?>

<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
	<div class="navbar-wrapper">
		<div class="navbar-header">
			<ul class="nav navbar-nav flex-row">
				<li class="nav-item mobile-menu d-md-none mr-auto">
					<a class="nav-link nav-menu-main menu-toggle hidden-xs" href="">
						<i class="ft-menu font-large-1"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="navbar-brand" href=""><img class="brand-logo" alt="robust admin logo" src="<?= URL::base() ?>assets/app-assets/images/logo/logo-dark-sm.png">
						<h3 class="brand-text">Ges-School</h3>
					</a>
				</li>
				<li class="nav-item d-md-none">
					<a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
						<i class="fa fa-ellipsis-v"></i>
					</a>
				</li>
			</ul>
		</div>

		<div class="navbar-container content">
			<div class="collapse navbar-collapse" id="navbar-mobile">
				<ul class="nav navbar-nav mr-auto float-left">
					<li class="nav-item d-none d-md-block">
						<a class="nav-link nav-menu-main menu-toggle hidden-xs" href="">
							<i class="ft-menu"></i>
						</a>
					</li>

					<li class="nav-item d-none d-md-block">
						<fieldset class="form-group position-relative  has-icon-left mt-1 mb-0">
							<input type="search" name="recherche" placeholder="Recherche" class="form-control">
							<div class="form-control-position">
								<i class="ficon ft-search"></i>
							</div>
						</fieldset>
					</li>
				</ul>

				<ul class="nav navbar-nav float-right">
					<li class="dropdown dropdown-language">
						<a class="nav-link" id="dropdown-flag" ><b>Annee scolaire :</b></a>
					</li>
					<li class="dropdown dropdown-language nav-item">
						<a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><?= $annee_scolaire_courante ?></span><span class="selected-language"></span></a>
						<div class="dropdown-menu" aria-labelledby="dropdown-flag">
						<?php foreach($annee_scolaires as $annee_scolaire){ ?>
							<a class="dropdown-item" href="#"> <?= $annee_scolaire['libelle']; ?></a>
						<?php } ?>
						</div>
					</li>

					<li class="dropdown dropdown-notification nav-item">
						<a class="nav-link nav-link-label" href="" data-toggle="dropdown">
							<i class="ficon ft-bell"></i>
							<span class="badge badge-pill badge-default badge-danger badge-default badge-up">3</span>
						</a>

						<!-- <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
							<li class="dropdown-menu-header">
								<h6 class="dropdown-header m-0">
									<span class="grey darken-2">Messages</span>
								</h6>
								<span class="notification-tag badge badge-default badge-danger float-right m-0">3 nouveaux</span>
							</li>

							<li class="scrollable-container media-list w-100">
								<a href="">
									<div class="media">
										<div class="media-left">
												<span class="avatar avatar-sm avatar-online rounded-circle">
													<img src="<?= URL::base() ?>assets/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar">
													<i></i>
												</span>
										</div>

										<div class="media-body">
											<h6 class="media-heading">Stéphane KAMGA</h6>
											<p class="notification-text font-small-3 text-muted">Bientôt la fin d'année...</p>
											<small>
												<time class="media-meta text-muted" datetime="2020-06-11T18:29:20+08:00">Aujourd'hui</time>
											</small>
										</div>
									</div>
								</a>
								<a href="">
									<div class="media">
										<div class="media-left">
												<span class="avatar avatar-sm avatar-away rounded-circle">
													<img src="<?= URL::base() ?>assets/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar">
													<i></i>
												</span>
										</div>

										<div class="media-body">
											<h6 class="media-heading">Didier FOTSO</h6>
											<p class="notification-text font-small-3 text-muted">Le trimestre dernier était ...</p><small>
											<time class="media-meta text-muted" datetime="2020-06-11T18:29:20+08:00">Mois dernier</time></small>
										</div>
									</div>
								</a>
							</li>

							<li class="dropdown-menu-footer">
								<a class="dropdown-item text-muted text-center" href="">Lire tout...</a>
							</li>
						</ul> -->
					</li>

					<li class="dropdown dropdown-user nav-item">
						<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
								<span class="avatar avatar-online">
									<img src="<?= URL::res() . APP_RES_IMG_PROFILE.$_SESSION[S::PERS_PHOTO];?>" alt="avatar">
									<i></i>
								</span>
							<span class="user-name"> <?= $_SESSION[S::PERS_NOM].' '.$_SESSION[S::PERS_PRENOM] ;?></span>
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="">
								<i class="ft-user"></i>&nbsp;Mon compte
							</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item" href="<?= URL::link('logout');?>">
								<i class="ft-power"></i>&nbsp;Déconnexion
							</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
