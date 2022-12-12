(function ($) {
    /* "use strict" */


    var dzChartlist = function () {
        var btnAware = function () {

            $('.avtivity-card')
                .on('mouseenter', function (e) {
                    var parentOffset = $(this).offset(),
                        relX = e.pageX - parentOffset.left,
                        relY = e.pageY - parentOffset.top;
                    $(this).find('.effect').css({top: relY, left: relX})
                })
                .on('mouseout', function (e) {
                    var parentOffset = $(this).offset(),
                        relX = e.pageX - parentOffset.left,
                        relY = e.pageY - parentOffset.top;
                    $(this).find('.effect').css({top: relY, left: relX})
                });
        }

        /**
         * Author : Benjamin Tsuro
         * Date : June 25th, 2021
         * Fetch Activities From Database
         *
         * TODO: Optimise to fetch for desired year
         * @returns {Promise<jQuery>}
         */
        let fetchData = async function () {
            let items = await $.ajax({
                type: 'GET',
                url: '/admin/activities',
                // data: {_token: token},
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept-Encoding': 'gzip;q=1.0, identity; q=0.5, *;q=0'
                },
                // dataType: 'json',
            }).then(response = (response) => {
                return response;
            });
            return items;
        }

        var chartBarWalking = async function (desiredYear, data) {
            let AllActivities = data;
            let totalDistance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let today = new Date();

            let membersExercising = {};
            let exercisingTotals = [0,0,0,0,0,0,0,0,0,0,0,0];


            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })

            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if(!membersExercising[date].includes(activity.user_id) && activity.activity === "Walking") {
                    membersExercising[date].push(activity.user_id);
                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            console.log(exercisingTotals);

            AllActivities.forEach(activity => {
                if (activity.activity.toLowerCase() === 'walking') {
                    let dateObj = new Date(Date.parse(activity.created_at));
                    let whichYear = parseInt(desiredYear);
                    let distance = parseFloat(activity.distance);
                    dateObj.getFullYear() === whichYear ? totalDistance[dateObj.getMonth()] += distance : void (0);
                }
            });
            for (let i = 0; i < totalDistance.length; i++) {
                totalDistance[i] = totalDistance[i].toFixed(0);
            }

            var optionsArea = {
                series: [{
                    name: "Number of People",
                    data: exercisingTotals
                },
                ],
                chart: {
                    height: 200,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: true,
                        export: {
                            csv: {
                                filename: `walking chart ${today.toLocaleDateString()}`,
                            },
                            svg: {
                                filename: `walking chart ${today.toLocaleDateString()}`,
                            },
                            png: {
                                filename: `walking chart ${today.toLocaleDateString()}`,
                            }
                        },
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [10],
                    colors: sec_color,
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },

                },
                markers: {
                    strokeWidth: [8],
                    strokeColors: sec_color,
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 13,
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                            return Math.floor(val);
                        }
                    },
                },
                fill: {
                    colors: sec_color,
                    type: 'solid',
                    opacity: 0
                },
                colors: sec_color,
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [
                    {
                        breakpoint: 1601,
                        options: {
                            chart: {
                                height: 400
                            },
                        },
                    }
                    , {
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            markers: {
                                strokeWidth: [4],
                                strokeColors: sec_color,
                                border: 0,
                                colors: ['#fff'],
                                hover: {
                                    size: 6,
                                }
                            },
                            stroke: {
                                width: [6],
                                colors: sec_color,
                                curve: 'smooth'
                            },
                        }
                    }
                ]
            };
            var chartArea = new ApexCharts(document.querySelector("#chartBarWalking"), optionsArea);
            chartArea.render();

        }

        var chartBarRunning = async function (desiredYear, data) {
            let AllActivities = data;
            let totalDistance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let today = new Date();
            let membersExercising = {};
            let exercisingTotals = [0,0,0,0,0,0,0,0,0,0,0,0];


            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })

            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if(!membersExercising[date].includes(activity.user_id) && activity.activity === "Running") {
                    membersExercising[date].push(activity.user_id);
                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })
            AllActivities.forEach(activity => {
                if (activity.activity.toLowerCase() === 'running') {
                    let dateObj = new Date(Date.parse(activity.created_at));
                    let whichYear = parseInt(desiredYear);
                    let distance = parseFloat(activity.distance);
                    dateObj.getFullYear() === whichYear ? totalDistance[dateObj.getMonth()] += distance : void (0);
                }
            });
            for (let i = 0; i < totalDistance.length; i++) {
                totalDistance[i] = totalDistance[i].toFixed(0);
            }
            var optionsArea = {
                series: [{
                    name: "Number Of People",
                    data: exercisingTotals
                }
                ],
                chart: {
                    height: 200,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: true,
                        export: {
                            csv: {
                                filename: `running chart ${today.toLocaleDateString()}`,
                            },
                            svg: {
                                filename: `running chart ${today.toLocaleDateString()}`,
                            },
                            png: {
                                filename: `running chart ${today.toLocaleDateString()}`,
                            }
                        },
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [10],
                    colors: sec_color,
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },

                },
                markers: {
                    strokeWidth: [8],
                    strokeColors: sec_color,
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 13,
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,
                        }
                    },
                },
                yaxis: {
                    type: 'numeric',
                    labels: {
                        offsetX: -16,
                        style: {
                            colors: '#3E4954',
                            fontSize: '14px',
                            fontFamily: 'Poppins',
                            fontWeight: 100,

                        },
                        formatter: function(val) {
                            return Math.floor(val);
                        }
                    },
                },
                fill: {
                    colors: sec_color,
                    type: 'solid',
                    opacity: 0
                },
                colors: sec_color,
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [
                    {
                        breakpoint: 1601,
                        options: {
                            chart: {
                                height: 400
                            },
                        },
                    }
                    , {
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            markers: {
                                strokeWidth: [4],
                                strokeColors: sec_color,
                                border: 0,
                                colors: ['#fff'],
                                hover: {
                                    size: 6,
                                }
                            },
                            stroke: {
                                width: [6],
                                colors: sec_color,
                                curve: 'smooth'
                            },
                        }
                    }
                ]
            };
            var chartArea = new ApexCharts(document.querySelector("#chartBarRunning"), optionsArea);
            chartArea.render();

        }
        var chartBarCycling = async function (desiredYear, data) {
            let AllActivities = data;
            let totalDistance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let today = new Date();

            let membersExercising = {};
            let exercisingTotals = [0,0,0,0,0,0,0,0,0,0,0,0];


            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })

            AllActivities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if(!membersExercising[date].includes(activity.user_id) && activity.activity === "Cycling") {
                    membersExercising[date].push(activity.user_id);
                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            AllActivities.forEach(activity => {
                if (activity.activity.toLowerCase() === 'cycling') {
                    let dateObj = new Date(Date.parse(activity.created_at));
                    let whichYear = parseInt(desiredYear);
                    let distance = parseFloat(activity.distance);
                    dateObj.getFullYear() === whichYear ? totalDistance[dateObj.getMonth()] += distance : void (0);
                }
            });
            for (let i = 0; i < totalDistance.length; i++) {
                totalDistance[i] = totalDistance[i].toFixed(0);
            }

            var optionsArea = {
                series: [{
                    name: "TNumber Of People",
                    data: exercisingTotals
                }
                ],
                chart: {
                    height: 200,
                    type: 'area',
                    group: 'social',
                    toolbar: {
                        show: true,
                        export: {
                            csv: {
                                filename: `cycling chart ${today.toLocaleDateString()}`,
                            },
                            svg: {
                                filename: `cycling chart ${today.toLocaleDateString()}`,
                            },
                            png: {
                                filename: `cycling chart ${today.toLocaleDateString()}`,
                            }
                        },
                    },
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [10],
                    colors: sec_color,
                    curve: 'smooth'
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    },

                },
                markers: {
                    strokeWidth: [8],
                    strokeColors: sec_color,
                    border: 0,
                    colors: ['#fff'],
                    hover: {
                        size: 13,
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                            return Math.floor(val);
                        }
                    },
                },
                fill: {
                    colors: sec_color,
                    type: 'solid',
                    opacity: 0
                },
                colors: sec_color,
                grid: {
                    borderColor: '#f1f1f1',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                responsive: [
                    {
                        breakpoint: 1601,
                        options: {
                            chart: {
                                height: 400
                            },
                        },
                    }
                    , {
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 250
                            },
                            markers: {
                                strokeWidth: [4],
                                strokeColors: sec_color,
                                border: 0,
                                colors: ['#fff'],
                                hover: {
                                    size: 6,
                                }
                            },
                            stroke: {
                                width: [6],
                                colors: sec_color,
                                curve: 'smooth'
                            },
                        }
                    }
                ]
            };
            var chartArea = new ApexCharts(document.querySelector("#chartBarCycling"), optionsArea);
            chartArea.render();

        }
        /* Function ============ */
        return {
            init: function () {
            },


            load: async function () {
                //btnAware();
                /**
                 * Author : Benjamin Tsuro
                 * Date : June 25th, 2021
                 * TODO switch date
                 * info - now its set to current year (2021)
                 */

                /*let AllActivities = await fetchData().then( res = (res) => res);
                chartBarWalking("2021", AllActivities);
                chartBarRunning("2021", AllActivities);
                chartBarCycling("2021", AllActivities);*/
            },

            resize: function () {

            }
        }

    }();

    jQuery(document).ready(function () {
    });

    jQuery(window).on('load', function () {
        /*setTimeout(function () {
            dzChartlist.load();
        }, 1000);*/

    });

    jQuery(window).on('resize', function () {


    });

})(jQuery);