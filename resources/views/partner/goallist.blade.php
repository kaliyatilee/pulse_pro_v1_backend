@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Master Goals</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="showGoals" class="display min-w850">
                                <thead>
                                <tr>
                                    <th>Program Name</th>
                                    <th>Age Group</th>
                                    <th>Steps</th>
                                    <th>Distance</th>
                                    <th>Calories</th>
                                    <th>Duration</th>
                                    <th>More</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($goals as $goal)
                                    <tr>
                                        <td>{{$goal->program}}</td>
                                        <td>{{$goal->group}}</td>
                                        <td>{{$goal->steps}}</td>
                                        <td>{{$goal->distance}}</td>
                                        <td>{{$goal->calories}}</td>
                                        <td>{{$goal->duration_per_session}}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"
                                                   data-toggle="modal"
                                                   data-target="#exampleModalCenter{{$goal->id}}"><i
                                                            class="fa fa-pencil"></i></a>
                                                <div class="modal fade" id="exampleModalCenter{{$goal->id}}">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-uppercase font-w700 text-black-50">
                                                                    <span class="text-uppercase font-w400 text-black-50">More About - </span>
                                                                    {{$goal->program}}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal"><span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        @if($goal->daily_calorie_intake)
                                                                            <h5 class="text-sm text-uppercase text-black-50 font-weight-bold">Daily Calorie Intake</h5>
                                                                            <p class="text-small font-w300 font-w200 text-black-50">{{$goal->daily_calorie_intake}}</p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @if($goal->reminder)
                                                                            <h5 class="text-sm text-uppercase text-black-50 font-weight-bold">Reminder</h5>
                                                                            <p class="text-small font-w300 font-w200 text-black-50">{{$goal->reminder}}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        @if($goal->participation)
                                                                            <h5 class="text-sm text-uppercase text-black-50 font-weight-bold">Participation</h5>
                                                                            <p class="text-small font-w300 font-w200 text-black-50">{{$goal->participation}}</p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @if($goal->recommendations)
                                                                            <h5 class="text-sm text-uppercase text-black-50 font-weight-bold">Recommendations</h5>
                                                                            <p class="text-small font-w300 font-w200 text-black-50">{{$goal->recommendations}}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row text-center">
                                                                    <div class="col">
                                                                        @if($goal->additional_consideration)
                                                                            <h5 class="text-sm text-uppercase text-black-50 font-weight-bold">Recommendations</h5>
                                                                            <p class="text-small font-w300 font-w200 text-black-50">{{$goal->recommendations}}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button data-id="{{ $goal->id }}" onclick="deleteConfirmation
                                                        ({{$goal->id}}, '{{ route('destroy_master_goals',
                                                $goal->id)}}', '{{csrf_token()}}', '{{route('showgoals')}}')"
                                                        class="btn
                                                btn-danger
                                            shadow
                                            btn-xs
                                            sharp"><i
                                                            class="fa
                                            fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
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
    </script>
@endsection