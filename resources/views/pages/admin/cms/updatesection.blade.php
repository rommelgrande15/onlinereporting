@extends('layouts.admin')
@section('title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/cms.css') }}
@endsection

@section('content')
    <div class="col-md-12 padding-b-25">
        <h3>Update Content</h3>
        <div class="buttons">
            <a href="{{route('cms.index', $section->page)}}"><i class="fa fa-arrow-left"></i> Go Back to Sections List</a>
        </div>
        <form method="POST" class="new-content-form" action="{{route('cms.contentupdate')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="page">Page</label> 
                        <select name="page" id="page" class="form-control">                            
                            @foreach($pages as $p)
                                <option value="{{$p->id}}" {{$p->id == $section->page ? 'selected' : ''}}>{{$p->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="page_id" id="page_id" class="form-control" value="{{$section->page}}" readonly>
                        <input type="hidden" name="section_id" id="section_id" class="form-control" value="{{$section->id}}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="language_id">Language</label> 
                        <select class="form-control" name="language_id" id="language_id" required>
                            <option value="">Select Language</option>
                            @foreach($langs as $lang)
                                <option value="{{$lang->id}}" {{$lang->id === $section->lang ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="section_name">Section Name</label> 
                        <select name="section_name" id="section_name" class="form-control">
                            <optgroup label="Sections">
                                <option value="about overview" {{$section->section_name == 'about overview' ? 'selected' : ''}}>about overview</option>
                                <option value="service overview" {{$section->section_name == 'service overview' ? 'selected' : ''}}>service overview</option>
                                <option value="incoming quality overview" {{$section->section_name == 'incoming quality overview' ? 'selected' : ''}}>incoming quality overview</option>
                                <option value="during production overview" {{$section->section_name == 'during production overview' ? 'selected' : ''}}>during production overview</option>
                                <option value="pre shipment overview" {{$section->section_name == 'pre shipment overview' ? 'selected' : ''}}>pre shipment overview</option>
                                <option value="container loading overview" {{$section->section_name == 'container loading overview' ? 'selected' : ''}}>container loading overview</option>
                                <option value="production lines overview" {{$section->section_name == 'production lines overview' ? 'selected' : ''}}>production lines overview</option>
                                <option value="tic parallax" {{$section->section_name == 'tic parallax' ? 'selected' : ''}}>tic parallax</option>
                                <option value="chart overview" {{$section->section_name == 'chart overview' ? 'selected' : ''}}>chart overview</option>
                                <option value="why I need qc" {{$section->section_name == 'why I need qc' ? 'selected' : ''}}>why I need qc</option>
                                <option value="why tic" {{$section->section_name == 'why tic' ? 'selected' : ''}}>why tic</option>
                            </optgroup>
                            
                            <optgroup label="Pages">
                                @foreach($pages as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label> 
                        <input type="text" name="title" id="title" class="form-control" value="{{$section->title}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="postTextArea">Content</label> 
                        <textarea id="postTextArea" class="form-control" rows="10" name="content">
                            {{$section->content}}
                        </textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Content</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var real_url = "{{ URL::to('/') }}/";
    </script>
     <script src="{{asset('/js/tinymce/tinymce.min.js')}}?apiKey=8nzmcp8p2v7b1z8wt9w36038jzw20h5ece9stulezjzzr1sz"></script>
	{{ Html::script('/js/admin/tinymce.js') }}
    {{ Html::script('/js/admin/cms.js') }}
@endsection
