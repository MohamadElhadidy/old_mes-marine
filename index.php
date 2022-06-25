<?php

$error_array = array();

include "config.php";

// Check if $_SESSION or $_COOKIE already set
if( isset($_SESSION['userid']) ){
    
    $userid =$_SESSION['userid'];
    $sql_query = "select count(*) as cntUser,id,username from users where id='".$userid."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_array($result);
      
  $count = $row['cntUser'];
  $uname = $row['username'];

  if( $count > 0 ){
     $_SESSION['userid'] = $userid; 
        if($uname == "equip") header('Location: main/equipments');
        if($uname == "spare") header('Location: main/spares_store');
        if($uname == "oil") header('Location: main/oils_store');
        if($uname == "reports") header('Location: main/reports');
     exit;
  }
}else if( isset($_COOKIE['rememberme'] )){
 
  // Decrypt cookie variable value
  $userid = decryptCookie($_COOKIE['rememberme']);
 
  $sql_query = "select count(*) as cntUser,id,username from users where id='".$userid."'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_array($result);

  $count = $row['cntUser'];
  $uname = $row['username'];
  if( $count > 0 ){
     $_SESSION['userid'] = $userid; 
        if($uname == "equip") header('Location: main/equipments');
        if($uname == "spare") header('Location: main/spares_store');
        if($uname == "oil") header('Location: main/oils_store');
        if($uname == "reports") header('Location: main/reports');
     exit;
  }
}

// Encrypt cookie
function encryptCookie( $value ) {

   $key = hex2bin(openssl_random_pseudo_bytes(4));

   $cipher = "aes-256-cbc";
   $ivlen = openssl_cipher_iv_length($cipher);
   $iv = openssl_random_pseudo_bytes($ivlen);

   $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);

   return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );
}

// Decrypt cookie
function decryptCookie( $ciphertext ) {

   $cipher = "aes-256-cbc";

   list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
   return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);

}

// On submit
if(isset($_POST['but_submit'])){

  $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
  $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);
 
  if ($uname != "" && $password != ""){

     $sql_query = "select count(*) as cntUser,id from users where username='".$uname."' and password='".$password."'";
     $result = mysqli_query($con,$sql_query);
     $row = mysqli_fetch_array($result);

     $count = $row['cntUser'];

     if($count > 0){
        $userid = $row['id'];
        if( isset($_POST['rememberme']) ){

           // Set cookie variables
           $days = 30;
           $value = encryptCookie($userid);
           setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
        }
 
        $_SESSION['userid'] = $userid; 

        if($uname == "equipment") header('Location: main/equipments_places_manufacturing');
        if($uname == "spare") header('Location: main/spares_store');
        if($uname == "oil") header('Location: main/oils_store');
        if($uname == "reports") header('Location: main/reports');
        if($uname == "follow") header('Location: main/follow');
        if($uname == "cost") header('Location: main/costs');
        if($uname == "view") header('Location: main/view');
      
        exit;
     } else{
       array_push($error_array, "fail");  
     }

  }else array_push($error_array, "fail");  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="assets/images/icon.png"/>
    <title>منظومة إدارة المخازن وصيانه المعدات </title>
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<div class="login-card">
  <div class="login-card-content">
    <div class="header">
      <div class="logo">
        <div> <img src="assets/images/logotop.png" alt="Marine Company" class="center"></div>
      </div>
      <h2>MARINE<span class="highlight">COMPANY</span></h2>
    </div>
    <form class="form"     method="POST" autocomplete="off">
      <div class="form-field username">
        <div class="icon">
          <i class="far fa-user"></i>
        </div>
		<input type="hidden" name="rememberme" value="1" />
        <input type="text" name="txt_uname"  placeholder="اسم المستخدم">

      </div>
      <div class="form-field password">
        <div class="icon">
          <i class="fas fa-lock"></i>
        </div>
        <input type="password"  name="txt_pwd"placeholder="كلمه المرور" id='password-input'>
        <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
      </div>
        <input type="submit" value="تسجيل الدخول" name="but_submit" />
     
       <?php
if(in_array("fail", $error_array)) echo "<h3 ><span  class='highlight'>اسم الدخول أو الرقم السري غير صحيح</span></h3>"; 
?>
    </form>
  </div>

</div>
    <script src="assets/js/showPassword.js"></script>
</body>
</html>