<div class="modal fade AQLModal" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Quantity and AQL</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usr">Quantity:</label>
                            <input type="number" class="form-control aql_qty" name="aql_qty" id="aql_qty" min="1" oninput="this.value = Math.abs(this.value)" required>
                            <div id="aqlRequired1" style="display:none">
                                <p style="color:red;">This field is required! </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                 
                            <label for="quantity_unit">Unit:</label>
                            {!! Form::select('quantity_unit', $units,'piece', ['class' => 'form-control aql_qty_unit', 'placeholder'=>'Select a unit', 'required'=>'']) !!}
                            <div id="aqlRequired12" style="display:none">
                                <p style="color:red;">This field is required! </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="div_hide_st">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usr">Normal Level:</label>
                                @if ($client_aql_detail)
                                    {!! Form::select('aql_normal_level', $normal, $client_aql_detail->normal_level, ['class' => 'form-control aql_normal_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                                @else
                                    {!! Form::select('aql_normal_level', $normal, null, ['class' => 'form-control aql_normal_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
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
                                    {!! Form::select('aql_special_level', $special, $client_aql_detail->special_level, ['class' => 'form-control aql_special_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                                @else
                                    {!! Form::select('aql_special_level', $special, null, ['class' => 'form-control aql_special_level', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                                @endif
                                <div id="aqlRequired3" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-bordered table-condensed row_aql_modal" width="100%">
                                <tr>
                                    <th></th>
                                    <th class="text-center">AQL</th>
                                    <th class="text-center">Max Allowed</th>
                                </tr>
                                <tr>
                                    <th>Major</th>
                                    <td>
                                        <select class="form-control aql_select aql_major" id="aql_major" required>
                                        </select>
                                        @if ($client_aql_detail)
                                        <input type="hidden" class="preset_aql_major" id="preset_aql_major" value="{{$client_aql_detail->aql_major}}">
                                        @endif
                                        <div id="aqlRequired4" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                    <td><input type="text " name="max_major" id="max_major" class="form-control max_major" />
                                        <div id="aqlRequired5" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Minor</th>
                                    <td>
                                        <select class="form-control aql_select aql_minor" id="aql_minor"></select>
                                        @if ($client_aql_detail)
                                        <input type="hidden" class="preset_aql_minor" id="preset_aql_minor" value="{{$client_aql_detail->aql_minor}}">
                                        @endif
                                        <div id="aqlRequired6" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                    <td><input type="text" name="max_minor" id="max_minor" class="form-control max_minor" />
                                        <div id="aqlRequired7" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Critical</th>
                                    <td><select type="text" name="aql_critical" id="aql_critical" class="form-control  aql_critical">
                                            <option value="0" selected>0</option>
                                        </select>
                                        <div id="aqlRequired7" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                    <td><input type="text" name="max_critical" id="max_critical" value="0" class="form-control max_critical" />
                                        <div id="aqlRequired8" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-bordered table-condensed" width="100%">
                                <tr>
                                    <th></th>
                                    <th class="text-center">Code Letter</th>
                                    <th class="text-center">Sample Size</th>
                                </tr>
                                <tr>
                                    <th>Normal</th>
                                    <td><input type="text" name="aql_normal_letter" id="aql_normal_letter" class="form-control aql_normal_letter">
                                        <div id="aqlRequired8" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                    <td><input type="text" name="aql_normal_sampsize" id="aql_normal_sampsize" class="form-control aql_normal_sampsize" />
                                        <div id="aqlRequired9" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Special</th>
                                    <td><input type="text" name="aql_special_letter" id="aql_special_letter" class="form-control aql_special_letter">
                                        <div id="aqlRequired10" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                    <td><input type="text" name="aql_special_sampsize" id="aql_special_sampsize" class="form-control aql_special_sampsize" />
                                        <div id="aqlRequired11" style="display:none">
                                            <p style="color:red;">This field is required! </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><!-- div end sample_test -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-success" name="Confirm" id="Confirm">Confirm</button> --}}

                <button type="button" class="btn btn-success confirm_aql"  name="Confirm" id="Confirm">Confirm</button>
            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<script>
    jQuery(document).ready(function() {

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

       /*  $('.AQLModal').on('shown.bs.modal', function() {
            
            //$(this).closest('.modal-dialog').find('.aql_minor').val();
            //console.log(this);
            //var pamj = $(this).closest('.row_aql_modal').find('.preset_aql_major').val();
            //var pamn = $(this).closest('.row_aql_modal').find('.preset_aql_minor').val();
            //console.log('aql: '+pamj);
            //$(this).closest('.row_aql_modal').find('.aql_major').val(pamj);
            //$(this).closest('.row_aql_modal').find('.aql_minor').val(pamn);
            //$('#aql_major').val(pamj);
            //$('#aql_minor').val(pamn);
        }); */

        // jQuery('#save').prop('disabled', true);
        jQuery('#aql_qty').on('change', function(e) {
            if (jQuery('#aql_qty').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_normal_level').on('change', function(e) {
            if (jQuery('#aql_normal_level').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_special_level').on('change', function(e) {
            if (jQuery('#aql_special_level').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_major').on('change', function(e) {
            if (jQuery('#aql_major').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#max_major').on('change', function(e) {
            if (jQuery('#max_major').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_minor').on('change', function(e) {
            if (jQuery('#aql_minor').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#max_minor').on('change', function(e) {
            if (jQuery('#max_minor').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_normal_letter').on('change', function(e) {
            if (jQuery('#aql_normal_letter').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_normal_sampsize').on('change', function(e) {
            if (jQuery('#aql_normal_sampsize').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_special_letter').on('change', function(e) {
            if (jQuery('#aql_special_letter').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });

        jQuery('#aql_special_sampsize').on('change', function(e) {
            if (jQuery('#aql_special_sampsize').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });



        jQuery('#aql_qty_unit').on('change', function(e) {
            if (jQuery('#aql_qty_unit').val() != "") {

                jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                checked();
            } else {

                jQuery('#Confirm').removeClass("confirm_aql");
            }
        });



        function checked() {

            jQuery('#aql_qty').removeAttr("style");


            jQuery('#aql_qty_unit').removeAttr("style");



            jQuery('#aql_normal_level').removeAttr("style");
            jQuery('#aql_special_level').removeAttr("style");
            jQuery('#aql_major').removeAttr("style");
            jQuery('#max_major').removeAttr("style");
            jQuery('#aql_minor').removeAttr("style");
            jQuery('#max_minor').removeAttr("style");
            jQuery('#aql_normal_letter').removeAttr("style");
            jQuery('#aql_normal_sampsize').removeAttr("style");
            jQuery('#aql_special_letter').removeAttr("style");
            jQuery('#aql_special_sampsize').removeAttr("style");

            for (var x = 1; x <= 12; x++) {
                jQuery('#aqlRequired' + x + '').css("display", "none");
            }
        }

        jQuery('#Confirm').click(function(e) {
            checked();

            // alert(jQuery('#aql_special_sampsize').val());
            for (var x = 0; x <= 12; x++) {
                if (jQuery('#aql_qty').val() === "") {
                    jQuery('#aql_qty').css('border-color', 'red');
                    jQuery('#aqlRequired1').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;

                } else if (jQuery('#aql_normal_level').val() === "") {
                    jQuery('#aql_normal_level').css('border-color', 'red');
                    jQuery('#aqlRequired2').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_special_level').val() === "") {
                    jQuery('#aql_special_level').css('border-color', 'red');
                    jQuery('#aqlRequired3').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_major').val() === "") {
                    jQuery('#aql_major').css('border-color', 'red');
                    jQuery('#aqlRequired4').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#max_major').val() === "") {
                    jQuery('#max_major').css('border-color', 'red');
                    jQuery('#aqlRequired5').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_minor').val() === "") {
                    jQuery('#aql_minor').css('border-color', 'red');
                    jQuery('#aqlRequired6').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#max_minor').val() === "") {
                    jQuery('#max_minor').css('border-color', 'red');
                    jQuery('#aqlRequired7').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_normal_letter').val() === "") {
                    jQuery('#aql_normal_letter').css('border-color', 'red');
                    jQuery('#aqlRequired8').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_normal_sampsize').val() === "") {
                    jQuery('#aql_normal_sampsize').css('border-color', 'red');
                    jQuery('#aqlRequired9').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_special_letter').val() === "") {
                    jQuery('#aql_special_letter').css('border-color', 'red');
                    jQuery('#aqlRequired10').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;
                } else if (jQuery('#aql_special_sampsize').val() === "") {
                    jQuery('#aql_special_sampsize').css('border-color', 'red');
                    jQuery('#aqlRequired11').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;



                } else if (jQuery('#aql_qty_unit').val() === "") {
                    jQuery('#aql_qty_unit').css('border-color', 'red');
                    jQuery('#aqlRequired12').css("display", "block");
                    jQuery('#Confirm').removeClass("confirm_aql");
                    x = 13;



                } else {
                    jQuery('#Confirm').addClass("btn btn-success confirm_aql");
                    /*  jQuery("#formData").attr("action", "{{route('addclient')}}");
                     $('#clr').click(); */
                    //alert("Success");

                    x = 13;
                }
            }
        });
    });

</script>
