@extends('layouts.new')
@section('title','Release Client Order')
@section('page-title','Release Client Order')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
{!! Html::style('/js/dropzone/dropzone3.css') !!}
{!! Html::style('/css/admin/project.css') !!}
{!! Html::style('/css/admin/select2.css') !!}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12 padding-b-25">
            <div class="tic_form">
                @include('partials.admin.release-order._editorder')
            </div>
        </div>
    </div>
</div>

<div class="se-pre-con"></div>
<div class="send-loading"></div>
@include('partials.admin.release-order._newsupplier')
@include('partials.admin.release-order._newfactory')
@include('partials.admin.release-order._newproduct')
@include('partials.admin.release-order._editproduct')
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
    var saveCBPI = "{{route('savecbpiinspection')}}";
    var savePSI = "{{route('edited-draft-inspection')}}";
    var releaseorder = "{{route('releaseorder')}}";
    var holdorder = "{{route('holdorder')}}";
    var routeupdatePsiDraft = "{{route('editpsidraft')}}";
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

{!! Html::script('/js/admin/project-release-order.js') !!}
{!! Html::script('/js/admin/dropzone-psi-release-order.js?v=2') !!}
<script>
    //$('.sel-inspector').select2();
    $('#supplier').select2();
    $('#factory').select2();

</script>

@endsection
