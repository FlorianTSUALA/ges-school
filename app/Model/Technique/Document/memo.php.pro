echo ($eleve['sexe'] == 'M') ? 'Masculin' : 'Féminin'

$date = new DateTime($eleve['date_naissance']);
echo $date->format('d/m/Y');

$parcours = Eleve::get_parcours_eleve($eleve['id']);
if (!empty($parcours)) {
    echo $parcours['libelle'];
}







details_eleve
exampleModalLongTitle
photo
matricule
nom
prenom
sexe
lieu_naissance
classe





suppression_facture




recap-total-top
<?= number_format(($facture['montant'] - $facture['reduction']), 0, ',', ' '); ?> Fcfa