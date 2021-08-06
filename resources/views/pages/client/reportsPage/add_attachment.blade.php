@extends('layouts.client._new')
@section('title','Add Attachment')
@section('page-title','Add Attachment')

@section('stylesheets')

{!! Html::style('/css/dropzone.css') !!}
{!! Html::style('/js/dropzone/dropzone3.css') !!}

{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
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

	.content-header h1 {
		border-bottom: 3px solid orange;
		width: 20%;
		text-align: center;
		margin: 0 auto;
	}

</style>
@endsection

@section('content')
    <br/><br/>
    <div class="row">
	    <div class="col-md-12">
			<div class="col-md-12 dropzone-container file_upload" id="file_upload_container">
			    <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
				<div class="fallback">
					<input name="file[]" class="psi_required joe file" type="file" id="file" multiple required />
				</div>
			</div>
		</div>
    </div>
    <div class="row">
        <div class="col-md-offset-9 col-md-3">
	        <br/>
            <input type="hidden" id="inspect_id" value="{{$inspect_id}}">
		    {!! Form::button('Submit', ['class' => 'btn btn-success btn-block','id'=>'btn-submit','type'=>'button']) !!}
	    </div>
    </div>

<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
{!! Html::script('/js/dropzone.js') !!}
<script>
    var pdf_icon = "{{asset('images/icons/pdf.png')}}"; 
    var doc_icon = "{{asset('images/icons/doc.png')}}";
    var xls_icon = "{{asset('images/icons/xls.png')}}";
    var ppt_icon = "{{asset('images/icons/ppt.png')}}";
    var pub_icon = "{{asset('images/icons/pub.png')}}";
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
    var add_attachment="{{route('client-submit-files')}}";
	$(document).ready(function() {
        var myDZ = new Dropzone("div.file_upload", {
        url: add_attachment,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .zip, .ZIP, .rar, .RAR, .DOC, .DOCX, .PUB, .JPEG, .JPG, .PNG, .GIF, .XLS, .XLSX, .PPT, .PPTX',
        maxFilesize: 500000000,
        paramName: "file",
        init: function() {
                $("#btn-submit").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (myDZ.getQueuedFiles().length > 0) {
                            myDZ.processQueue();
                            $('.send-loading ').show();
                    } else {
                        swal({
                            title: "Warning!",
                            text: "Please add attachment",
                            type: "warning",
                        });
                    }
                })

                this.on('addedfile', function(file) {
                    var ext = file.name.split('.').pop();
                    if (ext == "pdf") {
                        $(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
                    } else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
                        $(file.previewElement).find(".dz-image img").attr("src", doc_icon);
                    } else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
                        $(file.previewElement).find(".dz-image img").attr("src", xls_icon);
                    } else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
                        $(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
                    } else if (ext.indexOf("pub") != -1) {
                        $(file.previewElement).find(".dz-image img").attr("src", pub_icon);
                    }
                })
                this.on("sendingmultiple", function(data, xhr, formData) {
                    formData.append("inspect_id", $('#inspect_id').val());
                });
                this.on("successmultiple", function(files, response) {
                    console.log(response);
                    swal({
                        title: "Success!",
                        text: "Attachment Successfully added",
                        type: "success",
                    }, function() {
                        location.reload(0)
                    });
                });
                this.on("errormultiple", function(files, response) {
                    console.log(response);
                    myDZ.removeAllFiles();
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                        type: "error",
                    });
                });


            } //init

    });
	
	});
</script>
@endsection
