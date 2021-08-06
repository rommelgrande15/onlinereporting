'@extends('layouts.client._new')
@section('title',ucfirst($category) . ' History')
@section('page-title',ucfirst($category) . ' History')
@section('stylesheets')
@if(strpos(Request::url(''), 'tic-sera') !== false)
{!! Html::style('/css/admin/dashboard-sera.css') !!}
@else
{!! Html::style('/css/admin/dashboard.css') !!}
@endif
<style>
    .fa-loader {
        -webkit-animation: spin 2s linear infinite;
        -moz-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-moz-keyframes spin {
        100% {
            -moz-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    .content-header h1 {
        border-bottom: 3px solid orange;
        width: 30%;
        text-align: center;
        margin: 0 auto;
    }

    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: orange !important;
    }

</style>
@endsection

@section('content') 
<div class="row">
    <div class="col-md-12 padding-b-25">
        <div class="table-responsive">
            <table id="history_table" class="table table-condensed cell-border  small dataTable no-footer">
                <thead>
                    <tr>
                        <th>Action Type</th>
                        <th>Account</th>
                        <th>Action Taken</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($logs->count())
                    @foreach($logs as $log)
                    @php
                    if($log->type == "add"){
                    $class = "green";
                    } else if($log->type == "edit"){
                    $class = "yellow";
                    } else if($log->type == "delete"){
                    $class = "red";
                    }
                    @endphp
                    <tr>
                        <td><label class="badge bg-{{ $class }}">{{ ucfirst($log->type) }}</label></td>
                        <td>{{ $log->username }}</td>
                        <td>{{ $log->subject }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.col -->
    </div>
</div>

<div class="send-loading"></div>
@endsection
@section('scripts')
<script>
    //$('#product_table').DataTable();
    $('#history_table').dataTable({
        order: [3, 'desc']
    });
    var msg = '{!!Session::get('
    alert ')!!}';
    var exist = '{!!Session::has('
    alert ')!!}';
    if (exist) {
        alert(msg);
    }
    var auth_id = "{{Auth::id()}}";
    var token = "{{csrf_token()}}";

</script>
@endsection
