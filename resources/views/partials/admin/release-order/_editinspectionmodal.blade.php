<div class="modal fade EditAQLModal AQLModal" role="dialog">
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
                            <input type="number" class="form-control aql_qty edit_aql_qty e_aql" value="{{$product->aql_qty}}" name="aql_qty"  min="1" oninput="this.value = Math.abs(this.value)" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity_unit">Unit:</label>
                            {!! Form::select('quantity_unit', $units, $product->aql_qty_unit, ['class' => 'form-control aql_qty_unit edit_aql_qty_unit e_unit', 'placeholder'=>'Select a unit']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aql_normal_level">Normal Level:</label>
                            {!! Form::select('aql_normal_level', $normal, $product->aql_normal_level, ['class' => 'form-control aql_normal_level edit_aql_normal_level e_anlvl', 'placeholder'=>'--Select--', 'required'=>'']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aql_special_level">Special Level:</label>
                            {!! Form::select('aql_special_level', $special, $product->aql_special_level, ['class' => 'form-control aql_special_level edit_aql_special_level e_aslvl', 'placeholder'=>'--Select--', 'required'=>'']) !!}
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
                                    {!! Form::select('aql_major', $aql_options, $product->aql_major, ['class' => 'form-control aql_major edit_aql_major e_aqmj', 'placeholder'=>'--']) !!}
                                </td>
                                <td>
                                    <input type="text " name="max_major" id="max_major" value="{{$product->max_allowed_major}}" class="form-control max_major edit_max_major e_mxmj" />
                                </td>
                            </tr>

                            <tr>
                                <th>Minor</th>

                                <td>
                                    {!! Form::select('aql_minor', $aql_options, $product->aql_minor, ['class' => 'form-control aql_minor edit_aql_minor e_aqmn', 'placeholder'=>'--']) !!}
                                </td>
                                <td>
                                    <input type="text" name="max_minor" id="max_minor" value="{{$product->max_allowed_minor}}" class="form-control max_minor edit_max_minor e_mxmn" />
                                </td>
                            </tr>

                            <tr>
                                <th>Critical</th>
                                <td>
                                    <select type="text" name="aql_critical" id="aql_critical" class="form-control  aql_critical">
                                        <option value="0" selected>0</option>
                                    </select>
                                </td>
                                <td><input type="text" name="max_critical" id="max_critical" value="0" class="form-control max_critical" />
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
                                <td>
                                    <input type="text" name="aql_normal_letter" id="aql_normal_letter" value="{{$product->aql_normal_letter}}" class="form-control aql_normal_letter edit_aql_normal_letter e_anl">
                                </td>

                                <td>
                                    <input type="text" name="aql_normal_sampsize" id="aql_normal_sampsize" value="{{$product->aql_normal_sampsize}}" class="form-control aql_normal_sampsize edit_aql_normal_sampsize e_ans" />
                                </td>

                            </tr>

                            <tr>
                                <th>Special</th>
                                <td>
                                    <input type="text" name="aql_special_letter" id="aql_special_letter" value="{{$product->aql_special_letter}}" class="form-control aql_special_letter edit_aql_special_letter e_asl">
                                </td>

                                <td>
                                    <input type="text" name="aql_special_sampsize" id="aql_special_sampsize" value="{{$product->aql_special_sampsize}}" class="form-control aql_special_sampsize edit_aql_special_sampsize e_ass" />
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success confirm_aql e_confirm" name="Confirm">Confirm</button>
            </div>
        </div>

    </div>
</div>

