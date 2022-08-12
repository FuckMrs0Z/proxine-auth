<?php
$mysqli = new mysqli("localhost", "vrwylncx_auth", "XmFvH]f1cI0%", "vrwylncx_auth");
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$key = $_GET['id'];
$hours = $_GET['hours'];
$programid = $_GET['program'];
$action = $_GET['action'];
$sql1 = 'SELECT * FROM `license` WHERE `KEY` = \''.$key.'\'';
$res_b = $mysqli->query($sql1);
$res_b = $res_b->fetch_assoc();

if ($action == "add")
{
    $time = new DateTime($res_b['EXPIRY']);
    $custom = '+' .$hours.' hour';
    $time->modify($custom);
    mysqli_query($mysqli, 'UPDATE `license` SET `EXPIRY` = \''.$time->format('Y-m-d H:i:s').'\' WHERE ID = \''.$res_b['ID'].'\' AND `USER_ID` = "38"');
    $compen = [
        'key' => $res_b['KEY'],
        'hours added' => $hours,
    ];
    die(json_encode($compen));
}
if ($action == "remove")
{
    $time = new DateTime($res_b['EXPIRY']);
    $custom = '-' .$hours.' hour';
    $time->modify($custom);
    mysqli_query($mysqli, 'UPDATE `license` SET `EXPIRY` = \''.$time->format('Y-m-d H:i:s').'\' WHERE ID = \''.$res_b['ID'].'\' AND `USER_ID` = "38"');
    $compen = [
        'key' => $res_b['KEY'],
        'hours removed' => $hours,
    ];
    die(json_encode($compen));
}
$mysqli->close();
?>