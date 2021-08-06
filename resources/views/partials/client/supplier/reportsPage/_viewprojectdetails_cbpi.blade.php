<div id="viewProjectDetails" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Project Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-primary main-content-panel">
          <div class="panel-heading">
            <h3 class="panel-title">View Project</h3>
          </div>
          <div class="panel-body">
            <div id="div-action-cbpi"></div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                      <th colspan="4"><h3>1. Inspection Details</h3></th>
                    </tr>
                    <tr>
                        <th>Report Number:</th>
                        <td id="proj_report_number"></td>
                        <th>Service Type:</th>
                        <td id="proj_service_type"></td>
                      </tr>
                    <tr>
                        <th>Inspection Date:</th>
                        <td id="proj_ins_date">data</td>
                        <th>Assigned Inspector:</th>
                        <td id="proj_ass_ins">data</td>
                      </tr>


                      <tr>
                          <th colspan="4"><h3>2. Client Details</h3></th>
                      </tr>
                      <tr>
                          <th>Client Name:</th>
                          <td id="proj_client_name">data</td>
                          <th>Client Code:</th>
                          <td id="proj_client_code">data</td>
                        </tr>

                        <tr>
                            <th>Client Contact Person:</th>
                            <td id="proj_cli_cont_per">data</td>
                            <th>Client Contact Email:</th>
                            <td id="proj_client_con_email">data</td>
                          </tr>
                        <tr>
                            <th>Client Contact Number:</th>
                            <td colspan="3" id="proj_cli_cont_num">data</td>
                        </tr>

                        <tr>
                            <th colspan="4"><h3>3. Factory Details</h3></th>
                        </tr>
                        <tr>
                            <th>Factory Name:</th>
                            <td id="proj_fac_name">data</td>
                            <th>Factory Address:</th>
                            <td id="proj_fac_addr">data</td>
                          </tr>
                          <tr>                           
                              <th>Factory Address Local:</th>
                              <td id="proj_fac_addr_loc">data</td>
                              <th>Factory Contact Person:</th>
                              <td id="proj_fac_con_per">data</td>
                              
                            </tr>
                            <tr>
                                <th>Factory Contact Email:</th>
                                <td id="proj_fac_con_email">data</td>
                                <th>Factory Contact Number:</th>
                                <td id="proj_fac_con_num">data</td>
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

  </div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

