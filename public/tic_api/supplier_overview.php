
<?php 
  include 'controller.php'; 
  $ref_num=$_GET['ref_num'];
?>
<div class="row">

  <div class="col-md-6 col-sm-6 col-lg-6 col-md-offset-4 col-sm-offset-4 col-lg-offset-4">
                <div class="lightgallery">
                  <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Factory Location</h2><br/>">
                      <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                  </a>

                  <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Factory Gate</h2><br/>">
                    <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                  </a>

                  <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Warehouse</h2><br/>">
                    <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                  </a>

                  <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Loading Area</h2><br/>">
                    <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
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

