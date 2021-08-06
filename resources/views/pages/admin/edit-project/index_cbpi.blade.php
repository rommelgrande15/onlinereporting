@extends('layouts.new')
@section('title','Panel')
@section('page-title','Edit Inspection Project')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
{!! Html::style('/css/admin/project.css') !!}
{!! Html::style('/css/admin/select2.css') !!}
<style>
    .select2-container {
        width: 100% !important;
    }

</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12 padding-b-25">
            <div>
                @include('partials._editinspectionCBPI')
            </div>

            @include('partials.admin.project._newfactory')
            @include('partials.admin.project._newclient')
            @include('partials.admin.project._newproduct')
            @include('partials.admin.project._newclientcontact')
            @include('partials.admin.project._newfactorycontact')
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
    var newproduct = "{{route('newproductajax')}}";
    var getproduct = "{{route('selectproduct')}}";
    var newcontactclient = "{{route('addclientcontactajax')}}";
    var saveCBPI = "{{route('edited-draft-inspection-cbpi')}}";
    var savePSI = "{{route('edited-draft-inspection')}}";
    var routesavedraftCbpi = "{{route('savedraftinspectioncbpi')}}";
    var routeditdraftCbpi = "{{route('editcbpidraft')}}";
    var token = "{{csrf_token()}}";
    var pdf_icon = "{{asset('images/icons/pdf.png')}}";
    var doc_icon = "{{asset('images/icons/doc.png')}}";
    var xls_icon = "{{asset('images/icons/xls.png')}}";
    var ppt_icon = "{{asset('images/icons/ppt.png')}}";
    var pub_icon = "{{asset('images/icons/pub.png')}}";
    $("#loading_factory").select2();

</script>
{!! Html::script('/js/jquery.validate.min.js') !!}
{!! Html::script('/js/additional-methods.js') !!}
{!! Html::script('/js/aql/general.js') !!}
{!! Html::script('/js/aql/special.js') !!}
{!! Html::script('/js/aql/genss.js') !!}
{!! Html::script('/js/aql/allowed.js') !!}
{!! Html::script('/js/dropzone.js') !!}
{!! Html::script('/js/admin/project.js') !!}
{!! Html::script('/js/admin/dropzone-send-draft.js?v=2') !!}

@endsection
