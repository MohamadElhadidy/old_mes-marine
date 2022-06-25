<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$GLOBALS['id'] = $_GET['id'];

//declaring variables
$result = mysqli_query($con, "SELECT * FROM workshops WHERE id ='$id'");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);

$error_array = array();


if (isset($_POST['edit_button']))
{
	//code
	$code = strip_tags($_POST['code']);
	$code = str_replace(' ', '', $code);
	$name = strip_tags($_POST['name']);

	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
    }    
	  if($code != $row['code']) if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM workshops WHERE code='$code'  ")) > 0) array_push($error_array, "herecode") ;

	  if($name != $row['name'])if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM workshops WHERE  name = '$name' ")) > 0) array_push($error_array, "herename") ;

	if(empty($error_array))
	{
		$query =mysqli_query($con, "UPDATE workshops
		SET
		code = '$code',name = '$name', notes = '$notes'
		WHERE id = '$id'
		");

	echo "<script>
        alert(' تم التعديل بنجاح ')
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
  <title>تعديل ورشة </title>
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
    <li><a href="../../main/equipments" class="nav-link">الرئيسية</a></li>
    <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;" class="nav-link">تسجيل الخروج</a></li>
  </ul>
</div>
<div class="center">
  <h1>تعديل ورشة    </h1>
  <form method='post'>
    <div class="inputbox">
      <input type="text" required="required" name="code"  value="<?php if(isset($row['code']))echo $row['code'];?>">
      <span> كود الورشة</span>
      <br>
    </div>
              <?php if(in_array("herecode", $error_array)) echo "<h3 style='font-weight:bold;color:red;'>كود الورشة موجود بالفعل<br></h3>"; ?>

    <div class="inputbox">
      <input type="text" required="required" name="name"  value="<?php if(isset($row['name']))echo $row['name'];?>">
      <span> إسم الورشة</span>
    </div>
    <?php if(in_array("herename", $error_array)) echo "<h3 style='font-weight:bold;color:red;'> اسم الورشة موجود بالفعل <br></h3>"; ?>
  
    <div class="inputbox">
      <input type="text" required="required" name="notes"  value="<?php if(isset($row['notes']))echo $row['notes'];?>">
      <span> أي ملاحظات إضافيه</span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="edit_button" value="حفظ البيانات">
    </div>
  </form>
</div>
</body>

</html>

