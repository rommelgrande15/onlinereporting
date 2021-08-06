@extends('layouts.admin')
@section('title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/cms.css') }}
@endsection

@section('content')
    <div class="col-md-12 padding-b-25">
        <h3>Content Management</h3>
        <div class="buttons">
            <a class="btn btn-success" href="{{route('cms.new',$id)}}"><i class="fa fa-plus"></i> Add New Section Content</a>
        </div>
        <div class="table-responsive">
            <table id="sections_table" class="table table-condensed small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-center">Page Name</th>
                        <th class="text-center">Section</th>
                        <th class="text-center">Language</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sect as $sec)
                        <tr class="text-center">
                            <td>{{$sec->pageName}}</td>
                            <td>{{$sec->section_name}}</td>
                            <td>{{strtolower($sec->short_name)}}</td>
                            <td>
                                <a href="{{route('cms.updatecontent',$sec->id)}}" title="Update Content" class="btn btn-xs btn-success"> <i class="fa fa-pencil"></i> </a>
                                <a href="#" title="Delete Content" class="btn btn-xs btn-danger"> <i class="fa fa-ban"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/admin/cms.js') }}
@endsection
