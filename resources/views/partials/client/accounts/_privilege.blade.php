<div id="privelegeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Privelege Account</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Order Management</h4>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_create_order" class="check_privilege" checked>Create Order</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_edit_order" class="check_privilege" checked>Edit Order</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_copy_order" class="check_privilege" checked>Copy Order</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_cancel_order" class="check_privilege" checked>Cancel Order</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_del_order" class="check_privilege" checked>Delete Order</label>
                            </div>                           
                        </div>
                        <div class="col-md-12">
                            <h4>Supplier/Factory Management</h4>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_create_suppl" class="check_privilege" checked>Create Supplier</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_update_suppl" class="check_privilege" checked>Update Supplier</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_del_suppl" class="check_privilege" checked>Delete Supplier</label>
                            </div>  
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_create_fact" class="check_privilege" checked>Create Factory</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_update_fact" class="check_privilege" checked>Update Factory</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_del_fact" class="check_privilege" checked>Delete Factory</label>
                            </div>                          
                        </div>
                        <div class="col-md-12">
                            <h4>Product Management</h4>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_create_prod" class="check_privilege" checked>Create Product</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_update_prod" class="check_privilege" checked>Update Product</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="" id="priv_del_prod" class="check_privilege" checked>Delete Product</label>
                            </div>                          
                        </div>
                        <input type="hidden" id="user_id_priv" value="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="update-privelege" class="btn btn-success">Save Details</button>
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
        $('.check_privilege').click(function(){
            if($(this).val()=='yes'){
                $(this).val('no');
            }else{
                $(this).val('yes');
            }
        });
        $('#update-privelege').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/client-updateprivelege',
                data: {
                    user_id: $('#user_id_priv').val(),
                    create_order: $('#priv_create_order').val(),
                    edit_order: $('#priv_edit_order').val(),
                    copy_order: $('#priv_copy_order').val(),
                    cancel_order: $('#priv_cancel_order').val(),
                    delete_order: $('#priv_del_order').val(),
                    create_supplier: $('#priv_create_suppl').val(),
                    update_supplier: $('#priv_update_suppl').val(),
                    delete_supplier: $('#priv_del_suppl').val(),
                    create_factory: $('#priv_create_fact').val(),
                    update_factory: $('#priv_update_fact').val(),
                    delete_factory: $('#priv_del_fact').val(),
                    create_product: $('#priv_create_prod').val(),
                    update_product: $('#priv_update_prod').val(),
                    delete_product: $('#priv_del_prod').val()                  
                },
                beforeSend:function(){
                    $('.send-loading ').show();
                },
                success: function(data) {
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Account privelege successfully updated.",
                        type: "success",
                    }, function() {
                        location.reload();     
                    });                   
                },
                error: function(error) {
                    console.log(error);
                    $('.send-loading ').hide();
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                        type: "error",
                    });
                }

            });
        });
    });

    

</script>
