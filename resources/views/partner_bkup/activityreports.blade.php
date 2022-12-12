@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Activities Report</h4>
                    </div>
                    <div class="card-header">
                        <div class="container mt-0">

                            <div class="row">
                                <div class="col-2 d-flex align-items-center">
                                    <div class="form-group my-auto">
                                        <label for="activities" class="ml-2">Select Activities</label>
                                        <select name="activities" class="form-control default-select text-left"
                                                id="activities">
                                            <option value="all" selected>All</option>
                                            <option value="running">Running</option>
                                            <option value="walking">Walking</option>
                                            <option value="cycling">Cycling</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group my-auto">
                                        <label for="weight" class="ml-2">Choose Weight</label>
                                        <select name="weight" class="form-control default-select text-left"
                                                id="weight">
                                            <option value="all" selected>All</option>
                                            <option value="underweight">Underweight</option>
                                            <option value="normal">Normal</option>
                                            <option value="overweight">Overweight</option>
                                            <option value="obese">Obese</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 d-flex offset-lg-2 offset-md-1 align-items-center">
                                    <div class="form-group my-auto">
                                        <label for="startDate" class="ml-2">Start Date</label>
                                        <input id="startDate" name="startDate" type="date"
                                               class="form-control input-default h-auto py-3"
                                        >
                                    </div>
                                    <div class="form-group ml-5 my-auto">
                                        <label for="endDate" class="ml-2">End Date</label>
                                        <input id="endDate" name="endDate" type="date"
                                               class="form-control input-default h-auto py-3"
                                        >
                                    </div>
                                    <button id="filter" class="btn btn-success ml-5 mt-4">Filter</button>
                                    <button id="reset" class="btn btn-outline-warning ml-2 mt-4">Reset</button>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="activityReport" class="display min-w850">
                                <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Weight</th>
                                    <th>Distance Covered</th>
                                    <th>Calories Burnt</th>
                                    <th>Steps Count</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript">
        const sec_color = ['{!! $partnerdata["sec_color"] !!}'];
        const partner_id = ['{!! $partner->id !!}'];
        let data;
        let startDate = new Date();
        let endDate = new Date();
        const activities = document.querySelector('#activities');
        const weight = document.querySelector('#weight');
        const startDateInput = document.querySelector('#startDate');
        const endDateInput = document.querySelector('#endDate');
        const filter = document.querySelector('#filter');
        const reset = document.querySelector('#reset');
        let tableBody = document.querySelector('#activityReport').querySelector('tbody');
        const table = document.querySelector('#activityReport');

        startDateInput.addEventListener('change', (e) => {
            startDate = new Date(e.target.value).toJSON();
        });
        endDateInput.addEventListener('change', (e) => {
            endDate = new Date(e.target.value).toJSON();
        })
        let fetchData = async function ({partner_id, startDate, endDate, activities, weight}) {
            let items;
            await $.ajax({
                type: 'POST',
                url: `/admin/member/activities/range/${partner_id}/${startDate}/${endDate}/${activities}/${weight}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    items = response;
                }
            })
            return items;
        }
        let fetchMemberDetails = async function (member_id) {
            let items;
            await $.ajax({
                type: 'POST',
                url: `/admin/members/${member_id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    items = response;
                }
            })
            return items;
        }
        const populateTable = async (data) => {
            let rows = '';
            let test = ''

            if (data) {
                await data.forEach(td = async (td) => {
                    await fetchMemberDetails(td.user_id).then(member => {
                        let weight = '';
                        if(member.bmi < 18.5)
                            weight = 'under-weight';
                        if(member.bmi >= 18.5 && member.bmi <= 24.9)
                            weight = 'normal'
                        if(member.bmi >= 25 && member.bmi <= 29.9)
                            weight = 'over-weight';
                        if(member.bmi >= 30)
                            weight = 'obese';
                        let content = `<tr>
                            <td>${weight}</td>
                            <td>${weight}</td>
                            <td>${weight}</td>
                            <td>${weight}</td>
                            <td>${weight}</td>
                            <td>${weight}</td>
                        </tr>`;

                        let newRow = tableBody.insertRow(tableBody.rows.length);
                        newRow.innerHTML = content
                    })
                })

                // tableBody.innerHTML = rows
            }

            // tableBody = rows;
        }
        fetchData({
            partner_id: partner_id,
            startDate: startDate,
            endDate: endDate,
            activities: activities.value,
            weight: weight.value
        }).then(response => {
            data = response;
            populateTable(data);
        });
        filter.addEventListener('click', (e) => {
            fetchData({
                partner_id: partner_id,
                startDate: startDate,
                endDate: endDate,
                activities: activities.value,
                weight: weight.value
            }).then(response => {
                data = response;
                populateTable(data);
            });
        })
    </script>
    <script type="text/javascript">
        @if (session('success_message'))
        swal({
            title: "Success",
            text: "{{Session::get('success_message')}}",
            dangerMode: false,
            icon: "success",
        })
        @endif
    </script>
@endsection


{{--@extends('layouts.partner')--}}
{{--@section('content')--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="row">--}}
{{--            <div class="col-xl-6 col-xxl-12">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-sm-4">--}}
{{--                        <div class="card avtivity-card">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="media align-items-center">--}}
{{--											<span class="activity-icon bgl-success mr-md-4 mr-3">--}}
{{--												<svg width="40" height="40" viewBox="0 0 40 40" fill="none"--}}
{{--                                                     xmlns="http://www.w3.org/2000/svg">--}}
{{--													<g clip-path="url(#clip2)">--}}
{{--													<path d="M14.6406 24.384C14.4639 24.1871 14.421 23.904 14.5305 23.6633C15.9635 20.513 14.4092 18.7501 14.564 11.6323C14.5713 11.2944 14.8346 10.9721 15.2564 10.9801C15.6201 10.987 15.905 11.2962 15.8971 11.6598C15.8902 11.9762 15.8871 12.2939 15.8875 12.6123C15.888 12.9813 16.1893 13.2826 16.5583 13.2776C17.6426 13.2628 19.752 12.9057 20.5684 10.4567L20.9744 9.23876C21.7257 6.9847 20.4421 4.55115 18.1335 3.91572L13.9816 2.77294C12.3274 2.31768 10.5363 2.94145 9.52387 4.32498C4.66826 10.9599 1.44452 18.5903 0.0754914 26.6727C-0.300767 28.8937 0.754757 31.1346 2.70222 32.2488C13.6368 38.5051 26.6023 39.1113 38.35 33.6379C39.3524 33.1709 40.0002 32.1534 40.0002 31.0457V19.1321C40.0002 18.182 39.5322 17.2976 38.7484 16.7664C34.5339 13.91 29.1672 14.2521 25.5723 18.0448C25.2519 18.3828 25.3733 18.937 25.8031 19.1166C27.4271 19.7957 28.9625 20.7823 30.2439 21.9475C30.5225 22.2008 30.542 22.6396 30.2654 22.9155C30.0143 23.1658 29.6117 23.1752 29.3485 22.9376C25.9907 19.9053 21.4511 18.5257 16.935 19.9686C16.658 20.0571 16.4725 20.3193 16.477 20.61C16.496 21.8194 16.294 22.9905 15.7421 24.2172C15.5453 24.6544 14.9607 24.7409 14.6406 24.384Z"--}}
{{--                                                          fill="#27BC48"/>--}}
{{--													</g>--}}
{{--													<defs>--}}
{{--													<clipPath id="clip2">--}}
{{--													<rect width="40" height="40" fill="white"/>--}}
{{--													</clipPath>--}}
{{--													</defs>--}}
{{--												</svg>--}}
{{--											</span>--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="fs-14 mb-2">Active Walkers</p>--}}
{{--                                        <span class="title text-black font-w600">{{$active['walkers']}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="progress" style="height:5px;">--}}
{{--                                    <div class="progress-bar bg-success" style="width: 42%; height:5px;"--}}
{{--                                         role="progressbar">--}}
{{--                                        <span class="sr-only"></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="effect bg-success"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-4">--}}
{{--                        <div class="card avtivity-card">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="media align-items-center">--}}
{{--											<span class="activity-icon bgl-secondary  mr-md-4 mr-3">--}}
{{--												<svg width="40" height="37" viewBox="0 0 40 37" fill="none"--}}
{{--                                                     xmlns="http://www.w3.org/2000/svg">--}}
{{--													<path d="M1.64826 26.5285C0.547125 26.7394 -0.174308 27.8026 0.0366371 28.9038C0.222269 29.8741 1.07449 30.5491 2.02796 30.5491C2.15453 30.5491 2.28531 30.5364 2.41188 30.5112L10.7653 28.908C11.242 28.8152 11.6682 28.5578 11.9719 28.1781L15.558 23.6554L14.3599 23.0437C13.4739 22.5965 12.8579 21.7865 12.6469 20.8035L9.26338 25.0688L1.64826 26.5285Z"--}}
{{--                                                          fill="#A02CFA"/>--}}
{{--													<path d="M31.3999 8.89345C33.8558 8.89345 35.8467 6.90258 35.8467 4.44673C35.8467 1.99087 33.8558 0 31.3999 0C28.9441 0 26.9532 1.99087 26.9532 4.44673C26.9532 6.90258 28.9441 8.89345 31.3999 8.89345Z"--}}
{{--                                                          fill="#A02CFA"/>--}}
{{--													<path d="M21.6965 3.33297C21.2282 2.85202 20.7937 2.66217 20.3169 2.66217C20.1439 2.66217 19.971 2.68748 19.7853 2.72967L12.1534 4.53958C11.0986 4.78849 10.4489 5.84744 10.6979 6.89795C10.913 7.80079 11.7146 8.40831 12.6048 8.40831C12.7567 8.40831 12.9086 8.39144 13.0605 8.35347L19.5618 6.81357C19.9837 7.28187 22.0974 9.57273 22.4813 9.97775C19.7938 12.855 17.1064 15.7281 14.4189 18.6054C14.3767 18.6519 14.3388 18.6982 14.3008 18.7446C13.5161 19.7445 13.7566 21.3139 14.9379 21.9088L23.1774 26.1151L18.8994 33.0467C18.313 34.0002 18.6083 35.249 19.5618 35.8396C19.8951 36.0464 20.2621 36.1434 20.6249 36.1434C21.3042 36.1434 21.9707 35.8017 22.3547 35.1815L27.7886 26.3766C28.0882 25.8915 28.1683 25.305 28.0122 24.7608C27.8561 24.2123 27.4806 23.7567 26.9702 23.4993L21.3885 20.66L27.2571 14.3823L31.6869 18.1371C32.0539 18.4493 32.5054 18.6012 32.9526 18.6012C33.4335 18.6012 33.9145 18.424 34.2899 18.078L39.3737 13.3402C40.1669 12.6019 40.2133 11.3615 39.475 10.5684C39.0868 10.1549 38.5637 9.944 38.0406 9.944C37.5638 9.944 37.0829 10.117 36.7074 10.4671L32.9019 14.0068C32.8977 14.011 23.363 5.04163 21.6965 3.33297Z"--}}
{{--                                                          fill="#A02CFA"/>--}}
{{--												</svg>--}}
{{--											</span>--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="fs-14 mb-2">Active Runners</p>--}}
{{--                                        <span class="title text-black font-w600">{{$active['runners']}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="progress" style="height:5px;">--}}
{{--                                    <div class="progress-bar bg-secondary" style="width: 82%; height:5px;"--}}
{{--                                         role="progressbar">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="effect bg-secondary"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-4">--}}
{{--                        <div class="card avtivity-card">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="media align-items-center">--}}
{{--											<span class="activity-icon bgl-danger mr-md-4 mr-3">--}}
{{--												<svg width="40" height="39" viewBox="0 0 40 39" fill="none"--}}
{{--                                                     xmlns="http://www.w3.org/2000/svg">--}}
{{--													<path d="M18.0977 7.90402L9.78535 16.7845C9.17929 17.6683 9.40656 18.872 10.2862 19.4738L18.6574 25.2104V30.787C18.6574 31.8476 19.4992 32.7357 20.5598 32.7568C21.6456 32.7735 22.5295 31.9023 22.5295 30.8207V24.1961C22.5295 23.5564 22.2138 22.9588 21.6877 22.601L16.3174 18.9184L20.8376 14.1246L23.1524 19.3982C23.4596 20.101 24.1582 20.5556 24.9243 20.5556H31.974C33.0346 20.5556 33.9226 19.7139 33.9437 18.6532C33.9605 17.5674 33.0893 16.6835 32.0076 16.6835H26.1953C25.4293 14.9411 24.6128 13.2155 23.9015 11.4478C23.5395 10.5556 23.3376 10.1684 22.6726 9.55389C22.5379 9.42763 21.5993 8.56904 20.7618 7.80305C19.9916 7.10435 18.8047 7.15065 18.0977 7.90402Z"--}}
{{--                                                          fill="#FF3282"/>--}}
{{--													<path d="M26.0269 8.87206C28.4769 8.87206 30.463 6.88598 30.463 4.43603C30.463 1.98608 28.4769 0 26.0269 0C23.577 0 21.5909 1.98608 21.5909 4.43603C21.5909 6.88598 23.577 8.87206 26.0269 8.87206Z"--}}
{{--                                                          fill="#FF3282"/>--}}
{{--													<path d="M8.16498 38.388C12.6744 38.388 16.33 34.7325 16.33 30.2231C16.33 25.7137 12.6744 22.0581 8.16498 22.0581C3.65559 22.0581 0 25.7137 0 30.2231C0 34.7325 3.65559 38.388 8.16498 38.388Z"--}}
{{--                                                          fill="#FF3282"/>--}}
{{--													<path d="M31.835 38.388C36.3444 38.388 40 34.7325 40 30.2231C40 25.7137 36.3444 22.0581 31.835 22.0581C27.3256 22.0581 23.67 25.7137 23.67 30.2231C23.67 34.7325 27.3256 38.388 31.835 38.388Z"--}}
{{--                                                          fill="#FF3282"/>--}}
{{--												</svg>--}}
{{--											</span>--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="fs-14 mb-2">Active Cyclers</p>--}}
{{--                                        <span class="title text-black font-w600">{{$active['cyclers']}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="progress" style="height:5px;">--}}
{{--                                    <div class="progress-bar bg-danger" style="width: 50%; height:5px;"--}}
{{--                                         role="progressbar">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="effect bg-danger"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-6 col-xxl-12 bg-white">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-sm-flex d-block pb-3 border-0">--}}
{{--                        <div class="mr-auto pr-3 mb-sm-0 mb-3">--}}
{{--                            <h4 class="text-black fs-20">Activities Stats</h4>--}}
{{--                            <p class="fs-13 mb-0 text-black">#Running #Cycling #Walking</p>--}}
{{--                        </div>--}}
{{--                        <div class="select-box">--}}
{{--                            <div class="options-container" style="z-index: 100;">--}}
{{--                                <div class="option">--}}
{{--                                    <input type="radio" class="radio" id="walking" name="activities"/>--}}
{{--                                    <label for="walking" class="btn rounded btn-light">--}}
{{--                                        <svg width="20" height="39" viewBox="0 0 40 39" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z"--}}
{{--                                                  fill="#A02CFA"/>--}}
{{--                                            <path d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z"--}}
{{--                                                  fill="#A02CFA"/>--}}
{{--                                            <mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="19" width="39"--}}
{{--                                                  height="55">--}}
{{--                                                <path d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                            </mask>--}}
{{--                                            <g mask="url(#mask0)">--}}
{{--                                                <path d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                                <path d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                            </g>--}}
{{--                                        </svg>--}}
{{--                                        Walking--}}
{{--                                        <svg class="ml-2" width="14" height="8" viewBox="0 0 14 8" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M1 0.999999L7 7L13 1" stroke="#8cc640" stroke-width="2"--}}
{{--                                                  stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                        </svg>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                                <div class="option">--}}
{{--                                    <input type="radio" class="radio" id="cycling" name="activities"/>--}}
{{--                                    <label for="cycling" class="btn rounded btn-light">--}}
{{--                                        <svg width="20" height="39" viewBox="0 0 40 39" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M18.0977 7.90402L9.78535 16.7845C9.17929 17.6683 9.40656 18.872 10.2862 19.4738L18.6574 25.2104V30.787C18.6574 31.8476 19.4992 32.7357 20.5598 32.7568C21.6456 32.7735 22.5295 31.9023 22.5295 30.8207V24.1961C22.5295 23.5564 22.2138 22.9588 21.6877 22.601L16.3174 18.9184L20.8376 14.1246L23.1524 19.3982C23.4596 20.101 24.1582 20.5556 24.9243 20.5556H31.974C33.0346 20.5556 33.9226 19.7139 33.9437 18.6532C33.9605 17.5674 33.0893 16.6835 32.0076 16.6835H26.1953C25.4293 14.9411 24.6128 13.2155 23.9015 11.4478C23.5395 10.5556 23.3376 10.1684 22.6726 9.55389C22.5379 9.42763 21.5993 8.56904 20.7618 7.80305C19.9916 7.10435 18.8047 7.15065 18.0977 7.90402Z"--}}
{{--                                                  fill="#FF3282"/>--}}
{{--                                            <path d="M26.0269 8.87206C28.4769 8.87206 30.463 6.88598 30.463 4.43603C30.463 1.98608 28.4769 0 26.0269 0C23.577 0 21.5909 1.98608 21.5909 4.43603C21.5909 6.88598 23.577 8.87206 26.0269 8.87206Z"--}}
{{--                                                  fill="#FF3282"/>--}}
{{--                                            <path d="M8.16498 38.388C12.6744 38.388 16.33 34.7325 16.33 30.2231C16.33 25.7137 12.6744 22.0581 8.16498 22.0581C3.65559 22.0581 0 25.7137 0 30.2231C0 34.7325 3.65559 38.388 8.16498 38.388Z"--}}
{{--                                                  fill="#FF3282"/>--}}
{{--                                            <path d="M31.835 38.388C36.3444 38.388 40 34.7325 40 30.2231C40 25.7137 36.3444 22.0581 31.835 22.0581C27.3256 22.0581 23.67 25.7137 23.67 30.2231C23.67 34.7325 27.3256 38.388 31.835 38.388Z"--}}
{{--                                                  fill="#FF3282"/>--}}
{{--                                        </svg>--}}
{{--                                        Cycling--}}
{{--                                        <svg class="ml-2" width="14" height="8" viewBox="0 0 14 8" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M1 0.999999L7 7L13 1" stroke="#8cc640" stroke-width="2"--}}
{{--                                                  stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                        </svg>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                                <div class="option">--}}
{{--                                    <input type="radio" class="radio" id="running" name="activities"/>--}}
{{--                                    <label for="running" class="btn rounded btn-light">--}}
{{--                                        <svg class="" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <g clip-path="url(#clip5)">--}}
{{--                                                <path d="M0.988957 17.0741C0.328275 17.2007 -0.104585 17.8386 0.0219823 18.4993C0.133362 19.0815 0.644694 19.4865 1.21678 19.4865C1.29272 19.4865 1.37119 19.4789 1.44713 19.4637L6.4592 18.5018C6.74524 18.4461 7.00091 18.2917 7.18316 18.0639L9.33481 15.3503L8.61593 14.9832C8.08435 14.7149 7.71475 14.2289 7.58818 13.6391L5.55804 16.1983L0.988957 17.0741Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                                <path d="M18.84 6.49306C20.3135 6.49306 21.508 5.29854 21.508 3.82502C21.508 2.3515 20.3135 1.15698 18.84 1.15698C17.3665 1.15698 16.1719 2.3515 16.1719 3.82502C16.1719 5.29854 17.3665 6.49306 18.84 6.49306Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                                <path d="M13.0179 3.15677C12.7369 2.86819 12.4762 2.75428 12.1902 2.75428C12.0864 2.75428 11.9826 2.76947 11.8712 2.79479L7.29203 3.88073C6.6592 4.03008 6.26937 4.66545 6.41872 5.29576C6.54782 5.83746 7.02877 6.20198 7.56289 6.20198C7.65404 6.20198 7.74514 6.19185 7.8363 6.16907L11.7371 5.24513C11.9902 5.52611 13.2584 6.90063 13.4888 7.14364C11.8763 8.87002 10.2639 10.5939 8.65137 12.3202C8.62605 12.3481 8.60329 12.3759 8.58049 12.4038C8.10966 13.0037 8.25397 13.9454 8.96275 14.3023L13.9064 16.826L11.3397 20.985C10.9878 21.5571 11.165 22.3064 11.7371 22.6608C11.9371 22.7848 12.1573 22.843 12.375 22.843C12.7825 22.843 13.1824 22.638 13.4128 22.2659L16.6732 16.983C16.8529 16.6919 16.901 16.34 16.8074 16.0135C16.7137 15.6844 16.4884 15.411 16.1821 15.2566L12.8331 13.553L16.3543 9.78636L19.0122 12.0393C19.2324 12.2266 19.5032 12.3177 19.7716 12.3177C20.0601 12.3177 20.3487 12.2114 20.574 12.0038L23.6243 9.16112C24.1002 8.71814 24.128 7.97392 23.685 7.49803C23.4521 7.24996 23.1383 7.12339 22.8244 7.12339C22.5383 7.12339 22.2497 7.22717 22.0245 7.43727L19.7412 9.56107C19.7386 9.56361 14.0178 4.18196 13.0179 3.15677Z"--}}
{{--                                                      fill="#A02CFA"/>--}}
{{--                                            </g>--}}
{{--                                            <defs>--}}
{{--                                                <clipPath id="clip5">--}}
{{--                                                    <rect width="24" height="24" fill="white"/>--}}
{{--                                                </clipPath>--}}
{{--                                            </defs>--}}
{{--                                        </svg>--}}
{{--                                        Running--}}
{{--                                        <svg class="" width="14" height="8" viewBox="0 0 14 8" fill="none"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M1 0.999999L7 7L13 1" stroke="#8cc640" stroke-width="2"--}}
{{--                                                  stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                        </svg>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="selected btn btn-light mb-1">--}}
{{--                                <svg width="20" height="39" viewBox="0 0 40 39" fill="none"--}}
{{--                                     xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z"--}}
{{--                                          fill="#A02CFA"/>--}}
{{--                                    <path d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z"--}}
{{--                                          fill="#A02CFA"/>--}}
{{--                                    <mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="19" width="39"--}}
{{--                                          height="55">--}}
{{--                                        <path d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z"--}}
{{--                                              fill="#A02CFA"/>--}}
{{--                                    </mask>--}}
{{--                                    <g mask="url(#mask0)">--}}
{{--                                        <path d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z"--}}
{{--                                              fill="#A02CFA"/>--}}
{{--                                        <path d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z"--}}
{{--                                              fill="#A02CFA"/>--}}
{{--                                    </g>--}}
{{--                                </svg>--}}
{{--                                Walking--}}
{{--                                <svg class="ml-2" width="14" height="8" viewBox="0 0 14 8" fill="none"--}}
{{--                                     xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M1 0.999999L7 7L13 1" stroke="#8cc640" stroke-width="2"--}}
{{--                                          stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body pt-0 pb-5 mb-5 bg-white">--}}
{{--                <div id="chartBarWalking" class="chartBar active"></div>--}}
{{--                <div id="chartBarRunning" class="chartBar hidden"></div>--}}
{{--                <div id="chartBarCycling" class="chartBar hidden"></div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--    <script>--}}
{{--        let sec_color = ['{!! $partnerdata["sec_color"] !!}'];--}}

{{--        const selected = document.querySelector(".selected");--}}
{{--        const optionsContainer = document.querySelector(".options-container");--}}

{{--        const optionsList = document.querySelectorAll(".option");--}}
{{--        const chartBarList = document.querySelectorAll(".chartBar");--}}

{{--        selected.addEventListener("click", (event) => {--}}
{{--            optionsContainer.classList.toggle("active");--}}
{{--        });--}}
{{--        chartBarList.forEach(c => {--}}
{{--            if (c.classList.contains('hidden')) {--}}
{{--                c.style.display = "none"--}}
{{--            }--}}
{{--        });--}}
{{--        optionsList.forEach(o => {--}}
{{--            o.addEventListener("click", (event) => {--}}
{{--                selected.innerHTML = o.querySelector("label").innerHTML;--}}
{{--                optionsContainer.classList.remove("active");--}}
{{--                switch (selected.outerText.trim().toLowerCase()) {--}}
{{--                    case "running":--}}
{{--                        chartBarList.forEach(chart => {--}}
{{--                            if (chart.id.toLowerCase().includes('running')) {--}}
{{--                                chart.classList.remove('hidden');--}}
{{--                                chart.classList.add('active');--}}
{{--                            } else {--}}
{{--                                chart.classList.add('hidden');--}}
{{--                                chart.classList.remove('active');--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('hidden')) {--}}
{{--                                chart.style.display = "none"--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('active')) {--}}
{{--                                chart.style.display = "block"--}}
{{--                            }--}}
{{--                        })--}}
{{--                        break;--}}
{{--                    case "cycling":--}}
{{--                        chartBarList.forEach(chart => {--}}
{{--                            if (chart.id.toLowerCase().includes('cycling')) {--}}
{{--                                chart.classList.remove('hidden');--}}
{{--                                chart.classList.add('active');--}}
{{--                            } else {--}}
{{--                                chart.classList.add('hidden');--}}
{{--                                chart.classList.remove('active');--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('hidden')) {--}}
{{--                                chart.style.display = "none"--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('active')) {--}}
{{--                                chart.style.display = "block"--}}
{{--                            }--}}
{{--                        })--}}
{{--                        break;--}}
{{--                    default:--}}
{{--                        chartBarList.forEach(chart => {--}}
{{--                            if (chart.id.toLowerCase().includes('walking')) {--}}
{{--                                chart.classList.remove('hidden');--}}
{{--                                chart.classList.add('active');--}}
{{--                            } else {--}}
{{--                                chart.classList.add('hidden');--}}
{{--                                chart.classList.remove('active');--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('hidden')) {--}}
{{--                                chart.style.display = "none"--}}
{{--                            }--}}
{{--                            if (chart.classList.contains('active')) {--}}
{{--                                chart.style.display = "block"--}}
{{--                            }--}}
{{--                        })--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}