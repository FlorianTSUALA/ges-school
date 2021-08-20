$annee_scolaires = ( new AnneeScolaireRepository() )->getActive();


        
$annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');


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
