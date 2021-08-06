<?php
                require 'controller/controller.php';
                        $reports=selectAllReports($_GET['id'],$_GET['comp_id']);
                        foreach($reports as $result){  
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-product">
                                <div class="card-header card-header-image" data-header-animation="true">
                                   <!--  <a href="#">
                                        <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://booking.tic-sera.com/report_reviewer/reports/<?= $result['file_name']; ?>' width='100%' height='500px' frameborder='0'></iframe>
                                    </a> -->
                                </div>
                                <div class="card-body">
 
                                    <h4 class="card-title">
                                        <a href="http://booking.tic-sera.com/report_reviewer/reports/<?= $result['file_name']; ?>" title="Download Link" download="<?= $result['file_name']; ?>"><?= $result['file_name']; ?></a>
                                    </h4>

                                </div>
                                <div class="card-footer">
                                    <div class="price">

                                    </div>
                                    <div class="stats">
                                        <p class="card-category">Uploaded on <?= date("F d, Y",strtotime($result['date_created'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                      }
                      if(count($reports)==0){
                          echo "No report yet...";
                      }
                    ?>