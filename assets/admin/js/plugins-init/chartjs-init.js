(function($) {
    /* "use strict" */


    /* function draw() {

    } */

    var dzSparkLine = function() {
        let draw = Chart.controllers.line.__super__.draw; //draw shadow

        var screenWidth = $(window).width();





        var obeseChart = async function(data, activities, memberBMIinfo) {

            let memberTotals = [
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                []
            ];
            let numTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let exercisingTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let membersExercising = {};

            const endAt = new Date()
            data.members.obese.forEach((member) => {
                let date = new Date(member.created_at);
                memberTotals[date.getMonth()].push(member);
            });
            for (let i = 0; i <= endAt.getMonth(); i++) {
                for (let j = 0; j < i + 1; j++) {
                    numTotals[i] += memberTotals[j].length
                }
            }
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!membersExercising[date].includes(activity.user_id)) {
                    let inRange = false;
                    memberBMIinfo.members.obese.forEach((item) => {
                        if (activity.user_id === item.id) {
                            inRange = true
                        }
                    });
                    if (inRange) membersExercising[date].push(activity.user_id);

                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            if (jQuery('#lineChart_Obese').length > 0) {
                const obeseChart = document.getElementById("lineChart_Obese").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = obeseChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "#f00000");
                lineChart_3gradientStroke1.addColorStop(1, "#f00000");

                const lineChart_3gradientStroke2 = obeseChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(0, 0, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(0, 0, 0, 1)");

                Chart.controllers.line = Chart.controllers.line.extend({
                    draw: function() {
                        draw.apply(this, arguments);
                        let nk = this.chart.chart.ctx;
                        let _stroke = nk.stroke;
                        nk.stroke = function() {
                            nk.save();
                            nk.shadowColor = 'rgba(0, 0, 0, 0)';
                            nk.shadowBlur = 10;
                            nk.shadowOffsetX = 0;
                            nk.shadowOffsetY = 10;
                            _stroke.apply(this, arguments)
                            nk.restore();
                        }
                    }
                });

                obeseChart.height = 100;

                new Chart(obeseChart, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Total Obese Members",
                            data: numTotals,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "4",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#f00000'
                        }, {
                            label: "Members Exercising",
                            data: exercisingTotals,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "3",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(0, 0, 0, 1)'
                        }]
                    },
                    options: {
                        legend: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    // max: 100,
                                    min: 0,
                                    stepSize: 50,
                                    padding: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    padding: 10
                                }
                            }]
                        }
                    }
                });
            }
        }


        var overweightChart = async function(data, activities, memberBMIinfo) {

            let memberTotals = [
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                []
            ];
            let numTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let exercisingTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let membersExercising = {};

            const endAt = new Date()
            data.members.overweight.forEach((member) => {
                let date = new Date(member.created_at);
                memberTotals[date.getMonth()].push(member);
            });
            for (let i = 0; i <= endAt.getMonth(); i++) {
                for (let j = 0; j < i + 1; j++) {
                    numTotals[i] += memberTotals[j].length
                }
            }
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!membersExercising[date].includes(activity.user_id)) {
                    let inRange = false;
                    memberBMIinfo.members.overweight.forEach((item) => {
                        if (activity.user_id === item.id) {
                            inRange = true
                        }
                    });
                    if (inRange) membersExercising[date].push(activity.user_id);

                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            if (jQuery('#lineChart_Obese').length > 0) {
                const overweightChart = document.getElementById("lineChart_Overweight").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = overweightChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "#F0990E");
                lineChart_3gradientStroke1.addColorStop(1, "#F0990E");

                const lineChart_3gradientStroke2 = overweightChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(0, 0, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(0, 0, 0, 1)");

                Chart.controllers.line = Chart.controllers.line.extend({
                    draw: function() {
                        draw.apply(this, arguments);
                        let nk = this.chart.chart.ctx;
                        let _stroke = nk.stroke;
                        nk.stroke = function() {
                            nk.save();
                            nk.shadowColor = 'rgba(0, 0, 0, 0)';
                            nk.shadowBlur = 10;
                            nk.shadowOffsetX = 0;
                            nk.shadowOffsetY = 10;
                            _stroke.apply(this, arguments)
                            nk.restore();
                        }
                    }
                });

                overweightChart.height = 100;

                new Chart(overweightChart, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Total Obese Members",
                            data: numTotals,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "4",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#F0990E'
                        }, {
                            label: "Members Exercising",
                            data: exercisingTotals,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "3",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(0, 0, 0, 1)'
                        }]
                    },
                    options: {
                        legend: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    // max: 100,
                                    min: 0,
                                    stepSize: 50,
                                    padding: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    padding: 10
                                }
                            }]
                        }
                    }
                });
            }
        }

        var underweightChart = async function(data, activities, memberBMIinfo) {

            let memberTotals = [
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                []
            ];
            let numTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let exercisingTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let membersExercising = {};

            const endAt = new Date()
            data.members.underweight.forEach((member) => {
                let date = new Date(member.created_at);
                memberTotals[date.getMonth()].push(member);
            });
            for (let i = 0; i <= endAt.getMonth(); i++) {
                for (let j = 0; j < i + 1; j++) {
                    numTotals[i] += memberTotals[j].length
                }
            }
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!membersExercising[date].includes(activity.user_id)) {
                    let inRange = false;
                    memberBMIinfo.members.underweight.forEach((item) => {
                        if (activity.user_id === item.id) {
                            inRange = true
                        }
                    });
                    if (inRange) membersExercising[date].push(activity.user_id);

                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            if (jQuery('#lineChart_Obese').length > 0) {
                const underweightChart = document.getElementById("lineChart_Underweight").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = underweightChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "#A742B8");
                lineChart_3gradientStroke1.addColorStop(1, "#A742B8");

                const lineChart_3gradientStroke2 = underweightChart.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(0, 0, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(0, 0, 0, 1)");

                Chart.controllers.line = Chart.controllers.line.extend({
                    draw: function() {
                        draw.apply(this, arguments);
                        let nk = this.chart.chart.ctx;
                        let _stroke = nk.stroke;
                        nk.stroke = function() {
                            nk.save();
                            nk.shadowColor = 'rgba(0, 0, 0, 0)';
                            nk.shadowBlur = 10;
                            nk.shadowOffsetX = 0;
                            nk.shadowOffsetY = 10;
                            _stroke.apply(this, arguments)
                            nk.restore();
                        }
                    }
                });

                underweightChart.height = 100;

                new Chart(underweightChart, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Total Obese Members",
                            data: numTotals,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "4",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#A742B8'
                        }, {
                            label: "Members Exercising",
                            data: exercisingTotals,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "3",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(0, 0, 0, 1)'
                        }]
                    },
                    options: {
                        legend: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    // max: 100,
                                    min: 0,
                                    stepSize: 50,
                                    padding: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    padding: 10
                                }
                            }]
                        }
                    }
                });
            }
        }

        var normal = async function(data, activities, memberBMIinfo) {

            let memberTotals = [
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                []
            ];
            let numTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let exercisingTotals = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let membersExercising = {};

            const endAt = new Date()
            data.members.normal.forEach((member) => {
                let date = new Date(member.created_at);
                memberTotals[date.getMonth()].push(member);
            });
            for (let i = 0; i <= endAt.getMonth(); i++) {
                for (let j = 0; j < i + 1; j++) {
                    numTotals[i] += memberTotals[j].length
                }
            }
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!(date in membersExercising)) {
                    membersExercising[date] = [];
                }
            })
            activities.forEach((activity) => {
                let date = new Date(activity.created_at).toLocaleDateString('en-us');
                if (!membersExercising[date].includes(activity.user_id)) {
                    let inRange = false;
                    memberBMIinfo.members.normal.forEach((item) => {
                        if (activity.user_id === item.id) {
                            inRange = true
                        }
                    });
                    if (inRange) membersExercising[date].push(activity.user_id);

                }
            })

            Object.keys(membersExercising).forEach((item) => {
                let date = new Date(item).toLocaleDateString('en-us');
                exercisingTotals[new Date(date).getMonth()] = membersExercising[date].length;
            })

            if (jQuery('#lineChart_Obese').length > 0) {
                const normal = document.getElementById("lineChart_Normal").getContext('2d');
                //generate gradient
                const lineChart_3gradientStroke1 = normal.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke1.addColorStop(0, "#1BD084");
                lineChart_3gradientStroke1.addColorStop(1, "#1BD084");

                const lineChart_3gradientStroke2 = normal.createLinearGradient(500, 0, 100, 0);
                lineChart_3gradientStroke2.addColorStop(0, "rgba(0, 0, 0, 1)");
                lineChart_3gradientStroke2.addColorStop(1, "rgba(0, 0, 0, 1)");

                Chart.controllers.line = Chart.controllers.line.extend({
                    draw: function() {
                        draw.apply(this, arguments);
                        let nk = this.chart.chart.ctx;
                        let _stroke = nk.stroke;
                        nk.stroke = function() {
                            nk.save();
                            nk.shadowColor = 'rgba(0, 0, 0, 0)';
                            nk.shadowBlur = 10;
                            nk.shadowOffsetX = 0;
                            nk.shadowOffsetY = 10;
                            _stroke.apply(this, arguments)
                            nk.restore();
                        }
                    }
                });

                normal.height = 100;

                new Chart(normal, {
                    type: 'line',
                    data: {
                        defaultFontFamily: 'Poppins',
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Total Obese Members",
                            data: numTotals,
                            borderColor: lineChart_3gradientStroke1,
                            borderWidth: "4",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#1BD084'
                        }, {
                            label: "Members Exercising",
                            data: exercisingTotals,
                            borderColor: lineChart_3gradientStroke2,
                            borderWidth: "3",
                            backgroundColor: 'transparent',
                            pointBackgroundColor: 'rgba(0, 0, 0, 1)'
                        }]
                    },
                    options: {
                        legend: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    // max: 100,
                                    min: 0,
                                    stepSize: 50,
                                    padding: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    padding: 10
                                }
                            }]
                        }
                    }
                });
            }
        }

        /* Function ============ */
        return {
            init: function() {},


            load: async function() {
                let fetchData = async function() {
                    let items = await $.ajax({
                        type: 'GET',
                        url: `/admin/members/with-bmi-info/1`,
                        // data: {pratner_id: 1},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                    })
                    return items;
                }

                let fetchActivities = async function() {
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
                let fetchMembersBMIinfo = async function() {
                    let items = await $.ajax({
                        type: 'GET',
                        url: `/admin/members/with-bmi-info/1`,
                        // data: {pratner_id: 1},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                    })
                    return items;
                }

                let data = await fetchData().then((response) => {
                    return response;
                });
                let activities = await fetchActivities().then((response) => {
                    return response;
                });
                let memberBMIinfo = await fetchMembersBMIinfo().then((response) => {
                    return response;
                });

                obeseChart(data, activities, memberBMIinfo);
                overweightChart(data, activities, memberBMIinfo);
                underweightChart(data, activities, memberBMIinfo);
                normal(data, activities, memberBMIinfo);
            },

            resize: async function() {
                let fetchData = async function() {
                    let items = await $.ajax({
                        type: 'GET',
                        url: `/admin/members/with-bmi-info/1`,
                        // data: {pratner_id: 1},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                    })
                    return items;
                }

                let fetchActivities = async function() {
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
                let fetchMembersBMIinfo = async function() {
                    let items = await $.ajax({
                        type: 'GET',
                        url: `/admin/members/with-bmi-info/1`,
                        // data: {pratner_id: 1},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                    })
                    return items;
                }

                let data = await fetchData().then((response) => {
                    return response;
                });
                let activities = await fetchActivities().then((response) => {
                    return response;
                });
                let memberBMIinfo = await fetchMembersBMIinfo().then((response) => {
                    return response;
                });


                obeseChart(data, activities, memberBMIinfo);
                overweightChart(data, activities, memberBMIinfo);
                underweightChart(data, activities, memberBMIinfo);
                normal(data, activities, memberBMIinfo);
            }
        }

    }();

    jQuery(document).ready(function() {});

    jQuery(window).on('load', function() {
        dzSparkLine.load();
    });

    jQuery(window).on('resize', function() {
        //dzSparkLine.resize();
        setTimeout(function() {
            dzSparkLine.resize();
        }, 1000);
    });

})(jQuery);