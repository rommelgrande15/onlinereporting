<div id="createInvoice" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Invoice for {{$client_name}}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="client_name" id="client_name" value="{{$client_name}}">
          <input type="hidden" name="client_code" id="client_code" value="{{$client_code}}">
            <div class="col-md-6">
              <label for="month">Choose From</label>
              <input type="text" name="date_from" id="date_from" class="form-control"  placeholder="yyyy-mm-dd">

            </div>
            <div class="col-md-6">
              <label for="year">Choose To</label>
              <input type="text" name="date_to" id="date_to" class="form-control" placeholder="yyyy-mm-dd">

            </div>
        </div>    
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
        <button class="btn btn-success" id="generate_inv"><i class="fa fa-print"></i> Generate</button>
        {{-- <a href="{{ route('create-invoice',$client_code)}} " class="btn btn-success" id="generate_inv"><i class="fa fa-print"></i> Generate</a> --}}
      </div>
    </div>

  </div>
</div>



<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
  $(document).ready(function() {  
    $("#date_from").datepicker({
        dateFormat:"yy-mm-dd",
              onSelect: function (date) {
                  var date2 = $('#date_from').datepicker('getDate');
                  date2.setDate(date2.getDate());
          $('#date_to').datepicker('option', 'minDate', date2);
          var dt1 = $('#date_from').datepicker('getDate');
                  console.log(dt1);
                  var dt2 = $('#date_to').datepicker('getDate');
                  if (dt2 <= dt1) {
                      var minDate = $('#date_to').datepicker('option', 'minDate');
                      $('#date_to').datepicker('setDate', minDate);
          }     
            }
      });
      $('#date_to').datepicker({
			dateFormat:"yy-mm-dd"
        });

    $('#generate_inv').on('click',function(){
      console.log('test');
      var client_code=$('#client_code').val();
      var date_from=$('#date_from').val();
      var date_to=$('#date_to').val();
      if(date_from=='' && date_to==''){
        swal({
			    	title: "Warning",
			    	text: "Warning: Please fill up requried fields",
			    	type: "warning",
			    });
      }else{
        $('.send-loading ').show();
        location.href='/create-invoice-new/'+client_code+'/'+date_from+'/'+date_to;
        setTimeout(function(){ $('.send-loading ').hide(); }, 1000);
 
        //$.ajax({
			  //  type: 'GET',
			  //  url: '/create-invoice-new/'+client_code+'/'+date_from+'/'+date_to,
			  //  success: function(data) {
			  //  	$('.send-loading ').hide();
        //    console.log(data);
        //    //console.log(data);
        //    //location.href=asset(data);
			  //  },
			  //  error: function() {
			  //  	swal({
			  //  		title: "Error",
			  //  		text: "Error: Server encountered an error. Please try again or contact your system administrator.",
			  //  		type: "error",
			  //  	});
			  //  	$('.send-loading ').hide();
			  //  }
		    //});
      }
    });
  });
</script>
