<div id="updateSalesModal" class="modal fade" role="dialog">
  <div class="modal-dialog ui-front">
    <form method="POST" >
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Sales Details</h4>
        </div>
        <div class="modal-body">
          {!!csrf_field()!!}
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Sales Name:</label>
                  <input type="text" class="form-control" name="sales_name" id="update_sales_name" required>
                  <input type="hidden" class="form-control" id="update_id" name="sales_id">
                  <div id="Updasales1" style="display:none" ><p style="color:red;">This field is required! </p></div>
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" name="email" id="update_email">
                  </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="UpdateSalesData()" class="btn btn-success" >Save Details</button>
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>



<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>


      <script>
var message;
var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
      var array_id=[
        'update_email',
        'update_sales_name'
        // 'update_contact_number',
        // 'update_tel_number',
        // 'update_sales_country',
        // 'update_sales_state',
        // 'update_sales_city'
      ];

          var array_message=[
        'Email',
        'Sales Name'
        // 'Contact Number',
        // 'Tel Number',
        // 'Sales Country',
        // 'Sales State',
        // 'Sales City'
      ];



function UpdateSalesData(){

var count_null=0;
  for (let index = 0; index < array_id.length; index++) {
  const element = $('#'+array_id[index]+'').val();
              if(element==""){
                count_null+=1;
                jQuery('#'+array_id[index]+'').css("border","1px solid red");
                message=array_message[index];
                break;
              }else{
                jQuery('#'+array_id[index]+'').removeAttr("style");
              }
}

if(count_null==0){
  if(emailValidator.test($('#update_email').val())){
    $('.send-loading ').show();
      //  var update_username = $('#update_username').val();
       var update_email = $('#update_email').val();
       var update_sales_name = $('#update_sales_name').val();
      //  var update_contact_number= $('#update_contact_number').val();
      //  var update_tel_number= $('#update_tel_number').val();
      //  var update_sales_country = $('#update_sales_country').val();
      //  var update_sales_country_name = $('#update_sales_country option:selected').text();
      //  var  update_sales_state= $('#update_sales_state').val();
      //  var  update_sales_state_id= $('#update_sales_state_id').val();
      //  var  update_sales_city = $('#update_sales_city').val();
      //  var  update_sales_city_name = $('#update_sales_city_name').val();


            // var update_skype = jQuery('#update_skype').val();
            // var update_wechat = jQuery('#update_wechat').val();
            // var update_whatsapp = jQuery('#update_whatsapp').val();
            // var update_qqmail = jQuery('#update_qqmail').val();
            
            // if(update_skype==""){

            //   update_skype="N/A";
            // }
            // if(update_wechat==""){

            //   update_wechat="N/A";
            //   }
            //   if(update_whatsapp==""){

            //   update_whatsapp="N/A";
            //   }

            //    if(update_qqmail==""){

            //   update_qqmail="N/A";
            //   }
       var  sales_id = $('#update_id').val();
       $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            $.ajax({
               type:'POST',
               url:'/updatesales',
               data:
               { 
                //  update_username:update_username,
                 email:update_email,
                sales_name:update_sales_name,
                // contact_number:update_contact_number,
                //  update_tel_number:update_tel_number,
                //  update_sales_country:update_sales_country,
                //  update_sales_country_name:update_sales_country_name,
                //  update_sales_state:update_sales_state,
                //  update_sales_state_id:update_sales_state_id,
                //  update_sales_city:update_sales_city,
                 sales_id:sales_id,
                //  update_skype,
                // update_wechat,
                // update_whatsapp,
                //  update_qqmail
                },
               success:function(data){
                alert("User successfully Updated.");
                $('.send-loading ').hide();
                location.reload();
              },
              error: function(){
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
              }
              
            });   

  }else{
    alert("Email is not Valid");
  }

}else{
alert(""+message+" are required");
}
}

var updated =[
'update_contact_number',
'update_sales_name',
'update_address'
];


function checkeds()
        {
          for(var x=0;x<=2;x++){
          jQuery('.'+updated[x]+'').removeAttr("style");
          }

          for(var x=0;x<=2;x++){
            jQuery('#Updasales'+x+'').css("display","none");
          }
        }
  
     function sales()
     {
   // console.log(jQuery('.'+update+'').val());
   
      checkeds();
      for(var x=0;x<=2;x++){
        //alert(jQuery('#'+updated[x]+'').val());
      if(jQuery('#'+updated[x]+'').val()=="")
      {
    
        jQuery('#Updasales'+x+'').css("display","block");
        jQuery('#'+updated[x]+'').css('border-color', 'red');
        x=7;
      }else if(x==2){
        
       alert("Success");
        
      }
      }
     }

  $('#update_sales_state').autocomplete({
      maxResults: 10,
      source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_state, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	},
      select: function (event, ui) {
          $("#update_sales_state").val(ui.item.label); // display the selected text
          $("#update_sales_state_id").val(ui.item.value); // save selected id to hidden input
          showCityByCountryAndStateChangeNew();
          return false;
      }
    });

     function showStateByCountryChange() {
       
     var id = $('#update_sales_country').val();
     var name = $('#update_sales_country option:selected').text();
     $('#update_sales_country_name').val(name);

    //$('#update_sales_state').empty();
    //$('#update_sales_state').append('<option value="">Please Wait...</option>');
    $('#update_sales_state').val('Please wait..');
    $.ajax({
        url: '/get-state/' + id,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            //$('#update_sales_state').empty();
            //$('#update_sales_state').append('<option value="">Select State</option>');
            /* var data_country=  JSON.parse(result); */
            $('#update_sales_state').val('');
            //var data_country = result;
            var data_country=  JSON.parse(result);
            update_source_state.length = 0;
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#update_sales_state').append('<option value="' + element.id + '">' + element.name + '</option>');
                    update_source_state.push({value:element.id,label:element.name});
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_sales_state').empty();
            $('#update_sales_state').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

function showCityByCountryAndStateChange() {
     var sid = $('#update_sales_state').val();
     $('#update_sales_state_name').val(name);
}

$('#update_sales_city').autocomplete({
    maxResults: 10,
		source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_city, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	}
  });

 //$( "#sales_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );

function showCityByCountryAndStateChangeOLD() {
     var cid = $('#update_sales_country').val();
     var sid = $('#update_sales_state').val();
     var name = $('#update_sales_state option:selected').text();
     $('#update_sales_state_name').val(name);

    $('#update_sales_city').empty();
    $('#update_sales_city').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            $('#update_sales_city').empty();
            $('#update_sales_city').append('<option value="">Select City</option>');
            var data_city=  JSON.parse(result);
            //var data_city = result;

            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    $('#update_sales_city').append('<option value="' + element.id + '">' + element.name + '</option>');
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_sales_city').empty();
            $('#update_sales_city').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}


function showCityByCountryAndStateChangeNew() {
     var cid = $('#update_sales_country').val();
     var sid = $('#update_sales_state_id').val();

    $('#update_sales_city').val('Please wait...');

    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            $('#update_sales_city').val('');
  
            //var data_city = result;
            var data_city=  JSON.parse(result);
            update_source_city.length = 0;
            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                  update_source_city.push(element.name);
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_sales_city').empty();
            $('#update_sales_city').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

  function getCityName() {
     var name = $('#update_sales_city').val();
     $('#update_sales_city_name').val(name);
    }

      </script> 