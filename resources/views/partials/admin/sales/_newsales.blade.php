<div id="newSalesModal" class="modal fade" role="dialog">
  <div class="modal-dialog ui-front">
    <!-- <form method="POST" action="#"> -->
    <form method="" action="">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Sales Manager</h4>
        </div>
        <div class="modal-body">
          {{-- {{csrf_field()}} --}}
          <div class="row">
            {{-- <label class="pull-right"><span class="text-danger">*</span> <i>Indicate required fields</i></label><br/> --}}
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="email"><span class="text-danger">*</span> Sales Name:</label>
                    <input type="text" class="form-control f" name="sales_name" id="sales_name" required onkeyup="textInputValidator(this.id)">
                    <div id="sales5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                   <label for="email"><span class="text-danger">*</span> Email address:</label>
                   <input type="email" class="form-control d" name="email" id="email" required onkeyup="textInputValidator(this.id)">
                   <div id="sales1" style="display:none" ><p style="color:red;">This field is required! </p></div>
                 </div>
             </div>
          </div>          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="addSales()" class="btn btn-success" >Save Details</button>
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>


      <script>

      $(document).ready(function() {
        showAllCountryInCompany();
      });
var update =[
'a',
'b',
'c',
'd',
'e',
'f',
'g'
];


function checkeds()
        {
          for(var x=0;x<=6;x++){
          jQuery('.'+update[x]+'').removeAttr("style");
          }

          for(var x=0;x<=6;x++){
            jQuery('#sales'+x+'').css("display","none");
          }
        }


     function addSales()
     {
      
      var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        

            var username =jQuery('.a').val();
            var email = jQuery('.d').val();
            var password = jQuery('.b').val();
            var password_confirmation = jQuery('.c').val();
            var sales_name = jQuery('.f').val();
            var contact_number = jQuery('.e').val();

            var tel_number = jQuery('#tel_number').val();


            var user_country_name = jQuery('#sales_country option:selected').text();
            var user_country_id = jQuery('#sales_country').val();
           var insp_state=jQuery('#sales_state').val();
           var user_state_name = insp_state;
            var user_state_id = jQuery('#hidden_sales_state').val();
           var user_city_name = jQuery('#sales_city').val();
            var user_city_id = jQuery('#sales_city').val();

            var address= user_city_name +' '+ user_state_name +' '+ user_country_name;

            var sales_skype = jQuery('#sales_skype').val();
            var sales_wechat = jQuery('#sales_wechat').val();
            var sales_whatsapp = jQuery('#sales_whatsapp').val();
            var sales_qqmail = jQuery('#sales_qqmail').val();
            
            if(sales_skype==""){

              sales_skype="N/A";
            }
            if(sales_wechat==""){

              sales_wechat="N/A";
              }
              if(sales_whatsapp==""){

              sales_whatsapp="N/A";
              }

               if(sales_qqmail==""){

              sales_qqmail="N/A";
              }

            var count_null=0; //variable for counting the null values
            var array_id_name =['sales_name','username','password','password_confirmation','sales_country','sales_state','sales_city','email','contact_number','tel_number'];
            var message;
            var array_message =['Sales Name','Username','Password','Password Confirmation','Sales Country','Sales State','Sales City','Email','Contact Number','Tel Number'];

            for (let index = 0; index < array_id_name.length; index++) {
              const element = jQuery('#'+array_id_name[index]).val();
              if(element==""){
                count_null+=1;
                jQuery('#'+array_id_name[index]+'').css("border","1px solid red");
                message=array_message[index];
                break;
              }else{
                jQuery('#'+array_id_name[index]+'').removeAttr("style");
              }
            }
            console.log(count_null);
            if(count_null==0){
              if(password==password_confirmation){
                if(emailValidator.test(jQuery('.d').val())){
                  $('.send-loading ').show();
                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  $.ajax({
                    type:'POST',
                    url:'/salesDataNew',
                    data:{email:email},
                    success:function(data){  
                      if(data=='[]'){
                          $.ajax({
                            type:'POST',
                            url:'/SalesUsernameDataNew',
                            data:{username:username},
                            success:function(data){
                              if(data=='[]'){
                                $.ajaxSetup({
                                  headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                                });
                                $.ajax({
                                  type:'POST',
                                  url:'/newsales',
                                  data:{
                                    username:username,
                                    email:email,
                                    password:password,
                                    sales_name:sales_name,
                                    contact_number:contact_number,
                                    tel_number:tel_number,
                                    address:address,
                                    user_country_name:user_country_name,
                                    user_country_id:user_country_id,
                                    user_state_name:user_state_name,
                                    user_state_id:user_state_id,
                                    user_city_name:user_city_name,
                                    user_city_id:user_city_id,                                                   
                                    sales_skype:sales_skype,
                                    sales_wechat:sales_wechat,
                                    sales_whatsapp:sales_whatsapp,
                                    sales_qqmail:sales_qqmail
                                  },
                                  success:function(data){
                                    console.log(data);
                                    alert("Sales successfully added.");
                                    $('.send-loading ').hide();                                                 
                                    location.reload();
                                    //redirect()->route('clientcontacts',$client->client_code);
                                  },
                                  error: function(){
                                    alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                                    $('.send-loading ').hide(); 
                                  }  
                                });
                              }else{
                                  alert("Username is already Exist");
                                  $('.send-loading ').hide();  
                              }
                            }
                          });
                 }else{
                   alert("Email is already Exist");
                   $('.send-loading ').hide();  
                 }                       
                }
             }); 
      }else{
        alert("Email are not Valid");
        jQuery('.d').css('border-color', 'red');
     
}
               
              }else{
                alert("Password mismatch!");
                $('#password').css("border","1px solid red");
                $('#password_confirmation').css("border","1px solid red");
              }
            }else{
              alert(""+message+" are required fields.");
            }
     }


     $('#sales_country').on('change', function() {
      //showStateByCountryInCompany(this.id,'sales_state');
      textInputValidator(this.id);
    });

    $('#sales_state').on('change', function() {
      //showCityByCountryAndStateInCompany('sales_country','sales_state','sales_city');
      textInputValidator(this.id);
    });

    
    function textInputValidator(input_id){
       if(jQuery('#'+input_id).val()!=""){
            jQuery('#'+input_id).removeAttr("style");
        }
     }

     function showAllCountryInCompany(){
        $('#sales_country').empty();
		$('#sales_country').append('<option value="">Please Wait...</option>');
		$.ajax({         
        	url: '/get-all-country/1'            
          , type: 'GET'
        	, success: function (result) {
                //localStorage.setItem("result",result);
              
                $('#sales_country').empty();
				        $('#sales_country').append('<option value="">Select Country</option>');
              var data_country=  JSON.parse(result);
              //data_country=result;
              data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        $('#sales_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                        
                    }
                   
                });
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#sales_country').empty();
        $('#sales_country').append('<option value="">Something went wrong. Please try again.</option>');

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

    var source_state=[];

    $('#sales_state').autocomplete({
      maxResults: 10,
      source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_state, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	},
      select: function (event, ui) {
          $("#sales_state").val(ui.item.label); // display the selected text
          $("#hidden_sales_state").val(ui.item.value); // save selected id to hidden input
          showCityByCountryAndStateInCompany('sales_country','hidden_sales_state','');
          return false;
      }
    });

    function showStateByCountryInCompany(country_id,select_id){
    var id = $('#'+country_id).val();
    $('#'+select_id).val('Please wait..');
		$.ajax({         
        	url: '/get-state/'+id            
        	, type: 'GET'
        	, success: function (result) {
                //var data_country= result;
                var data_country=  JSON.parse(result);
                source_state.length = 0;
                data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        source_state.push({value:element.id,label:element.name});
                    }                  
                });
                $('#'+select_id).val('');
               
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
    
    var source_city=[];

  $('#sales_city').autocomplete({
    maxResults: 10,
		source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_city, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	}
  });

  $( "#sales_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );


    function showCityByCountryAndStateInCompany(country_id,state_id,city_id){
        var cid = $('#'+country_id).val();
        var sid = $('#'+state_id).val();
    $('#sales_city').val('Please Wait...');
		$.ajax({         
        	url: '/get-city/'+sid
        	, type: 'GET'
        	, success: function (result) {
                //console.log(result);
                //$('#'+city_id).val('Please wait...');
                //$('#'+city_id).empty();
				        //$('#'+city_id).append('<option value="">Select City</option>');
        var data_city=  JSON.parse(result);
        //var data_city=  result;
        source_city.length = 0;
                data_city.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        //$('#'+city_id).append('<option value="'+element.id+'">'+element.name+'</option>');
                        source_city.push(element.name);
                        //$('#'+city_id).val('');
                    }                  
				});
				$('#sales_city').val('');
     
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+city_id).empty();
				$('#'+city_id).append('<option value="">Something went wrong. Please try again.</option>');
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