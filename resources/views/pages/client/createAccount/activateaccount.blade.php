@extends('layouts.master')
@section('title','Create an account')
@section('stylesheets')
  {!! Html::style('/css/register/index.css') !!}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12 text-center logo-container">
            <a href="{{route('login')}}"><img src="{{URL::asset('/images/logo.png')}}" width="500"></a>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading orange-background">Activate account</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            @include('partials._messagesRegister')
                        </div>
                    </div>
                    
              </div>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')
	{!! Html::script('/js/register/index.js') !!}
@endsection

<script type="text/javascript" src="https://tic-service.company/cloudfare/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://tic-service.company/cloudfare/jquery-ui.min.js"></script>

<script>
    var source_comp_state=[];
    $(document).ready(function(){
        showAllCountryInCompany();
        $('#company_country').on('change', function() {
            showStateByCountryInCompany(this.id,'company_state','comp');
        //cmbValidator(this.id);
        });

        

        
    });
    $('#company_state').autocomplete({
            maxResults: 10,
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(source_comp_state, request.term); 
                response(results.slice(0, this.options.maxResults));
            },
            select: function (event, ui) {
                $("#company_state").val(ui.item.label); // display the selected text
                //$("#hidden_company_state_id").val(ui.item.value); // save selected id to hidden input
                return false;
            }
        });
    

    function showAllCountryInCompany(){
        $('#company_country').empty();
		$('#company_country').append('<option value="">Please Wait...</option>');
		$.ajax({         
        	url: 'http://world.t-i-c.asia/webapi_world_controller.php'            
          , type: 'POST'
        	, datatype: 'json'
        	, data: {
        	    show_all_country: 1
        	}
        	,success: function (result) {         
                $('#company_country').empty();
				$('#company_country').append('<option value="">Select Country</option>');
                data_country=result;
                data_country.forEach(element => {
                if(element.name=="" || element.name==null){
                }else{
                    $('#company_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                    $('#company_invoice_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                    
                }    
                });      
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#company_country').empty();
                $('#company_country').append('<option value="">Something went wrong. Please try again.</option>');

				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }
    var source_comp_city=[];
    var source_inv_city=[];
    
    var source_inv_state=[];
    function showStateByCountryInCompany(country_id,select_id,src){
        console.log('test');
        var id = $('#'+country_id).val();
        $('#'+select_id).val('Please Wait...');
		$.ajax({         
        	url: 'http://world.t-i-c.asia/webapi_state_controller.php?id='+id            
        	, type: 'GET'
        	, datatype: 'json'
        	, data: {
        	    show_all_country: 1
        	}
        	, success: function (result) {
              $('#'+select_id).val('');
               if(src=='comp'){
                source_comp_state.length = 0;
               }else{
                source_inv_state.length = 0;
               }
                var data_country= result;
                data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                       // $('#'+select_id).append('<option value="'+element.id+'">'+element.name+'</option>');
                       if(src=='comp'){
                        source_comp_state.push({value:element.id,label:element.name});
                        }else{
                          source_inv_state.push({value:element.id,label:element.name});
                        }
                    }                  
                });
                console.log(source_comp_state);
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+select_id).empty();
				$('#'+select_id).append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }
</script>
