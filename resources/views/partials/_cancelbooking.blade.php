<div id="cancelBookingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancel Booking</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to cancel this booking?</p>
        <input type="hidden" id="bookingIdNumber">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="cancelBookingYes">Yes, cancel this booking</button>
      </div>
    </div>

  </div>
</div>