@extends('layouts.supplier._new')
@section('title','New Order Supplier')
@section('page-title','New Order Supplier')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
{!! Html::style('/js/dropzone/dropzone3.css') !!}

{!! Html::style('/css/admin/project.css') !!}

{!! Html::style('/css/admin/select2.css') !!}
<style>
    .content-header h1 {
        border-bottom: 3px solid orange;
        width: 20%;
        text-align: center;
        margin: 0 auto;
    }

</style>

@endsection

@section('content')
@php
$create_order="";
$create_product="";
$create_supplier="";
$create_factory="";
@endphp
@if(!empty($privelege))
@php
$create_order=$privelege->create_order;
$create_product=$privelege->create_product;
$create_supplier=$privelege->create_supplier;
$create_factory=$privelege->create_factory;
@endphp
@endif
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12 padding-b-25">
            <div class="tic_form">
                @include('partials.client.supplier._newinspection')
            </div>

            <div class="loading_form">
                @include('partials.client.supplier._newinspectionCBPI')
            </div>

            <div class="site_form" style="display:none">
                @include('partials.client.supplier._newinspectionSite')
            </div>

            @include('partials.client.supplier._newverproduct')
            @include('partials.client.supplier.contactperson')

            @include('partials.client.supplier._newfactory')
            @include('partials.client._newsupplier')
            @include('pages.supplier.product._editproduct')
            @include('partials.client.supplier._selectproduct')
            @include('partials.client.supplier._inputcategory')
            @include('partials.client.supplier._inputsubcategory')
            @include('partials.client.supplier._inputsubcategory2')
            {{-- @include('partials.client._viewattachment') --}}


            {{-- @include('partials.client._newproduct')--}}
            {{-- @include('partials.client._projectnewfactory')
                @include('partials.admin.project._newfactory')
                @include('partials.admin.project._newclient')
               
                @include('partials.admin.project._newclientcontact')
                @include('partials.admin.project._newfactorycontact')
                
                {!! Html::script('/js/dropzone.js') !!}
                
                --}}
        </div>
    </div>

</div>

<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    var auth_id = "{{Auth::id()}}";
    var newclient = "{{route('addclientajax')}}";
    var newfactory = "{{route('newfactoryajax')}}";
    var newproduct = "{{route('save-client-product')}}";
    var getproductnew = "{{route('selectproductnew')}}";
    var newcontactclient = "{{route('addclientcontactajax')}}";
    var saveCBPI = "{{route('supplier-client-savecbpiinspection')}}";
    var savePSI = "{{route('supplier-client-saveinspection')}}";
    var saveSite = "{{route('client-savesitevisitinspection')}}";
    var token = "{{csrf_token()}}";
    var pdf_icon = "{{asset('images/icons/pdf.png')}}";
    var doc_icon = "{{asset('images/icons/doc.png')}}";
    var xls_icon = "{{asset('images/icons/xls.png')}}";
    var ppt_icon = "{{asset('images/icons/ppt.png')}}";
    var pub_icon = "{{asset('images/icons/pub.png')}}";

</script>
{!! Html::script('/js/jquery.validate.min.js') !!}
{!! Html::script('/js/additional-methods.js') !!}
{!! Html::script('/js/aql/general.js') !!}
{!! Html::script('/js/aql/special.js') !!}
{!! Html::script('/js/aql/genss.js') !!}
{!! Html::script('/js/aql/allowed.js') !!}

{!! Html::script('/js/client/project.js?v=1') !!}
{!! Html::script('/js/client/supplier-dropzone-psi.js') !!}
{!! Html::script('/js/client/supplier-dropzone-cli.js?v=4') !!}
@endsection
