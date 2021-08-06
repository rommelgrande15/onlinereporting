
<?php 
  include 'controller.php'; 
  $ref_num=$_GET['ref_num'];
?>
<div class="row">

  <div class="col-md-4">
    <label>Inspector Arrival Time:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Cargo Ready Time:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Container Arrival Time:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Loading Started:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Inspection Finished:</label> <span></span>
  </div> 
  
  <div class="col-md-4">
    <label>Loading Facility Cooperation:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Container Number:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Shipping Seal Number:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Sera Seal Number:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Container Size:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Container Status:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Floor Condition:</label> <span></span>
  </div>

   <div class="col-md-4">
    <label>Doors Condition:</label> <span></span>
  </div>

  <div class="col-md-4">
    <label>Light Proof:</label> <span></span>
  </div>


              <div class="col-md-6 col-md-offset-4">
                <br><br>
              <div class="lightgallery">
                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Front Doors</h2><br/>{{$cargo->loading_area}}">
                    <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Back Doors</h2><br/>{{$cargo->front_doors}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Left Side</h2><br/>{{$cargo->left_side}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Right Side</h2><br/>{{$cargo->right_side}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Container Floor & Joint</h2><br/>{{$cargo->container_floor_and_joint}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Container Wall & Joint</h2><br/>{{$cargo->container_wall_and_joint}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Container Ceiling</h2><br/>{{$cargo->container_ceiling}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Container Doors Closed</h2><br/>{{$cargo->container_doors_closed}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>

                <a href="http://newapi.t-i-c.asia/tic_api/test_image.jpg" data-sub-html="<h2>Equipment Interchange Receipt</h2><br/>{{$cargo->equipment_interchange_receipt}}">
                  <img src="http://newapi.t-i-c.asia/tic_api/test_image.jpg" width="300" style="padding-bottom:5px;"/>
                </a>


              </div>
            </div>


</div>

