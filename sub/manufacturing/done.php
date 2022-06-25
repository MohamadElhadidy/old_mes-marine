<?php
include "../../config.php";

 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$GLOBALS['id'] = $_GET['id'];

//declaring variables
$result = mysqli_query($con, "SELECT * FROM pre_equipments WHERE id ='$id'");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);

$error_array = array();

if (isset($_POST['add_button']))
{


	
	$code = strip_tags($_POST['code']);
	$code = str_replace(' ', '', $code);
	$_SESSION['code'] = $code;
	
	$name = strip_tags($_POST['name']);
	$_SESSION['name'] = $name;

	$power = strip_tags($_POST['power']);
  $_SESSION['power'] = $power;
    
  	$type = strip_tags($_POST['type']);
	$_SESSION['type'] = $type;

    $end_date = strip_tags($_POST['end_date']);

	
	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
	  $_SESSION['notes'] = $notes;
    }
    
	
	if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM equipments WHERE code='$code'  ")) > 0) array_push($error_array, "herecode") ;
	if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM equipments WHERE  name = '$name' ")) > 0) array_push($error_array, "herename") ;
			
	if(empty($error_array))
	{
		mysqli_query($con , "INSERT INTO equipments(code, name, type, power, notes) VALUES ('$code', '$name', '$type', '$power',  '$notes')");
        
		mysqli_query($con , "UPDATE pre_equipments set  end_date = '$end_date' , done = 1 WHERE id ='$id' " );
		$_SESSION['code'] = "";
		$_SESSION['name'] = "";
		$_SESSION['power']= "";
		$_SESSION['notes']= "";
		$_SESSION['type'] = "";
    echo "<script>
        alert(' تم الإنهاء بنجاح ')
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
  <title> انهاء تصنيع  مُعِــــده </title>
  <link rel="stylesheet" type="text/css" href="../css/navbar.css">
  <link rel="stylesheet" type="text/css" href="../css/form.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="../../assets/images/icons/favicon.png" rel="icon">
  <script>
      	$(document).ready(function() {
                     datePickerId.max = new Date().toISOString().split("T")[0];
        });
  </script></head>


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
  <h1>انهاء تصنيع  مُعِــــده  </h1>
  <form method='post'>
    <div class="inputbox">
      <input type="text" required="required" name="code"  value="<?php if(isset($row['code']))echo $row['code'];?>">
      <span> كود المُـــعده</span>
      <br>
    </div>
              <?php if(in_array("herecode", $error_array)) echo "<h3 style='font-weight:bold;color:red;text-align: center;'>كود المُـــعده موجود بالفعل<br></h3>"; ?>
    <div class="inputbox">
      <input type="text" required="required" name="name"  value="<?php if(isset($row['name']))echo $row['name'];?>">
      <span> إسم المُـــعده</span>
    </div>
      <?php if(in_array("herename", $error_array)) echo "<h3 style='font-weight:bold;color:red;text-align: center;'>اسم المُـــعده موجود بالفعل<br></h3>"; ?>
    <div class="inputbox">
      <input type="text" required="required"   name="power"  value="<?php if(isset($_SESSION['power']))echo $_SESSION['power'];?>">
      <span> قدرة المُعــــــده</span>
    </div>
    <div class="inputbox">
       <select name="type" required  style="width:100%;height:40px;">
          <option selected value="<?php if(isset($_SESSION['type'])){echo $_SESSION['type'];} else echo "";?>">
                <?php if(isset($_SESSION['type']))echo $_SESSION['type']; else echo
                        "ادخل نوع المُعــــــده";?>
                         </option>
                   
			    <?php
			    $query2 = "SELECT * FROM types ";
                $result2 = mysqli_query($con, $query2);
               if(mysqli_num_rows($result2) > 0 )
                 {
              while($row2 = mysqli_fetch_array($result2))
            	{?>
    	   <option value="<?php echo $row2['id'];?>"><?php echo $row2['name'];?></option>
            <?php	}}?>

            </select>
    </div>
    <div class="inputbox">
    <input type="date" name="end_date" id="datePickerId"   required />
      <span>تاريخ نهاية التصنيع</span>
    </div>
    <div class="inputbox">
      <input type="text"  name="notes"  value="<?php if(isset($_SESSION['notes']))echo $_SESSION['notes'];?>">
      <span> أي ملاحظات إضافيه</span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="add_button" onclick="return confirm('هل أنت متأكد من عملية الإنهاء ؟')"  value="إنهاء">
    </div>
                
  </form>
</div>
</body>

</html>

