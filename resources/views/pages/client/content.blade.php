<script src="../../js/clientjs/jquery.min.js?n=1"></script>

<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

 
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

 

@section('content')
<div class="col-md-12 padding-b-25">
      <h3>Inspections</h3>
      <div class="table-responsive">
       
        <table id="list_inspection" class="table table-condensed cell-bor small dataTable no-footer">
              <thead>
                  <tr>
                        <th class="text-center">Report Number</th>
                       <th class="text-center">Service Type</th>
                      <th class="text-center">Inspection Date</th>
                    <th class="text-center">View Details</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($inspections as $inspection)
                  <tr>
                  
                      <td class="text-center">
                          <strong>
                              {{$inspection->report_no}}
                          </strong>
                         
                      </td>
                     
                      <td class="text-center">{{$services[$inspection->service]}}</td>
                      
                      <td class="text-center">{{date('F d, Y',strtotime($inspection->inspection_date))}}</td>

                      <td class="text-center">
  
                     @if($services[$inspection->service] == "CBPI - No Serial" || $services[$inspection->service] == "CBPI - with Serial" || $services[$inspection->service] == "CBPI - ISCE" || $services[$inspection->service] == "Container Loading Inspection")
                        
                          <a  href="{{route('inspectiondetails',$inspection->id)}}" class="btn btn-warning btn-xs" title="View Project Details"><i class="fa  fa-eye"></i></a>
                       
                        
                    @endif
                       @if($services[$inspection->service] == "Pre Shipment Inspection" || $services[$inspection->service] == "During Production Inspection" || $services[$inspection->service] == "Incoming Quality Inspection" || $services[$inspection->service] == "Setting Up Production Lines")
                        
                           <a href="{{route('inspectiondetails',$inspection->id)}}" class="btn btn-warning btn-xs" title="View Project Details"><i class="fa  fa-eye"></i></a>
                       
                        
                    @endif  
                        
                     
                    </td>
                    
                      {{-- <td class="text-center">
                          <button class="btn btn-success btn-xs" title="Edit Details"><i class="fa fa-pencil"></i> </button>
                          <button class="btn btn-info btn-xs" title="View Details"><i class="fa fa-eye"></i> </button>
                          <button class="btn btn-danger btn-xs" title="Delete Record"><i class="fa fa-times"></i> </button>

                      </td> --}}
                  </tr>
                  @endforeach

              </tbody>
          </table>
      </div>
</div>
@endsection



      <script> 
$(document).ready(function() {
    $('#list_inspection').DataTable();
} );
    

      // setInterval(test, 1000);
        
        function test(){
          var sites = {!! json_encode($user_info->toArray()) !!};
        console.log(sites)
       
        }

      
 
    </script>
      {{-- <script src="../../js/clientjs/fastclick.js?n=1"></script>
      <script src="../../js/clientjs/jquery.slimscroll.min.js?n=1"></script>
      <script src="../../js/clientjs/adminlte.min.js?n=1"></script> --}}