<?php
$mysqli = new mysqli("localhost", "vrwylncx_auth", "XmFvH]f1cI0%", "vrwylncx_auth");
    if($mysqli === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $iid = $_GET['id'];
    $uuid = $_GET['uuid'];
    $hhwid = $_GET['hwid'];
    $iiv  = $_GET['current']; // 16 bytes 
    $ppid = $_GET['a'];
    $h = $_GET['h'];
    $ppn = $_GET['ppn'];
    $pn = hex2bin($ppn);
    $sql4 = 'SELECT * FROM `programs` WHERE `PROGRAM_NAME` = "'.$pn.'"';
    $res_z = $mysqli->query($sql4);
    $res_z = $res_z->fetch_assoc();
    $key = $res_z['ENCRYPTION']; // 32 bytes
    $method = 'aes-256-cfb';
    $curr = date('Y-m-d H:i:s');
    $id = hex2bin($iid);
    $iv = hex2bin($iiv);
    $hwid = hex2bin($hhwid);
    $uid = openssl_decrypt($uuid, $method, $key, false, $iv);
    $pid = openssl_decrypt($ppid, $method, $key, false, $iv);
    //die($pid. " ..................        ". $uid . "");
    $sql = 'SELECT * FROM `license` WHERE `KEY` = "'.$id.'"';
    $sql1 = 'SELECT * FROM `programs` WHERE `PROGRAM_ID` = "'.$pid.'"';
    $res_b = $mysqli->query($sql);
    $res_b = $res_b->fetch_assoc();
    $res_c = $mysqli->query($sql1);
    $res_c = $res_c->fetch_assoc();

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if ($id == NULL)
    {
        die("{Invalid Format} MYSQL SYNTAX ERROR, COULD NOT FIND TABLE {#0}, {IP, HWID, TIME, KEY}");
    }
    if ($uid == NULL)
    {
        die("{Invalid Format} MYSQL SYNTAX ERROR, COULD NOT FIND TABLE {#0}, {IP, HWID, TIME, KEY}");
    }
if ($res_c['DISABLED'] == "Yes")
{
die(base64_encode( openssl_encrypt ("ZSTD4HC0X31OYP5". ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv))); // disabled application
}
if ($res_b['USER_ID'] != $uid)
{
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_INVALID']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv)));// Invalid Key
}
if ($res_c['PROGRAM_NAME'] != $res_b['PROGRAM'])
{
die(base64_encode( openssl_encrypt ($res_c['RESPONSE_INVALID']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv)));// Invalid Key
}
if ($res_c['HASH_ENABLED'] == "Yes")
{
    if ($res_c['HASH'] != $h)
    {
        die(base64_encode( openssl_encrypt ($res_c['RESPONSE_HASH']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv)));// Invalid hash
    }
}
#   ------    New Key    ------ #
   
       
        if ($res_b['DURATION'] == "Hour")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 2 hours'));
        }
        elseif ($res_b['DURATION'] == "Day")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 1 days'));
        }
        elseif ($res_b['DURATION'] == "Week")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 7 days'));
        }
        elseif ($res_b['DURATION'] == "Month")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 30 days'));
        }
        elseif ($res_b['DURATION'] == "3 Months")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 90 days'));
        }
        elseif ($res_b['DURATION'] == "6 Months")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 180 days'));
        }
        elseif ($res_b['DURATION'] == "1 Year")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 366 days'));
        }
        elseif ($res_b['DURATION'] == "Lifetime")
        {
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + 5000 days'));
        }
        else
        {
            $gay = $res_b['DURATION'];
            $gay1 = $gay . ' days';
            $new = date('Y-m-d H:i:s', strtotime($Date. ' + '. $gay1));
        }
   
    #   ------    New HWID    ------ #
    if ($res_b['HWID'] == "Waiting for user" || $res_b['HWID'] == "Waiting For User")
    {
        if ($res_b['EXPIRY'] == "Not set" || $res_b['EXPIRY'] == "Not Set")
        {
            $sql = 'UPDATE `license` SET `EXPIRY` = "'.$new.'" WHERE `KEY` = "'.$id.'"';
            $les = mysqli_query($mysqli, $sql);
            $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Login", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
            $less = mysqli_query($mysqli, $sqls);
        }
        $sql = 'UPDATE `license` SET `HWID` = "'.$hwid.'" WHERE `KEY` = "'.$id.'"';
        $le = mysqli_query($mysqli, $sql);
        $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Login", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
        $less = mysqli_query($mysqli, $sqls);
        die(base64_encode( openssl_encrypt ($res_c['RESPONSE_SUCCESS'].".".$res_b['LEVEL']. ".".bin2hex($res_b['EXPIRY']), $method, $key, true, $iv)));// Success
    }
#   ------    Real Login Checks    ------ #
if ($id != $res_b['KEY'])
{
    $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Invalid Key", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
    $less = mysqli_query($mysqli, $sqls);
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_INVALID']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv)));// Invalid Key
}
$check_time = new DateTime($res_b['EXPIRY']);
$now_time = new DateTime($curr);
if ($now_time>=$check_time)
{
    $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Expired", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
    //$sqlsss = 'DELETE FROM `license` WHERE `KEY` = "'.$id.'"';
    $less = mysqli_query($mysqli, $sqls);
   // $lessss = mysqli_query($mysqli, $sqlsss);
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_EXPIRED']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv))); // Expired
}
if ($res_b['BANNED'] == "Yes")
{
    $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Invalid Hwid", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
    $less = mysqli_query($mysqli, $sqls);
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_BANNED']. ".0.". bin2hex($res_b['BANNED_REASON']), $method, $key, true, $iv)));// Banned
}
if ($id == $res_b['KEY'] && $hwid == $res_b['HWID'])
{
    $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Login", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
    $less = mysqli_query($mysqli, $sqls);
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_SUCCESS'].".".$res_b['LEVEL']. ".".bin2hex($res_b['EXPIRY']), $method, $key, true, $iv)));// Success
}
if ($id == $res_b['KEY'] && $hwid != $res_b['HWID'])
{
    $sqls = 'INSERT INTO `logs`(`KEY`, `HWID`, `IP`, `TIME`, `ACTION`, `USER_ID`, `PROGRAM`) VALUES ("'.$id.'", "'.$hwid.'", "'.$ip.'", "'.$curr.'", "Invalid Hwid", "'.$uid.'", "'.$res_c['PROGRAM_NAME'].'")';
    $less = mysqli_query($mysqli, $sqls);
    die(base64_encode( openssl_encrypt ($res_c['RESPONSE_HWID']. ".0.". bin2hex("hahahahahalol rtrt"), $method, $key, true, $iv)));// Invalid HWID
}

    $mysqli->close();
?>
  

