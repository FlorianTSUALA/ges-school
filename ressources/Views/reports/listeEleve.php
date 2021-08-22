<?php 

use Core\Routing\URL;   
?>

<!-- <link rel="stylesheet" type="text/css" href="http://127.0.0.1/ges-school/public/assets/app-assets/images/logo/cantineList2.css"> -->
<style type="text/css">
table, th, td, tbody {
  border: 1px solid black;
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

    
   

</table>
      
<table  style="width:100%; " class="table" >
    <colgroup>
        <col style="width: 10%">
        <col style="width: 40%">
        <col style="width: 40%">
        <col style="width: 10%">
    </colgroup>
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Sexe</th>
        </tr>
    </thead>
    <tbody>

    <tr>
                    <th scope="row">1</th>
                    <td>KAKAMBI</td>
                    <td>Franck</td>
                    <td>M</td>


     </tr>

    </tbody>
    
</table>


<page_footer>
   
</page_footer>

</page>