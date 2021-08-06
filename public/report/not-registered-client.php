<?php
include 'controller/controller.php';
if(empty($_SESSION['email'])){
    header("location:index.php");
} else { 
  $session_user_id=$_SESSION['user_id'];
  $session_user_email=$_SESSION['email'];
  $session_FirstName=$_SESSION['FirstName'];
  $session_LastName=$_SESSION['LastName'];

} 
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        The Inspection Company
    </title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />




    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="../../../maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- CSS Files -->




    <link href="assets/css/material-dashboard.min40a0.css?v=2.0.2" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/sweetalert2/6.4.1/sweetalert2.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/sweetalert2/6.4.1/sweetalert2.js"></script>





</head>

<body class="">






    <div class="wrapper ">

        <div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->

            <div class="logo">
                <a href="" class="simple-text logo-mini">

                </a>

                <a href="" class="simple-text logo-normal">
             Report Team
        </a></div>

            <div class="sidebar-wrapper">

                <div class="user">
                    <div class="photo">
                        <img src="assets/img/faces/avatar.jpg" />
                    </div>
                    <div class="user-info">
                        <a data-toggle="collapse" href="#collapseExample" class="username">
                            <span>
                            <?php echo $session_FirstName.' '.$session_LastName ?>
                      <b class="caret"></b>
                    </span>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <!--<li class="nav-item">
                            <a class="nav-link" href="#">
                              <span class="sidebar-mini"> MP </span>
                              <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                              <span class="sidebar-mini"> EP </span>
                              <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>-->
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">
                                        <span class="sidebar-mini"> L </span>
                                        <span class="sidebar-normal"> Logout </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">

                    <li class="nav-item ">
                        <a class="nav-link" href="client.php">
                            <i class="material-icons">dashboard</i>
                            <p> Registered Client </p>
                        </a>
                    </li>

                    <li class="nav-item active">
                        <a class="nav-link" href="not-registered-client.php">
                            <i class="material-icons">list</i>
                            <p> Not Registered Client </p>
                        </a>
                    </li>



                    <li class="nav-item ">
                        <a class="nav-link" href="">
                            <i class="material-icons">persons</i>
                            <p> Profile </p>
                        </a>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link" href="logout.php">
                            <i class="material-icons">reply</i>
                            <p> Logout </p>
                        </a>
                    </li>

                </ul>



            </div>
        </div>


        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
                <div class="container-fluid">
                    <div class="navbar-wrapper">


                        <div class="navbar-minimize">
                            <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
              <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
              <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
          </button>
                        </div>


                        <a class="navbar-brand" href="client.php">Dashboard</a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
      <span class="sr-only">Toggle navigation</span>
			<span class="navbar-toggler-icon icon-bar"></span>
			<span class="navbar-toggler-icon icon-bar"></span>
			<span class="navbar-toggler-icon icon-bar"></span>
		</button>

                    <div class="collapse navbar-collapse justify-content-end">



                        <ul class="navbar-nav">

                            <li class="nav-item dropdown">
                                <a class="nav-link" href="http://example.com/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <!--<span class="notification">5</span>-->
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                        </ul>





                        </div>
                    </div>
            </nav>
            <!-- End Navbar -->

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">cloud_upload</i>
                                    </div>
                                    <h4 class="card-title">Upload Report</h4>
                                </div>
                                <div class="card-body ">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="gen_info_id" value="<?= $_GET['id']; ?>">
                                        <input type="hidden" name="gen_comp_id" value="<?= $_GET['comp_id']; ?>">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="assets/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                    <span class="fileinput-new">Select File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="uploaded_report" accept="application/msword, application/pdf" required/>
                                                </span>
                                                <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <label class="title">Report No. / Reference No.</label>
                                            <input type="text" class="form-control" placeholder="Input report number" name="ref_num"><br>

                                            <label class="title">Factory Name</label>
                                            <input type="text" class="form-control" placeholder="Input factory name" name="fac_name"><br>

                                            <label class="title">Factory Email</label>
                                            <input type="email" class="form-control" placeholder="Input factory email" name="fac_email"><br>

                                            <label class="title">Inspection Date</label>
                                            <input type="date" class="form-control" placeholder="Input date" name="ins_date"><br>
                                         
                                            <!-- <label class="title">Shipment Date</label>
                                            <input type="date" class="form-control" placeholder="Input date" name="ship_date"><br> -->
                                            
                                            <label class="title">Add Recipient</label>
                                            <input type="text" class="form-control tagsinput" data-role="tagsinput" data-color="info" placeholder="Recipient" id="recipient"/>
                                            <input type="hidden" id="hide_recipient" name="hide_recipient"><br>

                                            <label class="title">Add Recipient CC</label>
                                            <input type="text" class="form-control tagsinput" data-role="tagsinput" data-color="info" placeholder="Recipient CC" id="recipient_cc"/>
                                            <input type="hidden" id="hide_recipient_cc" name="hide_recipient_cc">


                                        </div>
                                        <hr>
                                    
                                </div>
                                <div class="card-footer ">
                                    <button type="submit" name="not_registered_client" class="btn btn-fill btn-rose">Upload</button>
                                   <!--  <button type="button" id="submit_upload_report" onclick="getRecipient()" class="btn btn-fill btn-rose">Upload</button> -->
                                </div>
                                </form>
                                <?php
                                    if(isset($_POST['not_registered_client']) && $_SESSION['not_registered_client']=='ok'){
                                    
                                        echo"<script>alert('Report successfully uploaded.')</script>";
                                        echo("<meta http-equiv='refresh' content='1'>");
                                        

                                    }
                                ?>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>

                    <!-- <h3>Inspection Report</h3> -->
                    <br>
                    <?php
                        $reports=selectAllReports2($_GET['comp_id']);
                        foreach($reports as $result){  
                    ?>
                    <div class="row" id="row_id_<?= $result['id'];?>">
                        <div class="col-md-12">
                            <div class="card card-product">
                                <div class="card-header card-header-image" data-header-animation="true" align="center">
                                    <a href="#">
                                        <?php
                                            $type_of_file = pathinfo($result['file_name']);
                                            $ext=strtolower($type_of_file['extension']);
                                            $icon="";
                                            if($ext=='docx' || $ext=='doc'){
                                                $icon="word.png";
                                            }else{
                                                $icon="pdf.jpg";
                                            }
                                         ?>
                                        <!-- <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://booking.tic-sera.com/report_reviewer/reports/<?= $result['file_name']; ?>' width='100%' height='500px' frameborder='0'></iframe> -->
                                            <img class="img" src="assets/img/<?= $icon; ?>" style="width:250px; height:250px; " align="center">

                                       <!--  <iframe src='http://docs.google.com/gview?url=http://booking.tic-sera.com/report_reviewer/reports/<?= $result['file_name']; ?>&embedded=true' width='100%' height='500px' frameborder='0'></iframe> -->

                                            
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-actions text-center">
                                        <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <button type="button" class="btn btn-default btn-link" onclick="window.location.href='reports/<?= $result['file_name']; ?>'"  title="View">
                                            <i class="material-icons">art_track</i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-link"  title="Edit" onclick="editFile('<?= $result['id']; ?>')">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-link"  title="Remove" onclick="removeFile('<?= $result['id']; ?>')">
                                          <i class="material-icons">close</i>
                                        </button>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="reports/<?= $result['file_name']; ?>" download="reports/<?= $result['file_name']; ?>"><?= $result['file_name']; ?></a>
                                    </h4>

                                </div>
                                <div class="card-footer">
                                    <div class="price">

                                    </div>
                                    <div class="stats">
                                        <p class="card-category"><i class="material-icons">schedule</i>Uploaded at <?= date("F d, Y",strtotime($result['date_created'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php
                      }
                      if(count($reports)==0){
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-product">
                                <div class="card-header card-header-image" data-header-animation="true" align="center">
                                    <a href="#">
                                    <img class="img" src="assets/img/empty.png" style="width:300px; height:300px;">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-actions text-center">
                                        <!-- <button type="button" class="btn btn-danger btn-link fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="View">
                                            <i class="material-icons">art_track</i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Remove" onclick="removeFile('<?= $result['id']; ?>')">
                                          <i class="material-icons">close</i>
                                        </button> -->
                                    </div>
                                    <h4 class="card-title">
                                        <!-- <a href="#"><?= $result['file_name']; ?></a> -->
                                    </h4>

                                </div>
                                <div class="card-footer">
                                    <div class="price">

                                    </div>
                                    <div class="stats">
                                        <!-- <p class="card-category"><i class="material-icons">schedule</i>Uploaded at <?= date("F d, Y",strtotime($result['date_created'])); ?></p> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php      
                      }
                    ?>

                </div>




                <footer class="footer">
                    <div class="container-fluid">

                        <div class="copyright float-right">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script>, by
                            <a href="https://the-inspection-company.com" target="_blank">The Inspection Company - IT Department </a> for a Report Team.
                        </div>
                    </div>
                </footer>


            </div>

            </div>





<div id="modalEditReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="exampleModalLabel" class="modal-title">Edit Report</h4>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>

        <div class="modal-body">
            
        <div class="card ">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">cloud_upload</i>
                                    </div>
                                    <h4 class="card-title">Upload Report</h4>
                                </div>
                                <div class="card-body ">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_gen_info_id" value="<?= $_GET['id']; ?>">
                                        <input type="hidden" name="edit_gen_comp_id" value="<?= $_GET['comp_id']; ?>">
                                        <input type="hidden" name="edit_report_id" id="edit_report_id" value="">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="assets/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                    <span class="fileinput-new">Select File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="edit_uploaded_report" required/>
                                                </span>
                                                <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                        <hr>
                                    
                                </div>
                                <div class="card-footer ">
                                    <button type="submit" name="edit_submit_upload_report" class="btn btn-fill btn-rose">Upload</button>
                                </div>
                                </form>
                                <?php
                                    if(isset($_POST['edit_submit_upload_report']) && $_SESSION['edit_result_upload']=='ok'){
                                        echo"<script>alert('Report successfully updated.')</script>";
                                        echo("<meta http-equiv='refresh' content='1'>");
                                    }
                                ?>
                            </div>
                  
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
        </div>
      </div>
    </div>
  </div>










            <!--   Core JS Files   -->
            <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
            <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
            <script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>

            <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>


            <!-- Plugin for the momentJs  -->
            <script src="assets/js/plugins/moment.min.js"></script>

            <!--  Plugin for Sweet Alert -->
            <script src="assets/js/plugins/sweetalert2.js"></script>

            <!-- Forms Validations Plugin -->
            <script src="assets/js/plugins/jquery.validate.min.js"></script>

            <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
            <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>

            <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
            <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>

            <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
            <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>

            <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
            <script src="assets/js/plugins/jquery.dataTables.min.js"></script>

            <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
            <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>

            <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
            <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>

            <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
            <script src="assets/js/plugins/fullcalendar.min.js"></script>

            <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
            <script src="assets/js/plugins/jquery-jvectormap.js"></script>

            <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
            <script src="assets/js/plugins/nouislider.min.js"></script>

            <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
            <script src="../../../cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

            <!-- Library for adding dinamically elements -->
            <script src="assets/js/plugins/arrive.min.js"></script>

            <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
            <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>


            <!--  Google Maps Plugin    -->

            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>

            <!-- Place this tag in your head or just before your close body tag. -->
            <script async defer src="../../../buttons.github.io/buttons.js"></script>


            <!-- Chartist JS -->
            <script src="assets/js/plugins/chartist.min.js"></script>

            <!--  Notifications Plugin    -->
            <script src="assets/js/plugins/bootstrap-notify.js"></script>





            <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="assets/js/material-dashboard.min40a0.js?v=2.0.2" type="text/javascript"></script>
            <!-- Material Dashboard DEMO methods, don't include it in your project! -->
            <script src="assets/demo/demo.js"></script>
            <script>
                $(document).ready(function() {
                    $().ready(function() {
                        $sidebar = $('.sidebar');

                        $sidebar_img_container = $sidebar.find('.sidebar-background');

                        $full_page = $('.full-page');

                        $sidebar_responsive = $('body > .navbar-collapse');

                        window_width = $(window).width();

                        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                            if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                                $('.fixed-plugin .dropdown').addClass('open');
                            }

                        }

                        $('.fixed-plugin a').click(function(event) {
                            // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                            if ($(this).hasClass('switch-trigger')) {
                                if (event.stopPropagation) {
                                    event.stopPropagation();
                                } else if (window.event) {
                                    window.event.cancelBubble = true;
                                }
                            }
                        });

                        $('.fixed-plugin .active-color span').click(function() {
                            $full_page_background = $('.full-page-background');

                            $(this).siblings().removeClass('active');
                            $(this).addClass('active');

                            var new_color = $(this).data('color');

                            if ($sidebar.length != 0) {
                                $sidebar.attr('data-color', new_color);
                            }

                            if ($full_page.length != 0) {
                                $full_page.attr('filter-color', new_color);
                            }

                            if ($sidebar_responsive.length != 0) {
                                $sidebar_responsive.attr('data-color', new_color);
                            }
                        });

                        $('.fixed-plugin .background-color .badge').click(function() {
                            $(this).siblings().removeClass('active');
                            $(this).addClass('active');

                            var new_color = $(this).data('background-color');

                            if ($sidebar.length != 0) {
                                $sidebar.attr('data-background-color', new_color);
                            }
                        });

                        $('.fixed-plugin .img-holder').click(function() {
                            $full_page_background = $('.full-page-background');

                            $(this).parent('li').siblings().removeClass('active');
                            $(this).parent('li').addClass('active');


                            var new_image = $(this).find("img").attr('src');

                            if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                                $sidebar_img_container.fadeOut('fast', function() {
                                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                                    $sidebar_img_container.fadeIn('fast');
                                });
                            }

                            if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                                $full_page_background.fadeOut('fast', function() {
                                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                                    $full_page_background.fadeIn('fast');
                                });
                            }

                            if ($('.switch-sidebar-image input:checked').length == 0) {
                                var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                                $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                                $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            }

                            if ($sidebar_responsive.length != 0) {
                                $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                            }
                        });

                        $('.switch-sidebar-image input').change(function() {
                            $full_page_background = $('.full-page-background');

                            $input = $(this);

                            if ($input.is(':checked')) {
                                if ($sidebar_img_container.length != 0) {
                                    $sidebar_img_container.fadeIn('fast');
                                    $sidebar.attr('data-image', '#');
                                }

                                if ($full_page_background.length != 0) {
                                    $full_page_background.fadeIn('fast');
                                    $full_page.attr('data-image', '#');
                                }

                                background_image = true;
                            } else {
                                if ($sidebar_img_container.length != 0) {
                                    $sidebar.removeAttr('data-image');
                                    $sidebar_img_container.fadeOut('fast');
                                }

                                if ($full_page_background.length != 0) {
                                    $full_page.removeAttr('data-image', '#');
                                    $full_page_background.fadeOut('fast');
                                }

                                background_image = false;
                            }
                        });

                        $('.switch-sidebar-mini input').change(function() {
                            $body = $('body');

                            $input = $(this);

                            if (md.misc.sidebar_mini_active == true) {
                                $('body').removeClass('sidebar-mini');
                                md.misc.sidebar_mini_active = false;

                                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                            } else {

                                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                                setTimeout(function() {
                                    $('body').addClass('sidebar-mini');

                                    md.misc.sidebar_mini_active = true;
                                }, 300);
                            }

                            // we simulate the window Resize so the charts will get updated in realtime.
                            var simulateWindowResize = setInterval(function() {
                                window.dispatchEvent(new Event('resize'));
                            }, 180);

                            // we stop the simulation of Window Resize after the animations are completed
                            setTimeout(function() {
                                clearInterval(simulateWindowResize);
                            }, 1000);

                        });
                    });
                });
            </script>






            <!-- Sharrre libray -->
            <script src="assets/demo/jquery.sharrre.js"></script>



            <script>
                $(document).ready(function() {
                    // Javascript method's body can be found in assets/js/demos.js
                    md.initDashboardPageCharts();

                    md.initVectorMap();

                });
            </script>







            <script>
                $(document).ready(function() {
                    $('#datatables').DataTable({
                        "pagingType": "full_numbers",
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        responsive: true,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search records",
                        }
                    });

                    var table = $('#datatable').DataTable();

                    // Edit record
                    table.on('click', '.edit', function() {
                        $tr = $(this).closest('tr');
                        var data = table.row($tr).data();
                        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
                    });

                    // Delete a record
                    table.on('click', '.remove', function(e) {
                        $tr = $(this).closest('tr');
                        table.row($tr).remove().draw();
                        e.preventDefault();
                    });

                    //Like record
                    table.on('click', '.like', function() {
                        alert('You clicked on Like button');
                    });
                });
            </script>
            <script>
                function removeFile(file_id){
                    swal({
                        title: 'Are you sure?',
                        text: 'This cannot be undone',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Delete it!',
                        cancelButtonText: 'No, Stay'
                    }).then(function(isConfirm) {
                      if (isConfirm === true) {
                        $.ajax({
                      	url: 'controller/controller.php'
                      	, type: 'POST'
                      	, datatype: 'JSON'
                      	, data: {
                          deleteReport: 1
                            , id: file_id
                      	}
                      	, success: function (result) {
                              console.log(result);
                              if(result=="ok"){
                                swal({
                                  type: 'success',
                                  title: 'Report deleted successfully',
                                  showConfirmButton: false,
                                  timer: 2000
                                });
                                    //setTimeout(function () {location.reload();}, 1000);
                                    $('#row_id_'+file_id).fadeTo(1500, 0.01, function(){ 
                                        $(this).slideUp(150, function() {
                                            $(this).remove(); 
                                        }); 
                                    });
                              }
                      	}
                      }); 
                      }else if (isConfirm === false) {
                    
                      } else {
                    
                      }
                    })   
                }

                function editFile(id){
                    $('#edit_report_id').val(id);
                    $('#modalEditReport').modal();
                }

                function getRecipient(){
                    //console.log($("#recipient").tagsinput('items'));
                    $('#hide_recipient').val($("#recipient").tagsinput('items'));
                }
                $('#recipient').change(function(){
                    $('#hide_recipient').val($("#recipient").val());
                });

                $('#recipient_cc').change(function(){
                    $('#hide_recipient_cc').val($("#recipient_cc").val());
                });
            </script>



</body>


</html>