<style type="text/css">
    
    /*!
 * Favorite Grid v.1.0 
 * Author : Ali Norouzi ( https://github.com/anorouzii )
 * Licensed under MIT ( https://github.com/anorouzii/favorite-grid/blob/master/LICENSE )
*/
/************* Variables *************/
/************* Grid System Mixin (Column Generator) *************/
/************* Breakpoint Mixin *************/
/************* 2 type of container *************/
.container {
  padding: 0 15px;
  margin: 0 auto;
  width: 100%; }
  @media only screen and (min-width: 768px) {
    .container {
      max-width: 720px; } }
  @media only screen and (min-width: 992px) {
    .container {
      max-width: 960px; } }
  @media only screen and (min-width: 1200px) {
    .container {
      max-width: 1170px; } }
  .container-fluid {
    width: 100%;
    padding: 0 15px;
    margin: 0 auto; }

/************* Row *************/
.row {
  margin: 0 -15px; }
  .row:after {
    content: "";
    display: table;
    clear: both; }
  .row [class^="col"] {
    position: relative;
    min-height: 1px;
    padding: 0 15px;
    float: left; }

/************* Default column *************/
.col-1 {
  width: 8.33333%; }

.col-2 {
  width: 16.66667%; }

.col-3 {
  width: 25%; }

.col-4 {
  width: 33.33333%; }

.col-5 {
  width: 41.66667%; }

.col-6 {
  width: 50%; }

.col-7 {
  width: 58.33333%; }

.col-8 {
  width: 66.66667%; }

.col-9 {
  width: 75%; }

.col-10 {
  width: 83.33333%; }

.col-11 {
  width: 91.66667%; }

.col-12 {
  width: 100%; }

/************* XLarge Device column *************/
@media only screen and (min-width: 1200px) {
  .col-xl-1 {
    width: 8.33333%; }
  .col-xl-2 {
    width: 16.66667%; }
  .col-xl-3 {
    width: 25%; }
  .col-xl-4 {
    width: 33.33333%; }
  .col-xl-5 {
    width: 41.66667%; }
  .col-xl-6 {
    width: 50%; }
  .col-xl-7 {
    width: 58.33333%; }
  .col-xl-8 {
    width: 66.66667%; }
  .col-xl-9 {
    width: 75%; }
  .col-xl-10 {
    width: 83.33333%; }
  .col-xl-11 {
    width: 91.66667%; }
  .col-xl-12 {
    width: 100%; } }

/************* Large Device column *************/
@media only screen and (min-width: 992px) {
  .col-lg-1 {
    width: 8.33333%; }
  .col-lg-2 {
    width: 16.66667%; }
  .col-lg-3 {
    width: 25%; }
  .col-lg-4 {
    width: 33.33333%; }
  .col-lg-5 {
    width: 41.66667%; }
  .col-lg-6 {
    width: 50%; }
  .col-lg-7 {
    width: 58.33333%; }
  .col-lg-8 {
    width: 66.66667%; }
  .col-lg-9 {
    width: 75%; }
  .col-lg-10 {
    width: 83.33333%; }
  .col-lg-11 {
    width: 91.66667%; }
  .col-lg-12 {
    width: 100%; } }

/************* Medium Device column *************/
@media only screen and (min-width: 768px) {
  .col-md-1 {
    width: 8.33333%; }
  .col-md-2 {
    width: 16.66667%; }
  .col-md-3 {
    width: 25%; }
  .col-md-4 {
    width: 33.33333%; }
  .col-md-5 {
    width: 41.66667%; }
  .col-md-6 {
    width: 50%; }
  .col-md-7 {
    width: 58.33333%; }
  .col-md-8 {
    width: 66.66667%; }
  .col-md-9 {
    width: 75%; }
  .col-md-10 {
    width: 83.33333%; }
  .col-md-11 {
    width: 91.66667%; }
  .col-md-12 {
    width: 100%; } }

/************* Small Device column *************/
@media only screen and (min-width: 480px) {
  .col-sm-1 {
    width: 8.33333%; }
  .col-sm-2 {
    width: 16.66667%; }
  .col-sm-3 {
    width: 25%; }
  .col-sm-4 {
    width: 33.33333%; }
  .col-sm-5 {
    width: 41.66667%; }
  .col-sm-6 {
    width: 50%; }
  .col-sm-7 {
    width: 58.33333%; }
  .col-sm-8 {
    width: 66.66667%; }
  .col-sm-9 {
    width: 75%; }
  .col-sm-10 {
    width: 83.33333%; }
  .col-sm-11 {
    width: 91.66667%; }
  .col-sm-12 {
    width: 100%; } }


table
{
    width:  100%;
    margin: 0;
    min-height: 90vh;
    display: flex;
    flex-direction: column;
    border: 1px solid black;
}

th
{
    text-align: center;
    border: solid 1px #113300;
    background: #EEFFEE;
}

td
{
    text-align: left;
    border: solid 0.2px #55DD44;
}

td.col1
{
    border: solid 1px red;
    text-align: right;
}

end_last_page div
{
    border: solid 1mm red;
    height: 27mm;
    margin: 0;
    padding: 0;
    text-align: center;
    font-weight: bold;
}
</style>

<span style="font-size: 20px; font-weight: bold">Titre d'en tete repetée une seule flois<br></span>
<br>
<br>


<table  cellspacing='0' style="width: 100%; border: solid 2px #000000; ">

<thead>
    <tr>
        <th>
            <div>
                <h3>Ges-School</h3>
                ECOLE MATERNELLE ET <br />
                PRIMAIRE <br />
            </div>
        </th>
        <th>
            <div>
                <h3>LOGO</h3> <br />

            </div>
        </th>
        <th>
            <div id="direction">
                <h5>ANNEE SCOLAIRE </h5>
                <span>2020 - 2021</span> <br />
                CLASSE : CM2 <br />
            </div>
        </th>


    </tr>
</thead>

</table>

<table cellspacing="0" style="width: 100%; border: solid 2px #000000; ">
    <tr>
        <td style="width: 100%; font-size: 12pt;">
            <span style="font-size: 15pt; font-weight: bold;">ADRESSE DE RETOUR<br></span>
            <br>
            <b>Entrepot des Bois</b><br>
            
        </td>
    </tr>
</table>

           
<table cellspacing='0'>
    <colgroup>
        <col style="width: 5%" class="col1">
        <col style="width: 22%">
        <col style="width: 22%">
        <col style="width: 6%">
        <col style="width: 5%">
        <col style="width: 25%">
        <col style="width: 15%">
    </colgroup>
    <thead>
        <tr>
            <th>N°</th>
            <th>NOM</th>
            <th>PRENOM</th>
            <th>SEXE</th>
            <th>AGE</th>
            <th>PERSONNE A CONTACTER</th>
            <th>TELEPHONE</th>


        </tr>
    </thead>
    <tbody>
        
        <?php
            for ($k=1; $k<70; $k++) {
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $k; ?></td>
                <td>#####################</td>
                <td>#####################</td>
                <td style="text-align: center;">M</td>
                <td style="text-align: center;">7</td>
                <td>PAPA</td>
                <td>#############</td>
            </tr>
            
        <?php
            }
        ?>

    </tbody>

    <tfoot>
        <tr>
            <th colspan="7" style="font-size: 16px;">
                
    [[page_cu]]/[[page_nb]]
  
               
            </th>
        </tr>
    </tfoot>
    
</table>
<br><br><br>

Cool non ?<br>
<end_last_page end_height="30mm">
    <div>
        Ceci est un test de fin de page
    </div>
</end_last_page>