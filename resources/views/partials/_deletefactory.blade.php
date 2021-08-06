<!-- Modal -->
<div id="deleteFactoryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Product</h4>
      </div>
      <div class="modal-body">
          <p>Are You Sure you want to delete details of this factory? This cannot be undone.</p>
          <input type="hidden" id="delete_factory_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="close_product_modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="delete_factory_details">Delete Factory</button>
      </div>
    </div>

  </div>
</div>
