@extends('layouts.new')
@section('title','Panel')
@section('page-title','Project Template')
@section('stylesheets')
<link rel="stylesheet" href="/css/admin/template.css">
<link rel="stylesheet" href="/css/grapes.min.css">
@endsection
@section('content')
    <div class="row" style="margin: 0;margin-left: 0;height:100%">
        <div class="col-md-12 hidden-sm hidden-xs" style="padding-right: 0;padding-left: 0;">
            <div id="tic-builder"></div>
            <small style="margin: 0; padding: 0" id="page-counter"></small>
            <div style="display: none">
                <div class="document-title-cont">
                </div>
                <div class="document-menu-cont">
                    <div class="project-container">
                        <div class="project-container-header">
                            <h4 style="font-weight: bold">Project Templates</h4>
                            <button id="close-menu" class="btn btn-transparent" onclick="closeMenu();" title="Close Menu"><i class="fa fa-times" style="color: #dd4b39; font-size: 32px;"></i></button>
                        </div>
                        <hr style="margin-top: 0;">
                        <div class="project-container-content">
                            <div class="project-container-list">
                                @if($templates->count() == 0)
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            No Template Available
                                        </div>
                                    </div>
                                @else
                                    @foreach($templates as $template)
                                        <div class="project" id="{{ $template->id }}">
                                            <div class="project-title">{{ $template->name }}</div><small>created {{ \Carbon\Carbon::parse($template->created_at)->toFormattedDateString() }}</small>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="project-container-action">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <button class="btn btn-success btn-block" onclick="newTemplate()"><i class="fa fa-file"></i> New</button>
                                        <button class="btn btn-primary btn-block" onclick="copyTemplate()"><i class="fa fa-copy"></i> Clone</button>
                                        <button class="btn btn-danger btn-block" onclick="deleteTemplate()"><i class="fa fa-archive"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="se-pre-con"></div>
@endsection
@section('scripts')
    <script>
        var fullscreen = false;
        var projectId = null;
        $(window).on('load',function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
            builderHeight();
            if(localStorage.getItem('tic-editing') === 'true')
                $('.document-menu-cont').css('display', 'none');
        });
        $(window).resize(function(){
            setTimeout(function(){
                if(fullscreen) {
                    $('#tic-builder').height('100%');
                } else {
                    builderHeight();
                }
            }, 100);
        });
        $('.project-container-list').on('click', '.project', function(){
            $('.project.selected').removeClass('selected');
            $(this).addClass('selected');
            projectId = $(this).attr('id');
        });
		
    </script>
	<script src="/js/grapes.min.js"></script>
	<script src="/js/tic-plugin.min.js"></script>
	<script src="/js/tic.min.js"></script>
@endsection
