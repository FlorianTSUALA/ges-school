<?php

use Core\Routing\URL;

?>

<script>

      /*****************************************************
    *               Knob Card Statistics              *
    *****************************************************/
    var rtl = false;
    if($('html').data('textdirection') == 'rtl')
        rtl = true;
    $(".knob").knob({
        rtl:rtl,
        draw: function() {
            var ele = this.$;
            var style = ele.attr('style');
            var fontSize = parseInt(ele.css('font-size'), 10);
            var updateFontSize = Math.ceil(fontSize * 1.65);
            style = style.replace("bold", "normal");
            style = style + "font-size: " +updateFontSize+"px;";
            var icon = ele.attr('data-knob-icon');
            ele.hide();
            $('<i class="knob-center-icon '+icon+'"></i>').insertAfter(ele).attr('style',style);

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                this.cursorExt = 0.3;

                var a = this.arc(this.cv), // Arc
                    pa, // Previous arc
                    r = 1;

                this.g.lineWidth = this.lineWidth;

                if (this.o.displayPrevious) {
                    pa = this.arc(this.v);
                    this.g.beginPath();
                    this.g.strokeStyle = this.pColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });

    var weeklyActivityChart = Morris.Line({
        element: 'weekly-activity-chart',
        data: [{
            "day": Date.parse('2016-12-05'),
            "Walking": 40,
            "Cycling": 62
        }, {
            "day": Date.parse('2016-12-06'),
            "Walking": 200,
            "Cycling": 120
        }, {
            "day": Date.parse('2016-12-07'),
            "Walking": 105,
            "Cycling": 70
        }, {
            "day": Date.parse('2016-12-08'),
            "Walking": 150,
            "Cycling": 75
        }, {
            "day": Date.parse('2016-12-09'),
            "Walking": 275,
            "Cycling": 100
        }, {
            "day": Date.parse('2016-12-10'),
            "Walking": 325,
            "Cycling": 80
        }, {
            "day": Date.parse('2016-12-11'),
            "Walking": 130,
            "Cycling": 90
        }],
        xkey: 'day',
        xLabels:['day'],
        ykeys: ['Walking', 'Cycling'],
        labels: [ 'Walking', 'Cycling'],
        resize: true,
        smooth: true,
        pointSize: 3,
        pointStrokeColors:['#37BC9B', '#F6BB42'],
        gridLineColor: '#e3e3e3',
        behaveLikeLine: true,
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 3,
        hideHover: 'auto',
        lineColors: ['#37BC9B', '#F6BB42'],
        xLabelFormat:
                    function(x){var day=x.getDay();
                    var days=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
                    return days[day];}
    });


    
    /************************************
    *       Top Selling Categories      *
    ************************************/

    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: '<?= URL::base() ?>assets/app-assets/vendors/js/charts/echarts'
        }
    });


    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],


    // Charts setup
    function (ec) {

        // Initialize chart
        // ------------------------------
        var topCategoryChart = ec.init(document.getElementById('activity-division'));

        // Chart Options
        // ------------------------------
        var topCategoryChartOptions = {

            // Add title
            title: {
                text: 'Activity Devision',
                subtext: 'Weekly',
                x: 'center',
                textStyle: {
    				color: '#333333'
                },
                subtextStyle: {
    				color: '#333333'
                }
            },

            // Add custom colors
            color: ['#967ADC', '#37BC9B', '#F6BB42', '#DA4453', '#818a91'],

            // Enable drag recalculate
            calculable: true,

            // Add series
            series: [
                {
                    name: 'Top Categories',
                    type: 'pie',
                    radius: ['40%', '60%'],
                    center: ['50%', '65%'],
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
    							textStyle: {
    								color: '#333333'
    							}
                            },
                            labelLine: {
                                show: true,
    							lineStyle: {
    								color: '#333333'
    							}
                            }
                        },
                        emphasis: {
                            label: {
                                show: true,
                                formatter: '{b}' + '\n\n' + '{c} ({d}%)',
                                position: 'center',
                                textStyle: {
                                    fontSize: '12',
                                    fontWeight: '500'
                                }
                            }
                        }
                    },

                    data: [
                        {value: 335, name: 'Fitness'},
                        {value: 618, name: 'Running'},
                        {value: 235, name: 'Cycling'},
                        {value: 556, name: 'Dancing'},
                        {value: 100, name: 'Other'}
                    ]
                }
            ]
        };


        // Apply options
        // ------------------------------

        topCategoryChart.setOption(topCategoryChartOptions);

        // Resize chart
        // ------------------------------

        $(function () {

            // Resize chart on menu width change and window resize
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);

            // Resize function
            function resize() {
                setTimeout(function() {

                    // Resize chart
                    topCategoryChart.resize();
                }, 200);
            }
        });
        }
    );

    
</script>