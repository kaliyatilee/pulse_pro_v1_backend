(function ($) {
    /* "use strict" */

    let fetchData = async function () {
        let items = $.ajax({
            type: 'GET',
            url: '/admin/member/activities/' + member_id,
            // data: {_token: token},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
        })
        return items;
    }

    var dzChartlist = function () {
        let draw = Chart.controllers.line.__super__.draw; //draw shadow
        var screenWidth = $(window).width();
        var memberChartBarRunning = async function (desiredYear) {
            let AllActivities = await fetchData().then(response = (response) => {
                return response;
            });
            let whichHalfOfTheYear = new Date().getMonth();
            let data = [0, 0, 0, 0, 0, 0];
            let categories = [];

            if (whichHalfOfTheYear >= 0 && whichHalfOfTheYear <= 5) {
                categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'running') {
                        let dateObj = new Date(Date.parse(activity.date));
                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }

                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }
            if (whichHalfOfTheYear >= 6 && whichHalfOfTheYear <= 11) {
                categories = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'running') {
                        let dateObj = new Date(Date.parse(activity.date));

                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }
                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }
            var optionsArea = {
                series: [{
                    name: "Running",
                    data: data
                }
                ],
                chart: {
                    height: 400,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [4],
                    colors: ['#A02CFA'],
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },
                    markers: {
                        fillColors: ['#A02CFA'],
                        width: 19,
                        height: 19,
                        strokeWidth: 0,
                        radius: 19
                    }
                },
                markers: {
                    strokeWidth: [4],
                    strokeColors: ['#A02CFA'],
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 6,
                    }
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,

                        },
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: -16,
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,
                        },
                        formatter: function(val) {
                            return Math.floor(val) + " km";
                        }
                    },
                },
                fill: {
                    colors: ['#A02CFA'],
                    type: 'solid',
                    opacity: 0.7
                },
                colors: ['#A02CFA'],
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        chart: {
                            height: 250,
                        }
                    }
                }]
            };
            var chartArea = new ApexCharts(document.querySelector("#memberChartBarRunning"), optionsArea);
            chartArea.render();

        }
        var memberChartBarWalking = async function (desiredYear) {
            let AllActivities = await fetchData().then(response = (response) => {
                return response;
            });
            let whichHalfOfTheYear = new Date().getMonth();
            let data = [0, 0, 0, 0, 0, 0];
            let categories = [];

            if (whichHalfOfTheYear >= 0 && whichHalfOfTheYear <= 5) {
                categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'walking') {
                        let dateObj = new Date(Date.parse(activity.date));
                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }
                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }
            if (whichHalfOfTheYear >= 6 && whichHalfOfTheYear <= 11) {
                categories = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'walking') {
                        let dateObj = new Date(Date.parse(activity.date));
                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }
                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }

            var optionsArea = {
                series: [{
                    name: "Walking",
                    data: data
                }
                ],
                chart: {
                    height: 400,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [4],
                    colors: ['#FF3282'],
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },
                    markers: {
                        fillColors: ['#FF3282'],
                        width: 19,
                        height: 19,
                        strokeWidth: 0,
                        radius: 19
                    }
                },
                markers: {
                    strokeWidth: [4],
                    strokeColors: ['#FF3282'],
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 6,
                    }
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,

                        },
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: -16,
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,
                        },
                        formatter: function(val) {
                            return Math.floor(val) + " km";
                        }
                    },
                },
                fill: {
                    colors: ['#FF3282'],
                    type: 'solid',
                    opacity: 0.7
                },
                colors: ['#FF3282'],
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        chart: {
                            height: 250,
                        }
                    }
                }]
            };
            var chartArea = new ApexCharts(document.querySelector("#memberChartBarWalking"), optionsArea);
            chartArea.render();

        }
        var memberChartBarCycling = async function (desiredYear) {
            let AllActivities = await fetchData().then(response = (response) => {
                return response;
            });
            let whichHalfOfTheYear = new Date().getMonth();
            let data = [0, 0, 0, 0, 0, 0];
            let categories = [];



            if (whichHalfOfTheYear >= 0 && whichHalfOfTheYear <= 5) {
                categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'walking') {
                        let dateObj = new Date(Date.parse(activity.date));
                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }
                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }
            if (whichHalfOfTheYear >= 6 && whichHalfOfTheYear <= 11) {
                categories = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                AllActivities.forEach(activity => {
                    if (activity.activity.toLowerCase() === 'cycling') {
                        let dateObj = new Date(Date.parse(activity.date));
                        let whichYear = parseInt(desiredYear);
                        let distance = parseFloat(activity.distance);
                        let year = dateObj.getFullYear();
                        if(year < 0) {
                            year *= -1;
                        }
                        year === whichYear ? data[dateObj.getMonth() - 6] += distance : void (0);
                    }
                });
                for (let i = 0; i < data.length; i++) {
                    data[i] = data[i].toFixed(0);
                }
            }
            var optionsArea = {
                series: [{
                    name: "Cycling",
                    data: data
                }
                ],
                chart: {
                    height: 400,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [4],
                    colors: ['#FFBC11'],
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },
                    markers: {
                        fillColors: ['#FFBC11'],
                        width: 19,
                        height: 19,
                        strokeWidth: 0,
                        radius: 19
                    }
                },
                markers: {
                    strokeWidth: [4],
                    strokeColors: ['#FFBC11'],
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 6,
                    }
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,

                        },
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: -16,
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,
                        },
                        formatter: function(val) {
                            return Math.floor(val) + " km";
                        }
                    },
                },
                fill: {
                    colors: ['#FFBC11'],
                    type: 'solid',
                    opacity: 0.7
                },
                colors: ['#FFBC11'],
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        chart: {
                            height: 250,
                        }
                    }
                }]
            };
            var chartArea = new ApexCharts(document.querySelector("#memberChartBarCycling"), optionsArea);
            chartArea.render();

        }

        function rangeBMI(min, max) {
            this.low = min;
            this.high = max;
            this.has = function (bmi) {
                if (bmi < min) {
                    return "low";
                }
                if (bmi > max) {
                    return "high";
                }
                return "normal";
            }
        }

        function rangeHeight(female, male, gender) {
            this.female = female;
            this.male = male;
            this.measureMe = function (height) {
                if (gender.toLowerCase().trim() === 'male') {
                    if (height < male) {
                        return "short";
                    }
                    if (height > male) {
                        return "tall";
                    }
                    return "average";
                }
                if (gender.toLowerCase().trim() === 'female') {
                    if (height < female) {
                        return "short";
                    }
                    if (height > female) {
                        return "tall";
                    }
                    return "average";
                }

            }
        }

        var pieChart = function () {
            const averageUnitsPerBMI = 4.6;
            const bmiRange = new rangeBMI(18.5, 24.9);
            const member = memberdata;
            const heightRange = new rangeHeight(159.5, 171, member.gender);    //Height in Centimetres
            const bmiStatus = bmiRange.has(member.bmi);
            const heightStatus = heightRange.measureMe(member.height);

            let colorReps = {
                bmi : "#82BE65",
                height: "#0B2A97",
                weight: "#F6180E"
            }

            let percent = {
                bmi: 0,
                // height: 26,
                weight: 25
            }
            // const aveHeight = 1.79;
            // const h = member.height / 100
            // const heightDiff = parseInt((h.toFixed(2) / aveHeight) * 100 - 100);

            switch (bmiStatus) {
                case "high" :
                    percent.bmi = parseInt((member.bmi  / 100) * 100);
                    // colorReps.bmi = '#F6180E'
                    break
                case "low" :
                    percent.bmi = parseInt((member.bmi * averageUnitsPerBMI) * 0.5);
                    // colorReps.bmi = '#FF3282'
                    break
                default :
                    percent.bmi = 100;
                    percent.weight = 0;
                    // percent.height = 25;
                    break
            }

            var options = {
                series: [percent.weight, percent.bmi],
                chart: {
                    type: 'donut',
                    height: 200,
                },
                tooltip: {
                    y: {
                        formatter: function() {
                            return '';
                        },
                        title: {
                            formatter: function (item) {
                                if (item === 'series-1') {
                                    return 'Weight: ' + member.weight + "Kg";
                                }
                                // if (item === 'series-2') {
                                //     return 'Height: ' + (member.height / 100).toFixed(2) + "m";
                                // }
                                if (item === 'series-2') {
                                    return 'BMI: ' + member.bmi;
                                }
                            }
                        },
                    },
                    marker: {
                        show: true,
                    },
                },

                legend: {
                    show: false,
                },
                fill: {
                    colors: [colorReps.weight, colorReps.bmi]
                },
                stroke: {
                    width: 0,
                },
                colors: [colorReps.weight, colorReps.bmi],
                dataLabels: {
                    enabled: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#pieChart"), options);
            chart.render();
        }
        var radialBar = function () {
            const steps = progress.steps >= dailyTargets.steps ? dailyTargets.steps : progress.steps;
            const distance = progress.distance >= dailyTargets.distance ? dailyTargets.distance : progress.distance;
            const calories = progress.calories >= dailyTargets.calories ? dailyTargets.calories : progress.calories;
            const overall = Math.floor((steps / dailyTargets.steps * 100) + (distance / dailyTargets.distance * 100) + (calories / dailyTargets.calories * 100));
            const overallPercentage = Math.floor(overall/300*100);
            var options = {
                series: [overallPercentage],
                chart: {
                    height: 280,
                    type: 'radialBar',
                    offsetY: -10
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        dataLabels: {
                            name: {
                                fontSize: '16px',
                                color: undefined,
                                offsetY: 120
                            },
                            value: {
                                offsetY: 0,
                                fontSize: '34px',
                                color: 'black',
                                formatter: function (val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    colors: '#0B2A97',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 50, 65, 91]
                    },
                },
                stroke: {
                    lineCap: 'round',
                    colors: '#0B2A97'
                },
                labels: [''],
            };

            var chart = new ApexCharts(document.querySelector("#radialBar"), options);
            chart.render();
        }
        var donutChart = function () {
            $("span.donut").peity("donut", {
                width: "90",
                height: "90"
            });
        }
        /* Function ============ */
        return {
            init: function () {
            },


            load: function () {
                memberChartBarWalking('2021');
                memberChartBarRunning('2021');
                memberChartBarCycling('2021');
                pieChart();
                radialBar();
                donutChart();
            },

            resize: function () {

            }
        }

    }();

    jQuery(document).ready(function () {
    });

    jQuery(window).on('load', function () {
        setTimeout(function () {
            dzChartlist.load();
        }, 1000);

    });

    jQuery(window).on('resize', function () {


    });

})(jQuery);