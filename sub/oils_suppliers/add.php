<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$error_array = array();

if (isset($_POST['add_button']))
{
	$code = strip_tags($_POST['code']);
	$code = str_replace(' ', '', $code);
	$_SESSION['code'] = $code;

	$name = strip_tags($_POST['name']);
	$_SESSION['name'] = $name;

	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
	  $_SESSION['notes'] = $notes;
    }
    
		if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM oil_suppliers WHERE code='$code'  ")) > 0) array_push($error_array, "herecode") ;
	  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM oil_suppliers WHERE  name = '$name' ")) > 0) array_push($error_array, "herename") ;

	if(empty($error_array))
	{
		$query =mysqli_query($con , "INSERT INTO oil_suppliers(code, name, notes) VALUES ('$code', '$name', '$notes')");
		
		array_push($error_array, "pass") ;
		
		$_SESSION['code'] = "";
		$_SESSION['name'] = "";
		$_SESSION['notes']= "";
 echo "<script>
        alert(' تم الإضافة بنجاح ')
        window.location.href = 'index';
    </script>";
	}
}

// logout
if(isset($_POST['but_logout'])){

if (isset($_SESSION['userid'])) {
    unset($_SESSION['userid']);
    session_destroy();
}
 // Remove cookie variables
if (isset($_COOKIE['rememberme'])) {
    unset($_COOKIE['rememberme']);
  setcookie('rememberme', '', time() - 3600, '/mes'); // Empty value and old timestamp
}
    header('Location: ../../');
}
?>
<html>

<head>
  <meta charset="utf-8">
  <title>إضافة مورد - مخزن الزيوت والوقود</title>
  <link rel="stylesheet" type="text/css" href="../css/navbar.css">
  <link rel="stylesheet" type="text/css" href="../css/form.css">
  <link href="../../assets/images/icons/favicon.png" rel="icon">
</head>

<body>
    <form method='post' action="" id='the_form'>
        <input type="hidden"  name="but_logout">
    </form>
      <div class="nav">
  <ul>
    <li><a href="../..//main/oils_store" class="nav-link">الرئيسية</a></li>
    <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;" class="nav-link">تسجيل الخروج</a></li>
  </ul>
</div>
<div class="center">
  <h1>إضافة مورد - مخزن الزيوت والوقود</h1>
  <form method='post'>
    <div class="inputbox">
      <input type="text" required="required" name="code"  value="<?php if(isset($_SESSION['code']))echo $_SESSION['code'];?>">
      <span> كود المورد</span>
      <br>
    </div>
              <?php if(in_array("herecode", $error_array)) echo "<h3 style='font-weight:bold;color:red;'>كود المورد موجود بالفعل<br></h3>"; ?>

    <div class="inputbox">
      <input type="text" required="required" name="name"  value="<?php if(isset($_SESSION['name']))echo $_SESSION['name'];?>">
      <span> إسم المورد</span>
    </div>
              <?php if(in_array("herename", $error_array)) echo "<h3 style='font-weight:bold;color:red;'>اسم المورد موجود بالفعل<br></h3>"; ?>

    <div class="inputbox">
      <input type="text" required="required" name="notes"  value="<?php if(isset($_SESSION['notes']))echo $_SESSION['notes'];?>">
      <span> مجال التعامل</span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="add_button" value="حفظ البيانات">
    </div>
    
  </form>
</div>
</body>

</html>

