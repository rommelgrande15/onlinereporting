<?php
include 'controller/controller.php';
if(empty($_SESSION['username'])){
    header("location:index.php");
} else { 
  $session_user_id=$_SESSION['user_id'];
  $session_user_email=$_SESSION['username'];
 // $session_FirstName=$_SESSION['FirstName'];
  //$session_LastName=$_SESSION['LastName'];

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
    <link rel="stylesheet" href="maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->

    <link href="assets/css/material-dashboard.min40a0.css?v=2.0.2" rel="stylesheet" />
</head>

<body class="">

    <div class="wrapper ">

        <div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->

            <div class="logo">
                <a href="http://www.creative-tim.com/" class="simple-text logo-mini">

                </a>

                <a href="http://www.creative-tim.com/" class="simple-text logo-normal">
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
                    <li class="nav-item active ">
                        <a class="nav-link" href="client.php">
                            <i class="material-icons">dashboard</i>
                            <p> Registered Client </p>
                        </a>
                    </li>
                    <li class="nav-item">
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


                        <a class="navbar-brand" href="#pablo">Dashboard</a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
      <span class="sr-only">Toggle navigation</span>
			<span class="navbar-toggler-icon icon-bar"></span>
			<span class="navbar-toggler-icon icon-bar"></span>
			<span class="navbar-toggler-icon icon-bar"></span>
		</button>

                    <div class="collapse navbar-collapse justify-content-end">


                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                            </li>
                        </ul>



                    </div>
                </div>
            </nav>
            <!-- End Navbar -->



            
            
            
            
                
                
                
                
                

         <!-- <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-text card-header-warning">
                                    <div class="card-text">
                                        <h4 class="card-title">Client List</h4>
                                        
                                    </div>
                                </div>
                                
                                <div class="card-body"> 
                                
                                <div class="material-datatables">
                                    <table  id="client_tables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead class="text-warning">
                                            <th>Company Name</th>
                                            <th>Contact Name</th>
                                            <th>Contact Email</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $client=selectClientDetails();
                                                foreach($client as $result){   
                                            ?>
                                            <tr>
                                                <td><?= $result['compName']; ?></td>
                                                <td><?= $result['contactName']; ?></td>
                                                <td><?= $result['email']; ?></td>
                                                <td><button class="btn btn-rose" onclick="selectClientInspection('<?= $result['compID']; ?>')">Select <i class="fa fa-arrow-right"></i> </button></td>
                                            </tr>
                                            <?php
                                               }   
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-text card-header-warning">
                                    <div class="card-text">
                                        <h4 class="card-title">Booked Inspection</h4>
                                        <p class="card-category"></p>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <div id="load_inspec_details">
                                        <div class="load_inspection">
                                            <table class="table table-hover" id="inspec_tables">
                                                <thead class="text-warning">
                                                    <th>Inspection Title</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>-->

            
            
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-warning card-header-icon">
                                      <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-8 col-lg-10 col-sm-8"><h4 class="card-title">Client List</h4></div>
                                        <div class="col-md-4 col-lg-2 col-sm-4"><!-- <button class="btn btn-rose" onclick="window.location.href='client-add.php'"><i class="fa fa-plus"></i> Add Client</button> --></div>
                                      </div>
                                    </div>
                                <div class="card-body">
                                    <div class="toolbar">
                                      <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead class="text-warning">
                                                <th>Company</th>
                                                <th>Client</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Client</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    $client=selectClientDetails();
                                                    foreach($client as $result){   
                                                ?>
                                                <tr>
                                                    <td><?= $result['compName']; ?></td>
                                                    <td><?= $result['contactName']; ?></td>
                                                    <td><?= $result['email']; ?></td>
                                                    <td><button class="btn btn-rose" onclick="openModalClientInspec('<?= $result['compID']; ?>')">Select  </button></td>
                                                </tr>
                                                <?php
                                                   }   
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
                </div>

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

    <div id="modalViewClientInspection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="exampleModalLabel" class="modal-title">View Client Inspections</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive">
                    <div id="load_inspec_details">                                
                    </div>
                </div> 
                
            </div>
            <div class="modal-footer">
                <input type="hidden" id="company_id">
                <button type="button" data-dismiss="modal" class="btn btn-rose" onclick="redirectToInspectionUpload()">Add Inspection</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>           
            </div>
          </div>
        </div>
    </div>




    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.min.js " type="text/javascript "></script>
    <script src="assets/js/core/popper.min.js " type="text/javascript "></script>
    <script src="assets/js/core/bootstrap-material-design.min.js " type="text/javascript "></script>

    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js "></script>


    <!-- Plugin for the momentJs  -->
    <script src="assets/js/plugins/moment.min.js "></script>

    <!--  Plugin for Sweet Alert -->
    <script src="assets/js/plugins/sweetalert2.js "></script>

    <!-- Forms Validations Plugin -->
    <script src="assets/js/plugins/jquery.validate.min.js "></script>

    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="assets/js/plugins/jquery.bootstrap-wizard.js "></script>

    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="assets/js/plugins/bootstrap-selectpicker.js "></script>

    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="assets/js/plugins/bootstrap-datetimepicker.min.js "></script>

    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <script src="assets/js/plugins/jquery.dataTables.min.js "></script>

    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="assets/js/plugins/bootstrap-tagsinput.js "></script>

    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="assets/js/plugins/jasny-bootstrap.min.js "></script>

    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="assets/js/plugins/fullcalendar.min.js "></script>

    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="assets/js/plugins/jquery-jvectormap.js "></script>

    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="assets/js/plugins/nouislider.min.js "></script>

    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js "></script>

    <!-- Library for adding dinamically elements -->
    <script src="assets/js/plugins/arrive.min.js "></script>


    <!--  Google Maps Plugin    -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU "></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="buttons.github.io/buttons.js "></script>


    <!-- Chartist JS -->
    <script src="assets/js/plugins/chartist.min.js "></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/plugins/bootstrap-notify.js "></script>





    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/material-dashboard.min40a0.js?v=2.0.2 " type="text/javascript "></script>

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


                    var new_image = $(this).find("img ").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url(" ' + new_image + ' ")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url(" ' + new_image_full_page + ' ")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img ").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url(" ' + new_image + ' ")');
                        $full_page_background.css('background-image', 'url(" ' + new_image_full_page + ' ")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url(" ' + new_image + ' ")');
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
    <script src="assets/demo/jquery.sharrre.js "></script>


    <script>
        $(document).ready(function() {
            $('#inspec_tables').DataTable({
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

            var table = $('#inspec_tables').DataTable();
            
            $('#client_tables').DataTable({
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

            var table = $('#client_tables').DataTable();

            //new table
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

            var table = $('#datatables').DataTable();

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
        function loadDatatable(){
            $('#client_inspec_tables').DataTable({
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

            var table = $('#client_inspec_tables').DataTable();
        }
        function selectClientInspection(id){
            $('#load_inspec_details').empty();
            $('#load_inspec_details').load('load_client_inspection.php?id='+id);
            setTimeout(function() {         
                loadDatatable();
            }, 500); 
        }
        function openModalClientInspec(id){
            $('#load_inspec_details').empty();
            $('#load_inspec_details').load('load_client_inspection.php?id='+id);
            setTimeout(function() {         
                loadDatatable();
            }, 500); 
            $('#company_id').val(id);
            $('#modalViewClientInspection').modal();
        }

        function redirectToInspectionUpload(){
            var comp_id= $('#company_id').val();
            window.location.href='inspection-upload.php?comp_id='+comp_id;
        }
    </script>

</body>


</html>