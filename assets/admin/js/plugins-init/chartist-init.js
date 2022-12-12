(function ($) {
    /* "use strict" */


    var dzChartlist = function () {

        var screenWidth = $(window).width();

        var setChartWidth = function () {

            if (screenWidth <= 768) {
                var chartBlockWidth = 0;
                if (screenWidth >= 500) {
                    chartBlockWidth = 250;
                } else {
                    chartBlockWidth = 300;
                }

                jQuery('.chartlist-chart').css('min-width', chartBlockWidth - 31);
            }
        }

        var lineTooltipsChart = async function () {
            //Line chart with tooltips




            new Chartist.Line('#line-chart-obese1', {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    series: [
                        {
                            name: 'All Members',
                            data: [200, 215, 215, 219, 212, 250, 267],
                        },
                        {
                            name: 'Members Exercising',
                            data: [100, 97, 200, 150, 211, 167, 20],
                        }
                    ],
                    resize: true,
                    redraw: true,
                    colors: ['blue', 'black']
                },
                {
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    fullWidth: true
                }
            );

            new Chartist.Line('#line-chart-overweight', {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    series: [
                        {
                            name: 'All Members',
                            data: [10, 10, 12, 1, 14, 5, 4],
                            fill: "blue"
                        },
                        {
                            name: 'Members Exercising',
                            data: [1, 2, 4, 1, 1, 1, 1],
                            fill: "black"
                        }
                    ]
                },
                {
                    plugins: [
                        Chartist.plugins.tooltip()
                    ],
                    fullWidth: true
                }
            );

            var $chart = $('#line-chart-tooltips');

            var $toolTip = $chart
                .append('<div class="tooltip"></div>')
                .find('.tooltip')
                .hide();

            $chart.on('mouseenter', '.ct-point', function () {
                var $point = $(this),
                    value = $point.attr('ct:value'),
                    seriesName = $point.parent().attr('ct:series-name');
                $toolTip.html(seriesName + '<br>' + value).show();
            });

            $chart.on('mouseleave', '.ct-point', function () {
                $toolTip.hide();
            });

            $chart.on('mousemove', function (event) {
                $toolTip.css({
                    left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
                    top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
                });
            });

        }

        /* Function ============ */
        return {
            init: function () {
            },


            load: function () {
                setChartWidth();
                lineTooltipsChart();
            },

            resize: function () {

            }
        }

    }();

    jQuery(document).ready(function () {
    });

    jQuery(window).on('load', function () {
        dzChartlist.load();
    });

    jQuery(window).on('resize', function () {
        dzChartlist.resize();
    });

})(jQuery);