<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$GLOBALS['id'] = $_GET['id'];
$exist = 0;

//declaring variables
$result = mysqli_query($con, "SELECT * FROM oils WHERE id ='$id'");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);
$type = $row['type'];

$resultType = mysqli_query($con, "SELECT * FROM oil_type WHERE id ='$type'");
if(mysqli_num_rows($resultType) > 0 ) $rowType = mysqli_fetch_array($resultType);


$error_array = array();

$find1 = "SELECT * FROM oil_store_enter where name = '$id' ";
if(mysqli_num_rows(mysqli_query($con, $find1)) > 0 ) $exist = 1;

$find2 = " SELECT * FROM oil_store_out where name = '$id' ";
if(mysqli_num_rows(mysqli_query($con, $find2)) > 0 ) $exist = 1;

if (isset($_POST['edit_button']))
{
	//code
	$code = strip_tags($_POST['code']);
	$code = str_replace(' ', '', $code);
	$name = strip_tags($_POST['name']);
	if ($exist == 0)  $balance = strip_tags($_POST['balance']);
  $unit = strip_tags($_POST['unit']);
  if ($exist == 0)  $price = strip_tags($_POST['price']);
  $lmit = strip_tags($_POST['lmit']);
  $type = strip_tags($_POST['type']);

	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
    }    
	  if($code != $row['code']) if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM oils WHERE code='$code'  ")) > 0) array_push($error_array, "herecode") ;

	  if($name != $row['name'])if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM oils WHERE  name = '$name' ")) > 0) array_push($error_array, "herename") ;

	if(empty($error_array))
	{
		$query =mysqli_query($con, "UPDATE oils
		SET
		code = '$code',name = '$name',type = '$type',unit = '$unit',lmit = '$lmit',notes = '$notes'
		WHERE id = '$id'
		");
    	if ($exist == 0){
        $query =mysqli_query($con, "UPDATE oils
		SET
		balance = '$balance',
    price = '$price'
		WHERE id = '$id'
		");
      }
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
  <title>تعديل صنف - مخزن    الزُّيُوت و الْوَقُود</title>
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
    <li><a href="../../main/oils_store/" class="nav-link">الرئيسية</a></li>
    <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;" class="nav-link">تسجيل الخروج</a></li>
  </ul>
</div>
<div class="center">
  <h1>تعديل صنف - مخزن قطع الغيار</h1>
  <form method='post'>
    <div class="inputbox">
      <input type="text" required="required" name="code"  value="<?php if(isset($row['code']))echo $row['code'];?>">
      <span> كود الصنف</span>
      <br>
    </div>
              <?php if(in_array("herecode", $error_array)) echo "<h3 style='font-weight:bold;color:red;'>كود الصنف موجود بالفعل<br></h3>"; ?>

    <div class="inputbox">
      <input type="text" required="required" name="name"  value="<?php if(isset($row['name']))echo $row['name'];?>">
      <span> إسم الصنف</span>
    </div>
    <?php if(in_array("herename", $error_array)) echo "<h3 style='font-weight:bold;color:red;'> اسم الصنف موجود بالفعل <br></h3>"; ?>

    <div class="inputbox">
      <input type="text" required="required" <?php if ($exist == 1) echo 'disabled'; ?> pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title = "ادخل الرقم بشكل صحيح" name="balance"  value="<?php if(isset($row['balance']))echo $row['balance'];?>">
      <span> الرصيد الحالي</span>
    </div>
    <div class="inputbox">
          <select  style="width:100%;height:40px;" name="unit" required>
                        <option selected="true" value="<?php if(isset($row['unit'])) {echo $row['unit'];} else echo"";?>">
                   <?php if(isset($row['unit']))echo $row['unit']; else echo "اختر الوحدة";?>
                        </option>
                        <option value="عدد">
                            عدد
                        </option>
                        <option value="مللي متر">
                            مللي متر

                        </option>
                        <option value="سم">
                            سم

                        </option>
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
      <input type="text" required="required"  <?php if ($exist == 1) echo 'disabled'; ?> pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title="ادخل الرقم بشكل صحيح" name="price"  value="<?php if(isset($row['price']))echo $row['price'];?>">
      <span>سعر الوحدة الواحدة</span>
    </div>
    <div class="inputbox">
      <input type="text" required="required"  pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}" title = "ادخل الرقم بشكل صحيح" name="lmit"  value="<?php if(isset($row['lmit']))echo $row['lmit'];?>">
      <span>حد الطلب</span>
    </div>
    <div class="inputbox">
       <select name="type" required  style="width:100%;height:40px;">
          <option selected value="<?php if(isset($rowType['id'])){echo $rowType['id'];} else echo "";?>">
                <?php if(isset($rowType['name']))echo $rowType['name']; else echo
                        "ادخل نوع الصنف";?>
                         </option>
                   
			    <?php
			    $query2 = "SELECT * FROM oil_type";
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

