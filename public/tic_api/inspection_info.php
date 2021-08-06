
<?php 
  include 'controller.php'; 
  $ref_num=$_GET['ref_num'];
?>
<div class="row">
  <?php
    $inspect_info=getInspectionDetails($ref_num);
    foreach($inspect_info as $result){
  ?>
  
  <div class="col-md-12">
    <label>Reference Number:</label> <span><?= $result['client_project_number'];?></span>
  </div>

  <div class="col-md-4">
    <label>Service:</label> <span><?= $result['service'];?></span>
  </div>

  <div class="col-md-4">
    <label>Inspection Date:</label> <span><?= $result['inspection_date'];?></span>
  </div>

  <div class="col-md-4">
    <label>Factory Name:</label> <span><?= factoryDetails($result['factory'],"factory_name");?></span>
  </div>


  <?php
    }
  ?>
</div>

