<div id="viewAccountDetails" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">View Account Details</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="panel panel-primary main-content-panel">
                        <div class="panel-heading">
                          <h3 class="panel-title">View Account Supplier Details</h3>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="table_view_account">
                              <tbody>
                                  <tr style="background-color:lightgrey">
                                    <th colspan="4"><h4>1. Supplier Details</h4></th>
                                  </tr>
                                  <tr>
                                    <th>Supplier Name :</th>
                                    <td id="view_supp_name" colspan="3">data</td>
                                  </tr>
                                  <tr>
                                    <th>Supplier Number / Code :</th>
                                    <td id="view_supp_code" colspan="3">data</td>
                                  </tr>
                                  <tr>
                                    <th>Supplier Country :</th>
                                    <td id="view_supp_country" colspan="3">data</td>
                                  </tr>
                                  <tr>
                                    <th>Supplier City (English) :</th>
                                    <td id="view_supp_city" colspan="3">data</td>
                                  </tr>
              
                                  <tr>
                                    <th>Supplier Address (English) :</th>
                                    <td id="view_supp_address" colspan="3">data</td>
                                  </tr> 
                                  <tr>
                                    <th>Supplier City (Local Language) :</th>
                                    <td id="view_supp_city_local" colspan="3">data</td>
                                  </tr>
              
                                  <tr>
                                    <th>Supplier Address (Local Language) :</th>
                                    <td id="view_supp_address_local" colspan="3">data</td>
                                  </tr>           
                                </tbody>  
                            </table>
                          </div>  
                        </div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                </div>
            </div>
            <!-- Modal content end-->
    </div>
</div>
