<?php
include "../../config.php";

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

	$balance = strip_tags($_POST['balance']);
  $_SESSION['balance'] = $balance;
    
  $unit = strip_tags($_POST['unit']);
  $_SESSION['unit'] = $unit;
    
	
  $price = strip_tags($_POST['price']);
	$_SESSION['price'] = $price;
    
  $lmit = strip_tags($_POST['lmit']);
	$_SESSION['lmit'] = $lmit;
	
	$type = strip_tags($_POST['type']);
	$_SESSION['type'] = $type;

	
	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
	  $_SESSION['notes'] = $notes;
    }
    
	
	if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM spares WHERE code='$code'  ")) > 0) array_push($error_array, "herecode") ;
	if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM spares WHERE  name = '$name' ")) > 0) array_push($error_array, "herename") ;
			
	if(empty($error_array))
	{
		mysqli_query($con , "INSERT INTO spares(code, name, type, balance, unit, price, lmit, notes) VALUES ('$code', '$name', '$type', '$balance', '$unit', '$price', '$lmit', '$notes')");
		$_SESSION['code'] = "";
		$_SESSION['name'] = "";
		$_SESSION['balance']= "";
    $_SESSION['unit'] = "";
		$_SESSION['price']= "";
		$_SESSION['lmit']= "";
		$_SESSION['notes']= "";
		$_SESSION['type'] = "";
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
  <title>إضافة صنف - مخزن قطع الغيار</title>
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
    <li><a href="../../main/spares_store" class="nav-link">الرئيسية</a></li>
    <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;" class="nav-link">تسجيل الخروج</a></li>
  </ul>
</div>
<div class="center">
  <h1>إضافة صنف - مخزن قطع الغيار</h1>
  <form method='post'>
    <div class="inputbox">
      <input type="text" required="required" name="code"  value="<?php if(isset($_SESSION['code'])) echo $_SESSION['code'];?>">
      <span> كود الصنف</span>
      <br>
    </div>
              <?php if(in_array("herecode", $error_array)) echo "<h3 style='font-weight:bold;color:red;text-align: center;'>كود الصنف موجود بالفعل<br></h3>"; ?>
    <div class="inputbox">
      <input type="text" required="required" name="name"  value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name'];?>">
      <span> إسم الصنف</span>
    </div>
      <?php if(in_array("herename", $error_array)) echo "<h3 style='font-weight:bold;color:red;text-align: center;'>اسم الصنف موجود بالفعل<br></h3>"; ?>
    <div class="inputbox">
      <input type="text" required="required" pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title = "ادخل الرقم بشكل صحيح" name="balance"  value="<?php if(isset($_SESSION['balance']))echo $_SESSION['balance'];?>">
      <span> الرصيد الحالي</span>
    </div>
    <div class="inputbox">
          <select  style="width:100%;height:40px;" name="unit" required>
                        <option selected="true" value="<?php if(isset($_SESSION['unit'])) {echo $_SESSION['unit'];} else echo"";?>">
                   <?php if(isset($_SESSION['unit']))echo $_SESSION['unit']; else echo "اختر الوحدة";?>
                        </option>
                        <option value="عدد">  عدد</option>
                        <option value="مللي متر">مللي متر</option>
                        <option value="سم">سم</option>
                         <option value="سم مربع">
                            سم مربع
                        </option>
                        <option value="عبوه">
                            عبوه
                        </option>
                        <option value="متر">
                            متر
                        </option>
                        <option value="كيلو متر">
                            جالون
                        </option>
                        <option value="لتر">
                            لتر
                        </option>
                        <option value="جرام">
                            جرام
                        </option>
                        <option value="كيلو جرام">
                            كيلو جرام
                        </option>
                    </select>
    </div>
    <div class="inputbox">
      <input type="text" required="required" pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title="ادخل الرقم بشكل صحيح" name="price"  value="<?php if(isset($_SESSION['price']))echo $_SESSION['price'];?>">
      <span>سعر الوحدة الواحدة</span>
    </div>
    <div class="inputbox">
      <input type="text" required="required"  pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title = "ادخل الرقم بشكل صحيح" name="lmit"  value="<?php if(isset($_SESSION['lmit']))echo $_SESSION['lmit'];?>">
      <span>حد الطلب</span>
    </div>
    <div class="inputbox">
       <select name="type" required  style="width:100%;height:40px;">
          <option selected value="<?php if(isset($_SESSION['type'])){echo $_SESSION['type'];} else echo "";?>">
                <?php if(isset($_SESSION['type']))echo $_SESSION['type']; else echo
                        "ادخل نوع الصنف";?>
                         </option>
                   
			    <?php
			    $query2 = "SELECT * FROM spare_types";
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
      <input type="text"  name="notes"  value="<?php if(isset($_SESSION['notes']))echo $_SESSION['notes'];?>">
      <span> أي ملاحظات إضافيه</span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="add_button" value="حفظ البيانات">
    </div>
                
  </form>
</div>
</body>

</html>

