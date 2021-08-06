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
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="table_view_project">
                <tbody>
                    <tr style="background-color:lightgrey">
                      <th colspan="4"><h4>1. Inspection Details</h4></th>
                    </tr>
                    <tr>
                        <th>Report Number :</th>
                        <td id="proj_report_number"></td>
                        <th>Report Password :</th>
                        <td id="proj_report_password"></td>                   
                      </tr>
                    <tr>
                        <th>Service Type:</th>
                        <td id="proj_service_type"></td>
                        <th>Inspection Date :</th>
                        <td id="proj_ins_date">data</td>
                       
                      </tr>

                      <tr>
                          <th>Client Project Number :</th>
                          <td id="proj_cli_pro_num" >data</td>  
                          <th>Assigned Inspectors :</th>
                          <td id="proj_ass_ins" >data</td>                 
                        </tr>


                      {{-- <tr style="background-color:lightgrey">
                          <th colspan="4"><h4>2. Client Details</h4></th>
                      </tr>
                      <tr>
                          <th>Client Name :</th>
                          <td id="proj_client_name">data</td>
                          <th>Client Code :</th>
                          <td id="proj_client_code">data</td>
                        </tr>

                        <tr>
                          <th>Client Email :</th>
                          <td id="proj_client_email">data</td>
                          <th>Client Number :</th>
                          <td id="proj_client_num">data</td>
                        </tr>
                        <tr>
                          <th>Client Address :</th>
                          <td id="proj_client_address" colspan="3">data</td>
                        </tr>

                        <tr>
                            <th>Client Contact Person :</th>
                            <td id="proj_cli_cont_per">data</td>
                            <th>Client Contact Email :</th>
                            <td id="proj_client_con_email">data</td>
                          </tr>
                        <tr>
                            <th>Client Telephone Number :</th>
                            <td id="proj_cli_tel_num">data</td>
                            <th>Client Mobile Number :</th>
                            <td id="proj_cli_mob_num">data</td>
                            
                        </tr>
                        <tr>
                          <th>Client Contact We Chat :</th>
                          <td id="proj_cli_cont_wechat">data</td>
                          <th>Client Contact WhatsApp :</th>
                          <td id="proj_cli_cont_whatsapp">data</td>
                      </tr>
                      <tr>
                        <th>Client Contact QQ Mail :</th>
                        <td id="proj_cli_cont_qqmail">data</td>
                        <th>Client Contact Skype :</th>
                        <td id="proj_cli_cont_skype">data</td>
                    </tr> --}}



                       {{--  <tr style="background-color:lightgrey">
                            <th colspan="4"><h4>3. Factory Details</h4></th>
                        </tr>
                        <tr>
                            <th>Factory Name :</th>
                            <td id="proj_fac_name">data</td>
                            <th>Factory Address :</th>
                            <td id="proj_fac_addr">data</td>
                          </tr>
                          <tr>                           
                              <th>Factory Address Local :</th>
                              <td id="proj_fac_addr_loc">data</td>
                              <th>Factory Contact Person :</th>
                              <td id="proj_fac_con_per">data</td>
                              
                            </tr>
                            <tr>
                                <th>Factory Contact Email :</th>
                                <td id="proj_fac_con_email">data</td>
                                <th>Factory Contact Number :</th>
                                <td id="proj_fac_con_num">data</td>
                            </tr>
                            <tr>
                              <th>Factory Contact Skype :</th>
                              <td id="proj_fac_con_skype">data</td>
                              <th>Factory Contact We Chat :</th>
                              <td id="proj_fac_con_wechat">data</td>
                            </tr>
                            <tr>
                              <th>Factory Contact WhatsApp :</th>
                              <td id="proj_fac_con_whatsapp">data</td>
                              <th>Factory Contact QQ Mail :</th>
                              <td id="proj_fac_con_qqmail">data</td>
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

