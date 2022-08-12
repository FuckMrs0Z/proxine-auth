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


function generatemixeda($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwyxzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function key_gen(){

	return generatemixeda(4) . "-" . generatemixeda(4) . "-" . generatemixeda(4). "-" . generatemixeda(4);

}

$type1 = strtolower($type);

$type2 = ucwords($type1);

if ($row1['PROGRAM_USER'] != $row['USERNAME'])

{

    $apim = [

        'error' => 'API Mismatch',

    ];

    die(json_encode($apim));

}

if ($res_b['KEY'] != $key)

{

    $invalid = [

        'error' => 'Invalid Key',

    ];

    die(json_encode($invalid));

}

if ($action == "create")

{

    $key2 = key_gen();

    mysqli_query($mysqli, 'INSERT INTO `license`(`KEY`, `DURATION`, `PROGRAM`, `LEVEL`, `USER_ID`) VALUES (\''.$key2.'\', \''.$type2.'\', \''.$program.'\',  \''.$level.'\', \''.$row['ID'].'\')');
   
    $compen = [

        'created' => $key2,

    ];

    die(json_encode($compen));

}



if ($action == "reset")

{

    mysqli_query($mysqli, 'UPDATE `license` SET `HWID` = "Waiting for user" WHERE ID = \''.$res_b['ID'].'\'');

    $reset = [

        'reset' => $key,

    ];

    die(json_encode($reset));

}

if ($action == "reset1")

{

    $new = date('Y-m-d', strtotime($Date. ' + 3 days'));

    mysqli_query($mysqli, 'UPDATE `license` SET `HWID` = "Waiting For User" WHERE ID = \''.$res_b['ID'].'\'');

    mysqli_query($mysqli, 'UPDATE `license` SET `NEXT_RESET` = \''.$new.'\' WHERE ID = \''.$res_b['ID'].'\'');

    $reset = [

        'reset' => $key,

        'newdate' => $new,

    ];

    die(json_encode($reset));

}

if ($action == "delete")

{

    mysqli_query($mysqli, 'DELETE FROM `license` WHERE ID = \''.$res_b['ID'].'\'');

    $delete= [

        'deleted' => $key,

    ];

    die(json_encode($delete));

}

if ($action == "comp")

{

    $time = new DateTime($res_b['EXPIRY']);

    $custom = '+' .$hours.' hour';

    $time->modify($custom);

    mysqli_query($mysqli, 'UPDATE `license` SET `EXPIRY` = \''.$time->format('Y-m-d H:i:s').'\' WHERE ID = \''.$res_b['ID'].'\'');

    $compen = [

        'key' => $res_b['Key'],

        'hours added' => $hours,

    ];

    die(json_encode($compen));

}

if ($amount >= 251)

{

    $am = [

        'limit' => '250 or lower',

    ];

    die(json_encode($programinfo));

}

if ($action == "bulk")

{

   

    for($i=0;$i<$amount;$i++){

    $key2 = key_gen();

    mysqli_query($mysqli, 'INSERT INTO `license`(`KEY`, `DURATION`, `PROGRAM`, `LEVEL`, `USER_ID`) VALUES (\''.$key2.'\', \''.$type2.'\', \''.$program.'\',  \''.$level.'\', \''.$row['id'].'\')');

    $list .= nl2br($key2. "\n");

    }

    die($list);

}

if ($action == "programinfo")

{

    $programinfo = [

        'total program keys' => mysqli_num_rows($check_pi),

    ];

    die(json_encode($programinfo));



}

if ($action == "keyinfo")

{

    $keyinfo = [

        'key' => $res_b['KEY'],

        'hwid' => $res_b['HWID'],

        'expiry' => $res_b['EXPIRY'],

        'level' => $res_b['LEVEL'],

    ];

    die(json_encode($keyinfo));

}

if ($action == "keyinfo1")

{

    $keyinfo = [

        'success' => "Yes",

        'key' => $res_b['KEY'],

        'hwid' => $res_b['HWID'],

        'expiry' => $res_b['EXPIRY'],

        'level' => $res_b['LEVEL'],

        'nr' => $res_b['NEXT_RESET'],

    ];

    die(json_encode($keyinfo));

}

if ($action == "ban")

{

    mysqli_query($mysqli, 'UPDATE `license` SET `BANNED` = "Yes", `BANNED_REASON` = \''.$reason.'\' WHERE ID = \''.$res_b['ID'].'\'');

    $banstat = [

        'success' => "Yes",

        'hwid' => $hwid

    ];

    die(json_encode($banstat));

}

$mysqli->close();

?>