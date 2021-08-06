@extends('layouts.clientNew')
@section('content')
<div class="row">
    <h4 align="center">Title here</h4><br>
</div>
<div class="row">
        <div class="col-md-12">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Collapsable</h3>
              <div class="box-tools pull-right">
               {{-- <button type="button" class="btn btn-box-tool" ><i class="fa fa-refresh"></i>
                </button> --}}
                <button type="button" class="btn btn-box-tool" onclick="collapseBody()"><i class="fa fa-minus" id="buttonFa"></i>
                </button>
              </div>
            </div>
            <div class="box-body" id="loadDataHere">
              The body of the box

              sadsad

              asdsa

              asd
            {{--   {{$user_info->email}} --}}
            </div>
          </div>
        </div>


      </div>
      @endsection

      
      <script>
          /* $.ajax(
          {
              url: '/client-dashboard-load',
              type: 'GET',
              dataType: 'html',
          }).done( 
              function(data) 
              {
                  $('#loadDataHere').html(data);
                  console.log(data);
              }
          ); */
          
          </script>

      <script src="../../js/clientjs/test.js"></script>
      {{-- <script src="../../js/clientjs/fastclick.js?n=1"></script>
      <script src="../../js/clientjs/jquery.slimscroll.min.js?n=1"></script>
      <script src="../../js/clientjs/adminlte.min.js?n=1"></script> --}}