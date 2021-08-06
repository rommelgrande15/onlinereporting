@extends('layouts.admin')
@section('title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/cms.css') }}
@endsection

@section('content')
    <div class="col-md-12 padding-b-25">
        <h3>Languages</h3> 
         <div class="buttons">
            <button class="btn btn-success" data-toggle="modal" data-target="#languageModal"><i class="fa fa-plus"></i> Add New Language</button>
        </div>
        <div class="table-responsive">
            <table id="languages_table" class="table table-condensed small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-center">Language</th>
                        <th class="text-center">Short Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
	                @foreach($languages as $l)
	                	<tr class="text-center">
	                		<td>{{$l->name}}</td>
	                		<td>{{strtolower($l->short_name)}}</td>
	                		<td>
	                			<button class="btn btn-xs btn-primary">Publish</button>
	                		</td>
	                	</tr>
	                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('partials.admin.cms._newlanguage')
@endsection

@section('scripts')
	{{ Html::script('/js/admin/cms.js') }}
@endsection
