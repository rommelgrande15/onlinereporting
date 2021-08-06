@extends('layouts.new')
@section('title','Supplier Factory Management')
@section('page-title','Supplier Factory Management')
@section('stylesheets')
  {!! Html::style('/css/admin/dashboard.css') !!}
  <style>
        .fa-loader {
            -webkit-animation: spin 2s linear infinite;
            -moz-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-moz-keyframes spin {
            100% {
                -moz-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .content-header h1{
            border-bottom:3px solid orange; 
            width:30%; 
            text-align:center; 
            margin:0 auto;
        }
  </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                    <div class="buttons">
                        @if($req=='get_factory_by_supplier')
                            <a href="{{route('supplierlist-admin')}}" class="btn btn-info" ><i class="fa fa-arrow-left"></i> Back to supplier</a>
                            <button class="btn btn-success" data-toggle="modal" data-target="#newFactory" data-id="{{$supplier_id}}"><i class="fa fa-plus"></i> Add New Factory</button>
                            <input type="hidden" name="hidden_supplier_id" id="hidden_supplier_id" value="{{$supplier_id}}">
                        @endif
                                        
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="factories_table" class="table table-condensed cell-border small dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="text-center">Supplier Name</th>
                                    <th class="text-center">Factory Name</th>
                                    <th class="text-center">Factory Code / Number</th>
                                    <th class="text-center">Factory Address</th>                                                                                         
                                    <th class="text-center">Date Created</th>
                                    <th class="text-center">View / Edit / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($factories as $factory)
                                    @if($factory->factory_status!='2' || $factory->factory_status!=2)
                                    <tr class="text-center">                                       
                                        <td>{!!$suppliers->supplier_name!!}</td>
                                        <td>{!!$factory->factory_name!!}</td>
                                        <td>{!!$factory->factory_number!!}</td>
                                        <td>{!!$factory->factory_address!!}</td>                                                                                                                                                          
                                        <td>{!!$factory->created_at!!}</td> 
                                        <td>                                           
                                            <div class="dropdown">
                                                <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">                                         
                                                    <li><a  data-id="{!!$factory->id!!}" class="btn-view" title="View Details" >View</a></li>
                                                    <li><a  data-id="{!!$factory->id!!}" class="btn-edit" title="Edit Details" >Edit</a></li>
                                                    <li><a  data-id="{!!$factory->id!!}" class="btn-delete" title="Delete Record" >Delete</a></li>                                                         
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    {{-- No data --}}
                                @endforelse
                            </tbody>
                            <tfoot>
                        <tr>
                        <th class="text-center">.</th> 
                        <th class="text-center">.</th> 
                        <th class="text-center">.</th> 
                        <th class="text-center">.</th> 
                        <th class="text-center">.</th> 
                        <th class="text-center">.</th>               
                                         
                        </tr>
                      </tfoot>
                        </table>
                        
                    </div>
                </div>
        </div>
    </div>
    @include('partials.admin.view-factory._newcontact')
    @include('partials.admin.view-factory._newfactory')
    @include('partials.admin.view-factory._updatefactory')
    @include('partials.admin.view-factory._deletefactory')
    @include('partials.admin.view-factory._viewfactory')
    @include('partials.admin.view-factory._newfaccontactperson')

    <div class="send-loading"></div>
    
@endsection

@section('scripts')
	{!! Html::script('/js/admin/view-factory.js') !!}
@endsection

<script>
    /* var msg = '{!!Session::get('alert')!!}';
    var exist = '{!!Session::has('alert')!!}';
    if(exist){
      alert(msg);
    } */
    var auth_id = "{{Auth::id()}}"; 
    var token = "{{csrf_token()}}";


  
    
</script>


