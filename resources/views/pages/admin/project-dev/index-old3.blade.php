@extends('layouts.new')
@section('title','Panel')
@section('page-title','New Project')
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
                <div class="tic_form">
                    @include('partials.admin.project-dev._newinspection')
                </div>

                <div class="loading_form" >
                    @include('partials.admin.project-dev._newinspectionCBPI')
                </div>

               <div class="site_form">
                    @include('partials.admin.project-dev._newinspectionSite')
                </div> 


                  
              {{--    <div class="SPK_form" style="display:none">
                    @include('partials._newinspection_SPK')
                </div> 

                <div class="FRI_form" style="display:none">
                    @include('partials._newinspection_FRI')
                </div>  --}}
                

               {{--  @include('partials.admin.project._newfactory')
                @include('partials.admin.project._newclient')
                @include('partials.admin.project._newproduct')
                @include('partials.admin.project._newclientcontact')
                @include('partials.admin.project._newfactorycontact') --}}
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
            $(".select-inspectors").select2();
            $(".select-clients").select2();
            $(".select-factories").select2();

            $('.site_form').hide();
            $('.loading_form').hide();
            $(".se-pre-con").fadeOut("slow");
            getClients();
            
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

        function getClients(){
            $.ajax({
                type: "GET",
                url: '/get-project-data',
                success: function(data) {		
                    console.log(data);
                    $.each(data.clients, function(i, element) {
                        //clients select
                        if(element.client_status!='2'){
                            $('.select-clients').append('<option value="' + element.client_code + '">' + element.Company_Name  +' ('+element.client_code+')'+ '</option>');
                        }                      
                    });
                    $.each(data.factories, function(i, element) {
                        //factories select
                        if(element.factory_status!='2'){
                            $('.select-factories').append('<option value="' + element.id + '">' + element.factory_name + '</option>');
                        }
                    });
                    $.each(data.templates, function(i, element) {
                        $('.select-templates').append('<option value="' + element.id + '">' + element.name + '</option>');
                    });
                    $.each(data.inspectors, function(i, element) {
                        $('.select-inspectors').append('<option value="' + element.user_id + '">' + element.name +' ('+element.email_address+')'+ '</option>');
                    });
                }
            });
        }
    </script>
    {!! Html::script('/js/jquery.validate.min.js') !!}
    {!! Html::script('/js/additional-methods.js') !!}
    {!! Html::script('/js/aql/general.js') !!}
    {!! Html::script('/js/aql/special.js') !!}
    {!! Html::script('/js/aql/genss.js') !!}
    {!! Html::script('/js/aql/allowed.js') !!}
    {!! Html::script('/js/dropzone.js') !!}
	{!! Html::script('/js/admin/project-dev.js') !!}
    {!! Html::script('/js/admin/dropzone-send.js') !!}
    {!! Html::script('/js/admin/dropzone-psi.js') !!}
    {!! Html::script('/js/admin/dropzone-site-visit.js') !!}

@endsection
