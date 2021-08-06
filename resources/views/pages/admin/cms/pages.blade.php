@extends('layouts.admin')
@section('title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/cms.css') }}
@endsection

@section('content')
    <div class="col-md-12 padding-b-25">
        <h3>Web Pages</h3> 
       	<div class="buttons">
            <button class="btn btn-success" data-toggle="modal" data-target="#pageModal"><i class="fa fa-plus"></i> Add New Page</button>
        </div>
        <div class="table-responsive">
            <table id="pages_table" class="table table-condensed small dataTable no-footer">
                <thead>
                    <tr>    
                        <th class="text-center">#</th>
                        <th class="text-center">Page Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Slug</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
	               @foreach($pages as $i => $page )
	               	<tr class="text-center">
                        <td>{{$i+1}}</td>
	               		<td>{{$page->name}}</td>
	               		<td>{{$page->description}}</td>
	               		<td>{{$page->slug}}</td>
	               		<td>
	               			<a href="{{route('cms.index', $page->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
	               			<button class="btn btn-xs btn-success btn-edit" title="Update Page Details" data-id="{{$page->id}}" ><i class="fa fa-pencil"></i></button>
	               			<button class="btn btn-xs btn-success btn-danger" title="Delete Page" data-id="{{$page->id}}" ><i class="fa fa-ban"></i></button>

	               		</td>
	               	</tr>
	               @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('partials.admin.cms._newpage')
@endsection

@section('scripts')
	{{ Html::script('/js/admin/cms.js') }}
@endsection
