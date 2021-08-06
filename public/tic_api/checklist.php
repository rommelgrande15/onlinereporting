
<?php 
  include 'controller.php'; 
  $ref_num=$_GET['ref_num'];
?>
<div class="row">

  <div class="col-md-6 col-md-offset-4">
    <div class="lightgallery">
      <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" >
        <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300"/>
      </a>
    </div>        
  </div>

</div>

<script>
$(document).ready(function() {
  $(".lightgallery").lightGallery(); 
});
</script>

       <!-- <?php
    $reference_number=inspectionDetails($ref_num,"reference_number");
    $checklist=getImages($reference_number,"checklist");
    foreach($checklist as $result){
  ?>
      <div class="col-md-6 col-md-offset-4">
        <div class="lightgallery">
          <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg">
            <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300"/>
          </a>
        </div>
      </div>
  <?php
    }
  ?> -->

