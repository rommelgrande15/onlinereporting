<div id="changeAQL" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <form data-parsley-validate='' method="post">
                {!!csrf_field()!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">AQL Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usr">Normal Level:</label>
                                @if ($client_aql_detail)
                                <input type="hidden" id="edit_client_id" value="{{$client_aql_detail->client_id}}">
                                {!! Form::select('aql_normal_level', $normal, $client_aql_detail->normal_level, ['class' => 'form-control aql_normal_level', 'placeholder'=>'--Select--', 'required'=>'','id'=>'aql_normal_level']) !!}
                                @else
                                {!! Form::select('aql_normal_level', $normal, null, ['class' => 'form-control aql_normal_level', 'placeholder'=>'--Select--', 'required'=>'','id'=>'aql_normal_level']) !!}
                                @endif
                                <div id="aqlRequired2" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usr">Special Level:</label>
                                @if ($client_aql_detail)
                                {!! Form::select('aql_special_level', $special, $client_aql_detail->special_level, ['class' => 'form-control aql_special_level','id'=>'aql_special_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                                @else
                                {!! Form::select('aql_special_level', $special, null, ['class' => 'form-control aql_special_level','id'=>'aql_special_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                                @endif
                                <div id="aqlRequired3" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label>AQL</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Major</label>

                                <select class="form-control aql_select aql_major" id="aql_major">
                                </select>
                                @if ($client_aql_detail)
                                <input type="hidden" id="preset_aql_major" value="{{$client_aql_detail->aql_major}}">
                                 @endif
                                
                                <div id="aqlRequired4" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Minor</label>
                                <select class="form-control aql_select aql_minor" id="aql_minor"></select>
                                @if ($client_aql_detail)
                                <input type="hidden" id="preset_aql_minor" value="{{$client_aql_detail->aql_minor}}">
                                @endif
                                <div id="aqlRequired6" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Critical</label>
                                <select type="text" name="aql_critical" id="aql_critical" class="form-control  aql_critical">
                                    <option value="0" selected>0</option>
                                </select>
                                <div id="aqlRequired7" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
                    <!--<button type="submit" class="btn btn-success" id="update-aql"><i class="fa fa-floppy-o"></i> Save changes</button>-->
                    {!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'update-aql']) !!}
                </div>
            </form>
        </div>

    </div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        $('#close-err-e-prod').click(function() {
            $('#edit-show-error').hide();
        });
        $('#update-aql').click(function() {
            console.log('test Edit Aql Details');
            $('#edit-show-error').hide();
            $('.send-loading ').show();
            $.ajax({
                url: '/update-aql',
                type: 'POST',
                data: {
                    _token: token,
                    'client_id': $('#edit_client_id').val(),
                    'aql_normal_level': $('#aql_normal_level').val(),
                    'aql_special_level': $('#aql_special_level').val(),
                    'aql_major': $('#aql_major').val(),
                    'aql_minor': $('#aql_minor').val(),
                },
                beforeSend: function() {
                    $('.send-loading ').show();
                },
                success: function(response) {
                    console.log(response);
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "AQL Details successfully updated!",
                        type: "success",
                    }, function() {
                        $('#changeAQL').modal('hide');
                        location.reload();
                    });
                },
                error: function() {
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                        type: "error",
                    });
                }
            });
        });
        $('.aql_select').append('<option value="">--</option>');
        $('.aql_select').append('<option value="0.065">0.065</option>');
        $('.aql_select').append('<option value="0.1">0.1</option>');
        $('.aql_select').append('<option value="0.15">0.15</option>');
        $('.aql_select').append('<option value="0.25">0.25</option>');
        $('.aql_select').append('<option value="0.4">0.4</option>');
        $('.aql_select').append('<option value="0.65">0.65</option>');
        $('.aql_select').append('<option value="1">1.0</option>');
        $('.aql_select').append('<option value="1.5">1.5</option>');
        $('.aql_select').append('<option value="2.5">2.5</option>');
        $('.aql_select').append('<option value="4">4.0</option>');
        $('.aql_select').append('<option value="6.5">6.5</option>');
        $('.aql_select').append('<option value="10">10</option>');
        
        $('#changeAQL').on('shown.bs.modal', function (e) {
            $('#aql_major').val($('#preset_aql_major').val());
            $('#aql_minor').val($('#preset_aql_minor').val());
        });

    });

</script>
