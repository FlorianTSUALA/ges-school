<?php 

use App\Helpers\S;
use Core\Routing\URL; 

/*

    Varaible in this page
*****************************

reference
solde_paye
long_date_facture
eleve
classe
sous_total
reduction
reste
montant_paye
        
data_items  ****************
            date_debut
            date_fin
            quantite
            periode
            prix_unitaire
            sous_total
            resume
            sous_total
            ****************

*****************************


*/
    
    ?>

<!-- <link rel="stylesheet" type="text/css" href="http://127.0.0.1/ges-school/public/assets/app-assets/images/logo/cantineList2.css"> -->
<style type="text/css">
table, th, td, tbody {
  border: 0px solid black;
  border-collapse: collapse;
  margin-bottom: 0px;
  padding-bottom: 8px;
}
th, tr, td {
  padding: 0px;
  text-align: left;    
}


.table {
  width: 100%;
  margin-bottom: 0px;
}

</style>
<page >

<table  style="width:100%;">
    <tr>
        <td  rowspan="3"  style="width: 13%"><img src="<?= URL::base() ?>/assets/app-assets/images/logo/logo-80x80.png"> </td>
        <td style="text-align: left;    width: 22%"><b>Ges-School1</b></td>
        <td style="text-align: right;    width: 65%">  <b>REÇU DE PAIEMENT</b> </td>
    </tr>
  
    <tr>
        <td>Batterie 4</td>
        <td  style="text-align: right;">  <?= $data['reference'] ?></td>
    </tr>    
   
    <tr>
        <td>Libreville, Gabon</td>
        <td  style="text-align: right;"><strong class="text-danger" >Solde à payer: <?= $data['montant_paye'] ?> CFA</strong></td>
        
    </tr> 

    <tr>
        <td colspan="2" style="text-align: left; padding: 4px;"><strong class="text-danger" >Facture de</strong></td>
        <td  style="text-align: right;">Date de facturation :<strong class="text-danger" > <?= $data['long_date_facture'] ?> </strong></td>
    </tr> 

    <tr>
        <td colspan="2" style="text-align: left;">Elève : <strong class="text-danger" > <?= $data['eleve'] ?>  </strong></td>
        <td  style="text-align: left;">Classe : <strong class="text-danger" > <?= $data['classe'] ?></strong></td> 
    </tr> 

    
    

    <!-- <tr>
        <td colspan="3" style="text-align: left;">Classe : <strong class="text-danger" > <?= $data['classe'] ?></strong></td>
    </tr>  -->


</table>
      
<table cellspacing='0' style="width:100%; " class="table" >
    <colgroup>
        <col style="width: 8%">
        <col style="width: 47%">
        <col style="width: 15%">
        <col style="width: 15%">
        <col style="width: 15%">
    </colgroup>
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Object et description</th>
            <th>Montant</th>
            <th>Quantité</th>
            <th>Montant total</th>
        </tr>
    </thead>
    <tbody>

    <?= $data['html_table_body'] ?>

    </tbody>
    
</table>

<table  style="width:100%;">
    <tr>
        <td style="text-align: left;    width: 55%"></td>
        <td style="text-align: left;    width: 20%"></td>
        <td style="text-align: right;    width: 25%"></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left;" colspan="2" ><b>Montant total du versement</b></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Sous-Total</td>
        <td style="text-align: right;"><?= $data['montant_paye'] - $data['reduction'] ?> CFA</td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Remise</td>
        <td style="text-align: right;"><?= $data['reduction'] ?> CFA</td>
    </tr>
    <!-- <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Reste</td>
        <td style="text-align: right;"><?= $data['reste'] ?></td>
    </tr> -->
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;"><b>Solde à payer</b></td>
        <td style="text-align: right;"><b> <?= $data['montant_paye'] ?> CFA</b></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; "></td>
    </tr>
    <tr>
        <td style="text-align: left; padding: 4px;"><b>Conditions générales</b></td>
        <td style="text-align: right; "> <?= $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM) ?> </td>
        
    </tr>
    <tr>
        <td style="text-align: left;"><i>Après paiement, votre argent est non-remboursable.</i></td>
        <td style="text-align: center; "> <?=  $this->session->get(S::PERS_TYPE_PERSONNEL)  ?> </td>
    </tr>
    


</table>

<hr>
<table  style="width:100%;">
    <tr>
        <td  rowspan="3"  style="width: 13%"><img src="<?= URL::base() ?>/assets/app-assets/images/logo/logo-80x80.png"> </td>
        <td style="text-align: left;    width: 22%"><b>Ges-School1</b></td>
        <td style="text-align: right;    width: 65%">  <b>REÇU DE PAIEMENT</b> </td>
    </tr>
  
    <tr>
        <td>Batterie 4</td>
        <td  style="text-align: right;">  <?= $data['reference'] ?></td>
    </tr>    
   
    <tr>
        <td>Libreville, Gabon</td>
        <td  style="text-align: right;"><strong class="text-danger" >Solde à payer: <?= $data['montant_paye'] ?> CFA</strong></td>
        
    </tr> 

    <tr>
        <td colspan="2" style="text-align: left; padding: 4px;"><strong class="text-danger" >Facture de</strong></td>
        <td  style="text-align: right;">Date de facturation :<strong class="text-danger" > <?= $data['long_date_facture'] ?> </strong></td>
    </tr> 

    <tr>
    
    <td colspan="2" style="text-align: left;">Elève : <strong class="text-danger" > <?= $data['eleve'] ?></strong></td>
    <td style="text-align: left;">Classe : <strong class="text-danger" > <?= $data['classe'] ?></strong></td>
   
    </tr> 

    <!-- <tr>
        <td colspan="3" style="text-align: left;">Classe : <strong class="text-danger" > <?= $data['classe'] ?></strong></td>
    </tr>  -->

</table>
      
<table cellspacing='0' style="width:100%; ">
    <colgroup>
        <col style="width: 8%">
        <col style="width: 47%">
        <col style="width: 15%">
        <col style="width: 15%">
        <col style="width: 15%">
    </colgroup>
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Object et description</th>
            <th>Montant</th>
            <th>Quantité</th>
            <th>Montant total</th>
        </tr>
    </thead>
    <tbody >

    <?= $data['html_table_body'] ?>

    </tbody>
    
</table>

<table  style="width:100%;">
    <tr>
        <td style="text-align: left;    width: 55%"></td>
        <td style="text-align: left;    width: 20%"></td>
        <td style="text-align: right;    width: 25%"></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left;" colspan="2" ><b>Montant total du versement</b></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Sous-Total</td>
        <td style="text-align: right;"><?= $data['montant_paye'] - $data['reduction'] ?> CFA</td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Remise</td>
        <td style="text-align: right;"><?= $data['reduction'] ?> CFA</td>
    </tr>
    <!-- <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;">Reste</td>
        <td style="text-align: right;"><?= $data['reste'] ?></td>
    </tr> -->
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; padding: 5px 10px 5px 5px;"><b>Solde à payer</b></td>
        <td style="text-align: right;"><b> <?= $data['montant_paye'] ?> CFA</b></td>
    </tr>
    <tr>
        <td style="text-align: left;"></td>
        <td style="text-align: left; "></td>
    </tr>
    <tr>
        <td style="text-align: left; padding: 4px;"><b>Conditions générales</b></td>
        <td style="text-align: right; "> <?= $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM) ?> </td>
        
    </tr>
    <tr>
        <td style="text-align: left;"><i>Après paiement, votre argent est non-remboursable.</i></td>
        <td style="text-align: center; "><?= $this->session->get(S::PERS_TYPE_PERSONNEL) ?></td>
    </tr>
    


</table>
<page_footer>
    <!-- <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="text-align: left;     width: 60%"></td>
            <td style="text-align: center;    width: 40%" colspan="2" >Personne habilitée</td>
        </tr>
        <tr>
            <td style="text-align: left;"></td>
            <td style="text-align: center;" colspan="2" > <?= $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM) ?> </td>
        </tr>
        <tr>
            <td style="text-align: left;"></td>
            <td style="text-align: center;" colspan="2" >Le Sécrétariat</td>
        </tr>
        <tr>
            <td style="text-align: left;"></td>
            <td style="text-align: right;" colspan="2" ></td>
        </tr>

        <tr>
            <td style="text-align: left;"><b>Conditions générales</b></td>
            <td style="text-align: right;" colspan="2" ></td>
        </tr>
        <tr>
            <td style="text-align: left;">Après paiement, votre argent est non-remboursable.</td>
            <td style="text-align: right;" colspan="2" ></td>
        </tr>

        <!-- <tr>
            <td style="text-align: left;    width: 50%">Facture de paiement</td>
            <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
        </tr> -->
         <!--  </table> -->
</page_footer>

</page>