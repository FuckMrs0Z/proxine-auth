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
							<h1>Login</h1>
							<p class="text-muted">Sign in to your account</p>
              <form method="post">
							<select name="type" class="form-control mb-3 mb-3" style="background-color: #191C24;">
								<option>Developer Login</option>
								<option>Reseller Login</option>
							</select>
							<div class="input-group mb-3">
								<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
               
								<input class="form-control" type="text" name="loginUsername" placeholder="Username" style="background-color: #191C24;"> </div>
							<div class="input-group mb-4">
								<div class="input-group-prepend">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
								</div>
								<input class="form-control" type="password" name="loginPassword" placeholder="Password" style="background-color: #191C24;"> </div>
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
									<button name="login" style="width: 85px" class="btn btn-primary px-4 form-control" type="submit">Login</button>
                </form>
								</div>
							</div>
						</div>
					</div>
					<div class="card text-white bg-primary py-5 d-md-down-none" style="width:44% background-color: #3B2FA4;">
						<div class="card-body text-center">
							<div>
								<h2>Sign up</h2>
								<p>Welcome to accode login. If you do not have a login you have to sign up with your registration key.</p>
								<a href="register.php"><button class="btn btn-lg btn-outline-primary mt-3" style="color: #FFFFFF; border-color: #FFFFFF"type="button">Sign up here!</button></a>
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
$error = false;
$error_array = array();
if(isset($_POST['login']))
{
  if($_POST['type'] == "Developer Login")
  {
    Developerlogin();
  }
  elseif ($_POST['type'] == "Admin Login") {
    //call admin
  }
  elseif ($_POST['type'] == "Reseller Login") {
    Resellerlogin();
  }
}
function Developerlogin()
{
    include ("server.php");
    $username = $_POST['loginUsername'];
    $check_pass = $con->query("SELECT * FROM users WHERE USERNAME='$username'");
    $row3 = $check_pass->fetch_assoc();
    if (password_verify($_POST['loginPassword'], $row3['PASSWORD']))
    {
        $check_everything = $con->query("SELECT * FROM users WHERE USERNAME='" . mysqli_real_escape_string($con, $username) . "'");
        $check_users = mysqli_query($con, "SELECT * FROM users");
        $check_lics = mysqli_query($con, "SELECT * FROM license");
        $rowu = mysqli_num_rows($check_users);
        $rowl = mysqli_num_rows($check_lics);
        $row = mysqli_fetch_array($check_everything);
 
        $_SESSION['username'] = $row[1];
        $_SESSION['Success'] = true;
        $_SESSION['ID'] = $row[0];
        $_SESSION['num'] = $rowu;
        $_SESSION['lic'] = $rowl;
        $expire = $row[4];
        //die($row[4]);
        header("location: index.php");
    }
    else
    {
      echo '<script type="text/javascript">showDangerToast();</script>';
    }
	
}



function Resellerlogin()
{
    include ("rserver.php");
    $username = $_POST['loginUsername'];
    $check_pass = $con->query("SELECT * FROM resellers WHERE USERNAME='$username'");
    $row3 = $check_pass->fetch_assoc();
	$pass = md5($_POST['loginPassword']);
    if ($pass == $row3['PASSWORD'])
    {
        $check_everything = $con->query("SELECT * FROM resellers WHERE USERNAME='" . mysqli_real_escape_string($con, $username) . "'");
        $row = mysqli_fetch_array($check_everything);
        $_SESSION['username'] = $row[1];
        $_SESSION['Successr'] = true;
        $_SESSION['ID'] = $row[0];
        header("location: rindex.php");
    }
    else
    {
      echo '<script type="text/javascript">showDangerToast();</script>';
    }
	
}

?>
