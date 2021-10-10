<?php

namespace App\Controller;

use DateTime;
use App\Helpers\S;
use App\Model\Eleve;
use App\Model\Classe;
use Core\Routing\URL;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Parcours;
use App\Helpers\Helpers;
use App\Model\StatutEleve;
use App\Model\TypePension;
use App\Model\PensionEleve;
use App\Model\TypePaiement;
use App\Model\PensionClasse;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\DossierMedical;
use App\Model\DossierParental;
use App\Model\AntecedentScolaire;
use App\Model\Pays;
use App\Repository\EleveRepository;
use App\Repository\StatutApprenantRepository;

trait ExcellControllerTraitEleveLoader 
{
        
    public function loader_eleve()
    {
        $route = 'loader_eleve';
        $classes = Helpers::toJSON(Classe::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $pays = Helpers::toJSON(Pays::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $sexes = Helpers::toJSON([['id'=>'M', 'libelle' => 'Masculin'], ['id'=>'F', 'libelle' => 'Feminin']]);
        $this->render('sections.data_loader.eleve.index', compact('route', 'pays', 'classes', 'sexes'));
    }
     
        
    public function api_loader_eleve_api_display_data()
    {
        
    }
    
    public function api_loader_eleve_api_save($data_eleve)
    {
 
        for ($i = 0; $i <count($annee_scolaires); $i++){
            $nom = $data_eleve['nom'];
            $prenom = $data_eleve['prenom'];
            $date_naissance = $data_eleve['date_naissance'];
            $lieu_naissance = $data_eleve['lieu_naissance'];
            $pays_id = $data_eleve['nationalite'];
            $sexe = $data_eleve['sexe'];
            $classe_annee_encours = $data_eleve['classe_annee_encours'];
            $classe_anterieur = $data_eleve['classe_anterieur'];
            $inscription = $data_eleve['inscription'];
            $classe_id = Classe::table()->select()->where('libelle', $classe_annee_encours)->one();

            $eleve_id = $this->ajout_eleve($nom, $prenom, $date_naissance, $lieu_naissance, $pays_id, $sexe, $classe_anterieur);
            $this->inscription_eleve($eleve_id, $classe_id, $this->session->get(S::ANNEE_SCOLAIRE), $i);
        }
       
    }

    public function ajout_eleve($nom, $prenom, $date_naissance, $lieu_naissance, $pays_id, $sexe, $classe_anterieur){
           
        //ANTECEDANT SCOLAIRE
        $code_antecedent_scolaire = $this->antecedent_scolaire->genCode();
        $data_antecedent_scolaire = [
            'code' => $code_antecedent_scolaire,
            'classe' => $classe_anterieur,

        ];
        AntecedentScolaire::table()->insert($data_antecedent_scolaire)->execute();
        $id_antecedent_scolaire = $this->antecedent_scolaire->id($code_antecedent_scolaire);

        //DOSSIER MEDICAL
        $code_dossier_medical = DossierMedical::generateCode();
        $data_dossier_medical = [
            'code' => $code_dossier_medical,
        ];
        DossierMedical::table()->insert($data_dossier_medical)->execute();
        $id_dossier_medical = DossierMedical::get_id($code_dossier_medical);
        
        //DOSSIER PARENTAL
        $code_dossier_parental = DossierParental::generateCode();
        $data_dossier_parental = [
            'code' => $code_dossier_parental,
        ];
        DossierParental::table()->insert($data_dossier_parental)->execute();
        $id_dossier_parental = DossierParental::get_id($code_dossier_parental);

        //INFO ELEVE
        $eleve_code = Eleve::generateCode();
        $data_eleve = [
            'code' => $eleve_code,
            'matricule' => (new EleveRepository())->getMatricule(),
            'nom' => strtoupper($nom) ,
            'prenom' => ucfirst($prenom) ,
            'lieu_naissance' => $lieu_naissance,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe,
            'photo' => 'no-photo.jpg',
            Eleve::STATUT_ELEVE_ID => StatutEleve::get_id(StatutEleve::CODE_NOUVEAU),
            Eleve::DOSSIER_PARENTAL_ID => $id_dossier_parental,
            Eleve::GROUPE_FAMILIAL_ID => null,
            Eleve::DOSSIER_MEDICAL_ID => $id_dossier_medical,
            Eleve::ANTECEDENT_SCOLAIRE_ID => $id_antecedent_scolaire,
        ];
        Eleve::table()->insert($data_eleve)->execute();
        $eleve_id = Eleve::get_id($eleve_code);

        return $eleve_id;
    }

    public function inscription_eleve($eleve_id, $classe_id, $annee_scolaire_id, $index = 0)
    {

        $eleve = Eleve::table()->select()->where('visibilite', 1)->one();
        $type_pension_id = TypePension::get_id(TypePension::INSCRIPTION_CODE);
        $pension_classe = PensionClasse::table()
                                        ->select(
                                                [
                                                    'id',
                                                    'code',
                                                    'montant'
                                                ]
                                        )
                                        ->where('visibilite', 1)
                                        ->where('classe_id', $classe_id)
                                        ->where('annee_scolaire_id', $annee_scolaire_id)
                                        ->where('type_pension_id', $type_pension_id)
                                        ->one();
        $pension_classe_id = $pension_classe['id'];
        $montant_paye = $pension_classe['montant'];
        
        $nom_eleve =  $eleve['nom'] . ' ' . $eleve['prenom'];
        $reduction = 0;
        $date_facture = date('Y-m-d') ;
        $reference = Helpers::generateReference() . $index;
        $date_paiement = $date_facture;

        //Facture
            $model_facture = DBTable::getModel(DBTable::FACTURE);
            $code_facture = Facture::generateCode();
            $data_facture = [
                'code' => $code_facture,
                'type_paiement_id' => TypePaiement::get_id(TypePaiement::CODE_ESPECE),
                'libelle' => 'Facture versment',
                'reference' => $reference,
                'beneficiaire' => $nom_eleve,
                'gestionnaire' => $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM),
                'montant' => $montant_paye,
                'reduction' => $reduction,
                'date_facture' => $date_facture,
                'date_paiement' => $date_paiement,
                'eleve_id' => $eleve_id,
                'annee_scolaire_id' => $annee_scolaire_id,
                'description' => '',
            ];
            $model_facture->insert($data_facture)->execute();
            $facure_id = Facture::get_id($code_facture);
        //Facture

        //PENSION ELEVE
            {
                $motif = "Inscription";
                $quantite = 1;
                $montant = $montant_paye;
                $type_pension_id = $type_pension_id;
                $pension_classe_id = $pension_classe_id;

                $model_pension_eleve = PensionEleve::table();
                $code_pension_eleve = PensionEleve::generateCode();

                $data_pension_eleve_inscription = [
                    'code' => $code_pension_eleve,
                    'facture_id' => $facure_id,
                    'type_pension_id' => $type_pension_id,
                    'pension_classe_id' => $pension_classe_id,
                    'tranche_scolaire_id' => null,
                    'classe_id' => $classe_id,
                    'eleve_id' => $eleve_id,
                    'montant' => $montant,
                    'reduction' => $reduction,
                    'motif' => $motif,
                    'quantite' => $quantite
                ];
                $model_pension_eleve->insert($data_pension_eleve_inscription)->execute();
            }
        //PENSION ELEVE

        //  ##region INSCRIPTION PARCOURS 

            $model_parcours = Parcours::table();
            $code_parcours = Parcours::generateCode();
            $data_parcours = [
                'code' => $code_parcours,
                Parcours::ANNEE_SCOLAIRE_ID => $annee_scolaire_id,
                'date_inscription' => (new DateTime('NOW'))->format('Y-m-d H:i:s'),
                Parcours::ELEVE_ID => $eleve_id,
                Parcours::CLASSE_ID => $classe_id,
                Parcours::STATUT_APPRENANT_ID => (new StatutApprenantRepository())->getStatutApprenantId($eleve_id, $classe_id, $annee_scolaire_id),
            ];
            $model_parcours->insert($data_parcours)->execute();

            //MISE A JOUR DU #STATUT_ELEVE#
                if(is_null($eleve['statut_eleve_id'])){
                    Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                }else{
                    $statut_eleve_code = StatutEleve::table()->select('code')->where('statut_eleve.id', $eleve['statut_eleve_id'])->one()['code'];
                    if($statut_eleve_code == StatutEleve::CODE_DEMISSINAIRE){
                        Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_ANCIEN))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                    }else{
                        Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                    }
                }
        //  ##endregion INSCRIPTION PARCOURS 

        $result = true;
        if($result){
            $this->sendResponseAndExit(Helpers::toJSON('Versement enregistré avec sucess', TRUE));
        }else{
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistement à la base de données !!!', TRUE), false, 400, 'BD error : data '. $code);
        }

    }

    public function check_header_format_from_file()
    {
        # code...
    }

    public function load_data_from_file()
    {
        # code...
    }

    public function download_template_loader_eleve()
    {
        $this->download('excel/enregistrement_eleve.xlsx');
    }

}
    