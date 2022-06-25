<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
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

if (isset($_POST['add_button']))
{


	
	$order_date = strip_tags($_POST['order_date']);
	$_SESSION['order_date'] = $order_date;
	
	$equipment = strip_tags($_POST['equipment']);
	$_SESSION['equipment'] = $equipment;

	$ex_name = strip_tags($_POST['ex_name']);
  $_SESSION['ex_name'] = $ex_name;
    
  $details = strip_tags($_POST['details']);
  $_SESSION['details'] = $details;
    
	
  $price = strip_tags($_POST['price']);
	$_SESSION['price'] = $price;
    
  $worker = strip_tags($_POST['worker']);
	$_SESSION['worker'] = $worker;
	
	$supervisor = strip_tags($_POST['supervisor']);
	$_SESSION['supervisor'] = $supervisor;

	$employee = strip_tags($_POST['employee']);
	$_SESSION['employee'] = $employee;

    	$order_num = strip_tags($_POST['order_num']);
	
	if (empty($_POST['notes'])) {$notes =  '-';
    } else {
    $notes = strip_tags($_POST['notes']);
	  $_SESSION['notes'] = $notes;
    }
    
			$date = date("Y-m-d H:i:s");

		mysqli_query($con , "INSERT INTO external_spare_store (order_date, equipment, ex_name, details, worker, price, supervisor, employee, order_num, notes, date) VALUES ('$order_date', '$equipment', '$ex_name', '$details', '$worker', '$price', '$supervisor', '$employee', '$order_num', '$notes', '$date')");
		$_SESSION['order_date'] = "";
		$_SESSION['equipment'] = "";
		$_SESSION['details']= "";
    $_SESSION['ex_name'] = "";
		$_SESSION['price']= "";
		$_SESSION['worker']= "";
		$_SESSION['supervisor']= "";
		$_SESSION['employee'] = "";
		$_SESSION['notes'] = "";
    echo "<script>
        alert(' تم الإضافة بنجاح ')
        window.location.href = 'index';
    </script>";

	
}
?>
<html>
	  <meta charset="utf-8">
		<title>اذن صيانة خارجية   </title>
      <link rel="stylesheet" type="text/css" href="../css/navbar.css">

		  <link href="../../assets/images/icons/favicon.png" rel="icon">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/form.css">
<script>
		$(document).ready(function() {
      datePickerId.max = new Date().toISOString().split("T")[0];
    $('#employee').select2();
    $('#equipment').select2();
    $('#worker').select2();
    $('#supervisor').select2();
});
	</script>
</head>
	<body>
		  <?php  $result2 = mysqli_query($con, "SELECT order_num FROM external_spare_store ORDER BY order_num DESC LIMIT 1");
            if(mysqli_num_rows($result2) > 0 ) $row2 = mysqli_fetch_array($result2);  
            ?>
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
  <h1>اذن صيانة خارجية   </h1>
  <form method='post'>
       <div class="inputbox">
    <input type="date" name="order_date" id="datePickerId"  required />
      <span>التاريخ</span>
    </div>
      <div class="inputbox"  style="margin-bottom: 50px;">
     
				<select id="equipment"  name="equipment"  style="width:100%;height:40px;margin-bottom: 50px;"   required>
			    <option selected disabled VALUE="">ادخل اسم المعدة</option>
			    <?php
			    $query = "SELECT * FROM equipments where is_delete = 0";
                $result = mysqli_query($con, $query);
               if(mysqli_num_rows($result) > 0 )
                 {
              while($row = mysqli_fetch_array($result))
            	{?>
    	   <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
            <?php	}}?>

			</select>
    </div>
    <div class="inputbox">
		<input type="text"   required name="ex_name"  />
      	<span> اسم الورشة </span>
    </div>
<div class="inputbox">
		<input type="text"   required name="details"  />
      	<span>  الإصلاحات </span>
    </div>
    <div class="inputbox">
		<input type="text"  pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}"  required name="price"  />
      	<span>  التكلفة </span>
    </div>
    <div class="inputbox"  style="margin-bottom: 50px;">
      	<select id="worker"  style="width:100%;height:40px;margin-bottom: 50px;" name="worker"   required>
			    <option selected disabled VALUE=""> اسم القائم بالعمل</option>
			    <?php

				$query1 = "SELECT * FROM hr.data WHERE is_delete = 0";
				$result1 = mysqli_query($con, $query1);
				if(mysqli_num_rows($result1) > 0 )
					{
						while($row1 = mysqli_fetch_array($result1))
					{?>
	   				<option value="<?php echo $row1['name'];?>" required><?php echo $row1['name'];?></option>
				<?php	}} ?>
			</select>
    </div>
    
  <div class="inputbox"  style="margin-bottom: 50px;">
      	<select id="supervisor"  style="width:100%;height:40px;margin-bottom: 50px;" name="supervisor"   required>
			    <option selected disabled VALUE="">اسم مسئول الصيانة</option>
			    <?php

				$query1 = "SELECT * FROM hr.data WHERE  is_delete = 0";
				$result1 = mysqli_query($con, $query1);
				if(mysqli_num_rows($result1) > 0 )
					{
						while($row1 = mysqli_fetch_array($result1))
					{?>
	   				<option value="<?php echo $row1['name'];?>" required><?php echo $row1['name'];?></option>
				<?php	}} ?>
			</select>
    </div>
    

      <div class="inputbox"  style="margin-bottom: 50px;">
      	<select id="employee"  style="width:100%;height:40px;margin-bottom: 50px;" name="employee"   required>
			    <option selected disabled VALUE="">اسم موظف المخزن</option>
			    <?php

				$query1 = "SELECT * FROM hr.data WHERE department = 9";
				$result1 = mysqli_query($con, $query1);
				if(mysqli_num_rows($result1) > 0 )
					{
						while($row1 = mysqli_fetch_array($result1))
					{?>
	   				<option value="<?php echo $row1['name'];?>" required><?php echo $row1['name'];?></option>
				<?php	}} ?>
			</select>
    </div>
    

	
    	 <div class="inputbox">
    <input type="text" name="notes"  placeholder="ملاحظات"/>
    </div>
    <div class="inputbox">
				<input type="text" name="order_num" value="<?php echo $row2['order_num'] + 1;?>" readonly/>
      <span> رقم الإذن    </span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="add_button" value="حفظ">
    </div>                   
  </form>
</div>
	
	</body>
</html>


