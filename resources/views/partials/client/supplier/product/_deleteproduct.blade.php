<div id="deleteProduct" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        {!!Form::open(['data-parsley-validate'=>'', 'route'=>'delete-factory' ])!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Product</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this Product?</p>
            <div class="form-group">
                {!!Form::label('product_name','Product Name',['class'=>''])!!}
                {!!Form::text('product_name',null,['class'=>'form-control','readOnly'=>''])!!}
                {!!Form::hidden('del_prod_id',null,['class'=>'form-control','id'=>'del_prod_id'])!!}
            </div>        
        </div>
        <div class="modal-footer">
          {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
          {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'button','id'=>'btn_delete_factory']) !!}
        </div>
        {!!Form::close()!!}
      </div>
  
    </div>
  </div>
  <script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
  <script>
    $('#btn_delete_factory').on('click',function(){
      deleteFactory();
    });
    function deleteFactory(){
      var id = $('#del_prod_id').val();
        $('.send-loading').show();                   
        $.ajax({
           type:'POST',
           url:'/delete-supplier-product',
           data:{
            _token: token,
            id:id
          },
           success:function(data){
             console.log(data);
             $('.send-loading ').hide();
              swal({
                title: "Success",
                text: "Successfully deleted",
                type: "success",
              }, function() {
                location.reload();
              });
            },
            error: function(err){
              console.log(err);
              $('.send-loading ').hide();
              swal({
                  title: "Error",
                  text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                  type: "error",
              });
              
            }                             
        });
    }    
  </script>