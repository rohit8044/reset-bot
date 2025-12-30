<?php
include 'init.php';
$crypter = Crypter::init();
$privatekey = readFileData("Keys/PrivateKey.prk");

date_default_timezone_set('Asia/Dhaka');

function tokenResponse($data){
    global $crypter, $privatekey;
    $data = toJson($data);
    $datahash = sha256($data);
    $acktoken = array(
        "Data" => profileEncrypt($data, $datahash),
        "Sign" => toBase64($crypter->signByPrivate($privatekey, $data)),
        "Hash" => $datahash
    );
    return toBase64(toJson($acktoken));
}

//token data
$token = fromBase64($_POST['token']);
$tokarr = fromJson($token, true);

//Data section decrypter
$encdata = $tokarr['Data'];
$decdata = trim($crypter->decryptByPrivate($privatekey, fromBase64($encdata)));
$data = fromJson($decdata);

//Hash Validator
$tokhash = $tokarr['Hash'];
$newhash = sha256($encdata);

if (strcmp($tokhash, $newhash) == 0) {
    PlainDie();
}

$sql1 ="select * from server where srv_id=1";
$result1 = mysqli_query($con, $sql1);
$tatus = mysqli_fetch_assoc($result1);
        
if($tatus['server_h_status'] == 'offline'){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Apk Offline!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

//Username Validator
$uname = $data["uname"];
if($uname == null || preg_match("([a-zA-Z0-9]+)", $uname) === 0){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Invalid Username Format",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

//Password Validator
$pass = $data["pass"];
if($pass == null || !preg_match("([a-zA-Z0-9]+)", $pass) === 0){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Invalid Password Format",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}



$query = $con->query("SELECT * FROM `panel` WHERE `_username` = '".$uname."' AND `_password` = '".$pass."'");
if($query->num_rows < 1){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username Or Password Is Incorrect",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

$res = $query->fetch_assoc();

if($res["_reg_date"] == 'NULL'){
    $query = $con->query("UPDATE `panel` SET `_reg_date` = CURRENT_TIMESTAMP WHERE `_username` = '$uname'");
}

if($res["_exp_date"] == 'NULL'){
    
    $query = $con->query("UPDATE `panel` SET `_exp_date` = '$add_days' WHERE `_username` = '$uname'");
}

$uidup = $data["cs"];

if($res["_uid"] == NULL){
    $query = $con->query("UPDATE `panel` SET `_uid` = '$uidup' WHERE `_username` = '".$uname."' AND `_password` = '".$pass."'");
}

else if($res["_uid"] != $uidup) {
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Invalid Device Detected!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["expired"] < $res["registered"]){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "login expired!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_status"] == "banned"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username Banned!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_p_status"] == "unpaid"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Your Username is Free!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_user_type"] == "admin"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "User Not Available!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_user_type"] == "reseller"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "User Not Available!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_user_type"] == "owner"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "User Not Available!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

$uidup = $data["cs"];

if($res["_version"] == "free"){
    $query = $con->query("UPDATE `panel` SET `_uid` = '$NULL'  WHERE `_username` = '".$uname."' AND `_password` = '".$pass."'");
}

if($tatus["server_status"] == "offline"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Server Offline!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($tatus["server_status"] == "main"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Server Maintenance!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($tatus["server_h_status"] == "main"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Apk Maintenance!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($tatus["server_h_status"] == "offline"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Apk Offline!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["_v_status"] == "not-verified"){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username Not Verified!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}



if(strtotime(date("Y/m/d h:i")) > strtotime($res['_exp_date'])){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Login expired!",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}






$ackdata = array(
    "Status" => "Success",
    "MessageString" => "",
    "SubscriptionLeft" => $res["_exp_date"],
    "Validade" => $res["_exp_date"],
    "Title" => $title,
   "icon" => $icon,
   "isactive" => $isactive,
  "Username" => $res["_username"],
    "Vendedor" => $res["_registrar"],
    "RegisterDate" => $res["_reg_date"],
    $database = date_create($res["_exp_date"]),
$datadehoje = date_create(),
$resultado = date_diff($database, $datadehoje),
$dias = date_interval_format($resultado, '%a'),
"Dias" => "$dias Days Remaining"
);

echo tokenResponse($ackdata);
