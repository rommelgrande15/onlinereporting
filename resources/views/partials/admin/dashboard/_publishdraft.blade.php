<div id="publishDraftInspection" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Publish Inspection</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">

            <h4 id="title_publish"></h4><br/>

          <div class="form-group">
              <label>Assign Inspector</label>
              <select class="form-control pub_sel_ins" id="pub_sel_ins">
                <option value="">Select Inspector</option>
              </select>
            </div>
        </div>

        <div class="col-md-12">
            
            <div class="form-group">
                <label>Type of project</label><br/>
                <label class="checkbox-inline">
                    <input type="radio" name="project_type" value="app_project" id="app_project" class="psi_required" onclick="changeProjectTypePub('app')" required> APP Project
                  </label>
                  <label class="checkbox-inline">
                    <input type="radio" name="project_type" value="word_project" id="word_project" class="psi_required" onclick="changeProjectTypePub('word')" required> WORD Project
                  </label>
              </div>
          </div>

          <div class="col-md-12" id="div_template_pub" style="display:none;">
              <div class="form-group">
                {{ Form::label('template', 'Select Template') }}
                <select class="form-control" name="template_pub" id="template_pub" required>
                  <option value="" selected>Select Template</option>
                </select>
              </div>
            </div>

        </div>
      </div>
      <div class="modal-footer">       
        <button class="btn btn-success" type="button" id="publish_inspection"><i class="fa fa-check"></i> Publish inspection</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
        <input type="hidden" name="pub_insp_id" id="pub_insp_id">
        <input type="hidden" name="attachment_len" id="attachment_len">
        <input type="hidden" name="pub_service" id="pub_service">
      </div>
    </div>

  </div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <script>
        
        $('#publish_inspection').click(function(e){
          
          var dis_btn = this;
          var insp_id=$('#pub_insp_id').val();
          var template_pub=$('#template_pub').val();
          var type_of_project=$('input[name=project_type]:checked').val();
          var inspector=$('#pub_sel_ins').val();

          var attachment=$('#attachment_len').val();
          var service=$('#pub_service').val();
          if(attachment>=1){          
            var sure_conf = confirm("Are you sure you want to publish this inspection?");
            if (sure_conf) {
              //publish
              if(service=='cbpi' || service=='cbpi_serial' || service=='cbpi_isce'  || service=='cli' ){  
                //publish for cbpi              
                pubForCBPI(template_pub,insp_id,type_of_project,inspector);
              }else{
                //publish psi
                pubForPSI(template_pub,insp_id,type_of_project,inspector);
              }
            } else {
              //not publish
            }
          }else{
            alert("You can't directly publish this inspection because there is/are no attachments,requirements or memo. Please check.");
          }
        })

        function changeProjectTypePub(val){
          if(val=='app'){
            $('#div_template_pub').show();
          }else{
            $('#div_template_pub').hide();
          }
        }

        function pubForPSI(template_pub,insp_id,type_of_project,inspector){
          $('.send-loading ').show();
          $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              $.ajax({
                  url: '/shortpublishinspection',
                  type: 'POST',
                  data:{
                    template:template_pub,
                    edit_inspection_id:insp_id,
                    type_of_project:type_of_project,
                    inspector:inspector
                  },
                  success: function() {
                      alert("Inspection successfully published.");
                      $('.send-loading ').hide();
                      location.reload();
                  },
                  error: function(){
                    alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                  }
              });
        }

        function pubForCBPI(template_pub,insp_id,type_of_project,inspector){
          $('.send-loading ').show();
          $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              $.ajax({
                  url: '/shortpublishinspectioncbpi',
                  type: 'POST',
                  data:{
                    loading_template:template_pub,
                    edit_inspection_id_cbpi:insp_id,
                    project_type_cbpi:type_of_project,
                    loading_inspector:inspector
                  },
                  success: function() {
                      alert("Inspection successfully published.");
                      $('.send-loading ').hide();
                      location.reload();
                  }
              });
        }
      </script>

