@extends('layouts.partner')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Member Goals</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Goal Name</th>
                                    <th>Type</th>
                                    <th>Required Target</th>
                                    <th>Manage Goals</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($goals as $goal)
                                <tr>
                                    <td>{{$goal->goal_name}}</td>
                                    <td>{{$goal->goal_type}}</td>
                                    <td>{{$goal->required_target}} {{$goal->goal_measurement}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"
                                               data-toggle="modal" data-target="#exampleModalCenter{{$goal->id}}"><i
                                                        class="fa
                                               fa-pencil"></i></a>
                                            <div class="modal fade" id="exampleModalCenter{{$goal->id}}">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Plan</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">Goal Information</h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="basic-form">
                                                                        <form action="{{route('update_master_goals',
                                                                        $goal->id)
                                                                        }}" method="POST">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="text"
                                                                                               name="goal_name"
                                                                                               class="form-control
                                                                                               input-default "
                                                                                               value="{{$goal->goal_name}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="text"
                                                                                               name="goal_type"
                                                                                               class="form-control
                                                                                               input-default "
                                                                                               value="{{$goal->goal_type}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input type="text"
                                                                                               name="required_target"
                                                                                               class="form-control
                                                                                               input-default "
                                                                                               value="{{$goal->required_target}}">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <select class="form-control
                                                                                        select-default"
                                                                                                id="sel1"
                                                                                                name="goal_measurement">
                                                                                            @if(strtolower
                                                                                            ($goal->goal_measurement) ==
                                                                                            "km")
                                                                                                <option
                                                                                                        value="km"
                                                                                                        selected
                                                                                                >Kilometers</option>
                                                                                                <option
                                                                                                        value="kg"
                                                                                                >Kilograms</option>
                                                                                            @endif
                                                                                            @if(strtolower($goal->goal_measurement) ==
                                                                                            "kg")
                                                                                                <option
                                                                                                        value="km"
                                                                                                >Kilometers</option>
                                                                                                <option
                                                                                                        value="kg"
                                                                                                        selected
                                                                                                >Kilograms</option>
                                                                                            @endif
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn
                                                                                btn-primary">Save changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
@endsection