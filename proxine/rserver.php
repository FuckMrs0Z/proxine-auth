<?php
include("session.php");
$con = mysqli_connect("localhost", "vrwylncx_auth", "XmFvH]f1cI0%", "vrwylncx_auth");
if(mysqli_connect_error()){
	echo "Failed to connect: " + mysqli_connect_error();
}
function checklogin() {
	if(isset($_SESSION['Successr']) && $_SESSION['Successr'] == true ) {
		return true;
	} else {
		return false;
	}
}

function notloggedin($customMessage = false) {
	if( $customMessage == false ) {
		header("Location: /");
		die();
	} else {
		die($customMessage);
	}
}

function ShowError($msg) {
	header("Location: /?error=" . base64_encode($msg));
	die();
}

function ShowSuccess($msg) {
	header("Location: /?success=" . base64_encode($msg));
	die();
}

function getUserIP() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>