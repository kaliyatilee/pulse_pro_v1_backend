@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Revenue Report</h4>
                </div>

                
                <div class="card-body">
                    <div class="table-responsive">
                    <canvas id="chartLine2" class="chart-dropshadow2 ht-250"></canvas>
                </div>
<br>
                        <div class="row">
                            <div class="col-xl-6 col-xxl-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card avtivity-card">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                                                        <svg width="40" height="40" viewBox="0 0 40 37" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z"
                                                                fill="#A02CFA" />
                                                            <path
                                                                d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z"
                                                                fill="#A02CFA" />
                                                            <mask id="mask0" maskUnits="userSpaceOnUse" x="0"
                                                                y="19" width="39" height="55">
                                                                <path
                                                                    d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z"
                                                                    fill="#A02CFA" />
                                                            </mask>
                                                            <g mask="url(#mask0)">
                                                                <path
                                                                    d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z"
                                                                    fill="#A02CFA" />
                                                                <path
                                                                    d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z"
                                                                    fill="#A02CFA" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="media-body">
                                                        <p class="fs-14 mb-2">Self</p>
                                                        <span class="title text-black font-w600"><?= $selfubscription ?></span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="height:5px;">
                                                    <div class="progress-bar bg-secondary" style="width: 100%; height:5px;"
                                                        role="progressbar">
                                                        <span class="sr-only"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="effect bg-secondary"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="card avtivity-card">
                                            <div class="card-body">
                                                <div class="media align-items-center">
                                                    <span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                                                        <svg width="40" height="40" viewBox="0 0 40 37" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z"
                                                                fill="#A02CFA" />
                                                            <path
                                                                d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z"
                                                                fill="#A02CFA" />
                                                            <mask id="mask0" maskUnits="userSpaceOnUse" x="0"
                                                                y="19" width="39" height="55">
                                                                <path
                                                                    d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z"
                                                                    fill="#A02CFA" />
                                                            </mask>
                                                            <g mask="url(#mask0)">
                                                                <path
                                                                    d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z"
                                                                    fill="#A02CFA" />
                                                                <path
                                                                    d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z"
                                                                    fill="#A02CFA" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <div class="media-body">
                                                        <p class="fs-14 mb-2">Users</p>
                                                        <span class="title text-black font-w600"> <?= $usersubscriptions ?></span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="height:5px;">
                                                    <div class="progress-bar bg-secondary" style="width: 100%; height:5px;"
                                                        role="progressbar">
                                                        <span class="sr-only"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="effect bg-secondary"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                {{-- <div class="row mt-3 ml-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <p>Self: <?= $selfubscription ?></p>
                            <p>Users: <?= $usersubscriptions ?></p>
                        </div>
                    </div>

                </div> --}}

                <div class="card-body">
                    <div class="table-responsive">
                    <canvas id="chartLine" class="chart-dropshadow2" style="height: 500px !important;"></canvas>
                </div>

            </div>
            </div>
        </div>

    </div>
</div>
</div>


@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
     $(function() {

         /*LIne-Chart */
         var ctx = document.getElementById("chartLine2").getContext('2d');
        var myChart = new Chart(ctx, {

            data: {
                labels: ['<?= $one ?>', '<?= $two ?>', '<?= $three ?>', '<?= $four ?>', '<?= $five ?>', '<?= $six ?>', '<?= $seven ?>', '<?= $eight ?>'],
                datasets: [{
                        label: 'No Of Subscriptions',
                        data: [<?= $onev ?>, <?= $twov ?>, <?= $threev ?>, <?= $fourv ?>, <?= $fivev ?>, <?= $sixv ?>, <?= $sevenv ?>,  <?= $eightv ?>],
                        borderWidth: 3,
                        backgroundColor: 'transparent',
                        borderColor: '#6259ca',
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 0,
                        type: 'line',
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: true,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: "#c8ccdb",
                        },
                        barPercentage: 0.7,
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)',
                            zeroLineColor: 'rgba(119, 119, 142, 0.2)',
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                        },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)',
                            zeroLineColor: 'rgba(119, 119, 142, 0.2)',
                        },
                        ticks: {
                            min: 0,
                            max: 1000,
                            stepSize: 200
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Thousands',
                            fontColor: 'transparent'
                        }
                    }]
                },
                legend: {
                    display: true,
                    width: 30,
                    height: 30,
                    borderRadius: 50,
                    labels: {
                        fontColor: "#77778e"
                    },
                },
            }
        });



        /*LIne-Chart */
        var ctx = document.getElementById("chartLine").getContext('2d');
        var myChart = new Chart(ctx, {

            data: {
                labels: ['Self', 'Users'],
                datasets: [{
                        label: 'Self / Users',
                        data: [<?= $selfubscription ?>, <?= $usersubscriptions ?>],
                        borderWidth: 3,
                        backgroundColor: 'transparent',
                        borderColor: '#6259ca',
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 0,
                        type: 'line',
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: true,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: "#c8ccdb",
                        },
                        barPercentage: 0.7,
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)',
                            zeroLineColor: 'rgba(119, 119, 142, 0.2)',
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                        },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)',
                            zeroLineColor: 'rgba(119, 119, 142, 0.2)',
                        },
                        ticks: {
                            min: 0,
                            max: 1000,
                            stepSize: 100
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Thousands',
                            fontColor: 'transparent'
                        }
                    }]
                },
                legend: {
                    display: true,
                    width: 30,
                    height: 30,
                    borderRadius: 50,
                    labels: {
                        fontColor: "#77778e"
                    },
                },
            }
        });

    });

</script>