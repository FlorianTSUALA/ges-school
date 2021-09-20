<?php 
    use Core\Routing\URL;
?>


<script>
    function redirectTo(id = false){
        // console.log(id)
        id = (id == false) ? $('#recap-id').text(): id;
        // console.log(id)
        location.href = '<?= URL::link('eleve_modifier') ?>'+id
    }

    
    // Must use FileSaver.js 2.0.2 because 2.0.3 has issues.
    function download(imagePath){
        let fileName = getFileName(imagePath)
        console.log(fileName)
        console.log(imagePath)
        saveAs(imagePath, fileName)
    }
    
    function getFileName(str) {
        return str.substring(str.lastIndexOf('/') + 1)
    }

    
    function modal_eleve_detail(id){
        $.ajax({
            url: '<?= URL::link('api_eleve_info');?>'+id,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
            },
            success:function(data){
                eleve = data
                console.log("data")
                console.log("data")
                console.log("data")
                console.log(data)

                $('#recap-id').text(id)
                $('#recap-email').text(eleve.email)
                $('#recap-telephone').text(eleve.telephone)
                $('#recap-classe').text(eleve.classe)
                $('#recap-ecole').text(eleve.ecole)
                $('#recap-autres').text(eleve.autres)
                $('#recap-probleme_particulier').text(eleve.probleme_particulier)
                $('#recap-email_medecin').text(eleve.email_medecin)
                $('#recap-telephone_medecin').text(eleve.telephone_medecin)
                $('#recap-nom_medecin').text(eleve.nom_medecin)
                $('#recap-maladie_recurrente').text(eleve.maladie_recurrente)
                $('#recap-allergie').text(eleve.allergie)
                $('#recap-email_mere').text(eleve.email_mere)
                $('#recap-bureau_mere').text(eleve.bureau_mere)
                $('#recap-quartier_mere').text(eleve.quartier_mere)
                $('#recap-telephone_mere').text(eleve.telephone_mere)
                $('#recap-lieu_travail_mere').text(eleve.lieu_travail_mere)
                $('#recap-profession_mere').text(eleve.profession_mere)
                $('#recap-employeur_mere').text(eleve.employeur_mere)
                $('#recap-prenom_mere').text(eleve.prenom_mere)
                $('#recap-nom_mere').text(eleve.nom_mere)
                $('#recap-telephone_personne_urgence').text(eleve.telephone_personne_urgence)
                $('#recap-nom_personne_urgence').text(eleve.nom_personne_urgence)
                $('#recap-prenom_personne_urgence').text(eleve.prenom_personne_urgence)
                $('#recap-lien').text(eleve.lien)
                $('#recap-nom_eleve').text(eleve.nom)
                $('#recap-nom_usage').text(eleve.nom_usage)
                $('#recap-prenom_eleve').text(eleve.prenom)
                $('#recap-prenom_usage').text(eleve.prenom_usage)
                $('#recap-lieu_naissance_eleve').text(eleve.lieu_naissance)
                $('#recap-date_naissance_eleve').text(eleve.date_naissance)
                $('#recap-anciennete_eleve').text(eleve.anciennete)
                $('#recap-nom_pere').text(eleve.nom_pere)
                $('#recap-prenom_pere').text(eleve.prenom_pere)
                $('#recap-employeur_pere').text(eleve.employeur_pere)
                $('#recap-profession_pere').text(eleve.profession_pere)
                $('#recap-lieu_travail_pere').text(eleve.lieu_travail_pere)
                $('#recap-telephone_pere').text(eleve.telephone_pere)
                $('#recap-bureau_pere').text(eleve.bureau_pere)
                $('#recap-quartier_pere').text(eleve.quartier_pere)
                $('#recap-email_pere').text(eleve.email_pere)

                $('#recap-pays_eleve').text(eleve.pays)
                $('#recap-statut_eleve').text(eleve.statut_eleve)
                $('#recap-classe_eleve').text(eleve.classe_eleve)
                $('#recap-salle_classe_eleve').text(eleve.salle_classe_eleve)
                // $('#recap-annee_scolaire').text(eleve.annee_scolaire)
                //$('#recap-pays_pere').text(eleve.pays_pere)
                // $('#recap-pays_mere').text(eleve.pays_mere)
                $('#recap-groupe_sanguin').text(eleve.groupe_sanguin)


                $("#recap-sexe_eleve").text( (eleve.sexe == 'M')? 'Masculin' : 'Féminin' )
                $("#recap-photo").attr('src', "<?= URL::upload() ?>img/eleve/"+eleve.photo)

                $('#recap-pieces_jointes').on('click', function(e) {
                    download("<?= URL::upload() ?>img/eleve/"+eleve.pieces_jointes)
                })

                $('#eleve_modal_info').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }
</script>