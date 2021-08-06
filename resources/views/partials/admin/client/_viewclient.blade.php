<div id="viewClientDetails" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Client Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-primary main-content-panel">
          <div class="panel-heading">
            <h3 class="panel-title">View Client</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="table_view_client">
                <tbody>
                    <tr style="background-color:lightgrey">
                      <th colspan="4"><h4>1. Company Details</h4></th>
                    </tr>
                    <tr>
                        <th>Client Name :</th>
                        <td id="view_comp_name">data</td>
                        <th>Client Code :</th>
                        <td id="view_comp_code">data</td>
                      </tr>
                    <tr>                  
                      <th>Client Email :</th>
                      <td id="view_comp_email">data</td>
                      <th>Client Phone # :</th>
                      <td id="view_comp_phone">data</td>
                    </tr>
                    <tr>                  
                      <th>Client Country :</th>
                      <td id="view_comp_country">data</td>
                      <th>Client State:</th>
                      <td id="view_comp_state">data</td>
                    </tr>
                    <tr>                  
                      <th>Client City :</th>
                      <td id="view_comp_city">data</td>
                      <th>Zip code:</th>
                      <td id="view_comp_zip_code">data</td>
                    </tr>
                    <tr>                  
                      <th>Bldg Number :</th>
                      <td id="view_comp_bldg">data</td>
                      <th>House Number:</th>
                      <td id="view_comp_house_num">data</td>
                    </tr>
                    <tr id="tr_street_num">                  
                      <th>Street Number / Name :</th>
                      <td id="view_comp_street_num" colspan="3">data</td>
                    </tr>
                    <tr id="same_as_address" style="display:none;">                  
                      <th>Client Invoice Address :</th>
                      <td id="view_comp_inv_address" colspan="3">Same as invoice address</td>
                    </tr>

                    <tr class="not_same_as_address" style="display:none;">                  
                      <th>Client Invoice Country :</th>
                      <td id="view_inv_comp_country">data</td>
                      <th>Client Invoice State:</th>
                      <td id="view_inv_comp_state">data</td>
                    </tr>
                    <tr class="not_same_as_address" style="display:none;">                  
                      <th>Client Invoice City :</th>
                      <td id="view_inv_comp_city">data</td>
                      <th>Invoice Zip code:</th>
                      <td id="view_inv_comp_zip_code">data</td>
                    </tr>
                    <tr class="not_same_as_address" style="display:none;">                  
                      <th>Invoice Bldg Number :</th>
                      <td id="view_inv_comp_bldg">data</td>
                      <th>Invoice House Number:</th>
                      <td id="view_inv_comp_house_num">data</td>
                    </tr>
                    <tr class="not_same_as_address" style="display:none;">                  
                      <th>Invoice Street Number / Name :</th>
                      <td id="view_inv_comp_street_num" colspan="3">data</td>
                    </tr>

                    <tr>                  
                      <th>Client Payment Terms :</th>
                      <td id="view_comp_payment_terms" colspan="3">data</td>
                    </tr>
                    {{-- 06-11-2021 --}}
                    <tr>                  
                      <th>Sales Manager :</th>
                      <td id="view_sales_manager" colspan="3">data</td>
                    </tr>


    

                  </tbody>  
              </table>
            </div>  
          </div>
        </div>
      </div>
      <div class="modal-footer">

          <button data-id="{{$client->id}}" class="btn btn-success btn-add pull-left" title="Add More Contact Person" id="btn_add_more_contact_client"> Add More Contact Person {{-- <i class="fa fa-user-plus"></i> --}} </button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
      </div>
    </div>

  </div>
</div>





<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

