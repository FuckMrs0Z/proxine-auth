<?php
include ("../rserver.php");
if (checkLogin() == false)
{
    header("location: ../login.php");
}
else
{

}
function fnx($page)
{
    header("location: " . $page);
}
unset($_SESSION['program']);
$check_everything = mysqli_query($con, 'SELECT * FROM users WHERE USERNAME=\'' . $_SESSION['username'] . '\'');
$row = mysqli_fetch_array($check_everything);
$check_program = mysqli_query($con, 'SELECT * FROM programs WHERE PROGRAM_USER=\'' . $_SESSION['username'] . '\'');
$row3 = mysqli_fetch_array($check_program);
$res_b = $check_program;

if(isset($_POST['manage']))
{
  $_SESSION['program'] = $_POST['manage'];
  fnx("Settings.php");
}
if (isset($_POST['create']))
{
    if ($row[3] == "Starter Plan" && mysqli_num_rows($res_b) >= "5")
    {
        echo '<script>window.location.replace("account.php");</script>';
        exit();
    }
    if ($row[3] == "Ultimate Plan" && mysqli_num_rows($res_b) >= "50")
    {
        echo '<script>window.location.replace("account.php");</script>';
        exit();
    }
    if ($row[3] == "Unlimited Plan" && mysqli_num_rows($res_b) >= "500")
    {
        echo '<script>window.location.replace("account.php");</script>';
        exit();
    }
    $programid = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890987654321") , 0, 12);
    mysqli_query($con, 'INSERT INTO `programs`(`PROGRAM_NAME`, `PROGRAM_ID`, `PROGRAM_USER`) VALUES (\'' . $_POST['programname'] . '\',\'' . $programid . '\',\'' . $_SESSION['username'] . '\')');
    fnx("index.php");
}
if (isset($_POST['delete']))
{
    mysqli_query($con, 'DELETE FROM `programs` WHERE `PROGRAM_USER` = \'' . $_SESSION['username'] . '\' AND `PROGRAM_NAME` = \'' . $_POST['delete'] . '\'');
    //die('DELETE FROM `programs` WHERE `programuser` = \''.$_SESSION['username'].'\' & `programname` = \''.$_POST['del'].'\'');
    // mysqli_query($con, 'DELETE FROM `resellers` WHERE program = \''.$_POST['del'].'\'');
    //mysqli_query($con, 'DELETE FROM `license` WHERE program = \''.$_POST['del'].'\'');
    fnx("index.php");
}
if (isset($_POST['disable']))
{
    mysqli_query($con, 'UPDATE `programs` Set `DISABLED` = "Yes" WHERE `PROGRAM_USER` = \'' . $_SESSION['username'] . '\' AND `PROGRAM_NAME` = \'' . $_POST['disable'] . '\'');
    fnx("index.php");
}
if (isset($_POST['enable']))
{
    mysqli_query($con, 'UPDATE `programs` Set `DISABLED` = "No" WHERE `PROGRAM_USER` = \'' . $_SESSION['username'] . '\' AND `PROGRAM_NAME` = \'' . $_POST['enable'] . '\'');
    fnx("index.php");
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <style>

.blured{
-webkit-filter: blur(5px);
-moz-filter: blur(5px);
-o-filter: blur(5px);
-ms-filter: blur(5px);
filter: blur(5px);
}
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <div class="sidebar-brand brand-logo"><b><strong style = "color:#FFFFFF;">accode.</strong><strong style = "color:#FFFFFF;">xyz</strong></b></div>
          <div class="sidebar-brand brand-logo-mini" href="index.php"><b><strong style = "color:#ffffff;">P</strong><strong style = "color:#ffffff;">N</strong></b></div>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
              
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?php echo $_SESSION['username'];?></h5>
                  <span>User ID: <?php echo $_SESSION['ID'];?></span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Main</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="index.php">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="downloads.php">
              <span class="menu-icon">
                <i class="mdi mdi-download"></i>
              </span>
              <span class="menu-title">Downloads</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="settings.php">
              <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
              </span>
              <span class="menu-title">Settings</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
           
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
           
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="../assets/images/faces/face15.jpg" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $_SESSION['username'];?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a id="settings_button" class="dropdown-item preview-item">
                    <div id="settings_button" class="preview-thumbnail">
                      <div id="settings_button" class="preview-icon bg-dark rounded-circle">
                        <i id="settings_button" class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div id="settings_button" class="preview-item-content">
                      <p id="settings_button" class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="logout_button" class="dropdown-item preview-item">
                    <div id="logout_button" class="preview-thumbnail">
                      <div id="logout_button" class="preview-icon bg-dark rounded-circle">
                        <i id="logout_button" class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div id="logout_button" class="preview-item-content"> 
                      <p class="preview-subject mb-1" id="logout_button">Log out</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="../assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">Protect Your Program</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">License Your Program To Ensure No Unauthorised Access!</p>
                      </div>
                      <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                        <button data-toggle="modal" data-target="#exampleModal-4" class="btn btn-outline-light btn-rounded get-started-btn">Create Program</button>
                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">New Program</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Program Name:</label>
                                <input type="text" name="programname"class="form-control" id="recipient-name">
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="create"class="btn btn-primary">Create</button>
                            </form>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h4 class="mb-0"><?php echo $row[3];?></h4>
                          
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-cloud-check icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Account Package</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h4 class="mb-0"><?php if ($row[3] == "Unlimited Plan") {
                            echo "$20";
                          }
                          elseif($row[3] == "Ultimate Plan")
                          {
                            echo "$15";
                          }
                          elseif ($row[3] == "Starter Plan")
                          {
                            echo "$10";
                          }
                        
                          ?></h4>
                       
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-cash-multiple icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Purchase Package</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h4 class="mb-0"><?php echo mysqli_num_rows($res_b); ?></h4>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-server-network icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Programs</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h4 class="mb-0"><?php echo $row[4];?></h4>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-speedometer icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Account Expiry</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-12 grid-margin">
              
              <div class="card">
              <div class="card-body">
                <h4 class="card-title">Applications</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                        <th>ID</th>
                        <th>Program</th>
                        <th>Program ID</th>
                        <th>Disabled</th>
                        <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($res_b as $rows): if ($rows['PROGRAM_USER'] == $_SESSION['username']) {?>
                          <tr>
                          <td><?php echo $rows['ID']; ?></td>
                        <td><?php echo $rows['PROGRAM_NAME']; ?></td>
                        <td><?php echo $rows['PROGRAM_ID']; ?></td>
                        <td><?php if($rows['DISABLED'] == "No")
                        { ?> <div class="badge badge-outline-success">Enabled</div><?php } else {?><div class="badge badge-outline-danger">Disabled</div><?php }?></td>
                        <td>
                        <table>
                          <tr>
                            <form method="post">
                              <button onclick="return confirm('Are you sure you want to delete?')"type="submit" name="delete" value="<?php echo $rows['PROGRAM_NAME']; ?>" class="btn btn-outline-danger btn-lg">Delete</button>
                            </form>
                          </tr>
                          <tr> </tr> 
                          <tr>
                            <form method="post">
                              <button type="submit" name="manage" value="<?php echo $rows['PROGRAM_NAME']; ?>" class="btn btn-outline-success btn-sm">Manage</button>
                            </form>
                          </tr>
                          <tr> </tr>
                          <?php
                          if ($rows['DISABLED'] == "No")
                          {
                          ?>
                          <tr>
                            <form method="post">
                              <button type="submit" name="disable" value="<?php echo $rows['PROGRAM_NAME']; ?>" class="btn btn-outline-info btn-sm">Disable</button>
                            </form>
                          </tr>
                          <?php
                         }
                         else
                         {

                          ?>
                          <tr>
                            <form method="post">
                              <button type="submit" name="enable" value="<?php echo $rows['PROGRAM_NAME']; ?>" class="btn btn-outline-success btn-sm">Enable</button>
                            </form>
                          </tr>
                          <?php
                         }
                          ?>
                        </table>
                </td> 
                      </tr>
                      <?php } endforeach;?>
                    </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date("Y"); ?> <a style="color: #0090E7;"href="https://accode.xyz" target="_blank">accode.xyz</a>. All rights reserved.</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/data-table.js"></script>
    <!-- End custom js for this page -->
    <script>
      $("#logout_button").click(() => {
        window.location.href = "logout.php";
      })
      
    </script>
    
  </body>
</html>
