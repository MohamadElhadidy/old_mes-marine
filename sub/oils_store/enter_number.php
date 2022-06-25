<?php
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
?>
<html>
	  <meta charset="utf-8">
		<title>اذن دخول صنف او اصناف</title>
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
    $('#supplier').select2();
    $('#type').select2();
});
	</script>
</head>
	<body>
		  <?php  $result2 = mysqli_query($con, "SELECT order_num FROM oil_store_enter where is_delete = 0 ORDER BY order_num DESC LIMIT 1");
            if(mysqli_num_rows($result2) > 0 ) $row2 = mysqli_fetch_array($result2);  
            ?>
            <form method='post' action="" id='the_form'>
        <input type="hidden"  name="but_logout">
    </form>
      <div class="nav">
  <ul>
    <li><a href="../../main/oils_store" class="nav-link">الرئيسية</a></li>
    <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;" class="nav-link">تسجيل الخروج</a></li>
  </ul>
</div>
	<div class="center">
  <h1>اذن دخول صنف او اصناف</h1>
  <form method='post' action='enter'>
    <div class="inputbox">
		<input type="text" pattern="[0-9]{1,}" title = "ادخل الرقم بشكل صحيح"  required name="num"  />
      	<span>  عدد الاصناف </span>
    </div>
    <div class="inputbox">
      	<select id="employee"  style="width:100%;height:40px;" name="employee"   required>
			    <option selected disabled VALUE="">ادخل اسمك</option>
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
     
				<select id="supplier"  name="supplier"  style="width:100%;height:40px;"   required>
			    <option selected disabled VALUE="">ادخل اسم المورد</option>
			    <?php
			    $query = "SELECT * FROM oil_suppliers where is_delete = 0";
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
     
			  <select  id="type"  name="type"   style="width:100%;height:40px;"  required>
                    <option selected disabled VALUE="">ادخل نوع الصنف او الأصناف</option>                                   
               <?php
			    $query2 = "SELECT * FROM oil_type where is_delete = 0";
                $result2 = mysqli_query($con, $query2);
               if(mysqli_num_rows($result2) > 0 )
                 {
              while($row3 = mysqli_fetch_array($result2))
            	{?>
    	   <option value="<?php echo $row3['id'];?>"><?php echo $row3['name'];?></option>
            <?php	}}?>
                </select>
    </div>
   
	 <div class="inputbox">
    <input type="date" name="order_date" id="datePickerId"  required />
      <span>التاريخ</span>
    </div>
    <div class="inputbox">
				<input type="text" name="order_num" value="<?php echo $row2['order_num'] + 1;?>" readonly/>
      <span> رقم اذن الدخول  </span>
    </div>
    <div class="inputbox">
      <input  type="submit" name="add_button" value="التالي">
    </div>                   
  </form>
</div>
	
	</body>
</html>


