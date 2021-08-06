@extends('layouts.client._new')
@section('title','Edit Multiple Order')
@section('page-title','Edit Multiple Order')
@section('stylesheets')
    {!! Html::style('/css/dropzone.css') !!}
    {!! Html::style('/js/dropzone/dropzone3.css') !!}
    {!! Html::style('/css/admin/project.css') !!}

    {!! Html::style('/css/admin/select2.css') !!}
    <style>
        .content-header h1{
            border-bottom:3px solid orange; 
            width:20%; 
            text-align:center; 
            margin:0 auto;
        }
       
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 padding-b-25">       
                <div class="tic_form">
                    @include('partials.client._editinspection-mrn')
                </div>

               {{--  @include('partials.client._newproduct')
                @include('partials.client.contactperson')

                @include('partials.client._newfactory') --}}

                @include('partials.client._newverproduct')
                @include('partials.client.contactperson')

                @include('partials.client._newsupplier')
                @include('partials.client._newfactory')
                @include('partials.client.edit-project._editproduct')
                @include('partials.client._selectproduct')
                @include('partials.client._inputcategory')
                @include('partials.client._inputsubcategory')
                @include('partials.client._inputsubcategory2')

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
        var newproduct = "{{route('save-client-product')}}";
        var getproduct = "{{route('selectproduct')}}";
        var newcontactclient = "{{route('addclientcontactajax')}}";
        var saveCBPI = "{{route('client-savecbpiinspection')}}";
        var savePSI = "{{route('client-saveinspection')}}";
        var editPSI = "{{route('client-editinspection-mrn')}}";
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
    {!! Html::script('/js/aql/master.js') !!}
  
	{!! Html::script('/js/client/project-edit-mrn.js?v=1') !!}
    {{-- {!! Html::script('/js/client/client-dropzone-cbpi.js') !!} --}}
    {!! Html::script('/js/client/client-dropzone-psi-draft-mrn.js?v=1') !!}

@endsection
