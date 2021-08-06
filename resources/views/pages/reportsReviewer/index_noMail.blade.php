@extends('layouts.reports_reviewer_template')

@section('title', 'Reports Reviewer')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
@endsection


@section('topbar')

@endsection
@section('sidebar')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12 padding-b-25">
        <h3>Inspections</h3>
        <div class="table-responsive">
            <table id="clients_table" class="display table table-condensed cell-border small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-left"></th>
                        <th class="text-left">Reference #</th>
                        <th class="text-left">Client Name</th>
                        <th class="text-left">Company Name</th>
                        <th class="text-left">Working By</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Inspection Date</th>
                        <th class="text-left">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('partials.reports_reviewer.dashboard._upload_report_nomail')
@include('partials.reports_reviewer.dashboard._view_report')
@include('partials.reports_reviewer.dashboard._upload_profile')
@include('partials.reports_reviewer.dashboard._assign_reporter')
@endsection
@section('scripts')
{!! Html::script('/js/dropzone.js') !!}
{!! Html::script('/js/reports-reviewer/panel-reports_reviewer.js') !!}
<script>
    $(document).ready(function() {
        var token = "{{csrf_token()}}";
        
        $('#clients_table').DataTable({
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('all-inspections') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "order": [
                [6, "desc"]
            ],
            "columns": [

                {
                    "data": "client_book"
                },
                {
                    "data": "reference_number"
                },
                {
                    "data": "client_name"
                },
                {
                    "data": "Company_Name"
                },
                {
                    "data": "name"
                },
                {
                    "data": "inspection_status"
                },
                {
                    "data": "inspection_date"
                },
                {
                    "data": "options",
                    "searchable": false,
                    "orderable": false
                }
            ]
        });

        $('#reports_table').DataTable({
            serverSide: true,
            ajax: {
                url: '/view-uploaded-report',
                type: 'POST'
            }
        });
    });

</script>
@endsection
