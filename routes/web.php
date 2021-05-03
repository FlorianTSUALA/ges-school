<?php

use App\Controller\ExcelController;

//START
    use App\Controller\ClubController;
    use App\Controller\HomeController;
    use App\Controller\PaysController;
    use App\Controller\TestController;
    use App\Controller\CoursController;
    use App\Controller\CycleController;
    use App\Controller\EleveController;
    use App\Controller\RepasController;
    use App\Controller\BiblioController;
    use App\Controller\ClasseController;
    use App\Controller\CantineController;
    use App\Controller\DomaineController;
    use App\Controller\MatiereController;
    use App\Controller\PeriodeController;
    use App\Controller\PrinterController;
    use App\Controller\SessionController;
    use App\Controller\ActiviteController;
    use App\Controller\BulletinController;
    use App\Controller\DocumentController;
    use App\Controller\PersonnelController;
    use App\Controller\ScolariteController;
    use App\Controller\VersementController;
    use App\Controller\Auth\LoginController;
    use App\Controller\DisciplineController;
    use App\Controller\EnseignementController;
    use App\Controller\ExemplaireController;
    use App\Controller\AffectationController;
    use App\Controller\EmploiTempsController;
    use App\Controller\InscriptionController;
    use App\Controller\ParametrageController;
    use App\Controller\SalleClasseController;
    use App\Controller\TypePensionController;
    use App\Controller\ComptabiliteController;
    use App\Controller\EmploieTempsController;
    use App\Controller\EtatDocumentController;
    use App\Controller\TypeActiviteController;
    use App\Controller\TypePaiementController;

    use App\Controller\AnneeScolaireController;
    use App\Controller\PensionClasseController;
    use App\Controller\TypePersonnelController;
    use App\Controller\PrixAbonnementController;
    use App\Controller\TrancheHoraireController;
    use App\Controller\StatutApprenantController;
    use App\Controller\TrancheScolaireController;
    use App\Controller\AbonnementActiviteController;
    use App\Controller\InscriptionActiviteController;
//END


//ACCUEIL
$router->addRoute('accueil', 'accueil', [HomeController::class, 'home']);

$router->addRoute('biblio_accueil', 'biblio/accueil', [BiblioController::class, 'accueil']);
$router->addRoute('cantine_accueil', 'cantine/accueil', [CantineController::class, 'accueil']);
$router->addRoute('club_accueil', 'club/accueil', [ClubController::class, 'accueil']);
$router->addRoute('personnel_accueil', 'personnel/accueil', [PersonnelController::class, 'accueil']);
$router->addRoute('enseignement_accueil', 'enseignant/accueil', [EnseignementController::class, 'accueil']);
$router->addRoute('bulletin_accueil', 'bulletin/accueil', [BulletinController::class, 'accueil']);
$router->addRoute('emploi_temps_accueil', 'emploi_temps/accueil', [EmploiTempsController::class, 'accueil']);
$router->addRoute('parametrage_accueil', 'parametrage/accueil', [ParametrageController::class, 'accueil']);
$router->addRoute('comptabilite_accueil', 'comptabilite/accueil', [ComptabiliteController::class, 'accueil']);
$router->addRoute('scolarite_accueil', 'scolarite/accueil', [ScolariteController::class, 'accueil']);


//LOGIN
$router->addRoute('login', '', [LoginController::class, 'index']);
$router->addRoute('postlogin', 'login', [LoginController::class, 'login']);
$router->addRoute('logout', 'logout', [LoginController::class, 'logout']);

//INSCRIPTION
$router->addRoute('inscrire', 'inscription', [InscriptionController::class, 'index']);
$router->addRoute('inscrire-create', 'inscription/create/', [InscriptionController::class, 'inscrire']);

// TEST SAVING WITH EXCEL
$router->addRoute('excell', 'excell', [ExcelController::class, 'excell']);

//ELEVE LIVE SEARCH
$router->addRoute('eleve-list-class', 'eleve/list/class/{code}', [EleveController::class, 'eleve_classe']);
$router->addRoute('eleve-list-all', 'eleve/list/class', [EleveController::class, 'eleve_classe']);
$router->addRoute('eleve_search_info', 'eleve_info/search/{search}', [EleveController::class, 'eleve_info']);
$router->addRoute('eleve_search_detail', 'eleve_detail/search/{code}', [EleveController::class, 'eleve_detail']);

//VERSEMENT
$router->addRoute('versement_accueil', 'versement/accueil', [VersementController::class, 'accueil']);
$router->addRoute('versement', 'versement', [VersementController::class, 'index']);
$router->addRoute('versement-create', 'versement/create/{code}', [VersementController::class, 'save']);
$router->addRoute('versement_facture', 'versement/print/{code}', [VersementController::class, 'imprimer_facture']);
$router->addRoute('versement-preview', 'versement/preview/{code}', [VersementController::class, 'preview']);

//LISTE VERSEMENT

$router->addRoute('versement-list_all', 'versement/list/all', [VersementController::class, 'list_all']);
// $router->addRoute('versement-list_info', 'versement/list/_info{code}', [VersementController::class, 'preview']);
$router->addRoute('versement-detail', 'versement/detal/{code}', [VersementController::class, 'detail']);


$router->addRoute('versement_liste_test', 'test/versement/list', [VersementController::class, 'liste_abonnee']);
$router->addRoute('versement_liste', 'versement/list', [VersementController::class, 'liste_abonnee']);
$router->addRoute('versement_info', 'versement/info/', [VersementController::class, 'info']);

$router->addRoute('versement_liste_test', 'test/versement/list', [VersementController::class, 'liste_abonnee']);
$router->addRoute('versement_liste', 'versement/list', [VersementController::class, 'liste_abonnee']);
$router->addRoute('versement_info', 'versement/info/', [VersementController::class, 'info']);

//PRINTER REPORT
$router->addRoute('print', 'print/{model}', [PrinterController::class, 'index']);

//ELEVE
$router->crudRoute('activite', ActiviteController::class);

//ELEVE
$router->crudRoute('type_activite', TypeActiviteController::class);

//ELEVE
$router->crudRoute('inscription_activite', InscriptionActiviteController::class);

//PRIX_ABONNEMENT
$router->crudRoute('prix_abonnement', PrixAbonnementController::class);

//ELEVE
$router->crudRoute('abonnement_activite', AbonnementActiviteController::class);

//ELEVE
$router->crudRoute('personnel_activite', AbonnementActiviteController::class);

//ELEVE
$router->crudRoute('eleve', EleveController::class);


//CLASS
$router->crudRoute('classe', ClasseController::class);

//SALLE DE CLASSE
$router->crudRoute('salle_classe', SalleClasseController::class);

//PENSION CLASSE
$router->crudRoute('pension_classe', PensionClasseController::class);

//DOCUMENT
$router->crudRoute('document', DocumentController::class);

//ETAT_DOCUMENT
$router->crudRoute('etat_document', EtatDocumentController::class);

//EXEMPLAIRE
$router->crudRoute('exemplaire', ExemplaireController::class);

//DOMAINE
$router->crudRoute('domaine', DomaineController::class);

//CYCLE
$router->crudRoute('cycle', CycleController::class);

//PERIODE
$router->crudRoute('periode', PeriodeController::class);
$router->addRoute('api_liste_periode', 'api/liste/periode', [PeriodeController::class, 'apiPeriodes']);
$router->addRoute('api_liste_periode_session', 'api/liste/session/periode', [PeriodeController::class, 'apiPeriodesOfSession']);

//SESSION
$router->crudRoute('session', SessionController::class);
$router->addRoute('api_liste_session', 'api/liste/session', [SessionController::class, 'apiListeSession']);

//REPAS
$router->crudRoute('repas', RepasController::class);

//STATUT_APPRENANT
$router->crudRoute('statut_apprenant', StatutApprenantController::class);

//PAYS
$router->crudRoute('pays', PaysController::class);


//ANNEE_SCOLAIRE
$router->crudRoute('annee_scolaire', AnneeScolaireController::class);

//TYPE_PAIEMENT
$router->crudRoute('type_paiement', TypePaiementController::class);


//TRANCHE_SCOLAIRE
$router->crudRoute('tranche_scolaire', TrancheScolaireController::class);

//TRANCHE_HORAIRE
$router->crudRoute('tranche_horaire', TrancheHoraireController::class);

//TYPE_PERSONNEL
$router->crudRoute('type_personnel', TypePersonnelController::class);

//TYPE_PENSION
$router->crudRoute('type_pension', TypePensionController::class);

//PERSONNEL
$router->crudRoute('personnel', PersonnelController::class);
$router->addRoute('ajout_personnel', 'personnel/nouveau', [PersonnelController::class, 'ajout']);
$router->addRoute('modifier_personnel', 'personnel/modifier/{code}', [PersonnelController::class, 'modifier']);
$router->addRoute('personnel_liste', 'personnel/detail', [PersonnelController::class, 'liste']);
$router->addRoute('personnel_salle_classe', 'personnel/salleclasse', [PersonnelController::class, 'liste_classe']);
$router->addRoute('personnel_api_get_all', 'personnel/api/all', [PersonnelController::class, 'getApiPersonnels']);
$router->addRoute('personnel_api_info', 'personnel/api/info/{code}', [PersonnelController::class, 'getApiPersonnel']);
$router->addRoute('personnel_api_delete_personnel', 'personnel/api/delete/personnel/{code}', [PersonnelController::class, 'apiDeletePersonnel']);
$router->addRoute('api_personnel_list', 'personnel/api/list', [PersonnelController::class, 'getApiAllEssentiel']);


//CANTINE
$router->crudRoute('cantine', CantineController::class);
$router->addRoute('abonnement_cantine', 'cantine/abonnement', [CantineController::class, 'abonnement_cantine']);
$router->addRoute('enregistrement_cantine', 'cantine/create/{code}', [CantineController::class, 'save']);
$router->addRoute('facture_cantine', 'cantine/facture/{code}', [CantineController::class, 'imprimer_facture']);
$router->addRoute('cantine_liste', 'cantine/detail', [CantineController::class, 'liste_abonnee']);
$router->addRoute('cantine_abonnement_info', 'cantine/abonnement_info/', [CantineController::class, 'abonnement_info']);


//BIBLIOTHEQUE
$router->addRoute('biblio_ajout_livre', 'biblio/ajout_livre', [BiblioController::class, 'ajouterLivre']);
$router->addRoute('biblio_ajout_exemplaire', 'biblio/ajout_exemplaire', [BiblioController::class, 'ajouterExemplaire']);
$router->addRoute('biblio_activite', 'biblio/activite', [BiblioController::class, 'activite']);
$router->addRoute('biblio_historique', 'biblio/historique', [BiblioController::class, 'afficherHistorique']);
$router->addRoute('biblio_dashboard', 'biblio/dashboard', [BiblioController::class, 'dashboard']);
$router->addRoute('biblio_emprunt', 'biblio/emprunt', [BiblioController::class, 'emprunt']);
$router->addRoute('biblio_api_emprunt_save', 'biblio/api/emprunt/save', [BiblioController::class, 'enregistrerEmprunt']);
$router->addRoute('biblio_api_emprunt_liste', 'biblio/api/emprunt/all', [BiblioController::class, 'getListeEmprunt']);
$router->addRoute('biblio_api_restitution', 'biblio/api/restitution/{code}', [BiblioController::class, 'enregistrerRestitution']);
$router->addRoute('biblio_api_alerte', 'biblio/api/alerte/{code}', [BiblioController::class, 'alerte']);



//AFFECTATION

//  SALLE *-* ENSEIGNANT
$router->addRoute('affectation_salle_enseignant', 'affectation/enseignant_salle', [AffectationController::class, 'affecterSalleEnseignant']);
$router->addRoute('affectation_salle_enseignant_update', 'api/affectation/enseignant_salle/update/', [AffectationController::class, 'modifierAffectationSalleEnseignant']);
$router->addRoute('affectation_salle_enseignant_all', 'api/affectation/enseignant_salle/all', [AffectationController::class, 'listeAffectationSalleEnseignant']);


//  SALLE *-* ELEVE
$router->addRoute('affectation_salle_eleve', 'affectation/eleve_salle', [AffectationController::class, 'affecterSalleEleve']);
$router->addRoute('affectation_salle_eleve_save', 'api/affectation/eleve_salle/save/', [AffectationController::class, 'enregistrerAffectationSalleEleve']);
$router->addRoute('affectation_salle_eleve_update', 'api/affectation/eleve_salle/update/', [AffectationController::class, 'modifierAffectationSalleEleve']);

$router->addRoute('api_info_affectation_eleve_salle_classe', 'api/info/affectation/eleve/salle/classe', [AffectationController::class, 'apiInfoAffectationEleveBySalleClasse']);
$router->addRoute('api_save_affectation_eleve_salle_classe', 'api/save/affectation/eleve/salle/classe', [AffectationController::class, 'apiSaveAffectationEleveBySalleClasse']);
$router->addRoute('api_info_affectation_eleve', 'api/info/affectation/eleve/', [AffectationController::class, 'apiInfoAffectationEleve']);

//  CLASSE *-* MATIERE
$router->addRoute('affectation_classe_matiere', 'affectation/classe_matiere', [AffectationController::class, 'affecterClasseMatiere']);
$router->addRoute('affectation_classe_matiere_save', 'api/affectation/classe_matiere/save', [AffectationController::class, 'enregistrerAffectationClasseMatiere']);
$router->addRoute('affectation_classe_matiere_delete', 'api/affectation/classe_matiere/delete', [AffectationController::class, 'supprimerAffectationClasseMatiere']);
$router->addRoute('affectation_classe_matiere_update', 'api/affectation/classe_matiere/update', [AffectationController::class, 'modifierAffectationClasseMatiere']);
$router->addRoute('affectation_classe_matiere_all', 'api/affectation/classe_matiere/all', [AffectationController::class, 'listeAffectationClasseMatiere']);
$router->addRoute('api_matiere_list', 'matiere/api/list', [MatiereController::class, 'getApiAllEssentiel']);


//NOTE: REMPLISSAGE DES NOTES SCOLAIRE
$router->addRoute('note', 'enseignement/note', [EnseignementController::class, 'note']);

$router->addRoute('api_liste_classe_matiere', 'api/liste/classe/matiere', [EnseignementController::class, 'apiListeClasseMatiere']);
$router->addRoute('api_liste_classe_eleve', 'api/liste/classe/eleve', [EnseignementController::class, 'apiListeClasseEleve']);
$router->addRoute('api_liste_salle_matiere', 'api/liste/salle/matiere', [EnseignementController::class, 'apiListeSalleMatiere']);
$router->addRoute('api_update_note_eleve_matiere', 'api/update/note/eleve/matiere', [EnseignementController::class, 'apiUpdateNoteEleveMatiere']);
$router->addRoute('api_update_note_eleve', 'api/update/note/eleve', [EnseignementController::class, 'apiUpdateNoteEleve']);
$router->addRoute('api_info_note_classe', 'api/info/note/classe', [EnseignementController::class, 'apiInfoNoteClasse']);
$router->addRoute('api_info_note_salle', 'api/info/note/salle', [EnseignementController::class, 'apiInfoNoteSalle']);
$router->addRoute('api_init_note', 'api/init/note', [EnseignementController::class, 'apiInitNote']);
$router->addRoute('api_init_note_classe', 'api/init/note/classe', [EnseignementController::class, 'apiInitNoteClasse']);
$router->addRoute('api_init_note_salle', 'api/init/note/salle', [EnseignementController::class, 'apiInitNoteSalle']);

//BULLETIN
$router->crudRoute("bulletin", BulletinController::class);
$router->addRoute('bullettin_preview_salle', 'bullettin/preview/salle', [BulletinController::class, 'bullettinPreviewSalle']);
$router->addRoute('bullettin_preview_note_eleve', 'bullettin/preview/note/eleve', [BulletinController::class, 'bullettinPreviewNoteEleve']);
$router->addRoute('bullettin_generate_note_eleve', 'bullettin/generate/note/eleve', [BulletinController::class, 'bullettinGenerateNoteEleve']);
$router->addRoute('bulletin_info_classement', 'bulletin/info/classement', [BulletinController::class, 'bulletinInfoClassement']);
$router->addRoute('bulletin_info_classement_classe', 'bulletin/info/classement/classe', [BulletinController::class, 'bulletinInfoClassementClasse']);
$router->addRoute('bulletin_info_classement_salle', 'bulletin/info/classement/salle', [BulletinController::class, 'bulletinInfoClassementSalle']);
$router->addRoute('bulletin_info_classement_annee', 'bulletin/info/classement/annee', [BulletinController::class, 'bulletinInfoClassementAnnee']);
$router->addRoute('bulletin_info_classement_annee_classe', 'bulletin/info/classement/annee/classe', [BulletinController::class, 'bulletinInfoClassementAnneeClasse']);
$router->addRoute('bulletin_info_classement_annee_salle', 'bulletin/info/classement/annee/salle', [BulletinController::class, 'bulletinInfoClassementAnneeSalle']);
$router->addRoute('bulletin_info_classement_annee_periode', 'bulletin/info/classement/annee/periode', [BulletinController::class, 'bulletinInfoClassementAnneePeriode']);
$router->addRoute('bulletin_info_classement_annee_periode_classe', 'bulletin/info/classement/annee/periode/classe', [BulletinController::class, 'bulletinInfoClassementAnneePeriodeClasse']);
$router->addRoute('bulletin_info_classement_annee_periode_salle', 'bulletin/info/classement/annee/periode/salle', [BulletinController::class, 'bulletinInfoClassementAnneePeriodeSalle']);

//COURS - AFFECTATION DES MATIERES AUX ENSEIGNANTS DANS DES CLASSES
$router->crudRoute('cours', CoursController::class);

//DISCIPLINE
$router->crudRoute('discipline', DisciplineController::class);

//MATIERE
$router->crudRoute('matiere', MatiereController::class);


//EMPLOIE DE TEMPS
$router->crudRoute('emploie_temps', EmploieTempsController::class);

// FOR DEVELOPEMENT TEST FUNCTION
$router->addRoute('test', 'test', [TestController::class, 'test']);
$router->addRoute('testr', 'testr', [TestController::class, 'testr']);
$router->addRoute('test-sql', 'testsql', [TestController::class, 'testSQL']);
$router->addRoute('test-pdf', 'testpdf', [TestController::class, 'testpdf']);
$router->addRoute('test-alert', 'test', [TestController::class, 'testAlert']);
$router->addRoute('testa', 'testa', [TestController::class, 'testA']);
$router->addRoute('testb', 'testb', [TestController::class, 'testB']);
$router->addRoute('testc', 'testc', [TestController::class, 'testC']);

