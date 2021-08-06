<div id="languageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="POST" action="{{route('cms.newlanguage')}}">
      {{csrf_field()}}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Language</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="lang_country">Country</label>
              <select name="lang_country" id="lang_country" class="form-control">
                <option value="">Select Language</option>
                @foreach($language as $lang)
                  <option value="{{$lang->short_name}}">{{$lang->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="country">Short Name</label>
              <input type="text" name="short_name" id="short_name" class="form-control" readonly>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Language</button>
        </div>
      </div>
    </form>

  </div>
</div>