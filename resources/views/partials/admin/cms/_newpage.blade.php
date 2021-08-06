<div id="pageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="POST" action="{{route('cms.newpage')}}">
      {{csrf_field()}}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Page</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="page_name">Page Name</label>
              <input type="text" name="page_name" id="page_name" class="form-control">
            </div>
            <div class="form-group">
              <label for="page_description">Page Description</label>
              <textarea name="page_description" id="page_description" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label for="page_name">Slug</label><span class="note"> (Slug must be unique)</span>
              <input type="text" name="slug" id="slug" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Page</button>
        </div>
      </div>
    </form>

  </div>
</div>