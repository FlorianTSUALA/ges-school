<?php 
    use Core\Routing\URL;
?>


<script>

    function _redirect_to(id = false){
        // console.log(id)
        id = (id == false) ? $('#_recap-id').text(): id;
        // console.log(id)
        location.href = '<?= URL::link('eleve_modifier') ?>'+id
    }
    
    // Must use FileSaver.js 2.0.2 because 2.0.3 has issues.
    function _download(imagePath){
        let fileName = _getFileName(imagePath)
        console.log(fileName)
        console.log(imagePath)
        saveAs(imagePath, fileName)
    }
    
    function _getFileName(str) {
        return str.substring(str.lastIndexOf('/') + 1)
    }

    function _modal_eleve_detail(id){
        console.log(id)
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

                $('#_recap-id').text(id)
                $('#_recap-email').text(eleve.email)
                $('#_recap-telephone').text(eleve.telephone)
                $('#_recap-classe').text(eleve.classe)
                $('#_recap-ecole').text(eleve.ecole)
                $('#_recap-autres').text(eleve.autres)
                $('#_recap-probleme_particulier').text(eleve.probleme_particulier)
                $('#_recap-email_medecin').text(eleve.email_medecin)
                $('#_recap-telephone_medecin').text(eleve.telephone_medecin)
                $('#_recap-nom_medecin').text(eleve.nom_medecin)
                $('#_recap-maladie_recurrente').text(eleve.maladie_recurrente)
                $('#_recap-allergie').text(eleve.allergie)
                $('#_recap-email_mere').text(eleve.email_mere)
                $('#_recap-bureau_mere').text(eleve.bureau_mere)
                $('#_recap-quartier_mere').text(eleve.quartier_mere)
                $('#_recap-telephone_mere').text(eleve.telephone_mere)
                $('#_recap-lieu_travail_mere').text(eleve.lieu_travail_mere)
                $('#_recap-profession_mere').text(eleve.profession_mere)
                $('#_recap-employeur_mere').text(eleve.employeur_mere)
                $('#_recap-prenom_mere').text(eleve.prenom_mere)
                $('#_recap-nom_mere').text(eleve.nom_mere)
                $('#_recap-telephone_personne_urgence').text(eleve.telephone_personne_urgence)
                $('#_recap-nom_personne_urgence').text(eleve.nom_personne_urgence)
                $('#_recap-prenom_personne_urgence').text(eleve.prenom_personne_urgence)
                $('#_recap-lien').text(eleve.lien)
                $('#_recap-nom_eleve').text(eleve.nom)
                $('#_recap-nom_usage').text(eleve.nom_usage)
                $('#_recap-prenom_eleve').text(eleve.prenom)
                $('#_recap-prenom_usage').text(eleve.prenom_usage)
                $('#_recap-lieu_naissance_eleve').text(eleve.lieu_naissance)
                $('#_recap-date_naissance_eleve').text(eleve.date_naissance)
                $('#_recap-anciennete_eleve').text(eleve.anciennete)
                $('#_recap-nom_pere').text(eleve.nom_pere)
                $('#_recap-prenom_pere').text(eleve.prenom_pere)
                $('#_recap-employeur_pere').text(eleve.employeur_pere)
                $('#_recap-profession_pere').text(eleve.profession_pere)
                $('#_recap-lieu_travail_pere').text(eleve.lieu_travail_pere)
                $('#_recap-telephone_pere').text(eleve.telephone_pere)
                $('#_recap-bureau_pere').text(eleve.bureau_pere)
                $('#_recap-quartier_pere').text(eleve.quartier_pere)
                $('#_recap-email_pere').text(eleve.email_pere)

                $('#_recap-pays_eleve').text(eleve.pays)
                $('#_recap-statut_eleve').text(eleve.statut_eleve)
                $('#_recap-classe_eleve').text(eleve.classe_eleve)
                $('#_recap-salle_classe_eleve').text(eleve.salle_classe_eleve)
                // $('#_recap-annee_scolaire').text(eleve.annee_scolaire)
                //$('#_recap-pays_pere').text(eleve.pays_pere)
                // $('#_recap-pays_mere').text(eleve.pays_mere)
                $('#_recap-groupe_sanguin').text(eleve.groupe_sanguin)


                $("#_recap-sexe_eleve").text( (eleve.sexe == 'M')? 'Masculin' : 'Féminin' )
                $("#_recap-photo").attr('src', "<?= URL::upload() ?>img/eleve/"+eleve.photo)

                $('#_recap-pieces_jointes').on('click', function(e) {
                    _download("<?= URL::upload() ?>img/eleve/"+eleve.pieces_jointes)
                })

                $('#_eleve_modal_info').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

</script>