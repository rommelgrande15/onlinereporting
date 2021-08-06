@extends('layouts.admin')
@section('title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/cms.css') }}
@endsection

@section('content')
    <div class="col-md-12 padding-b-25">
        <h3>Create New Content</h3>
        <div class="buttons">
            <a href="{{route('cms.index', $page->id)}}"><i class="fa fa-arrow-left"></i> Go Back to Sections List</a>
        </div>
        <form method="POST" class="new-content-form" action="{{route('cms.newcontent')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="page">Page</label> 
                        <input type="text" name="page" id="page" class="form-control" value="{{$page->name}}" readonly>
                        <input type="hidden" name="page_id" id="page_id" class="form-control" value="{{$page->id}}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="language_id">Language</label> 
                        <select class="form-control" name="language_id" id="language_id" required>
                            <option value="">Select Language</option>
                            @foreach($langs as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="section_name">Section Name</label> 
                        <select class="form-control" name="section_name" id="section_name">
                            <optgroup label="Sections">
                                <option value="about overview">about overview</option>
                                <option value="service overview">service overview</option>
                                <option value="incoming quality overview">incoming quality overview</option>
                                <option value="during production overview">during production overview</option>
                                <option value="pre shipment overview">pre shipment overview</option>
                                <option value="container loading overview">container loading overview</option>
                                <option value="production lines overview">production lines overview</option>
                                <option value="tic parallax">tic parallax</option>
                                <option value="chart overview">chart overview</option>
                                <option value="why I need qc">why I need qc</option>
                                <option value="why tic">why tic</option>
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
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="postTextArea">Content</label> 
                        <textarea id="postTextArea" class="form-control" rows="10" name="content"></textarea>
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
