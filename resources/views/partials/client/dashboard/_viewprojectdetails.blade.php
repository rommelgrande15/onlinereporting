<div id="viewProjectDetails" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View Project Details</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-primary main-content-panel" >
          <div class="panel-heading">
            <h3 class="panel-title">View Project</h3>
          </div>
          <div class="panel-body" id="printThis">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="table_view_project">
                <tbody>
                    <tr style="background-color:lightgrey">
                      <th colspan="4"><h4>1. Inspection Details</h4></th>
                    </tr>
                    <tr>

                    <th colspan="2">My Project Number :</th>
                          <td colspan="2" id="proj_cli_pro_num" >data</td>  
                          <th style="display:none;" id="proj_cli_supplier_label">Supplier :</th>
                          <td id="proj_cli_supplier" style="display:none;">data</td>

                     


                      </tr>

                      <tr>
                      <th>Service:</th>
                        <td id="proj_service_type"></td>
                        <th>Inspection Date :</th>
                        <td id="proj_ins_date">data</td>            
                        </tr>
                  </tbody>  
              </table>
              
            </div>  
          </div>
<br>
          <button class="btn btn-warning" type="button"  id="btnPrint" ><i class="fa fa-print" ></i> Print</button>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>

      


      </div>
    </div>

  </div>
</div>



<style>


@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {

    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}


</style>


<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script type="text/javascript" >
document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

</script>