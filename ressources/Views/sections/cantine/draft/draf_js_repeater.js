
            let sum = 0
            $(this).parents().find(".sous_total").each(function(){
                let val = parseFloat($(this).val())
                if (!isNaN(val)) {
                        sum += val
                }
            })
            console.log("sum1")
            console.log(sum)



                    /*
        for(var item in items)
        {
            let current = items[item];
            let _state = current['state'];
            var _type_pension_code = current['type_pension_code'];

            let  _est_mensuel    = parseInt(current['est_mensuel']);

            let _recapitulatif = parseFloat(current['recapitulatif']);

            _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;


            msg = _recapitulatif+"*"+tmp_montant+"-"+_remise+ " = " +sub_total;

            $('#COL4-'+_type_pension_code).val(msg);

        }

        //Reste
        _reduction = parseFloat($(reduction).val());
        _reste = parseFloat($(reste).val());
        _montant_total -= _reduction;
        _montant_total -= _reste;
        let reduction_familiale = (isNaN($('#RF-reduction').val()))? 0 : $('#RF-reduction').val();
        _montant_total = _montant_total - reduction_familiale;
        $(montant).val(_montant_total);*/