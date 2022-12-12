@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Member Activitiesreport</h4>
                      
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Activityname</th>
                                    <th>View Data</th>
                                   
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
    <script>
        let sec_color = ['{!! $partnerdata["sec_color"] !!}'];
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