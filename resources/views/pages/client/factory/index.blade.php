@extends('layouts.client._new')
@section('title','Factory Management')
@section('page-title','Factory Management')
@section('stylesheets')
    @if(strpos(Request::url(''), 'tic-sera') !== false)
		{!! Html::style('/css/admin/dashboard-sera.css') !!}
	@else
		{!! Html::style('/css/admin/dashboard.css') !!}
	@endif
  <style>

:root {
  /* larger checkbox */
}
:root label.checkbox-bootstrap input[type=checkbox] {
  /* hide original check box */
  opacity: 0;
  position: absolute;
  /* find the nearest span with checkbox-placeholder class and draw custom checkbox */
  /* draw checkmark before the span placeholder when original hidden input is checked */
  /* disabled checkbox style */
  /* disabled and checked checkbox style */
  /* when the checkbox is focused with tab key show dots arround */
}
:root label.checkbox-bootstrap input[type=checkbox] + span.checkbox-placeholder {
  width: 14px;
  height: 14px;
  border: 1px solid;
  border-radius: 3px;
  /*checkbox border color*/
  border-color: #737373;
  display: inline-block;
  cursor: pointer;
  margin: 0 7px 0 -20px;
  vertical-align: middle;
  text-align: center;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder {
  background: #8a8a8a;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder:before {
  display: inline-block;
  position: relative;
  vertical-align: text-top;
  width: 5px;
  height: 9px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 2px 2px 0;
  /*can be done with post css autoprefixer*/
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  content: "";
}
:root label.checkbox-bootstrap input[type=checkbox]:disabled + span.checkbox-placeholder {
  background: #ececec;
  border-color: #c3c2c2;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked:disabled + span.checkbox-placeholder {
  background: #d6d6d6;
  border-color: #bdbdbd;
}
:root label.checkbox-bootstrap input[type=checkbox]:focus:not(:hover) + span.checkbox-placeholder {
  outline: 1px dotted black;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox] + span.checkbox-placeholder {
  width: 26px;
  height: 26px;
  border: 2px solid;
  border-radius: 5px;
  /*checkbox border color*/
  border-color: #737373;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox]:checked + span.checkbox-placeholder:before {
  width: 9px;
  height: 15px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 3px 3px 0;
}

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
                        @php 
					        $create_factory="";
					        $update_factory="";
					        $delete_factory="";
				        @endphp
                        @if($sub_acc=='yes')
					        @if(!empty($privelege))
					        	@php 
					        		$create_factory=$privelege->create_factory;
					        		$update_factory=$privelege->update_factory;
					        		$delete_factory=$privelege->delete_factory;
					        	@endphp
                            @endif	
				        @endif

                        @if($req=='get_factory_by_supplier')
                            @if(strpos(Request::url(''), 'tic-sera') !== false)              
                                <a href="{{route('supplierlist-client-tic-sera')}}" class="btn btn-info" ><i class="fa fa-arrow-left"></i> Back to supplier</a>
                            @else
                                <a href="{{route('supplierlist-client')}}" class="btn btn-info" ><i class="fa fa-arrow-left"></i> Back to supplier</a>
                            @endif
                            @if($create_factory=="yes" || $create_factory=="")
                                <button class="btn btn-success" data-toggle="modal" data-target="#newFactory" data-id="{{$supplier_id}}"><i class="fa fa-plus"></i> Add New Factory</button>
                            @else
                                <button class="btn btn-success disabled"><i class="fa fa-plus"></i> Add New Factory</button>
                            @endif
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
                                                <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
                                                <ul class="dropdown-menu">                                            
                                                    <li><a  data-id="{!!$factory->id!!}" class="btn-view" title="View Details" >View</a></li>
                                                    
                                                    @if($update_factory=="" || $update_factory=="yes")
                                                        <li><a data-id="{!!$factory->id!!}" class="btn-edit" title="Edit Details" >Edit</a></li>
                                                    @else
                                                        <li class="disabled" ><a title="Edit Details" >Edit</a></li>
                                                    @endif

                                                    @if($delete_factory=="" || $delete_factory=="yes")
                                                        <li><a data-id="{!!$factory->id!!}" class="btn-delete" title="Delete Record" >Delete</a></li> 
                                                    @else
                                                        <li class="disabled"><a  title="Delete Record" >Delete</a></li> 
                                                    @endif                                                                   
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
    @include('partials.client.factory._newcontact')
    @include('partials.client.factory._newfactory')
    @include('partials.client.factory._updatefactory')
    @include('partials.client.factory._deletefactory')
    @include('partials.client.factory._viewfactory')
    @include('partials.client.factory._newfaccontactperson')

    <div class="send-loading"></div>
    
@endsection

@section('scripts')
	{!! Html::script('/js/client/factory.js') !!}
@endsection

<script>
    var msg = '{!!Session::get('alert')!!}';
    var exist = '{!!Session::has('alert')!!}';
    if(exist){
      alert(msg);
    }
    var auth_id = "{{Auth::id()}}"; 
    var token = "{{csrf_token()}}";


  
    
</script>


