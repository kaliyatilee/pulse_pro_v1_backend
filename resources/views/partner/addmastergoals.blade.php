@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Goal Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="post" action="{{route('create_master_goals')}}">
                                @csrf
                                <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group my-auto">
                                            <label>Group</label>
                                            <select class="form-control default-select text-left" name="group" required>
                                                <option value="null" selected>None</option>
                                                <option value="pre-adolescent" class="py-2">pre-adolescent</option>
                                                <option value="adolescent">adolescent</option>
                                                <option value="young-adult">young-adult</option>
                                                <option value="adult">adult</option>
                                                <option value="senior-citizen">senior-citizen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-group">
                                            <label>Program</label>
                                            <input name="program" type="text" class="form-control input-text"
                                                   placeholder="program name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Steps</label>
                                                    <input name="steps" type="number"
                                                           class="form-control input-default "
                                                           placeholder="Steps" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Distance</label>
                                                    <input name="distance" type="number"
                                                           class="form-control input-default "
                                                           placeholder="distance in kilometers" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Calories</label>
                                                    <input name="calories" type="number"
                                                           class="form-control input-default "
                                                           placeholder="amount of calories" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Weekly Frequency</label>
                                                    <input name="weekly_frequency" type="number" class="form-control input-default "
                                                           placeholder="days per week" required>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Duration Per Session</label>
                                                    <div class="row">
                                                        <div class="col-6 d-flex align-items-center align-content-between">
                                                            <input name="duration_from" type="number" class="form-control input-default"
                                                                   placeholder="from 0 minutes" required>
                                                        </div>
                                                        <div class="col-6 d-flex align-items-center">
                                                            <input name="duration_to" type="number" class="form-control input-default "
                                                                   placeholder="to 0 minutes">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row-md-2">
                                        <div class="form-group">
                                            <label>Consideration</label>
                                            <textarea class="form-control" name="additional_consideration"
                                                      rows="8" placeholder="What are your additional considerations"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Recommendations</label>
                                            <textarea class="form-control" name="recommendations"
                                                      rows="8" placeholder="What are your recommendations"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Participation</label>
                                            <textarea class="form-control" name="participation"
                                                      rows="8" placeholder="Any participation schemas for patient"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Daily Calorie Intake</label>
                                            <input name="daily_calorie_intake" type="text" class="form-control input-text"
                                                   placeholder="for underweight individuals">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Reminder</label>
                                            <input name="reminder" type="text" class="form-control input-text"
                                                   placeholder="remind to">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
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
            text: "{{session('success_message')}}",
            dangerMode: false,
            icon: "success",
        })
        @endif
    </script>
@endsection