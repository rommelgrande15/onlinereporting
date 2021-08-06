@extends('layouts.inspector._new')
@section('title','Inspector Online Reports')
@section('page-title','Function Checking & Test Photos Form')
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
    </style>
{!! Html::style('/js/dropzone/dropzone3.css') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
@endsection

@section('content')
@php
$header_bg_color = '#ffa500';
@endphp
    <div class="row">	
        <div class="col-md-12 padding-b-25">	
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;"><h4 style="margin-left: 20px;"></h4></th>
                            </tr>
                            <tr>
                                <th class="col-md-3">
                                    <label for="">Function Test</label><br>
                                    <input type="text" class="form-control"><br>
                                    <label for="">Sampling Size</label><br>
                                    <input type="text" class="form-control"><br>
                                </th>
                                <th class="col-md-3">
                                    <form>
                                        <h4>Unit</h4>
                                        <input type="radio" id="okay" name="color_logo_style" value="okay">
                                        <label>Carton</label><br>
                                        <input type="radio" id="not_okay" name="color_logo_style" value="not_okay">
                                        <label>Piece</label><br>
                                        <input type="radio" id="pending" name="color_logo_style" value="pending">
                                        <label>Pieces</label><br>
                                        <input type="radio" id="N/A" name="color_logo_style" value="N/A">
                                        <label>Box</label><br>
                                        <input type="radio" id="N/A" name="color_logo_style" value="N/A">
                                        <label>Pairs</label><br>
                                        <input type="radio" id="N/A" name="color_logo_style" value="N/A">
                                        <label>N/A</label><br>
                                    </form>
                                </th>
                                <th class="col-md-3">
                                    <form>
                                        <h4>Result</h4>
                                        <input type="radio" id="okay" name="color_logo_style" value="okay">
                                        <label>Passed</label><br>
                                        <input type="radio" id="not_okay" name="color_logo_style" value="not_okay">
                                        <label>Pending</label><br>
                                        <input type="radio" id="pending" name="color_logo_style" value="pending">
                                        <label>Failed</label><br>
                                        <input type="radio" id="pending" name="color_logo_style" value="pending">
                                        <label>N/A</label><br>
                                    </form>
                                </th>
                                <th class="col-md-3">
                                    <label for="">Inspected By:</label><br>
                                    <input type="text" class="form-control"><br>
                                    <label for="">Confirm By QC/Manager:</label><br>
                                    <input type="text" class="form-control"><br>
                                    <label for="">Reviewed By:</label><br>
                                    <input type="text" class="form-control"><br>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                <th class="col-md-12">
                                <div class="col-md-12 dropzone-container dz-message default-dropzone-text">
                                        <form method="post" action="{{url('inspector-image-create')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                        </form> 
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" style="position: absolute; right: 0; margin-right: 25px;">Add New Function Test</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{!! Html::script('/js/inspector/inspector.js') !!}
@endsection
