@extends('layouts.inspector._new')
@section('title','Inspector Online Reports')
@section('page-title','Online Reporting Form')
@section('stylesheets')

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
    </style>
<meta name="_token" content="{{csrf_token()}}" />
{!! Html::style('/js/dropzone/dropzone3.css') !!}
@endsection

@section('content')
@php
$header_bg_color = '#ffa500';
@endphp
{{-- START OF ONLINE REPORTING INSTRUCTIONS --}}
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
    {{-- END OF ONLINE REPORTING INSTRUCTIONS --}}
    {{-- START OF GENERAL INFORMATION FORM --}}
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
                                        <div class="col-md-6">
                                                <label for="">Inspection Date</label><br>
                                                <input type="text" class="form-control"  value="{{ $inspection->inspection_date }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="">Service</label><br>
                                                <input type="text" class="form-control"  value="{{strtoupper($inspection->service)}}" readonly>
                                                <input type="hidden" name="" id="" class="form-control" value="{{ $report->id }}" readonly>
                                                <input type="hidden" name="" id="" class="form-control" value="{{ $report->inspection_id }}" readonly>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Client</label><br>
                                            <input type="text" class="form-control" value="{{ $client->client_name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="">Contact</label><br>
                                                <input type="text" name="" id="" class="form-control" value="{{ $client_contact_person->contact_person }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                                <label for="">Factory</label><br>
                                                <input type="text" class="form-control" value="{{ $factory->factory_name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Contact</label><br>
                                            <input type="text" class="form-control" value="{{ $factory_contact_person->factory_contact_person }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-8">
                                            <label for="">Address</label><br>
                                            <input type="text" class="form-control" value="{{ $factory->factory_address }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Product</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->product_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label for="">Brand</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->brand }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Model #</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->model_no }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">PO #</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->po_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <label for="">PO qty.</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_qty }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">PO qty. Unit</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_qty_unit }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Total Available qty.</label><br>
                                            <input type="text" class="form-control" value="" placeholder="Format:12345678">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Total Available qty. Unit</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_qty_unit }}" readonly>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label for="">Total Finish Percentage</label><br>
                                            <input type="text" class="form-control"  value="auto-calculated (total available quantity/poquantity * 100 == total finish percentage ) --- (WILL MAKE WHILE CODING THE BACKEND PART OF THE FORM)" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <label for="">Normal Level</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_normal_level }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Sample Level</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_special_level }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Sampling Size</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_normal_sampsize }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Sampling Size Unit</label><br>
                                            <input type="text" class="form-control" value="{{ $psi_products->aql_qty_unit }}" readonly><br>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for=""> </label>
                                            <label for="">Total Available Quantity Of Packing Unit</label>
                                            <input type="text" class="form-control" placeholder="Format:12345678">
                                        </div>
                                        <div class="col-md-6">
                                                <label>Packing Unit</label>
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Unit</option>
                                                    <option value="volvo">Cartons</option>
                                                    <option value="saab">Carton</option>
                                                    <option value="mercedes">Box</option>
                                                    <option value="audi">Roll</option>
                                                    <option value="saab">Sets</option>
                                                    <option value="mercedes">Pcs</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Carton Quantity Pick Samples</label><br>
                                            <input type="text" class="form-control" placeholder="Format:123">
                                        </div>
                                        <div class="col-md-6">
                                                <label>Sample Unit</label>
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Unit</option>
                                                    <option value="volvo">Cartons</option>
                                                    <option value="saab">Carton</option>
                                                    <option value="mercedes">Box</option>
                                                    <option value="audi">Roll</option>
                                                    <option value="saab">Sets</option>
                                                    <option value="mercedes">Pcs</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Selected Carton No.</label>
                                            <input type="text" class="form-control" placeholder="Format:12345678">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Sealed Carton No.</label>
                                            <input type="text" class="form-control" placeholder="Format:12345678">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" style="margin-left: 20px;">General Information Photos Of Products</label><br>
                                        <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            </form>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    {{-- END OF GENERAL INFORMATION FORM --}}
    {{-- START OF PRODUCT DETAILS INSPECTION --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#psi_products1"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Product Details Inspection</center></h4>
                </a>
            </h4>
        </div>
        <div id="psi_products1" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Export Carton</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-6">
                                                <label for="" style="margin-left: 20px;">Export Carton Photos</label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
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
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-12">
                                                <label for="" style="margin-left: 20px;">Product Details Photos</label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
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
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;">Product Photos</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-12">
                                                <label for="" style="margin-left: 20px;">Packing Of Product Photos</label>
                                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" 
                                                class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
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
                                            <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Defects / Failure</th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">
                                                <form>
                                                    <label>Defects Category</label>
                                                    <select name="unit" id="unit" class="form-control">
                                                        <option value="unit">Select Category</option>
                                                        <option value="volvo">Critical</option>
                                                        <option value="saab">Major</option>
                                                        <option value="mercedes">Minor</option>
                                                        <option value="audi">N/A</option>
                                                    </select><br>
                                                </form>
                                                    <label for="">Number Of Defects Found</label><br>
                                                    <input type="number" class="form-control" placeholder="Format:123">
                                            </th>
                                            <th class="col-md-9">
                                                <h4>Defect Description</h4>
                                                <center><textarea name="" id="" cols="130" rows="4"></textarea></center>
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
                                                        <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                                        </form> 
                                                    </div>
                                                </th>
                                            </tr>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="">Function Test</label><br>
                                        <input type="text" name="function_test1" id="function_test1" class="form-control"><br>
                                        <label for="">Sampling Size</label><br>
                                        <input type="text" name="sampling_size1" id="sampling_size1" class="form-control"><br>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Unit</label>
                                        <select name="function_test_unit1" id="function_test_unit1" class="form-control">
                                            <option value="">Select Unit</option>
                                            <option value="carton">Cartons</option>
                                            <option value="piece">Piece</option>
                                            <option value="pieces">Pieces</option>
                                            <option value="box">Box</option>
                                            <option value="pairs">Pairs</option>
                                            <option value="N/A">N/A</option>
                                        </select><br>
                                        <label>Result</label>
                                        <select name="function_test_result1" id="function_test_result1" class="form-control">
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
                                    <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                        <input type="hidden" name="photo_description" id="photo_description" value="function_checking_test_photos1" />
                                    </form>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 button">
                            <div class="form-group">
                                <button class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" id="btn_add_more_function_test1"><i class="fa fa-plus"></i> Add More Function Test</button>
                            </div>
                        </div>
                        <br>
                        
                    <div class="col-md-12 padding-b-25 functions1_part2"  style="display:none">	
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
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="">Function Test</label><br>
                                        <input type="text" name="function_test1_part2" id="function_test1_part2" class="form-control"><br>
                                        <label for="">Sampling Size</label><br>
                                        <input type="text" name="sampling_size1_part2" id="sampling_size1_part2" class="form-control"><br>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Unit</label>
                                        <select name="function_test_unit1_part2" id="function_test_unit1_part2" class="form-control">
                                            <option value="">Select Unit</option>
                                            <option value="carton">Cartons</option>
                                            <option value="piece">Piece</option>
                                            <option value="pieces">Pieces</option>
                                            <option value="box">Box</option>
                                            <option value="pairs">Pairs</option>
                                            <option value="N/A">N/A</option>
                                        </select><br>
                                        <label>Result</label>
                                        <select name="function_test_result1_part2" id="function_test_result1_part2" class="form-control">
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
                                    <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                        <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                        <input type="hidden" name="photo_description" id="photo_description" value="function_checking_test_photos1_part2" />
                                    </form>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 button">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger remove_more_functions1_part2 btn-block" style="margin-top:5px;"><i class="fa fa-times"></i> Delete Function Test</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <button class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" id="btn_add_more_functions1_part2"><i class="fa fa-plus"></i> Add More Function Test</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 padding-b-25 functions1_part3"  style="display:none">	
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
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Function Test</label><br>
                                            <input type="text" name="function_test1_part3" id="function_test1_part3" class="form-control"><br>
                                            <label for="">Sampling Size</label><br>
                                            <input type="text" name="sampling_size1_part3" id="sampling_size1_part3" class="form-control"><br>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Unit</label>
                                            <select name="function_test_unit1_part3" id="function_test_unit1_part3" class="form-control">
                                                <option value="">Select Unit</option>
                                                <option value="carton">Cartons</option>
                                                <option value="piece">Piece</option>
                                                <option value="pieces">Pieces</option>
                                                <option value="box">Box</option>
                                                <option value="pairs">Pairs</option>
                                                <option value="N/A">N/A</option>
                                            </select><br>
                                            <label>Result</label>
                                            <select name="function_test_result1_part3" id="function_test_result1_part3" class="form-control">
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
                                        <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                            <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                            <input type="hidden" name="photo_description" id="photo_description" value="function_checking_test_photos1_part3" />
                                        </form>    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 button">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger remove_more_functions1_part3 btn-block" style="margin-top:5px;"><i class="fa fa-times"></i> Delete Function Test</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <button class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" id="btn_add_more_functions1_part3"><i class="fa fa-plus"></i> Add More Function Test</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 padding-b-25 functions1_part4"  style="display:none">	
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
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <label for="">Function Test</label><br>
                                                <input type="text" name="function_test1_part4" id="function_test1_part4" class="form-control"><br>
                                                <label for="">Sampling Size</label><br>
                                                <input type="text" name="sampling_size1_part4" id="sampling_size1_part4" class="form-control"><br>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Unit</label>
                                                <select name="function_test_unit1_part4" id="function_test_unit1_part4" class="form-control">
                                                    <option value="">Select Unit</option>
                                                    <option value="carton">Cartons</option>
                                                    <option value="piece">Piece</option>
                                                    <option value="pieces">Pieces</option>
                                                    <option value="box">Box</option>
                                                    <option value="pairs">Pairs</option>
                                                    <option value="N/A">N/A</option>
                                                </select><br>
                                                <label>Result</label>
                                                <select name="function_test_result1_part4" id="function_test_result1_part4" class="form-control">
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
                                            <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                <input type="hidden" name="photo_description" id="photo_description" value="function_checking_test_photos1_part4" />
                                            </form>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 button">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger remove_more_functions1_part4 btn-block" style="margin-top:5px;"><i class="fa fa-times"></i> Delete Function Test</button>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <button class="btn btn-success" style="margin-right: 20px; margin-bottom: 20px; float: right; margin-top: 20px" type="button" id="btn_add_more_functions1_part4"><i class="fa fa-plus"></i> Add More Function Test</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 padding-b-25 functions1_part5"  style="display:none">	
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
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <label for="">Function Test</label><br>
                                                    <input type="text" name="function_test1_part5" id="function_test1_part5" class="form-control"><br>
                                                    <label for="">Sampling Size</label><br>
                                                    <input type="text" name="sampling_size1_part5" id="sampling_size1_part5" class="form-control"><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Unit</label>
                                                    <select name="function_test_unit1_part5" id="function_test_unit1_part5" class="form-control">
                                                        <option value="">Select Unit</option>
                                                        <option value="carton">Cartons</option>
                                                        <option value="piece">Piece</option>
                                                        <option value="pieces">Pieces</option>
                                                        <option value="box">Box</option>
                                                        <option value="pairs">Pairs</option>
                                                        <option value="N/A">N/A</option>
                                                    </select><br>
                                                    <label>Result</label>
                                                    <select name="function_test_result1_part5" id="function_test_result1_part5" class="form-control">
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
                                                <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                    <input type="hidden" name="report_id" id="report_id" value="{{ $report->id}}" />
                                                    <input type="hidden" name="photo_description" id="photo_description" value="function_checking_test_photos1_part5" />
                                                </form>    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 button">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger remove_more_functions1_part5 btn-block" style="margin-top:5px;"><i class="fa fa-times"></i> Delete Function Test</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>
    {{-- END OF PRODUCT DETAILS INSPECTION --}}
    {{-- START OF INSPECTION SUMMARRY RESULT --}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Inspection Summary Result Form</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
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
                                            <form>
                                                <h4>Shipping Quantity</h4>
                                                <input type="radio" id="okay" class="shipt_qty1" name="shipt_qty1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="shipt_qty1" name="shipt_qty1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="shipt_qty1" name="shipt_qty1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="shipt_qty1" name="shipt_qty1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_shipt_qty1" name="remarks_shipt_qty1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Laboratory Certification</h4>
                                                <input type="radio" id="okay" class="ce_report1" name="ce_report1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="ce_report1" name="ce_report1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="ce_report1" name="ce_report1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="ce_report1" name="ce_report1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_ce_report1" name="remarks_ce_report1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Color / Logo / Style</h4>
                                                <input type="radio" id="okay" class="color_logo_style1" name="color_logo_style1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="color_logo_style1" name="color_logo_style1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="color_logo_style1" name="color_logo_style1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="color_logo_style1" name="color_logo_style1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_color_logo_style1" name="remarks_color_logo_style1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Marking / Type Label</h4>
                                                <input type="radio" id="okay" class="marking1" name="marking1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="marking1" name="marking1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="marking1" name="marking1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="marking1" name="marking1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_marking1" name="remarks_marking1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                            
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
                                            <form>
                                                <h4>Product Spec/Function</h4>
                                                <input type="radio" id="okay" class="prouct_spect_function1" name="prouct_spect_function1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="prouct_spect_function1" name="prouct_spect_function1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="prouct_spect_function1" name="prouct_spect_function1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="prouct_spect_function1" name="prouct_spect_function1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                                <textarea id="remarks_prouct_spect_function1" name="remarks_prouct_spect_function1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Visual checking</h4>
                                                <input type="radio" id="okay" class="visual_checking1" name="visual_checking1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="visual_checking1" name="visual_checking1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="visual_checking1" name="visual_checking1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="visual_checking1" name="visual_checking1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_visual_checking1" name="remarks_visual_checking1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Product Packing</h4>
                                                <input type="radio" id="okay" class="product_packing1" name="product_packing1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="product_packing1" name="marking1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="product_packing1" name="marking1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="product_packing1" name="marking1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_product_packing1" name="remarks_product_packing1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Shipping Mark</h4>
                                                <input type="radio" id="okay" class="ship_mark1" name="ship_mark1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="ship_mark1" name="ship_mark1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="ship_mark1" name="ship_mark1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="ship_mark1"  name="ship_mark1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_ship_mark1" name="remarks_ship_mark1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
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
                                            <form>
                                                <h4>Export Carton</h4>
                                                <input type="radio" id="okay" class="export_carton1" name="export_carton1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="export_carton1" name="export_carton1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="export_carton1" name="export_carton1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="export_carton1" name="export_carton1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_export_carton1" name="remarks_export_carton1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Measurement Data</h4>
                                                <input type="radio" id="okay" class="measurement_data1" name="measurement_data1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="measurement_data1" name="measurement_data1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="measurement_data1" name="measurement_data1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="measurement_data1" name="measurement_data1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_measurement_data1" name="remarks_measurement_data1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
                                        </th>
                                        <th class="col-md-3">
                                            <form>
                                                <h4>Comparable With Sample</h4>
                                                <input type="radio" id="okay" class="comparable_with_sample1" name="comparable_with_sample1" value="okay">
                                                <label>Okay</label><br>
                                                <input type="radio" id="not_okay" class="comparable_with_sample1" name="comparable_with_sample1" value="not_okay">
                                                <label>Not Okay</label><br>
                                                <input type="radio" id="pending" class="comparable_with_sample1" name="comparable_with_sample1" value="pending">
                                                <label>Pending</label><br>
                                                <input type="radio" id="N/A" class="comparable_with_sample1" name="comparable_with_sample1" value="N/A">
                                                <label>N/A</label><br>
                                            </form>
                                            <textarea id="remarks_comparable_with_sample1" name="remarks_comparable_with_sample1" rows="4" cols="50" placeholder="If Not Okay/Pending , Please provide details here. You can freely adjust the textbox to review your remarks."></textarea>
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
    {{-- END OF INSPECTION SUMMARRY RESULT --}}
    <div class="panel panel-default">
        <div class="panel-heading">
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
                                                <center><textarea name="" id="" cols="180" rows="7" placeholder="Please, provide the details of your remarks here."></textarea></center>
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse8"style="color: {{ $header_bg_color}};">
                    <h4 style="margin-left: 20px;"><center>Summary Measurements Form</center></h4>
                </a>
            </h4>
        </div>
        <div id="collapse8" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">	
                    <div class="col-md-12 padding-b-25">	
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;">Product Check</h4></th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2">
                                                <h4>Item No.</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Sample size</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Specification</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Actual Findings(LxWxH)</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Weight</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Result</h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:12345678">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format: 1 ctn">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:01_G3C004FBDF10">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:50.0x50.0x50.0">
                                                    <select name="unit" id="unit" class="form-control">
                                                        <option value="unit">Select Unit</option>
                                                        <option value="volvo">Centimeter</option>
                                                        <option value="saab">Meter</option>
                                                        <option value="mercedes">Milimeter</option>
                                                        <option value="mercedes">Inches</option>
                                                        <option value="audi">N/A</option>
                                                    </select><br>
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:50">
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Unit</option>
                                                    <option value="volvo">Kilogram</option>
                                                    <option value="saab">Grams</option>
                                                    <option value="mercedes">Ounce</option>
                                                    <option value="mercedes">Pound</option>
                                                    <option value="mercedes">Liter</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                            </td>
                                            <td class="col-md-2">
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Result</option>
                                                    <option value="volvo">Pass</option>
                                                    <option value="saab">Pending</option>
                                                    <option value="mercedes">Fail</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;">Gift Box Check</h4></th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2">
                                                <h4>Item No.</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Sample size</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Specification</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Actual Findings(LxWxH)</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Weight</h4>
                                            </th>
                                            <th class="col-md-2">
                                                <h4>Result</h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:12345678">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format: 1 ctn">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:01_G3C004FBDF10">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:50.0x50.0x50.0">
                                                    <select name="unit" id="unit" class="form-control">
                                                        <option value="unit">Select Unit</option>
                                                        <option value="volvo">Centimeter</option>
                                                        <option value="saab">Meter</option>
                                                        <option value="mercedes">Milimeter</option>
                                                        <option value="mercedes">Inches</option>
                                                        <option value="audi">N/A</option>
                                                    </select><br>
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" class="form-control" placeholder="Format:50">
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Unit</option>
                                                    <option value="volvo">Kilogram</option>
                                                    <option value="saab">Grams</option>
                                                    <option value="mercedes">Ounce</option>
                                                    <option value="mercedes">Pound</option>
                                                    <option value="mercedes">Liter</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                            </td>
                                            <td class="col-md-2">
                                                <select name="unit" id="unit" class="form-control">
                                                    <option value="unit">Select Result</option>
                                                    <option value="volvo">Pass</option>
                                                    <option value="saab">Pending</option>
                                                    <option value="mercedes">Fail</option>
                                                    <option value="audi">N/A</option>
                                                </select><br>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th colspan="12" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;">Export Cartons Check</h4></th>
                                            </tr>
                                            <tr>
                                                <th class="col-md-2">
                                                    <h4>Item No.</h4>
                                                </th>
                                                <th class="col-md-2">
                                                    <h4>Sample size</h4>
                                                </th>
                                                <th class="col-md-2">
                                                    <h4>Specification</h4>
                                                </th>
                                                <th class="col-md-2">
                                                    <h4>Actual Findings(LxWxH)</h4>
                                                </th>
                                                <th class="col-md-2">
                                                    <h4>Weight</h4>
                                                </th>
                                                <th class="col-md-2">
                                                    <h4>Result</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Format:12345678">
                                                </td>
                                                <td class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Format: 1 ctn">
                                                </td>
                                                <td class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Format:01_G3C004FBDF10">
                                                </td>
                                                <td class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Format:50.0x50.0x50.0">
                                                        <select name="unit" id="unit" class="form-control">
                                                            <option value="unit">Select Unit</option>
                                                            <option value="volvo">Centimeter</option>
                                                            <option value="saab">Meter</option>
                                                            <option value="mercedes">Milimeter</option>
                                                            <option value="mercedes">Inches</option>
                                                            <option value="audi">N/A</option>
                                                        </select><br>
                                                </td>
                                                <td class="col-md-2">
                                                    <input type="text" class="form-control" placeholder="Format:50">
                                                    <select name="unit" id="unit" class="form-control">
                                                        <option value="unit">Select Unit</option>
                                                        <option value="volvo">Kilogram</option>
                                                        <option value="saab">Grams</option>
                                                        <option value="mercedes">Ounce</option>
                                                        <option value="mercedes">Pound</option>
                                                        <option value="mercedes">Liter</option>
                                                        <option value="audi">N/A</option>
                                                    </select><br>
                                                </td>
                                                <td class="col-md-2">
                                                    <select name="unit" id="unit" class="form-control">
                                                        <option value="unit">Select Result</option>
                                                        <option value="volvo">Pass</option>
                                                        <option value="saab">Pending</option>
                                                        <option value="mercedes">Fail</option>
                                                        <option value="audi">N/A</option>
                                                    </select><br>
                                                </td>
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
    {{-- START OF AB AND OR PHOTO --}}
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
    {{-- END OF AB AND OR PHOTO --}}
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
                            <center><button type="button" id="btn_save_inspector_report" width="100%" class="btn btn-primary btn-block" style="margin-top:20px;"><i class="fa fa-sign-in">&nbsp;</i>Submit Online Report</button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END OF Submit Report --}}
</div>



@endsection

@section('scripts')
{!! Html::script('/js/inspector/inspectordropzone.js') !!}
@endsection
