<div id="viewFactoryDetails" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Factory Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-primary main-content-panel">
          <div class="panel-heading">
            <h3 class="panel-title">View Factory</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="table_view_factory">
                <tbody>
                    <tr style="background-color:lightgrey">
                      <th colspan="4"><h4>1. Factory Details</h4></th>
                    </tr>
                    <tr>
                        <th>Factory Name :</th>
                        <td id="view_fac_name" colspan="3">data</td>
                      </tr>
                      <tr>
                        <th>Factory Address Local :</th>
                        <td id="view_fac_addr_local" colspan="3">data</td>
                      </tr>
                      <tr>
                        <th>Factory Address :</th>
                        <td id="view_fac_addr" colspan="3">data</td>
                      </tr>


    

                  </tbody>  
              </table>
            </div>  
          </div>
        </div>
      </div>
      <div class="modal-footer">

          <button data-id="" class="btn btn-success pull-left btn-add" title="Add More Contact Person" id="btn_add_more_con_person">Add More Contact Person </button>

        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
      </div>
    </div>

  </div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
