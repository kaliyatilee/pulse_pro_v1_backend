@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Goals</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Member</th>
                                    <th>Assigned Goals</th>
                                    <th>Assign</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                    @if($member->role !== 'admin')
                                        <tr>
                                            <td><img class="rounded-circle" width="35"
                                                     src="images/profile/small/pic1.jpg"
                                                     alt=""></td>
                                            <td>{{$member->firstname}} {{$member->lastname}}</td>
                                            <td>
                                                @if(array_key_exists($member->id, $memberGoal))
                                                    <div class="flex-row ">
                                                        <div class="btn btn-primary shadow rounded-pill goal-pill">
                                                            {{$memberGoal[$member->id]->group}}
                                                            : {{$memberGoal[$member->id]->program}}
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"
                                                       data-toggle="modal"
                                                       data-target="#exampleModalCenter{{$member->id}}"><i
                                                                class="fa fa-plus"></i></a>
                                                    <div class="modal fade" id="exampleModalCenter{{$member->id}}">


                                                        @php
                                                            $age = \Carbon\Carbon::parse($member->dob)->age;
                                                            $ageGroup = '';
                                                            if ($age < 13) {
                                                                $ageGroup = 'pre-adolescent';
                                                            }
                                                            if ($age >= 13 && $age <= 17) {
                                                                $ageGroup = 'adolescent';
                                                            }
                                                            if ($age >= 18 && $age <= 25) {
                                                                $ageGroup = 'young-adult';
                                                            }
                                                            if ($age >= 26 && $age <= 59) {
                                                                $ageGroup = 'adult';
                                                            }
                                                            if ($age >= 60) {
                                                                $ageGroup = 'senior-citizen';
                                                            }
                                                        @endphp

                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Goal Details</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="basic-form">

                                                                            <form action="@if(array_key_exists($member->id, $memberGoal)){{route('overwrite_goal')}} @else {{route('assign_goal')}}@endif"
                                                                                  method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="user_id"
                                                                                       value="{{$member->id}}">
                                                                                <input type="hidden"
                                                                                       name="partner_id"
                                                                                       value="{{$partner->id}}">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label> Goal name</label>
                                                                                            <select name="goal_id" class="form-control default-select" id="goal_id" onchange="getGoalId(event)">
                                                                                                <option value="null" selected>Select Goal</option>
                                                                                                @foreach($masterGoals
                                                                                                as $goal)
                                                                                                    @if($goal->group === $ageGroup)
                                                                                                        <option value="{{$goal->id}}">
                                                                                                            {{$goal->group}}
                                                                                                            - {{$goal->program}}
                                                                                                        </option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer row">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger light"
                                                                                            data-dismiss="modal">Close
                                                                                    </button>
                                                                                    @if(!array_key_exists($member->id, $memberGoal))
                                                                                        <button type="submit"
                                                                                                class="btn btn-primary">
                                                                                            Save
                                                                                        </button>
                                                                                    @else

                                                                                        <button type="button"
                                                                                                onclick="overwriteConfirmation({{$partner->id}}, {{$member->id}},'{{route('overwrite_goal')}}', '{{@csrf_token()}}', '{{route('assigngoals')}}')"
                                                                                                class="btn btn-primary">
                                                                                            Overwrite
                                                                                        </button>
                                                                                    @endif

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
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
    <script type="text/javascript">
        @if (session('success_message'))
        swal({
            title: "Success",
            text: "{{Session::get('success_message')}}",
            dangerMode: false,
            icon: "success",
        })
        @endif

        @if (session('error_message'))
        swal({
            title: "Failed",
            text: "{{Session::get('error_message')}}",
            dangerMode: true,
            icon: "error",
        })
        @endif

        let goal_id = 'null';
        function getGoalId(event) {
            goal_id = event.target.options[event.target.selectedIndex].value;
        }
        let overwriteConfirmation = (partner_id, user_id, route, token, next) => {
            swal({
                title: "Overwrite!",
                text: "Are you sure you want to overwrite this goal",
                dangerMode: true,
                icon: "warning",
                buttons: true
            }).then(function (e) {
                if (e === true) {
                    $.ajax({
                        type: 'POST',
                        url: route,
                        data: {
                            partner_id,
                            user_id,
                            goal_id,
                            _token: token,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        error: function (response) {

                            swal({
                                title: "Failed",
                                text: response.responseText,
                                dangerMode: true,
                                icon: "error",
                            })
                        },
                        success: function () {
                            swal({
                                title: "Successful",
                                text: "Member goals updated successfully",
                                icon: "success",
                            }).then(function (e) {
                                window.location.href = next;
                            })
                        }
                    })
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }


        // function overwriteConfirmation(member_id, goal_id, partner_id, route, token, next) {
        // }
    </script>

@endsection