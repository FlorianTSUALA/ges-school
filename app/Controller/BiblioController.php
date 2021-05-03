<?php

namespace App\Controller;

use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Emprunt;
use Config\Invariant\API;
use App\Helpers\Helpers;
use App\Model\EnumModel;
use App\Model\Exemplaire;
use Core\Session\Request;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Repository\EleveRepository;
use App\Helpers\TraitCRUDController;
use App\Repository\BiblioRepository;
use App\Repository\DocumentRepository;
use App\Repository\ExemplaireRepository;
use App\Controller\Admin\AppController;

class BiblioController extends AppController
{

    private $biblio_repository;
    // use TraitCRUDController;
    public function __construct()
    {
        parent::__construct();
        $this->biblio_repository = new BiblioRepository;

        // @TODO
        // $this->vairant = DBTable::ABONNEMENT_biblio;
        $this->folder_view_index = 'biblio.abonnement_biblio';

        // $this->loadModel($this->vairant);
        $this->base_route = 'abonnement_biblio';
        $this->class_name = 'abonnement_biblio';

        $this->title_page = 'Gestion du abonnement_biblio - Ges-School';
        $this->title_home = 'Gestion du abonnement_biblio';
        $this->create_title = "Ajout d'un abonnement_biblio";
        $this->view_title = "Information sur un abonnement_biblio";
        $this->update_title = "Mise à jour des informations du perosnnel";
        $this->delete_title = "Suppression du abonnement_biblio";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce abonnement_biblio ";
        
    }
    
    
    public function accueil()
    {
        $exemple = [];
        $this->render('sections.biblio.accueil', compact('exemple'));
    }
    
    
    public function ajouterLivre()
    {
        # code... 
    }

    public function ajouterExemplaire()
    {
        # code... 
    }

    public function activite()
    {
        # code... 
    }

    public function afficherHistorique()
    {
        # code... 
    }

    public function dashboard()
    {
        # code... 
    }

    public function emprunt()
    {
        $route = 'biblio_emprunt';
        $domaines = (new DocumentRepository())->getDocumentGroupByDomaine();
        $documents = (new DocumentRepository())->getDocument();
        $exemplaire_disponibles = (new DocumentRepository())->getExemplaire($disponible = true);
        $exemplaires = (new DocumentRepository())->getExemplaire();
        $etat_documents = (new DocumentRepository())->getEtatDocument();
        $eleves = (new EleveRepository() )->getInfoPerso();
        $this->render('sections.biblio.emprunt_exemplaire', compact('route', 'domaines', 'eleves', 'exemplaires', 'exemplaire_disponibles', 'documents', 'etat_documents'));
    }

    public function getListeEmprunt()
    {
        $data = (new ExemplaireRepository())->getAllEmprunt();

        $results[API::TAG_DATA] = $data;
        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($data);
        $results[API::TAG_DATATABLE_RF] = count($data);
        $results[API::TAG_DATA] = $data;
        echo Helpers::toJSON($results) ;
    }

    public function enregistrerEmprunt()
    {
        
        $data = $_POST;
        
        $eleve_code = Request::getSecParam('id_eleve');
        $eleve_id = Model::getId(DBTable::ELEVE, str_replace('RF-', '', $eleve_code));

        $date_emprunt = Request::getSecParam('date_emprunt');
        $date_retour = Request::getSecParam('date_retour');
        
        $livres = $data['livres'];
        $isFail = false;

        foreach($livres as $key => $livre){

            // vd($livre);
            
            $etat_document_code = $livre['etat_livre'];
            $exemplaire_code = $livre['code_livre'];
            
            $etat_document_id = Model::getId(DBTable::ETAT_DOCUMENT, $etat_document_code);
            $exemplaire_id = Model::getId(DBTable::EXEMPLAIRE, $exemplaire_code);

            //MISE A JOUR
            $exemplaire = Exemplaire::table();
            $exemplaire->update([
                                    'etat_document_id' => $etat_document_id, 
                                    'statut' => EnumModel::STATUT_DOCUMENT_EMPRUNTE
                                ])
            ->where('id', $exemplaire_id)
            ->execute();

            //INSERTION EMPRUNT
            $emprunt = Emprunt::table();
            $data_emprunt = [
                'code' => Emprunt::generateCode(),
                'eleve_id' => $eleve_id,
                'exemplaire_id' =>  $exemplaire_id,
                'etat_document_id' =>  $etat_document_id,
                'date_emprunt' =>  $date_emprunt,
                'date_expiration' =>  $date_retour,
            ];
            $emprunt->insert($data_emprunt)->execute();
            
        }
        
        if (!$isFail) {
            $this->sendResponseAndExit(Helpers::toJSON('Emprunt enregistrée avec success', TRUE));
        } else {
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistement à la base de données !!!', TRUE), false, 400, 'BD error : data '. $eleve_code);
        }
    }

    public function emprunt_exemplaire()
    {
        # code... 
    }
    
    public function restitution($code)
    {
        # code... 
    }

    public function alerte($code)
    {
        # code... 
    }


}
