<?php
include ("server.php");
if (checkLogin() == false)
{
    header("location: login.php");
}
else
{
 
}
function fnx($page)
{
    header("location: " . $page);
}
if(empty($_SESSION['program']))
{
    fnx("index.php");
}
else{

}
$gay;
$check_program = mysqli_query($con, 'SELECT * FROM programs WHERE PROGRAM_NAME=\''.$_SESSION['program'].'\'');
$row = $check_program->fetch_assoc();

$check_everything = mysqli_query($con, 'SELECT * FROM users WHERE USERNAME=\'' . $_SESSION['username'] . '\'');
$row1 = mysqli_fetch_array($check_everything);
$check_license = mysqli_query($con, 'SELECT * FROM license WHERE PROGRAM=\'' . $_SESSION['program'] . '\'');
$check_license1 = mysqli_query($con, 'SELECT * FROM logs WHERE PROGRAM=\'' . $_SESSION['program'] . '\'');
$row3 = mysqli_fetch_array($check_license);
$res_b = $check_license;
$res_c = $check_license1;

if(isset($_POST['PurgeLogs']))
{
    mysqli_query($con, 'DELETE FROM `logs` WHERE `USER_ID` = \'' . $_SESSION['ID'] . '\' AND `PROGRAM` = \'' . $_SESSION['program'] . '\'');
    fnx("Logs.php");
} 

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
	<style>
      .hidden{
    display: none;
    }
	.blured {
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
	<link rel="shortcut icon" href="../assets/images/favicon.png" /> </head>

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
								<h5 class="mb-0 font-weight-normal"><?php echo $_SESSION['username'];?></h5> <span>User ID: <?php echo $_SESSION['ID'];?></span> </div>
						</div>
						<a href="#" id="profile-dropdown" data-toggle="dropdown"></a>
						<div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
							<a href="#" class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-settings text-primary"></i> </div>
								</div>
								<div class="preview-item-content">
									<p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-onepassword  text-info"></i> </div>
								</div>
								<div class="preview-item-content">
									<p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-calendar-today text-success"></i> </div>
								</div>
								<div class="preview-item-content">
									<p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
								</div>
							</a>
						</div>
					</div>
				</li>
				<li class="nav-item nav-category"> <span class="nav-link">Main</span> </li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="index.php"> <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span> <span class="menu-title">Dashboard</span> </a>
				</li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="downloads.php"> <span class="menu-icon">
                <i class="mdi mdi-download"></i>
              </span> <span class="menu-title">Downloads</span> </a>
				</li>
				<li class="nav-item nav-category"> <span class="nav-link">Management</span> </li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="Settings.php"> <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
              </span> <span class="menu-title">Settings</span> </a>
				</li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="License.php"> <span class="menu-icon">
                <i class="mdi mdi-key-variant"></i>
              </span> <span class="menu-title">All Licenses</span> </a>
				</li>
                <li class="nav-item menu-items">
					<a class="nav-link" href="Resellerlicense.php"> <span class="menu-icon">
                <i class="mdi mdi-key-variant"></i>
              </span> <span class="menu-title">Reseller Licenses</span> </a>
				</li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="Resellers.php"> <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span> <span class="menu-title">Resellers</span> </a>
				</li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="Responses.php"> <span class="menu-icon">
                <i class="mdi mdi-server"></i>
              </span> <span class="menu-title">Responses</span> </a>
				</li>
				<li class="nav-item nav-category"> <span class="nav-link">Information</span> </li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="Bans.php"> <span class="menu-icon">
                <i class="mdi mdi-close"></i>
              </span> <span class="menu-title">Bans</span> </a>
				</li>
				<li class="nav-item menu-items">
					<a class="nav-link" href="Logs.php"> <span class="menu-icon">
                <i class="mdi mdi-server"></i>
              </span> <span class="menu-title">Logs</span> </a>
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
					<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize"> <span class="mdi mdi-menu"></span> </button>
					<ul class="navbar-nav navbar-nav-right">
						<li class="nav-item dropdown d-none d-lg-block">
							<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
								<h6 class="p-3 mb-0">Projects</h6>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item preview-item">
									<div class="preview-thumbnail">
										<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-file-outline text-primary"></i> </div>
									</div>
									<div class="preview-item-content">
										<p class="preview-subject ellipsis mb-1">Software Development</p>
									</div>
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item preview-item">
									<div class="preview-thumbnail">
										<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-web text-info"></i> </div>
									</div>
									<div class="preview-item-content">
										<p class="preview-subject ellipsis mb-1">UI Development</p>
									</div>
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item preview-item">
									<div class="preview-thumbnail">
										<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-layers text-danger"></i> </div>
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
								<div class="navbar-profile"> <img class="img-xs rounded-circle" src="../assets/images/faces/face15.jpg" alt="">
									<p class="mb-0 d-none d-sm-block navbar-profile-name">
										<?php echo $_SESSION['username'];?>
									</p> <i class="mdi mdi-menu-down d-none d-sm-block"></i> </div>
							</a>
							<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
								<h6 class="p-3 mb-0">Profile</h6>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item preview-item">
									<div class="preview-thumbnail">
										<div class="preview-icon bg-dark rounded-circle"> <i class="mdi mdi-settings text-success"></i> </div>
									</div>
									<div class="preview-item-content">
										<form method="post">
											<button style="background-color: #191C24; border-color: #191C24;" class="btn btn-primary btn-sm">Settings</button>
										</form>
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
					<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas"> <span class="mdi mdi-format-line-spacing"></span> </button>
				</div>
			</nav>
			<!-- partial -->
			<div class="main-panel">
          <div class="content-wrapper">
		  
		<div class="row">
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-9">
								<div class="d-flex align-items-center align-self-start">
									<h4 class="mb-0"><?php echo $row1[3];?></h4> </div>
							</div>
							<div class="col-3">
								<div class="icon icon-box-success "> <span class="mdi mdi-cloud-check icon-item"></span> </div>
							</div>
						</div>
						<h6 class="text-muted font-weight-normal">Account Package</h6> </div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-9">
								<div class="d-flex align-items-center align-self-start">
									<h4 class="mb-0"><?php if ($row1[3] == "Unlimited Plan") {
                            echo "$20";
                          }
                          elseif($row1[3] == "Ultimate Plan")
                          {
                            echo "$15";
                          }
                          elseif ($row1[3] == "Starter Plan")
                          {
                            echo "$10";
                          }
                        
                          ?></h4> </div>
							</div>
							<div class="col-3">
								<div class="icon icon-box-success"> <span class="mdi mdi-cash-multiple icon-item"></span> </div>
							</div>
						</div>
						<h6 class="text-muted font-weight-normal">Purchase Package</h6> </div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-9">
								<div class="d-flex align-items-center align-self-start">
									<h4 class="mb-0"><?php echo mysqli_num_rows($res_b); ?></h4> </div>
							</div>
							<div class="col-3">
								<div class="icon icon-box-success"> <span class="mdi mdi-server-network icon-item"></span> </div>
							</div>
						</div>
						<h6 class="text-muted font-weight-normal">Licenses</h6> </div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-9">
								<div class="d-flex align-items-center align-self-start">
									<h4 class="mb-0"><?php echo $row1[4];?></h4> </div>
							</div>
							<div class="col-3">
								<div class="icon icon-box-success "> <span class="mdi mdi-speedometer icon-item"></span> </div>
							</div>
						</div>
						<h6 class="text-muted font-weight-normal">Account Expiry</h6> </div>
				</div>
			</div>
		</div>
        <div class="row ">
			<div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Log Actions</h4>
                <div class="row">
                <form method="post">
                              <button style="margin-left: 10px" onclick="return confirm('Are You Sure You Want To Delete All Logs')"type="submit" name="PurgeLogs" class="btn btn-outline-danger btn-md">Purge Logs</button>
                            </form>
                           
                            
                           
                </div>
                </div>
                </div> 
                </div>
                </div>
               
		<div class="row ">
			<div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Licenses</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                        <th>ID</th>
                        <th>License</th>
                        <th>IP</th>
                        <th>Server</th>
                        <th>Time</th>
                        <th>Log</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($res_c as $rows): if ($rows['USER_ID'] == $_SESSION['ID'] && $rows['PROGRAM'] == $_SESSION['program']) {?>
                          <tr>
                          <td><?php echo $rows['ID']; ?></td>
                        <td><?php echo $rows['KEY']; ?></td>
                        <td><?php echo $rows['IP']; ?></td>
                        <td>Yes</td>
                        <td><?php echo $rows['TIME']; ?></td>
                        <td><?php echo $rows['ACTION']; ?></td>
                     
                       
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
	
		  <div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Compensate All Keys For Program: <?php echo $_SESSION['program'];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Day(s)</label>
                                <input type="text" placeholder="E.g 1" name="CompensateAllDay1"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Hour(s)</label>
                                <input type="text" placeholder="E.g 1" name="CompensateAllHour1"class="form-control" id="recipient-name">
                              </div>
                          </div>
						 
                          <div class="modal-footer">
                            <button type="submit" name="CompensateAll1"class="btn btn-primary">Compensate</button>
                            </form>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
    


					<div class="modal fade" id="exampleModal-5" tabindex="-1" role="dialog" aria-labelledby="ModalLabel1" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel1">Compensate Key ID: <?php echo $_POST['singular'];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Day(s)</label>
                                <input type="text" placeholder="E.g 1" name="CompensateAllDay1"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Hour(s)</label>
                                <input type="text" placeholder="E.g 1" name="CompensateAllHour1"class="form-control" id="recipient-name">
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" value="<?php echo $_POST['singular'];?>" name="CompensateAll1"class="btn btn-primary">Compensate</button>
                            </form>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					<div class="modal fade" id="exampleModal-6" tabindex="-1" role="dialog" aria-labelledby="ModalLabel2" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel1">Ban Key ID: <?php echo $_POST['singular1'];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ban Reason</label>
                                <input type="text" placeholder="Debugger" name="reason"class="form-control" id="recipient-name">
                              </div>
							
                          </div>
                          <div class="modal-footer">
                            <button type="submit" value="<?php echo $_POST['singular1'];?>" name="ban"class="btn btn-danger">Ban</button>
                            </form>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
          



					
					<div class="modal fade" id="exampleModal-0" tabindex="-1" role="dialog" aria-labelledby="ModalLabel0" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel1">Create Keys For Program: <?php echo $_SESSION['program'];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post">
                              <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Custom Key</label>
                                <input type="text" placeholder="Leave Blank For Random Key" name="custom"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Key Level</label>
                                <input type="number" placeholder="Leave Empty For Default" name="Level"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Duration (DAYS)</label>
                                <input type="number" placeholder="Enter Duration In Days" min="1" required name="duration"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Bulk Keys</label>
                                <input type="number" placeholder="Leave Empty For Singular" max="100" name="bulk"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Key Length (Min: 5) (Max: 30)</label>
                                <input type="number" placeholder="Number" min="5" max="30" required name="length"class="form-control" id="recipient-name">
                              </div>
							  <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Case</label>
                                <select required name="case" class="form-control">
									<option>Upper Case</option>
									<option>Lower Case</option>
									<option>Mixed Case</option>
							</select>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="createkeys1"class="btn btn-primary">Create</button>
                            </form>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
					<!-- content-wrapper ends -->
					<!-- partial:partials/_footer.html -->
					<footer class="footer">
						<div class="d-sm-flex justify-content-center justify-content-sm-between"> <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ?? <?php echo date("Y"); ?> <a style="color: #0090E7;"href="https://accode.xyz" target="_blank">accode.xyz</a>. All rights reserved.</span> </div>
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
<?php

?>