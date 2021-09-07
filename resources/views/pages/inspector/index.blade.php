@extends('layouts.inspector._new')
@section('title','Inspector Online Reports')
@section('page-title','Online Reporting Form')
@section('stylesheets')
<?php $header_bg_color = '#ffa500'; ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="{{ URL::asset('js/inspector/inspectordropzone.js') }}";></script>
<script>

$(document).ready(function(){
(function(){
  var newscript = document.createElement('script');
     newscript.type = 'text/javascript';
     newscript.async = true;
     newscript.src = "{{ URL::asset('js/inspector/inspectordropzone.js') }}";
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(newscript);
})();
    // Add new element
    $(".add").click(function(){
 (function(){
  var newscript = document.createElement('script');
     newscript.type = 'text/javascript';
     newscript.async = true;
     newscript.src = "{{ URL::asset('js/inspector/inspectordropzone.js') }}";
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(newscript);
})();
        // Finding total number of elements added
        var total_element = $(".element").length;
                    
        // last <div> with element class id
        var lastid = $(".element:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
 

        //var max = 5;
        // Check total number elements
       // if(total_element < max ){
            // Adding new div container after last occurance of element class
            $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");
			  $("#div_" + nextindex).append('<div class="panel-heading"> <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#ccollapse'+ nextindex +'" style="color: {{ $header_bg_color}};"><h4 style="margin-left: 20px;"><center>Inspection Of Product Report</center></h4></a></h4></div><div  id="ccollapse'+ nextindex +'" class="panel-collapse collapse">@include('pages.inspector.generalinformation.banner')<div class="form-group"><button class="btn btn-danger" style="float:left;margin-right: 20px; margin-bottom: 20px;  margin-top: 20px" type="button" id="remove_' + nextindex + '" onclick="remove(this.id)"><i class="fa fa-plus"></i>Remove</button></div></div>');
		  
 // $("#div_" + nextindex).append('<form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone' + nextindex + '"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" /> <input type="hidden" name="photo_description" id="photo_description" value="ab_nd_or_photos" /> </form>  ');

     let singleDropzoneOptions = {
       // maxFilesize: 0.5,
        dictDefaultMessage: "Drop Photoes here to upload",
      //  maxFiles: 1,
        clickable: true,
       // thumbnailWidth: 140,
        //thumbnailHeight: 140,
        //maxThumbnailFilesize: 0.5,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    }
    $("form#dropzone"+nextindex).dropzone(singleDropzoneOptions);
	  $("form#dropzonep"+nextindex).dropzone(singleDropzoneOptions);
	   $("form#dropzoned"+nextindex).dropzone(singleDropzoneOptions);
	    $("form#dropzonec"+nextindex).dropzone(singleDropzoneOptions);
		 $("form#dropzonecl"+nextindex).dropzone(singleDropzoneOptions);
		 $("form#dropzonedefect"+nextindex).dropzone(singleDropzoneOptions);
		  $("form#dropzonefunc"+nextindex).dropzone(singleDropzoneOptions);

		  //   $("#div_" + nextindex).append("<div class='panel-heading'> <h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#ccollapse"+ nextindex +"' style='color: {{ $header_bg_color}};'><h4 style='margin-left: 20px;'><center>Inspection Of Product Report</center></h4></a></h4></div><div  id='ccollapse"+ nextindex +"' class='panel-collapse collapse'><div class='panel-body'> <div class='row'>	<div class='col-md-12 padding-b-25 prod-details'> <div class='col-md-12'>  <div class='col-md-12'> <h3  style='background-color: {{ $header_bg_color}}; color:white;'><center>Product Details</center></h3> </div> </div> <div class='col-md-12'>   <div class='col-md-12'> <label>PST Code</label> {{-- <input type='text' class='form-control pst_code ' id='pst_code' name='pst_code[]'  value='' > --}}<select class='form-control' name='pst_code' id='pst_code'>  <option value='' selected>Select PST Code</option>   @foreach ($pst_code_datas as $pst_code_data) <option value='{{$pst_code_data->pst_code}}' >{{$pst_code_data->pst_code}}</option>  @endforeach</select> </div>  </div> <div class='col-md-12'> {{-- <div class='col-md-6'> <label >Main Part Qty.</label> <input type='text' class='form-control main_part_qty ' id='main_part_qty' name='main_part_qty[]'  value='' ></div> --}} <div class='col-md-6 main_part_qty_modal'> <div class='form-group fg_qty_psi'>  {!! Form::label('Main Part Qty.', 'Main Part Qty.') !!}  <div class='input-group input_qty_psi'><input type='text' class='form-control main_part_qty ' name='main_part_qty' id='main_part_qty' readonly required> <div class='input-group-btn'><button class='btn btn-primary btn-main_part_qty-modal' type='button' > <i class='fa fa-plus'></i> </button> </div>  </div> </div> </div><div class='col-md-6 div_part_number'><label>Part Number</label>  <select class='form-control part_number' name='part_number[]' id='part_number'> <option></option></select> </div> </div> <div class='col-md-12'> <div class='col-md-6'> <label>Manufacture Code</label>  <input type='text' class='form-control manufacture_code ' id='manufacture_code' name='manufacture_code[]'  value='' readonly> </div><div class='col-md-6'>   <label>Description</label>  <input type='text' class='form-control description ' id='description' name='description[]'  value='' readonly></div> </div>  <div class='col-md-12'>   <div class='col-md-6'> <label>BOM qty.</label><input type='text' class='form-control bom_qty ' id='bom_qty' name='bom_qty[]'  value='' readonly></div>  <div class='col-md-6'> <label>Quantity(pcs)</label> <input type='text' class='form-control qty_pcs ' id='qty_pcs' name='qty_pcs[]'  value='' ></div> </div> <div class='col-md-12'>  <div class='col-md-6'> <label >Total Packaging</label> <input type='text' class='form-control total_packaging ' id='total_packaging' name='total_packaging[]'  value='' ></div>  <div class='col-md-6'>  <label>Samples</label> <input type='text' class='form-control samples_unit ' id='samples_unit' name='samples_unit[]'  value='' > </div>  </div>   <div class='col-md-12'>   <div class='col-md-6'>  <label>Carton Size</label>  <input type='text' class='form-control carton_size' id='carton_size' name='carton_size[]'  value='' > </div> <div class='col-md-6'> <label>Carton Weight</label>   </div>  </div>   </div>  </div>   </div> </div>&nbsp;<span id='remove_" + nextindex + "' class='remove'>X</span>");
                         
            // Adding element to <div>
          //  $("#div_" + nextindex).append("<div class='panel-heading'> <h4 class='panel-title'> <a data-toggle='collapse' data-parent='#accordion' href='#ccollapse"+ nextindex +"' style='color: {{ $header_bg_color}};'> <h4 style='margin-left: 20px;'><center>Inspection Of Product Report</center></h4> </a> </h4> </div> <div  id='ccollapse"+ nextindex +"' class="panel-collapse collapse"><div class='panel-body'></div> </div> &nbsp;<span id='remove_" + nextindex + "' class='remove'>X</span>");
                    
       // }
         


		 
    });
 }); 

 
    // Remove element
   function addsec(id){
 (function(){
  var newscript = document.createElement('script');
     newscript.type = 'text/javascript';
     newscript.async = true;
     newscript.src = "{{ URL::asset('js/inspector/inspectordropzone.js') }}";
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(newscript);
})();
        // Finding total number of elements added
        var total_element = $(".elementsec"+id).length;
                    
        // last <div> with element class id
        var lastid = $(".elementsec"+id+":last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
 

        //var max = 5;
        // Check total number elements
       // if(total_element < max ){
            // Adding new div container after last occurance of element class
            $(".elementsec"+id+":last").after("<div class='elementsec"+ id +"' id='div"+ id +"sec_"+ nextindex +"'></div>");
			  $("#div"+ id +"sec_" + nextindex).append('<div class="panel-body"> <div class="row"> <div class="col-md-12 padding-b-25"> <div class="col-md-12"> <div class="table-responsive"> <table class="table table-hover table-bordered"> <tbody> <tr> <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Defects / Failure</th> </tr> <tr> <th class="col-md-3"> <input type="hidden" value="' + id + '" name="sid[]"><label>Defects Category</label> <select name="defects_category[]" id="defects_category' + nextindex + '" class="form-control"> <option value="">Select Category</option> <option value="critical">Critical</option> <option value="major">Major</option> <option value="minor">Minor</option> <option value="N/A">N/A</option> </select><br>  <label for="">Number Of Defects Found</label><br> <input type="number" id="number_of_defects' + nextindex + '" name="number_of_defects[]" class="form-control" placeholder="Format:123"> </th> <th class="col-md-9"> <h4>Defect Description</h4> <center><textarea name="defect_details[]" id="defect_details' + nextindex + '" cols="130" rows="4"></textarea></center> </th> </tr> </tbody> </table> <table class="table table-hover table-bordered"> <tbody> <tr> <tr> <th class="col-md-12"> <label for="" style="margin-left: 20px;"> Defect Failure Photos</label> <div class="col-md-12 dropzone-container dz-message default-dropzone-text"> <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzonedefects' +id+ nextindex + '"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" /> <input type="hidden" name="photo_description" id="photo_description" value="' + id + 'defect_failure_photos' + nextindex + '" /> </form> </div> </th> </tr> </tr> </tbody> </table> </div> </div>  </div> </div> </div>');
		  
 // $("#div_" + nextindex).append('<form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone' + nextindex + '"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" /> <input type="hidden" name="photo_description" id="photo_description" value="ab_nd_or_photos" /> </form>  ');

     let singleDropzoneOptions = {
       // maxFilesize: 0.5,
        dictDefaultMessage: "Drop Photoes here to upload",
      //  maxFiles: 1,
        clickable: true,
       // thumbnailWidth: 140,
        //thumbnailHeight: 140,
        //maxThumbnailFilesize: 0.5,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    }
    $("form#dropzonedefects"+id+nextindex).dropzone(singleDropzoneOptions);
	 
		 
                    
    }
	
	function closepopups(id){
		
		var x = document.getElementById("aql_qty"+id).value;
		$('#main_part_qty'+id).val(x);
		
		$('.AQLModal'+id).modal('hide');
	}
	
	 function addfuncsec(id){
 (function(){
  var newscript = document.createElement('script');
     newscript.type = 'text/javascript';
     newscript.async = true;
     newscript.src = "{{ URL::asset('js/inspector/inspectordropzone.js') }}";
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(newscript);
})();
        // Finding total number of elements added
        var total_element = $(".elementfuncsec"+id).length;
                    
        // last <div> with element class id
        var lastid = $(".elementfuncsec"+id+":last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
 

        //var max = 5;
        // Check total number elements
       // if(total_element < max ){
            // Adding new div container after last occurance of element class
           $(".elementfuncsec"+id+":last").after("<div class='elementfuncsec"+ id +"' id='div"+ id +"funcsec_"+ nextindex +"'></div>");
			  $("#div"+ id +"funcsec_" + nextindex).append('<div class="panel-body"> <div class="row" style="margin-top: 20px"> <div class="col-md-12 padding-b-25"> <div class="col-md-12"> <div class="table-responsive"> <table class="table table-hover table-bordered"> <tbody> <tr> <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Function Test</th> </tr> </tbody> </table> </div> <div class="col-md-12"> <div class="col-md-6"> <input type="hidden" value="' + id + '" name="rid[]"><label for="">Function Test</label><br> <input type="text" name="function_test[]" id="function_test' + nextindex + '" class="form-control"><br> <label for="">Sampling Size</label><br> <input type="text" name="sampling_size[]" id="sampling_size' + nextindex + '" class="form-control"><br> </div> <div class="col-md-6"> <label>Unit</label> <select name="function_test_unit[]" id="function_test_unit' + nextindex + '" class="form-control"> <option value="">Select Unit</option> <option value="carton">Cartons</option> <option value="piece">Piece</option> <option value="pieces">Pieces</option> <option value="box">Box</option> <option value="pairs">Pairs</option> <option value="N/A">N/A</option> </select><br> <label>Result</label> <select name="function_test_result[]" id="function_test_result' + nextindex + '" class="form-control"> <option value="">Select Result</option> <option value="Passed">Passed</option> <option value="Pending">Pending</option> <option value="Failed">Failed</option> <option value="N/A">N/A</option> </select><br> </div> </div> <div class="col-md-12"> <label for="" style="margin-left: 20px;"> Function Checking Photos</label> <div class="col-md-12 dropzone-container dz-message default-dropzone-text"> <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzonefuncs' +id+ nextindex + '"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" /> <input type="hidden" name="photo_description" id="photo_description" value="' + id + 'function_checking_test_photos' + nextindex + '" /> </form> </div> </div> </div> </div> <br> </div> </div>');
		  
 // $("#div_" + nextindex).append('<form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone' + nextindex + '"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" /> <input type="hidden" name="photo_description" id="photo_description" value="ab_nd_or_photos" /> </form>  ');

     let singleDropzoneOptions = {
       // maxFilesize: 0.5,
        dictDefaultMessage: "Drop Photoes here to upload",
      //  maxFiles: 1,
        clickable: true,
       // thumbnailWidth: 140,
        //thumbnailHeight: 140,
        //maxThumbnailFilesize: 0.5,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    }
    $("form#dropzonefuncs"+id+nextindex).dropzone(singleDropzoneOptions);
	 
		 
                    
    }
        function remove(clicked_id){     
        var id = clicked_id;
		    event.preventDefault();

        var split_id = id.split("_");
        var deleteindex = split_id[1];

        // Remove <div> with id
        $("#div_" + deleteindex).remove();
                
	}
	  function addshowmodal(clicked_id){     
        var id = clicked_id;
		    event.preventDefault();

        $('.showmodcontent').append("<p id='test'"+ id +">"+id+"</p>");
                
	}
</script>
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
    
        .ui-autocomplete {
            position: fixed;
            top: 100%;
            left: 0;
            z-index: 1051 !important;
            float: left;
            display: none;
            min-width: 160px;
            width: 160px;
            padding: 4px 0;
            margin: 2px 0 0 0;
            list-style: none;
            background-color: #ffffff;
            border-color: #ccc;
            border-color: rgba(0, 0, 0, 0.2);
            border-style: solid;
            border-width: 1px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            *border-right-width: 2px;
            *border-bottom-width: 2px;
        }

        textarea {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;

            width: 98%;
        }
        .select2-container{
        width: 100%!important;
        }
        /* .select2-search--dropdown .select2-search__field {
        width: 98%;
        } */
    </style>
<meta name="_token" content="{{csrf_token()}}" />
{!! Html::style('/js/dropzone/dropzone3.css') !!}
{!! Html::style('/css/admin/select2.css') !!}

@endsection

@section('content')
@php
$header_bg_color = '#ffa500';
@endphp
<form data-parsley-validate='' method="POST" action="" id="form_online_report">
    {!!csrf_field()!!}
{{-- LABEL FOR INSTRUCTION PART --}}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#instructions"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Online Reporting Instructions</center></h4>
                </a>
            </h4>
        </div>
        
    <div id="instructions" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="row">	
                <div class="col-md-12 padding-b-25">	
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Instructions</th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-12">
                                            <p>Welcome to Online Reporting Tool for Inspector of The Inspection Company. Please be guided, just click the form title and complete all the details needed for the specific inormation for the reports. Please , dont leave any blank on the form just put N/A .<br> Note that if you want to remove photos, please click remove so it will not be included on your report, Thankyou!</p>
                                            
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END OF LABEL FOR INSTRUCTION PART --}}
{{-- START OF GENERAL INFORMATION PART --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>General Information Form</center></h4>
                </a>
            </h4>
        </div>
        
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">	
                        <div class="col-md-12 padding-b-25">	
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;"></h4></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="uniqueid" id="uniqueid" value="<?php echo time(); ?>">
                                        <div class="col-md-6">
                                                <label for="">Inspection Date</label><br>
                                                <input type="text" id="inspection_date" name="inspection_date" class="form-control"  value="{{ $inspection->inspection_date }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="">Service</label><br>
                                                <input type="text" class="form-control" id="service" name="service"  value="{{strtoupper($inspection->service)}}" readonly>
                                                <input type="hidden" name="report_id" id="report_id" class="form-control" value="{{ $report->id }}" readonly>
                                                <input type="hidden" name="inspection_id" id="inspection_id" class="form-control" value="{{ $report->inspection_id }}" readonly>
                                                <input type="hidden" name="inspector_id" id="inspector_id" class="form-control" value="{{ $user_info->id }}" readonly>
                                                <input type="hidden" name="p_s_i_products_id" id="p_s_i_products_id" class="form-control" value="{{ $psi_products->id }}" readonly>
                                                <input type="hidden" id="token" name="token" value="{{{ csrf_token() }}}" />
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Client</label><br>
                                            <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $client->client_name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="">Contact</label><br>
                                                <input type="text" name="client_contact_person" id="client_contact_person" class="form-control" value="{{ $client_contact_person->contact_person }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                                <label for="">Factory</label><br>
                                                <input type="text" id="factory_name" name="factory_name" class="form-control" value="{{ $factory->factory_name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Contact</label><br>
                                            <input type="text" class="form-control" id="factory_contact" name="factory_contact" value="{{ $factory_contact_person->factory_contact_person }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label for="">Address</label><br>
                                            <input type="text" class="form-control" id="factory_address" name="factory_address" value="{{ $factory->factory_address }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" style="margin-left: 20px;">General Information Photos Of Products</label><br>
                                        <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            <input type="hidden" name="photo_description" id="photo_description" value="general_information_photos" />
                                            </form>   
                                        </div>
                                       
                                        <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                            <div class="fallback">
                                                <input name="file[]" class="file" type="file" id="file" multiple required />
                                                {{-- @foreach($inspection_photos as $inspection_photo)
                                                <img src="{{ url( 'public/images/inspection/7597/'.$inspection_photo->photo_path) }}" />
                                                @endforeach --}}
                                            </div>
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            <input type="hidden" name="photo_description" id="photo_description" value="general_information_photos" />
                                            </form>    
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    {{-- END OF GENERAL INFORMATION PART --}}
    
    {{-- NEW COLLAPSE FOR PART # OF GREGOR --}}
    <div class="panel panel-default part1">
	<div>
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Inspection Of Product Report</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25 prod-details">	
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <h3 for="" style="background-color: {{ $header_bg_color}}; color:white;"><center>Product Details</center></h3>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label for="">PST Code</label>
                                    {{-- <input type="text" class="form-control pst_code "   name="pst_code[]"  value="" > --}}
                                    <select class="form-control" name="pst_code[]" onchange="findpst(this.id)" id="pstcodee1">
                                        <option value="" selected>Select PST Code</option>
                                        @foreach ($pst_code_datas as $pst_code_data)
                                        <option value="{{$pst_code_data->pst_code}}" >{{$pst_code_data->pst_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                              
                                <div class="col-md-6 main_part_qty_modal">
                                    <div class="form-group fg_qty_psi">
                                        {!! Form::label('Main Part Qty.', 'Main Part Qty.') !!}
                                        <div class="input-group input_qty_psi">
                                            <input type="text" class="form-control main_part_qty " name="main_part_qty[]" id="main_part_qty" readonly required>
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary btn-main_part_qty-modal" type="button" id='1' onClick="addshowmodal(this.id)" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @include('pages.inspector.generalinformation.aqlmodal.main_part_modal')
									
                                </div>
                             
                                <div class="col-md-6 div_part_number">
                                    <label for="">Part Number</label>
                                        <select class="form-control part_number" name="part_number[]" id="partnumberr1" onchange="findpartno(this.id)">
                                            <option></option>
                                        </select>
                                </div>
                            
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="">Manufacture Code</label>
                                    <input type="text" class="form-control manufacture_code " id="manufacture_code1" name="manufacture_code[]"  value="" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Description</label>
                                    <input type="text" class="form-control description " id="description1" name="description[]"  value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="">BOM qty.</label>
                                    <input type="text" class="form-control bom_qty " id="bom_qty1" name="bom_qty[]"  value="" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Quantity(pcs)</label>
                                    <input type="text" class="form-control qty_pcs " id="qty_pcs1" name="qty_pcs[]"  value="" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="">Total Packaging</label>
                                    <input type="text" class="form-control total_packaging " id="total_packaging1" name="total_packaging[]"  value="" >
                                </div>
                                <div class="col-md-6">
                                    <label for="">Samples</label>
                                    <input type="text" class="form-control samples_unit " id="samples_unit1" name="samples_unit[]"  value="" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="">Carton Size</label>
                                    <input type="text" class="form-control carton_size" id="carton_size1" name="carton_size[]"  value="" >
                                </div>
                                <div class="col-md-6">
                                    <label for="">Carton Weight</label>
                                    <input type="text" class="form-control carton_weight " id="carton_weight" name="carton_weight[]"  value="" >
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
    <div class="row">	
        <div class="col-md-12 padding-b-25">	
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"><center>Inspection Summary Result</center></th>
                        </tr>
               
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Overall Check Result</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">
                               
                                    <h4>Shipping Quantity</h4>
                                    <input type="radio" id="shipt_qty1" class="shipt_qty1" name="shipt_qty1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="shipt_qty1" class="shipt_qty1" name="shipt_qty1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="shipt_qty1" class="shipt_qty1" name="shipt_qty1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="shipt_qty1" class="shipt_qty1" name="shipt_qty1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_shipt_qty" name="remarks_shipt_qty1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                               
                                    <h4>Laboratory Certification</h4>
                                    <input type="radio" id="ce_report1" class="ce_report1" name="ce_report1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="ce_report1" class="ce_report1" name="ce_report1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="ce_report1" class="ce_report1" name="ce_report1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="ce_report1" class="ce_report1" name="ce_report1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_ce_report" name="remarks_ce_report1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                               
                                    <h4>Color / Logo / Style</h4>
                                    <input type="radio" id="color_logo_style1" class="color_logo_style1" name="color_logo_style1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="color_logo_style1" class="color_logo_style1" name="color_logo_style1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="color_logo_style1" class="color_logo_style1" name="color_logo_style1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="color_logo_style1" class="color_logo_style1" name="color_logo_style1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_color_logo_style" name="remarks_color_logo_style1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                               
                                    <h4>Marking / Type Label</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="marking1" name="marking1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay'+ nextindex + '" class="marking1" name="marking1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending'+ nextindex + '" class="marking1" name="marking1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A'+ nextindex + '" class="marking1" name="marking1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_marking'+ nextindex + '" name="remarks_marking1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"></th>
                        </tr>
                        <tr>
                            <th class="col-md-3">
                               
                                    <h4>Product Spec/Function</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="prouct_spect_function1" name="prouct_spect_function1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay'+ nextindex + '" class="prouct_spect_function1" name="prouct_spect_function1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending'+ nextindex + '" class="prouct_spect_function1" name="prouct_spect_function1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A'+ nextindex + '" class="prouct_spect_function1" name="prouct_spect_function1" value="N/A">
                                    <label>N/A</label><br>
                               
                                    <textarea id="remarks_prouct_spect_function'+ nextindex + '" name="remarks_prouct_spect_function1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                              
                                    <h4>Visual checking</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="visual_checking1" name="visual_checking1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay'+ nextindex + '" class="visual_checking1" name="visual_checking1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending'+ nextindex + '" class="visual_checking1" name="visual_checking1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A'+ nextindex + '" class="visual_checking1" name="visual_checking1" value="N/A">
                                    <label>N/A</label><br>
                              
                                <textarea id="remarks_visual_checking'+ nextindex + '" name="remarks_visual_checking1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                                
                                    <h4>Product Packing</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="product_packing0" name="product_packing1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay' + nextindex + '" class="product_packing0" name="product_packing1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending' + nextindex + '" class="product_packing0" name="product_packing1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A' + nextindex + '" class="product_packing0" name="product_packing1" value="N/A">
                                    <label>N/A</label><br>
                              
                                <textarea id="remarks_product_packing'+ nextindex + '" name="remarks_product_packing1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                               
                                    <h4>Shipping Mark</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="ship_mark1" name="ship_mark1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay'+ nextindex + '" class="ship_mark1" name="ship_mark1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending'+ nextindex + '" class="ship_mark1" name="ship_mark1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A'+ nextindex + '" class="ship_mark1"  name="ship_mark1" value="N/A">
                                    <label>N/A</label><br>
                                
                                <textarea id="remarks_ship_mark'+ nextindex + '" name="remarks_ship_mark1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"></th>
                        </tr>
                        <tr>
                            <th class="col-md-3">
                               
                                    <h4>Export Carton</h4>
                                    <input type="radio" id="okay'+ nextindex + '" class="export_carton1" name="export_carton1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay'+ nextindex + '" class="export_carton1" name="export_carton1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending'+ nextindex + '" class="export_carton1" name="export_carton1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A'+ nextindex + '" class="export_carton1" name="export_carton1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_export_carton'+ nextindex + '" name="remarks_export_carton1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                              
                                    <h4>Measurement Data</h4>
                                    <input type="radio" id="okay" class="measurement_data1" name="measurement_data1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay" class="measurement_data1" name="measurement_data1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending" class="measurement_data1" name="measurement_data1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A" class="measurement_data1" name="measurement_data1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_measurement_data1" name="remarks_measurement_data1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                            <th class="col-md-3">
                               
                                    <h4>Comparable With Sample</h4>
                                    <input type="radio" id="okay" class="comparable_with_sample1" name="comparable_with_sample1" value="okay">
                                    <label>Okay</label><br>
                                    <input type="radio" id="not_okay" class="comparable_with_sample1" name="comparable_with_sample1" value="not_okay">
                                    <label>Not Okay</label><br>
                                    <input type="radio" id="pending" class="comparable_with_sample1" name="comparable_with_sample1" value="pending">
                                    <label>Pending</label><br>
                                    <input type="radio" id="N/A" class="comparable_with_sample1" name="comparable_with_sample1" value="N/A">
                                    <label>N/A</label><br>
                               
                                <textarea id="remarks_comparable_with_sample0" name="remarks_comparable_with_sample1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <div id="mydiv"></div>
           
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Packing Photos</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;"></label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="packing_photos1" />
                                            </form>    
                                            </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Product Label Photo</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;"></label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="product_label_photos1" />
                                            </form>    
                                            </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Date Code Label Photos</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;"></label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="date_code_label_photos1" />
                                            </form>    
                                            </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Carton Box Photos</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;"></label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="carton_box_photos1" />
                                            </form>    
                                            </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Carton Label Photos</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;"></label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="carton_label_photos1" />
                                            </form>    
                                            </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
								<input type="hidden" name="sid[]" value="1">
                                    <tbody>
                                        <tr>
                                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Defects / Failure</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">
                                               
                                                    <label>Defects Category</label>
                                                    <select name="defects_category[]" id="defects_category1" class="form-control">
                                                        <option value="">Select Category</option>
                                                        <option value="critical">Critical</option>
                                                        <option value="major">Major</option>
                                                        <option value="minor">Minor</option>
                                                        <option value="N/A">N/A</option>
                                                    </select><br>
                                               
                                                    <label for="">Number Of Defects Found</label><br>
                                                    <input type="number" id="number_of_defects1" name="number_of_defects[]" class="form-control" placeholder="Format:123">
                                            </th>
                                            <th class="col-md-9">
                                                <h4>Defect Description</h4>
                                                <center><textarea name="defect_details[]" id="defect_details1" cols="130" rows="4"></textarea></center>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <tr>
                                                <th class="col-md-12">
                                                    <label for="" style="margin-left: 20px;"> Defect Failure Photos</label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                                        <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzonedefect1">
                                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                            <input type="hidden" name="photo_description" id="photo_description" value="1defect_failure_photos1" />
                                                        </form> 
                                                    </div>
                                                </th>
                                            </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
						<div class="elementsec1" id='div1sec_1'>	</div>				  
                        <div class="col-md-12 button">
                            <div class="form-group">
                                <button class="btn btn-success addsec" style="margin-right: 20px; float: right; margin-top: 20px" type="button" id="1" onclick="addsec(this.id)" ><i class="fa fa-plus"></i> Add More Defect Failures</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="panel-body">
                <div class="row" style="margin-top: 20px">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Function Test</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
							<input type="hidden" name="rid[]" value="1">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="">Function Test</label><br>
                                        <input type="text" name="function_test[]" id="function_test1" class="form-control"><br>
                                        <label for="">Sampling Size</label><br>
                                        <input type="text" name="sampling_size[]" id="sampling_size1" class="form-control"><br>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Unit</label>
                                        <select name="function_test_unit[]" id="function_test_unit1" class="form-control">
                                            <option value="">Select Unit</option>
                                            <option value="carton">Cartons</option>
                                            <option value="piece">Piece</option>
                                            <option value="pieces">Pieces</option>
                                            <option value="box">Box</option>
                                            <option value="pairs">Pairs</option>
                                            <option value="N/A">N/A</option>
                                        </select><br>
                                        <label>Result</label>
                                        <select name="function_test_result[]" id="function_test_result1" class="form-control">
                                            <option value="">Select Result</option>
                                            <option value="Passed">Passed</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failed">Failed</option>
                                            <option value="N/A">N/A</option>
                                        </select><br>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" style="margin-left: 20px;"> Function Checking Photos</label>
                                    <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                    <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzonefunc1">
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                        <input type="hidden" name="photo_description" id="photo_description" value="1function_checking_test_photos1" />
                                    </form>    
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="elementfuncsec1" id="div1funcsec_1">	</div>
                        <div class="col-md-12 button">
                            <div class="form-group">
                                <button class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" id="1" onclick="addfuncsec(this.id)" ><i class="fa fa-plus"></i> Add More Function Test</button>
                            </div>
                        </div>
                        <br>
                        
                    </div>
                      </div>     
<div class="element" id='div_1'>	</div>				  
                           <div class="panel-body">
                <div class="row">	
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;"></th>
                                </tr>
                            </tbody>
                        </table>
						</div>
                        <div class="col-md-12 button">
                            <div class="form-group">
                                    <button class="btn btn-primary add" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" onclick="" ><i class="fa fa-plus"></i>Add More Product Report #</button>
                            </div>
                        </div>
                    </div>
					</div>
                    </div>
                </div>
           

   
   
         {{-- START OF Remarks And Additional Information --}}
        <div class="panel panel-default">
            <div class="panel-heading" style="margin-top: 1px;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"style="color: {{ $header_bg_color}};">
                        <h4 style="margin-left: 20px;"><center>Remarks And Additional Information Form</center></h4>
                    </a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">	
                        <div class="col-md-12 padding-b-25">	
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;" class="form-control">Remarks</th>
                                            </tr>
                                            <tr>
                                                <th class="col-md-12">
                                                    <h4 style="margin-left: 20px;">Remarks</h4>
                                                    <center><textarea name="remarks_details" id="remarks_details" cols="180" rows="7" placeholder="Please, provide the details of your remarks here."></textarea></center>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="col-md-12">
                                                    <h4 style="margin-left: 20px;">Remarks Photos</h4>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                                        <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="remarks_" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="remarks_photos" />
                                                </form>    
                                                    </div>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- STARTOFAB&ORPhoto --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse9"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>AB & OR Photo Forms</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse9" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;">Anti Bribery (AB) Photos</h4></th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-12">
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                                     <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            <input type="hidden" name="photo_description" id="photo_description" value="ab_nd_or_photos" />
                                            </form>    
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;">Onsite Report (OR) Photos</h4></th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-12">
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                                     <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            <input type="hidden" name="photo_description" id="photo_description" value="onsite_report_photos" />
                                            </form>    
                                                </div>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- START OF Additional Header Information --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse10"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Additional Header Information Form</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse10" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Additional Information</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="">Client</label>
                                                <input type="text" name="client_name" id="client_name" class="form-control" value="{{ $client->client_name }}" readonly><br>
                                                <label for="">Report Date</label>
                                                <input type="text" name="report_date" id="report_date" class="form-control" value="{{ $report->created_at }}" readonly><br>
                                                <label for="">Inspected By:</label><br>
                                                <input type="text" name="inspected_by" id="inspected_by" class="form-control" value="{{ $user_info->name }}" readonly><br>
                                            </th>
                                            <th class="col-md-6">
                                                <label for="">Inspection Result</label>
                                                <select name="result" id="result" class="form-control ">
                                                    <option value="">Select Result</option>
                                                    <option value="passed">Passed</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="failed">Failed</option>
                                                    <option value="N/A">N/A</option>
                                                  </select><br>
                                                <label for="">Report No.</label>
                                                <input type="text" name="report_no" id="report_no" class="form-control" value="{{ $report->report_no }}" readonly><br>
                                                <label for="">Confirm By QC/Manager:</label><br>
                                                <input type="text" id="confirm_by" name="confirm_by" class="form-control" placeholder="Name:"><br>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END OF Additional Header Information --}}
     {{-- START OF Submit Report --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse11"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Submit Report</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse11" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <p>Dear Fellow Inspector, please double check all the details that you provided before submitting this report. In case you submit this report, you can no longer edit this report. Because it's consider done. Please do take time to check everything in the form. Thankyou.</p><br>
                            <center><button type="button" id="btn_save_inspector_report" width="100%" class="btn btn-primary btn-block"  style="margin-top:20px;"><i class="fa fa-sign-in">&nbsp;</i>Submit Online Report</button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END OF Submit Report --}}
</div>
</form>
@endsection

@section('scripts')
    {{-- {!! Html::script('/js/inspector/inspector.js') !!} --}}
    {!! Html::script('/js/inspector/inspectordropzone.js') !!}
    {!! Html::script('/js/inspector/product-report2.js') !!}
    {!! Html::script('/js/inspector/aql-qty.js') !!}
    {!! Html::script('/js/aql/general.js') !!}
    {!! Html::script('/js/aql/special.js') !!}
    {!! Html::script('/js/aql/genss.js') !!}
    {!! Html::script('/js/aql/allowed.js') !!}
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    {{-- <script type="text/javascript" class="reloadMe" src="{{asset('/js/inspector/inspector.js')}}"></script> --}}
	 {{-- <script src="https://localhost/onlinereport/js/inspector/inspectordropzone.js"></script> --}}
    <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
    {{-- <script src="{{ asset('cloudfare/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script> --}}
    <script src="{{ asset('js/select2.min.js')}}"></script>   
    
@endsection
