@extends('layouts.new')
@section('title','New Project')
@section('page-title','New Project')
@section('stylesheets')
    {!! Html::style('/css/dropzone.css') !!}
    {!! Html::style('/css/admin/project.css') !!}
   



    {!! Html::style('/css/admin/select2.css') !!}




@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 padding-b-25">       
                <div class="tic_form">
                    @include('partials.admin.project-dev._newinspection')
                </div>

                <div class="loading_form" >
                    @include('partials.admin.project-dev._newinspectionCBPI')
                </div>

               <div class="site_form" style="display:none">
                    @include('partials.admin.project-dev._newinspectionSite')
                </div> 



                

                @include('partials.admin.project-dev._newfactory')
                @include('partials.admin.project-dev._newclient')
                @include('partials.admin.project-dev._newproduct')
                @include('partials.admin.project-dev._newclientcontact')
                @include('partials.admin.project-dev._newfactorycontact')
            </div>
        </div>
        
    </div>
	
    <div class="se-pre-con"></div>
    <div class="send-loading"></div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(window).on('load',function() {
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
        var savePSI = "{{route('saveinspection')}}";
        var saveSite = "{{route('savesitevisitinspection')}}";
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
    {!! Html::script('/js/dropzone.js') !!}
	{!! Html::script('/js/project-dev/project.js') !!}
    {!! Html::script('/js/project-dev/dropzone-send.js') !!}
    {!! Html::script('/js/project-dev/dropzone-psi.js') !!}
    {!! Html::script('/js/project-dev/dropzone-site-visit.js') !!}

@endsection
