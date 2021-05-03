<?php

namespace App\Controller;

use App\Helpers\S;
use Core\Model\Model;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Repository\PeriodeRepository;
use App\Repository\ParcoursRepository;
use App\Controller\Admin\AppController;
use App\Model\AffectationClasseMatiere;
use App\Repository\SalleClasseRepository;
use App\Repository\EnseignementRepository;
use App\Controller\EnseignementControllerTraitInitBulletinNote;

use function Core\Helper\dd;

class EnseignementController extends AppController
{
    use EnseignementControllerTraitInitBulletinNote;
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('matiere');
    }

    public function index()
    {
        $this->app->setTitle('Gestion des emploie de temps  - Ges-School');
        
        $this->render('sections.emploie_temps.emploie_temps');
        // $this->render('sections.emploie_temps.emploie_temps', compact('pays', 'classes', 'statut_apprenants'));
    }

 
    public function accueil()
    {
        $route = 'enseignement_accueil';
        $this->render('sections.enseignement.accueil', compact('route'));
    }


    public function note(){
        $route = 'note';
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $periodeOfSession  = (new PeriodeRepository())->getPeriodeOfSession($annee_scolaire_id);
        $data_salle_classes = (new SalleClasseRepository())->getSalles();
        $periodes = (new PeriodeRepository())->getPeriodes($annee_scolaire_id);
        
        $data_all = (new EnseignementRepository())->getEleveOfSalleOfClasseAndMatiereOfClasse($annee_scolaire_id);
        
        // dd($data_all);

        $this->render('sections.note.index', compact('route', 'data_salle_classes', 'data_all', 'periodeOfSession', 'periodes'));
    }
        
    public function apiInfoNoteSalle()
    {
        # DRAFT
    }
 
    
    public function apiInitNoteSalle()
    {
        # DRAFT

    }
      

    public function apiListeSalleMatiere()
    {
        # DRAFT
        
    }

    public function apiListeClasseMatiere()
    {
        //DRAFT
        $classe_id = Request::getSecParam('classe', NULL);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $model = AffectationClasseMatiere::table()
            ->select(
                [
                    'affectation_classe_matiere.classe_id' => 'classe', 
                    'affectation_classe_matiere.matiere_id' => 'matiere', 
                    'affectation_classe_matiere.coefficient' => 'coefficient' 
                ])
            ->where('affectation_classe_matiere.visibilite', 1)
            ->where('affectation_classe_matiere.annee_scolaire_id', $annee_scolaire_id);
        
        if(!is_null($classe_id))
            $model->where('affectation_classe_matiere.classe_id', $classe_id);
        
        $data = $model->get();
        $this->sendResponseAndExit(Helpers::toJSON($data), true);
    }
    
    public function apiListeClasseEleve()
    {
        # DRAFT
        $salle_classe_code = Request::getSecParam('salle_classe_id', NULL);
        $salle_classe_id = Model::getId(DBTable::SALLE_CLASSE, $salle_classe_code);
        
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $data = (new ParcoursRepository() )->getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id);

        $this->sendResponseAndExit(Helpers::toJSON($data), true);  
    }
    
    public function apiUpdateNoteEleveMatiere()
    {
        # DRAFT

    }
    
    public function apiUpdateNoteEleve()
    {
        # DRAFT

    }
    
    public function apiInfoNoteClasse()
    {
        # DRAFT

    }
 

    public function apiInitNoteClasse()
    {
        # DRAFT

    }

    public function apiInitNote()
    {
        # DRAFT

    }

}