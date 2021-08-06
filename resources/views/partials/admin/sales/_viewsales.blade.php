<div id="viewSalesDetails" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Sales Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-primary main-content-panel">
          <div class="panel-heading">
            <h3 class="panel-title">View Sales</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="table_view_factory">
                <tbody>
                    <tr style="background-color:lightgrey">
                      <th colspan="4"><h4>1. Sales Details</h4></th>
                    </tr>
                    <tr>
                      <th>Sales Name :</th>
                      <td id="view_sales_name">data</td>
                      <th>Email Address :</th>
                      <td id="view_email">data</td>
                    </tr>
                    {{-- <tr>                      
                    </tr>
                    <tr>
                      <th>Username :</th>
                      <td id="view_un">data</td>
                      <th>Mobile number :</th>
                      <td id="view_mobile">data</td>
                    </tr>
                    <tr>
                      <th>Telephone number :</th>
                      <td id="view_tel">data</td>
                      <th>Skype :</th>
                      <td id="view_skype">data</td>
                    </tr>
                    <tr>
                      <th>We Chat :</th>
                      <td id="view_wechat">data</td>
                      <th>WhatsApp :</th>
                      <td id="view_whatsapp">data</td>
                    </tr>
                    <tr>
                      <th>QQ Mail :</th>
                      <td id="view_qqmail">data</td>
                      <th>Country :</th>
                      <td id="view_country">data</td>
                    </tr>
                    <tr>
                      <th>State :</th>
                      <td id="view_state">data</td>
                      <th>City :</th>
                      <td id="view_city">data</td>
                    </tr> --}}


    

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

  </div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
