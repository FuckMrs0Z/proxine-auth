<?php

$mysqli = new mysqli("localhost", "vrwylncx_auth", "XmFvH]f1cI0%", "vrwylncx_auth");

if($mysqli === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());

}

$apikey = $_GET['api'];

$action = $_GET['action'];

$type = $_GET['type'];

$program = $_GET['program'];

$amount = $_GET['amount'];

$key = $_GET['key'];

$level = $_GET['level'];

$hours = $_GET['hours'];

$hwid = $_GET['hwid'];

$userid = $_GET['userid'];

$reason = $_GET['reason'];

$check_user = mysqli_query($mysqli, 'SELECT * FROM `users` WHERE `API_KEY` = \''.$apikey.'\'');

$row = $check_user->fetch_assoc();

$check_program = mysqli_query($mysqli, 'SELECT * FROM programs WHERE `PROGRAM_NAME`= \''.$program.'\'');

$row1 = $check_program->fetch_assoc();

$check_pi = mysqli_query($mysqli, 'SELECT * FROM license WHERE PROGRAM=\''.$program.'\'');

$username = $row['USERNAME'];

$sqlapi = $row['API_KEY'];

$sql1 = 'SELECT * FROM `license` WHERE `KEY` = \''.$key.'\'';

$res_b = $mysqli->query($sql1);

$res_b = $res_b->fetch_assoc();


if ($row1['PROGRAM_USER'] != $row['USERNAME'])
{

    die("APIFailure.");
}

if ($res_b['KEY'] != $key)
{

    die("InvalidLicense.");

}
if ($action == "info")
{

    $curr = date('Y-m-d H:i:s');
    $check_time = new DateTime($res_b['EXPIRY']);
    $now_time = new DateTime($curr);
    if ($now_time>=$check_time)
    {
        die("ExpiredLicense.");
    }
    if ($res_b['BANNED'] == "Yes")
    {
        die("BannedLicense.");
    }

    $keyinfo = [

        'key' => $res_b['KEY'],

        'hwid' => $res_b['HWID'],

        'expiry' => $res_b['EXPIRY'],

        'level' => $res_b['LEVEL'],

    ];

    die("Success.");
    //die(json_encode($keyinfo));

}

$mysqli->close();

?>