<?php

namespace App\Model;

interface Common
{
   const ID = "id";
   const CODE = "code";
   const CREER_PAR = "creer_par";
   const DATE_CREATION = "date_creation";
   const MODIFIER_PAR = "modifier_par";
   const DATE_MODIFICATION = "date_modification";
   const SUPPRIMER_PAR = "supprimer_par";
   const DATE_SUPPRESSION = "date_suppression";
   const VISIBILITE = "visibilite";

/*   public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(true,self::ID),
            new FormModel(true,self::CODE),
            new FormModel(true,self::CREER_PAR,'Créer par', InputType::TEXT),
            new FormModel(true,self::DATE_CREATION,'Date de création', InputType::DATE),
            new FormModel(true,self::MODIFIER_PAR,'Modifier par', InputType::TEXT),
            new FormModel(true,self::DATE_MODIFICATION,'Date de modification', InputType::DATE),
            new FormModel(true,self::SUPPRIMER_PAR,'Supprimer par', InputType::EMAIL),
            new FormModel(true,self::DATE_SUPPRESSION,'Date de suppression', InputType::DATE),
            new FormModel(true,self::VISIBILITE),

        ];
}*/

}