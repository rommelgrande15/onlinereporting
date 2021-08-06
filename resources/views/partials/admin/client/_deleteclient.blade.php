<div id="deleteClient" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deleteclient' ])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Client</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to delete this Client?</p>
          <div class="form-group">
              {!!Form::label('client_name','Client Name',['class'=>''])!!}
              {!!Form::text('client_name',null,['class'=>'form-control','id'=>'del_client_name','readOnly'=>''])!!}
              {!!Form::hidden('client_id',null,['class'=>'form-control','id'=>'del_client_id','readOnly'=>''])!!}
          </div>        
      </div>
      <div class="modal-footer">
        {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
        {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'button','onClick' => 'deleteData()']) !!}
      </div>
      {!!Form::close()!!}
    </div>

  </div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>


  function deleteData(){

   $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

             // e.preventDefault();
var id= $('#del_client_id').val();
//alert(id);
$.ajax({
  type:'POST',
  url:'/deleteclient',
  data:{client_id:id},
  success:function(data){   
  alert("Deleted");
 
  setTimeout(function(){  location.reload(); }, 1000);
              }  


});
  }


</script>