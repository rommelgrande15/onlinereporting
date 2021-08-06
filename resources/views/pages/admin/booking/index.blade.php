@extends('layouts.new')
@section('title','Booking Management')
@section('page-title','Booking Management')
@section('stylesheets')
  {{ Html::style('/css/admin/dashboard.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                    <br>
                    <div class="table-responsive">
                       <div id="load_booking_list">
                       </div>
                    </div>
                    <div align="center" style="background-color:#FFF; height:500px;" id="booking_list_preloader">
                        <img src="/images/loader-64x/Preloader_8.gif" style="padding-top:170px;">
                    </div>
                </div>
        </div>
    </div>

    <div id="viewProjectInformation" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">         
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Project Information</h4>
                </div>
                <div class="modal-body">
                    <div id="load_booking_info">
                    </div>
                    <div align="center" style="background-color:#FFF; " id="view_project_preloader">
                        <img src="/images/loader-64x/Preloader_8.gif">
                    </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                </div>               
            </div>         
        </div>
    </div>
 
@endsection
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#load_booking_list').load('https://the-inspection-company.com/web_api/booking_list.php', function(){
            setTimeout(function() {         
                $('#booking_list').DataTable({
                    "aaSorting": [[ 3, "desc" ]]
                });
                $('#booking_list').addClass('small table table-condensed dataTable no-footer');
            }, 500); 
            $('#booking_list_preloader').css("display","none");
        }); 
       
    });
    function viewInspection(id){
        $('#load_booking_info').empty();
        $('#view_project_preloader').css("display","block");
        $('#load_booking_info').load('https://the-inspection-company.com/web_api/view_project.php?id='+id, function(){
            $('#view_project_preloader').css("display","none");
        }); 

        $('#viewProjectInformation').modal();
    }
</script>

