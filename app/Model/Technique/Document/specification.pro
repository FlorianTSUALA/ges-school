---> fichier de presentation
    - liste_abonnement
    - paiement_abonnement

--------------------------------

---> fichier de scripts
    - liste_abonnement
    - script-paiement_abonnement-save



@TODO
<?php
    /**
     * KGS ~ SECURITY TIMELESS
     */
    $_SESSION[Session::AVOID_ACTION] = false;
    $_SESSION[Session::PAGE_ACTION] = Page::Proprietaire_TRANSACTION;
    $arrayKGStimeSession = [Session::CONNECTED];

    timeoutSession($arrayKGStimeSession, Page::Proprietaire_TRANSACTION);
?>
