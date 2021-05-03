<?php

namespace App\Report;

use App\Helpers\S;
use FPDF\PhpInvoice;
use Core\Session\Session;

class FactureVersement extends Report{


    public function index($reference="INV-55033645"){
        $invoice = new PhpInvoice();

        $date = Session::get(S::FAC_DATE);//date('M dS ,Y', time());
        $nom = Session::get(S::FAC_NOM);
        $prenom = Session::get(S::FAC_PRENOM) ;
        $classe = Session::get(S::FAC_CLASSE);
        $ref = Session::get(S::FAC_REF);


        $items = Session::get(S::FAC_PENSION);
        $activites = Session::get(S::FAC_ACTIVITE);
        $cantines = Session::get(S::FAC_CANTINE);
        $autres = Session::get(S::FAC_AUTRE);
        //$motif = "Tranche d'inscription";
        //$des_motif = "Tranche spéciale réservé à l'inscription de l'élève";
        // $prix = 580;
        // $total = 13480;
        // $quantite = 4;
        // $reduction = 10;
        $grand_total = 0;
        // $remise = 320;




        /* Header Settings */
        // $invoice->setTimeZone('America/Los_Angeles');
        $invoice->setLogo( $this->path_res."images/example2.png");
        $invoice->setColor("#f7540e");
        $invoice->setType("RECU DE VERSEMENT");
        $invoice->setReference($ref);
        $invoice->setDate($date);
        $invoice->setFrom(array("Ges-School","Batterie 4","Libreville , Gabon"));
        $invoice->setTo(array( $nom.' '.$prenom ,$classe,""));

        $i = 0;
        //var_dump($items);
        foreach($items as $item)
        {
            ++$i;
            if($item['state'] == 'true'){
                $_est_mensuel    = $item['est_mensuel'];
                $_montant =  $item['montant'];
                $_mensualite = $item['mensualite'];

                $tmp_montant = 0;

                $_recapitulatif = $item['recapitulatif'];
                $periode  = ' ';
                $size = count($item['multiplicateur']) ;
                if(isset($item['multiplicateur']) && is_array($item['multiplicateur']) && $size > 0){
                    $_recapitulatif = isset($_recapitulatif)? 0 : $_recapitulatif;
                    $tmp_montant = $_mensualite;


                    $i = 0;

                    foreach( $item['multiplicateur'] as $key => $tranche)
                    {
                        // var_dump($tranche);
                        $periode  = 'Pension des tranche(s) suivante(s) : ';
                        if($size == ++$i){
                            $periode .= $tranche['value'].'.';
                        }else{
                            $periode .= $tranche['value'] .', ';
                        }
                    }
                }else{
                    $tmp_montant = $_montant;
               }
               $_recapitulatif = (isset($_recapitulatif))? 1 : $_recapitulatif;

               $sub_total = $tmp_montant * $_recapitulatif;

               $invoice->addItem("Pension : ".$item['type_pension'], $periode, $_recapitulatif, 0, $tmp_montant, 0, $sub_total);
            //    $invoice->addItem($motif, $periode, $_recapitulatif, $reduction, $tmp_montant, $remise, $sub_total);

                $grand_total += $sub_total;

            }
        }/* Adding $Items in table */

        //----- |||| ------ //
        //----- |||| ------ //
        //----- |||| ------ //
        //Cantines
        {
            ++$i;
            $item = $cantines ;
            $_est_mensuel = $item['est_mensuel'];
            $_montant = $item['montant'];
            $_mensualite = $item['mensualite'];
            $recapitulatif = $item['recapitulatif'];
            $recapitulatif = $recapitulatif? 0 : $recapitulatif;
            $remise = $item['remise'];
            $remise = $remise? 0 : $remise;

            $_est_mensuel    = $item['est_mensuel'];
            $_montant =  $item['montant'];
            $_mensualite = $item['mensualite'];

            $tmp_montant = 0;

            $_recapitulatif = $item['recapitulatif'];
            $periode  = ' ';
            $size = count($item['multiplicateur']) ;
            if(isset($item['multiplicateur']) && is_array($item['multiplicateur']) && $size > 0){
                $_recapitulatif = isset($_recapitulatif)? 0 : $_recapitulatif;
                $tmp_montant = $_mensualite;

                $i = 0;

                foreach( $item['multiplicateur'] as $key => $tranche)
                {
                    // var_dump($tranche);
                    $periode  = 'Pension des tranche(s) suivante(s) : ';
                    if($size == ++$i){
                        $periode .= $tranche['value'].'.';
                    }else{
                        $periode .= $tranche['value'] .', ';
                    }
                }
            }else{
                $tmp_montant = $_montant;
            }
            $_recapitulatif = (isset($_recapitulatif))? 1 : $_recapitulatif;

            $sub_total = $tmp_montant * $_recapitulatif;

            $invoice->addItem("Pension : ".$item['type_pension'], $periode, $_recapitulatif, 0, $tmp_montant, 0, $sub_total);
            $grand_total += $sub_total;
        }


        //Activite
        {
            ++$i;
            $item = $activites ;
            $_est_mensuel = $item['est_mensuel'];
            $_montant = $item['montant'];
            $_mensualite = $item['mensualite'];
            $recapitulatif = $item['recapitulatif'];
            $recapitulatif = $recapitulatif? 0 : $recapitulatif;
            $remise = $item['remise'];
            $remise = $remise? 0 : $remise;

            $_est_mensuel    = $item['est_mensuel'];
            $_montant =  $item['montant'];
            $_mensualite = $item['mensualite'];

            $tmp_montant = 0;

            $_recapitulatif = $item['recapitulatif'];
            $periode  = ' ';
            $size = count($item['activites']) ;
            if(isset($item['activites']) && is_array($item['activites']) && $size > 0){
                $_recapitulatif = isset($_recapitulatif)? 0 : $_recapitulatif;
                $tmp_montant = $_mensualite;

                $i = 0;
//                Pension des activités : '+msg+'
                $msg  = 'Pension des tranche(s) suivante(s) : ';
                foreach( $item['activites'] as $key => $tranche)
                {
                    // var_dump($tranche);
                    if($size == ++$i){
                        $msg .= $tranche['value'].'.';
                    }else{
                        $msg .= $tranche['value'] .', ';
                    }
                }

                $periode  = ' ';
                foreach( $item['multiplicateur'] as $key => $tranche)
                {
                    // var_dump($tranche);
                    if($size == ++$i){
                        $periode .= $tranche['value'].'.';
                    }else{
                        $periode .= $tranche['value'] .', ';
                    }
                }
            }else{
                $tmp_montant = $_montant;
            }
            $_recapitulatif = (isset($_recapitulatif))? 1 : $_recapitulatif;

            $sub_total = $tmp_montant * $_recapitulatif;

            $invoice->addItem("Pension des activités : ".$msg . ", pour les tranches : ". $periode, $periode, $_recapitulatif, 0, $tmp_montant, 0, $sub_total);
            $grand_total += $sub_total;
        }




        $current = $autres ;
        $_montant = $current['multiplicateur'];
        $_montant = $_montant ? 0 : $_montant;
        $_remise = $current['remise'];
        $_remise = $_remise? 0 : $_remise;
        $sub_total = $recapitulatif - $remise;
        if($_montant !== 0){
            $invoice->addItem( $current['type_pension'], '', $_recapitulatif, 0, $recapitulatif, 0, $sub_total);
        }




        /* Add totals */


        $invoice->addTotal("Total",$grand_total,true);
        /* Set badge */
        $invoice->addBadge("payer comptant");
        /* Add title */
        $invoice->addTitle("Note Importante                                                                                                                                             Secretariat");
        /* Add Paragraph */
        $invoice->addParagraph("Apres paiement, votre argent est non-remboursable.");
        /* Set footer note */
        // $invoice->setFooternote("Ges-School");


        /* Render */
        $invoice->render('facture.pdf','I'); /* I => Display on browser, D => Force Download, F => local path save, S => return document path */
    }

}