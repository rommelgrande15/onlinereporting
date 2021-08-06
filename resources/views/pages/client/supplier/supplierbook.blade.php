@extends('layouts.client._new')
@section('title','Supplier Book')
@section('page-title','Supplier Book')
@section('stylesheets')
	@if(strpos(Request::url(''), 'tic-sera') !== false)
		{!! Html::style('/css/admin/dashboard-sera.css') !!}
	@else
		{!! Html::style('/css/admin/dashboard.css') !!}
	@endif
<style>

:root {
  /* larger checkbox */
}
:root label.checkbox-bootstrap input[type=checkbox] {
  /* hide original check box */
  opacity: 0;
  position: absolute;
  /* find the nearest span with checkbox-placeholder class and draw custom checkbox */
  /* draw checkmark before the span placeholder when original hidden input is checked */
  /* disabled checkbox style */
  /* disabled and checked checkbox style */
  /* when the checkbox is focused with tab key show dots arround */
}
:root label.checkbox-bootstrap input[type=checkbox] + span.checkbox-placeholder {
  width: 14px;
  height: 14px;
  border: 1px solid;
  border-radius: 3px;
  /*checkbox border color*/
  border-color: #737373;
  display: inline-block;
  cursor: pointer;
  margin: 0 7px 0 -20px;
  vertical-align: middle;
  text-align: center;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder {
  background: #727272;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder:before {
  display: inline-block;
  position: relative;
  vertical-align: text-top;
  width: 5px;
  height: 9px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 2px 2px 0;
  /*can be done with post css autoprefixer*/
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  content: "";
}
:root label.checkbox-bootstrap input[type=checkbox]:disabled + span.checkbox-placeholder {
  background: #ececec;
  border-color: #c3c2c2;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked:disabled + span.checkbox-placeholder {
  background: #d6d6d6;
  border-color: #bdbdbd;
}
:root label.checkbox-bootstrap input[type=checkbox]:focus:not(:hover) + span.checkbox-placeholder {
  outline: 1px dotted black;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox] + span.checkbox-placeholder {
  width: 26px;
  height: 26px;
  border: 2px solid;
  border-radius: 5px;
  /*checkbox border color*/
  border-color: #737373;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox]:checked + span.checkbox-placeholder:before {
  width: 9px;
  height: 15px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 3px 3px 0;
}

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

</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 padding-b-25">
			<div class="buttons">
				@php 
					$create_supplier="";
					$update_supplier="";
					$delete_supplier="";
				@endphp
			</div>
			<br>
			<div class="table-responsive">
				<table id="inspections_tbl_clientside" class="table table-condensed cell-border small dataTable no-footer">
					<thead>
						<tr>
							<th class="text-left">Project No.</th>
							<th class="text-left">Service</th>
              <th class="text-left">Factory Name</th>	
							<th class="text-left">Product Name</th>							
							<th class="text-left">Model/ Part No.</th>
							<th class="text-left">Manday</th>
							<th class="text-left  ">PO #</th>
							<th class="text-left">Status</th>
							<th class="text-left">Created</th>
							<th class="text-center">View/Track</th>
							<th class="text-center">Edit/Cancel</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
              <th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
@include('partials.client.dashboard._viewprojectdetails')
@include('partials.client.dashboard._cancelinspection')
@include('partials.client.dashboard._deleteinspection')
<div class="send-loading"></div>
@endsection
@section('scripts')
{!! Html::script('/js/client/panel-client.js?v=4') !!}

<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });

    $(document).ready(function() {
        $('#inspections_tbl_clientside').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('client-supplier-book-get-mrn') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}",
                    supplier_book: 'true'
                }
            },
            "order": [[ 8, "desc" ]],
            "columns": [{
                    "data": "client_project_number"
                },
                {
                    "data": "service"
                },
                {
                    "data": "factory_name"
                },
                {
                    "data": "product_name"
                },
                {
                    "data": "model_no"
                },
                {
                    "data": "manday"
                },
                {
                    "data": "po_no"
                },
                {
                    "data": "inspection_status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "view_edit",
                    "orderable":false,
                    "searcheable":false
                },
                {
                    "data": "edit_cancel",
                    "orderable":false,
                    "searcheable":false
                }
            ]

        });
    });

</script>


@endsection


