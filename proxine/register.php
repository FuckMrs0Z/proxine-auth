<?php
ob_start();
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <script src="../assets/js/toastDemo.js"></script>
  <script src="../assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<title>accode</title>
	<link href="style.css" rel="stylesheet">
  <link href="../assets/vendors/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
	<meta name="robots" content="noindex">
	<style>
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active
{
 -webkit-box-shadow: 0 0 0 30px #191C24 inset !important;
 -webkit-text-fill-color: white !important;
}

	footer {
		position: relative;
		height: 300px;
		width: 100%;
	}
	p.copyright {
		position: absolute;
		width: 100%;
		color: #fff;
		line-height: 40px;
		font-size: 0.7em;
		text-align: center;
		bottom: 0;
	}
  .hidden{
    display: none;
    }
	</style>
</head>
<body class="c-app c-dark-theme flex-row align-items-center">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card-group">
					<div class="card p-4">
						<div class="card-body">
							<h1>Sign up</h1>
							<p class="text-muted">Register your account</p>
              <form method="post">
							<select name="type" class="form-control mb-3 mb-3" style="background-color: #191C24;">
								<option>Developer</option>
							</select>
							<div class="input-group mb-3">
								<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
               
								<input class="form-control" type="text" name="loginUsername" placeholder="Username" style="background-color: #191C24;"> </div>
                                
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
								</div>
								<input class="form-control" type="password" name="loginPassword" placeholder="Password" style="background-color: #191C24;"> </div>
                                <div class="input-group mb-4">
								<div class="input-group-prepend">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
								</div>
								<input class="form-control" type="text" name="loginKey" placeholder="License" style="background-color: #191C24;"> </div>
                <div id="textn" class="alert alert-danger hidden" style="background-color: #46232C; border-color: #e83d44; color: #c03238; height: 47px;" role="alert"> Invalid Login. </div>
                <script type="text/javascript">
                  function test(){
                   var element = document.getElementById("textn");
                          element.classList.remove("hidden");
                                       }
               </script>
							<div class="row">
								<div class="col-6">
                <form method="post">
									<button name="login" style="width: 120px" class="btn btn-primary px-4 form-control" type="submit">Sign up</button>
                </form>
								</div>
							</div>
						</div>
					</div>
					<div class="card text-white bg-primary py-5 d-md-down-none" style="width:44% background-color: #3B2FA4;">
						<div class="card-body text-center">
							<div>
								<h2>Sign up</h2>
								<p>If you do not have a login you may sign up with your registration key here.</p>
							    <p>Registration keys can only be given by administrators.</p>	
								<!-- <button class="btn btn-lg btn-outline-primary mt-3" style="color: #FFFFFF; border-color: #FFFFFF"type="button">Sign up now!</button> -->
                </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
include("server.php");
$error = false;
$error_array = array();
if(isset($_POST['login']))
{
    $key = $_POST['loginKey'];
    $check_everything = mysqli_query($con, "SELECT * FROM kkey WHERE keystring='". mysqli_real_escape_string($con, $key) ."'");
    $row = mysqli_fetch_array($check_everything);
    $type = $row[2];
    if ($type == "Unlimited Plan")
    {
      $new = date('Y-m-d', strtotime($Date. ' + 10 Year'));
    }
    elseif ($type == "Ultimate Plan")
    {
      $new = date('Y-m-d', strtotime($Date. ' + 180 Days'));
    }
    elseif ($type == "Starter Plan")
    {
      $new = date('Y-m-d', strtotime($Date. ' + 90 Days'));
    }
    if(mysqli_num_rows($check_everything) == 1){
          $register_username = $_POST['loginUsername'];
          $register_password = password_hash($_POST['loginPassword'], PASSWORD_DEFAULT);
          $regkey = $_POST['loginKey'];
          $lastquery = mysqli_query($con, "INSERT INTO users (USERNAME, PASSWORD, ACCOUNT_TYPE, ACCOUNT_EXPIRY, REGISTRATION_KEY) VALUES ('".$register_username."', '". mysqli_real_escape_string($con, $register_password) ."', '".$type."', '".$new."', '".$regkey."')");
        //  die("INSERT INTO users (USERNAME, PASSWORD, ACCOUNT_TYPE, ACCOUNT_EXPIRY, REGISTRATION_KEY) VALUES ('".$register_username."', '". mysqli_real_escape_string($con, $register_password) ."', '".$type."', '".$new."', '".$regkey."')");
          $anotherlastquery = mysqli_query($con, "DELETE FROM kkey WHERE keystring='".$_POST['loginKey']."'");
          header('location: login.php');
    }
    else{
      $error = true;
    }
}

?>
