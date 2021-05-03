<script>
    //DashBoard - Recent Transaction
    'use strict';

    Date.prototype.addDays = function(days) {
            //var yesterday = new Date(today.getTime() - (1000*60*60*24));
            //var hourago = new Date(today.getTime() - (1000*60*60));
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
    }

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getRandomBootstrapColor(){
        const arrX = ["warning", "info","success", "danger", "primary", "light", "dark"];
        return arrX[Math.floor(Math.random() * arrX.length)];
    }

    function getTransactionSummary(motif, montant, reference){
        return "|Motif : <b>" + motif + "</b></br>|Montant : <b>" + montant + "</b></br>| Ref : <b>" + reference + "</b>";
    }

    $(document).ready(function () {
        var data = [];
        var data_total = [];
        var data_montant = [];

        window.Apex = {
            stroke: {
                width: 0.5
            },
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 2,
                style: 'hollow',
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            },
            tooltip: {
                fixed: {
                    enabled: true
                },
                x: {
                    format: 'dd MMM yyyy HH:mm'
                }
            },
            chart: {
                height: 180,
                width: "100%",
                zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                toolbar: {
                    autoSelected: 'zoom'
                },
            },
            dataLabels: {
                enabled: false
            },
            /*fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100]
                    },
                },*/
            xaxis: {
                type: 'datetime',
            }
        };

        var option_spark_total = {
                series: [{
                    name: 'Transactions : ',
                    data: data_total
                }],
                chart: {
                    type: 'area',
                    id: 'spark_total',
                    group: 'pm-spark',
                },
                title: {
                    text: 'Evolution du nombre de transaciton',
                    align: 'left'
                },
                yaxis: {
                    title: {
                        text: 'Total'
                    },
                },
                colors: ['#00E396'],

        };

        var option_spark_montant = {
            series: [{
                name: 'Revenu total ',
                data: data_montant
            }],
            title: {
                    text: 'Fluctuation des revenus à <?= $_SESSION[Session::PM_DENOMINTION] ?>',
                    align: 'left'
                },
            chart: {
                type: 'area',
                id: 'spark_montant',
                group: 'pm-spark',
            },
            yaxis: {
                title: {
                        text: 'Montant'
                    },
            },
        };

        displayChart( <?= $_SESSION[Session::PM_COMPTE_ID] ?> , 5, "<?= Query::INTERVAL_PERIOD_MINUTE ?>");

        var spark_total = new ApexCharts(document.querySelector("#pm-spark-total"), option_spark_total);
        spark_total.render();

        var spark_montant = new ApexCharts(document.querySelector("#pm-spark-montant"), option_spark_montant);
        spark_montant.render();

        function updateRecentTransactions(id, limit){
            axios.get('<?php echo KGS_APPS_URL ?>api/transaction/transaction_point_marchand_read_all.php', {
                params:{
                    compte_id: id,
                    limit: limit
                }
            }).then(function(response){

                    var content = "";
                    var json = response.data.data;
                        if (Array.isArray(json) && json.length)
                        {
                            for (var key in json) {

                                if(json.hasOwnProperty(key)){
                                    console.log(json[key]);
                                    var motif = json[key].Motif;
                                    var dateP = json[key].Dates;
                                    var ref = json[key].Reference;
                                    var remise = json[key].Remise;
                                    var montant = json[key].MontantDepot;

                                    var datetime = new Date(''+ dateP);
                                    var h = addZero(datetime.getHours());
                                    var m = addZero(datetime.getMinutes());

                                    var d = addZero(datetime.getDay());
                                    var mm = addZero(datetime.getMonth());
                                    var time  = h + ":" + m;
                                    var date = d + "/" + mm;

                                    content +=
                                    (
                                        '<div class="ul-widget-s7">'+
                                            '<div class="ul-widget-s7__items"><span class="ul-widget-s7__item-time">' + time  +' <br> '+  date + '</span>'+
                                                '<div class="ul-widget-s7__item-circle">'+
                                                    '<p class="badge-dot-'+ getRandomBootstrapColor() + ' ul-widget7__big-dot"></p>'+
                                                '</div>'+
                                                '<div class="ul-widget-s6__item-text">'+
                                                    getTransactionSummary(motif, montant, ref) +
                                                '</div>'+
                                            '</div>'+
                                        '</div>'
                                    );
                                }
                            }
                        }
                        else
                        {
                            content +='<div class="jumbotron bg-success shadow-lg text-white">'+
                                        '<h3 class=" text-white"><i class="i-Information"></i>&nbsp;Information non disponible !</h3>'+
                                        '<hr class="my-4 bg-white">'+
                                        '</div>';
                        }

                    $('#recent-transac').html(content);

                   // console.log("Displaying 4 Dashboad");

            }).catch(function(error){
                    console.log("Error in Refresh Recent Transaction");
            });
        }

        function displayChart(id, interval, period){
                axios.get('<?php echo KGS_APPS_URL ?>api/transaction/transaction_point_marchand_real_time.php', {
                    params:{
                        compte_id: id,
                        interval: interval,
                        period: period
                    }
                }).then(function(response){
                    var json = response.data.data;
                    console.log(json);
                    if (Array.isArray(json) && json.length)
                    {
                        for (var key in json) {
                            if(json.hasOwnProperty(key)){
                                data_montant.push([new Date(json[key].date_paiement), parseFloat(json[key].Montant) ]);
                                data_total.push([new Date(json[key].date_paiement), parseInt(json[key].Nombre) ]);
                            }
                        }
                    }

                }).catch(function(error){
                        console.log("Error In Chart");
                });
        }

        window.setInterval(function (){
                updateRecentTransactions(<?php echo $_SESSION[Session::USER_ID_CONNECTED]; ?>, <?php echo REALTIME_TOTAL_CHART_TRANSACTION; ?>);
        }, <?php echo REALTIME_TIME_RECENT_TRANSACTION;  ?>);

    });

</script>
