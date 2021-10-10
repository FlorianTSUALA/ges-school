r<?php 

use App\App;
use App\Helpers\S;
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
        <td style="text-align: left;    width: 22%"><b> <?= App::ORGANISATION ?> </b></td>
        <td style="text-align: right;    width: 65%">  <b>LISTE DES ELEVES INSCRITS &nbsp; &nbsp;</b> </td>
    </tr>
  
    <tr>
        <td> &nbsp; &nbsp;Batterie 4</td>
        <td  style="text-align: right;"> Classe : <strong class="text-danger" > <?= $data['classe']??"" ?> &nbsp; &nbsp;</strong></td>
    </tr>    
   
    <tr>
        <td> &nbsp; &nbsp;Libreville, Gabon</td>
        <td  style="text-align: right;"> Année Scolaire : <strong class="text-danger" > <?= $data['annee_scolaire']??"" ?>  &nbsp; &nbsp;</strong></td>
    </tr> 
<!-- 
    <tr>
        <td colspan="2" style="text-align: left;">Elève : <strong class="text-danger" > <?= $data['eleve']??"" ?>  </strong></td>
        <td  style="text-align: left;">Classe : <strong class="text-danger" > <?= $data['classe']??"" ?></strong></td> 
    </tr>  -->

    
   

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
            <th>  &nbsp; Numéro</th>
            <th>  &nbsp; Nom</th>
            <th>  &nbsp; Prénom</th>
            <th>  &nbsp; Sexe</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
            foreach ($data['eleves'] as $eleve){
                $i++;
                echo "<tr>";
                echo "    <td scope='row'> &nbsp;{$i}</td>";
                echo "    <td>  &nbsp;{$eleve->nom}</td>";
                echo "    <td>  &nbsp;{$eleve->prenom}</td>";
                echo "    <td>  &nbsp;{$eleve->sexe}</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
    
</table>


<page_footer>
   
</page_footer>

</page>