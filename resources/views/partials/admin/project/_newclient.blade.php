<div id="newClient" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <!-- {{Form::open(['data-parsley-validate'=>'', 'route'=>'addclient'])}} -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add new Client</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {{Form::label('client_name','Client Name',['class'=>''])}}
                    {{Form::text('client_name',null,['class'=>'form-control','id'=>'new_client_name'])}}
                    <div id="require1" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>

                </div>

                <div class="form-group">
                    {{Form::label('client_code','Client Code',['class'=>''])}}
                    {{Form::text('client_code',null,['class'=>'form-control','id'=>'new_client_code'])}}
                    <div id="require2" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal", 'id'=>'clr']) }}
                {{ Form::button('<i class="fa fa-floppy-o"></i> Save Client Details', ['class' => 'btn btn-success', 'id'=>'save']) }}
            </div>
            {{Form::close()}}
        </div>

    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<script>
    jQuery(document).ready(function() {
        // jQuery('#save').prop('disabled', true);

        jQuery('#new_client_name').keyup(function(e) {
            if (jQuery('#new_client_name').val() != "") {
                jQuery('#new_client_name').removeAttr("style");
                jQuery('#require1').css("display", "none");
            }
        });

        jQuery('#new_client_code').keyup(function(e) {
            if (jQuery('#new_client_code').val() != "") {
                jQuery('#new_client_code').removeAttr("style");
                jQuery('#require2').css("display", "none");
            }
        });

        jQuery('#save').click(function(e) {
            for (var x = 0; x <= 1; x++) {
                if (jQuery('#new_client_name').val() == "") {
                    jQuery('#new_client_name').css('border-color', 'red');
                    jQuery('#require1').css("display", "block");
                    x = 3;

                } else if (jQuery('#new_client_code').val() == "") {
                    jQuery('#new_client_code').css('border-color', 'red');
                    jQuery('#require2').css("display", "block");
                    x = 3;
                } else {
                    jQuery("#formData").attr("action", "{{route('addclient')}}");
                    $('#clr').click();
                    alert("Success");
                    x = 3;
                }
            }
        });
    });

</script>
