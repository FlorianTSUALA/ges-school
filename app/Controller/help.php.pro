<?php
use App\Helpers\S;
use App\Model\Classe;
use Core\Model\Model;
use Core\Routing\URL;
use App\Model\DBTable;
use Core\Session\Request;
use App\Repository\AnneeScolaireRepository;

$annee_scolaires = ( new AnneeScolaireRepository() )->getActive();

$annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        
$annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');


$eleve_id = Eleve::table()->select('id')->where('code',$code)->where('visibilite', 1)->one()['id'];


$code_classe = $this->classe->code(Request::getSecParam('classe_eleve', ''), Classe::LIBELLE) ;

$msg_inscriptpion = 'Inscription Enregistrée avec success';
$data_inscriptpion = [];
$data_inscriptpion['msg_inscriptpion'] = 'Inscription Enregistrée';
$data_inscriptpion['code_classe'] = $code_classe;
$data_inscriptpion['code_eleve'] = $code_eleve;
$data_inscriptpion['nom_eleve'] = Request::getSecParam('nom_eleve', '') ;
$data_inscriptpion['prenom_eleve'] = Request::getSecParam('prenom_eleve', '') ;
// $data_inscriptpion['code_parcours'] = $code_parcours;
$data_inscriptpion['annee_scolaire'] = Request::getSecParam('annee_scolaire', '');
// $data_inscriptpion['code_annee_scolaire'] = $code_annee_scolaire;
$_SESSION[S::DATA_TRANSPORT] = $data_inscriptpion;

$location = URL::link('versement');

$this->renderAtLocation($location, 'sections.versement.versement_scolarite', compact('data_inscriptpion'));

$pension_classe_code = Request::getSecParam('pension_classe_id');

$type_pension_id = Model::getId(DBTable::TYPE_PENSION, $type_pension_code);
                