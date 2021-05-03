$(".periode").val('JOUR')
        let selected = $(".periode").val()
        let tmp = prix_abonnements.filter((item)=>{
            return String(item.periode) === String(selected)
        })

        let current = tmp[0]

        $(".prix_unitaire").val( parseFloat(current.montant) )
        $(".date_debut").val( '<?= date("y-M-d");?>' )
        $(".duree").val( 1 )
        $(".sous_total").val( $(".prix_unitaire").val()* $(".duree").val() )
        $("#montant").val($(".sous_total").val())
