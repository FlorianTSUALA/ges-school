<?php

namespace App\Controller;

use App\Helpers\Helpers;
use Core\Session\Request;
use App\Model\ModeleMessage;
use function Core\Helper\dd;
use App\Controller\Admin\AppController;

use App\Model\AffectationClasseMatiere;
use App\Repository\ModeleMessageRepository;

class ModeleMessageController extends AppController
{

    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('modele_message');
    }

    public function index()
    {
        $this->app->setTitle('Gestion des modeles de messages  - ' . $this->organisation);
        $route = 'modele_message';

        $data_modele_message = $this->getTypeModeleMessage();

        $this->render('sections.modele_message.index', compact('route', 'data_modele_message'));
    }


    public function preview()
    {
        $route = 'enseignement_accueil';
        $this->render('sections.enseignement.accueil', compact('route'));
    }

    public function edit()
    {
        # DRAFT
    }


    public function api_detail()
    {
        # DRAFT

    }


    public function api_delete()
    {
        # DRAFT

    }

    public function api_update()
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
                ]
            )
            ->where('affectation_classe_matiere.visibilite', 1)
            ->where('affectation_classe_matiere.annee_scolaire_id', $annee_scolaire_id);

        if (!is_null($classe_id))
            $model->where('affectation_classe_matiere.classe_id', $classe_id);

        $data = $model->get();
        $this->sendResponseAndExit(Helpers::toJSON($data), true);
    }

    public function getTypeModeleMessage(){
        return [
            'ELEVE_INFO' =>[
                    'NOM' => 'Modele Eleves',
                    'CODE' => 'ELEVE_INFO',
                    // 'FONCTION' => 'eleve_info_modele_messages',
                    'MODELE_MESSAGE' => ModeleMessage::table()->select(['code' => 'id', 'message', 'description'])->where('code_type_modele_message', 'ELEVE_INFO')->where('visibilite', 1)->get(),
                    'DATA' => (new ModeleMessageRepository)->get_eleve_detail_all(),
                    'ATTRIBUT' => [
                        'pays_mere',
                        'pays_pere',
                        'email',
                        'ecole',
                        'classe_precedente',
                        'telephone',
                        'allergie',
                        'groupe_sanguin',
                        'maladie_recurrente',
                        'probleme_particulier',
                        'nom_medecin',
                        'telephone_medecin',
                        'email_medecin',
                        'autres',
                        'matricule',
                        'nom',
                        'surnom',
                        'prenom',
                        'nom_complet',
                        'sexe',
                        'date_naissance',
                        'lieu_naissance',
                        'anciennete',
                        'photo',
                        'statut_eleve_id',
                        'statut_eleve',
                        'id',
                        'classe',
                        'salle_classe',
                    ],
            ],



        ];
    }

}
