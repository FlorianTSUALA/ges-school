PrixAbonnementController => best expresion hydrahn request model


Periode => date ui format

tranche_scolaire => multiple select 2 model



        if (fromInscription) {
            $(eleve_nom_complet).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_ELEVE); ?>").trigger('change')
            // $(classe).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_CLASSE); ?>").trigger('change')
            // $(statut_apprenant).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_STATUT_APPRENANT); ?>").trigger('change')
            fromInscription = false;
        }


C:\laragon\www\ges-school\Documentation\Robust\html\ltr\vertical-multi-level-menu-template\dashboard-crm.html



'personnel_id' => Personnel::get_id($this->session->get(S::PERS_CODE)),
'eleve_id' => Eleve::get_id($code),
'annee_scolaire_id' => ($this->session->get(S::ANNEE_SCOLAIRE)),