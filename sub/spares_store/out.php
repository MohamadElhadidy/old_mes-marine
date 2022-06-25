<?php

require "../../config.php";
// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

// logout
	function negavite($var)
{
    // returns whether the input integer positive
    return($var < 0);
}
if(isset($_POST['out_button'])){
	if(count($_POST['name']) != count(array_unique($_POST['name']))){
		echo "<script>
        alert(' يجب إدخال الصنف مرة واحدة ')
        window.location.href = 'out_number';
    </script>";

	}else{
	
		//Variable
    $date = date("Y-m-d H:i:s");
	$newBalance = array();
	$type = array();
	$price = array();
	
	for($i=0;$i< $_POST['numbers'];$i++)
	{
        $query = mysqli_query($con,"SELECT * FROM spares WHERE id ='".$_POST['name'][$i]."'");

    if(mysqli_num_rows($query) > 0 )
    {
         $row = mysqli_fetch_array($query);
		 $newBalance[$i] = $row['balance'] - $_POST['balance'][$i];
		 $type[$i] = $row['type'] ;
		 $price[$i] = $row['price'];
		 $name =  $row['name'];
		 if($newBalance[$i] < 0){
			 echo "<script>
        alert(' يجب التأكد من العدد  '.$name.'   ')
        window.location.href = 'out_number';
    </script>";
		 }
    }

    if (empty($_POST['notes'][$i])) $_POST['notes'][$i] =  '-';
    }
	$s = "insert into spare_store_out (order_num, order_date, tb, type, name, balance, price, direction,  recipient, employee, notes, date) values";

	for($i=0;$i<$_POST['numbers'];$i++)
	{
		$s .="('".$_POST['order_num']."', '".$_POST['order_date']."', '".$_POST['type']."',  '".$type[$i]."', 
		'".$_POST['name'][$i]."','".$_POST['balance'][$i]."','".$price[$i]."', '".$_POST['direction'][$i]."', '".$_POST['recipient']."',  '".$_POST['employee']."', '".$_POST['notes'][$i]."', '$date'),";
	}
	$s = rtrim($s,",");

	if(count(array_filter($newBalance, "negavite")) == 0){
	if(!mysqli_query($con, $s)){
		echo "<script>
        alert('أعد المحاولة مرة أخرى')
        window.location.href = 'out_report';
    </script>";
	}else{
		for($i=0;$i<$_POST['numbers'];$i++)
		{
	     	mysqli_query($con,"update spares set balance = '$newBalance[$i]' where id = '".$_POST['name'][$i]."'");
		}
	       	echo "<script>
        alert('تم حفظ البيانات بنجاح')
        window.location.href = 'index';
    </script>";

		
	}
 }else{
	 	 echo "<script>
        alert(' يجب التأكد من العدد    ')
        window.location.href = 'out_number';
    </script>";
		 }
 }
	
}	

?>


<html>
	<head>
		<title>اذن خروج صنف او اصناف</title>
				  <link href="../../assets/images/icons/favicon.png" rel="icon">

		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/form2.css">
	<script>
		$(document).ready(function() {
    $('.item').select2();
});
	</script>
	</head>
	<body>

	<div class='signup-container'>

	<div class='right-container'>
				<form method="post" autocomplete="off">

		  		<?php
		$numbers = $_POST['numbers'];
		$order_num = $_POST['order_num'];
		$order_date = $_POST['order_date'];
		$recipient = $_POST['recipient'];
		$type = $_POST['type'];
		$employee = $_POST['employee'];
		
			for($i=1;$i<=$numbers;$i++)
			{
				
		?>
    <header>
        <h1>صنف <?php echo $i;?></h1>
				<input type="hidden" value="<?php echo $numbers;?>" name="numbers" >
		<input type="hidden" value="<?php echo $order_num;?>" name="order_num">
		<input type="hidden" value="<?php echo $order_date;?>" name="order_date">
		<input type="hidden" value="<?php echo $type;?>" name="type">
		<input type="hidden" value="<?php echo $employee;?>" name="employee" >
		<input type="hidden" value="<?php echo $recipient ?>" name="recipient">
      <div class='set'>
        <div class='pets-breed'>
          <label for='pets-breed'> اسم الصنف</label>
        	<select class="item" name="name[]"  required>
        <option selected disabled VALUE=""> اسم الصنف</option>
			    <?php
			    $query = "SELECT * FROM spares";
                $result = mysqli_query($con, $query);
               if(mysqli_num_rows($result) > 0 )
                 {
					 while($row = mysqli_fetch_array($result))
            	{?>
    	   <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
             <?php	}} ?> 

			</select>
        </div>
        <div class='pets-birthday'>
          <label for='pets-birthday'>العدد</label>
			<input type="text" name="balance[]"  placeholder=" العدد" required>  
        </div>
	 <div class='pets-breed'>
          <label for='pets-breed'>  مكان التوجية</label>
        	<select class="item" name="direction[]"  required>
        <option selected disabled VALUE="">  مكان التوجية</option>
			  <?php
			    if($type=='other'){
					?>
					<option value="أخري" selected>أخري</option>
					<?php
				}
				 elseif($type=='safety'){
					?>
					<option value="مهمات وقائية" selected>مهمات وقائية</option>
					<?php
				}
				  elseif($type=='tools'){
					?>
					<option value="عدد و أدوات" selected>عدد و أدوات</option>
					<?php
				}else{
			    if($type=='pre_equipments') {$done="where done = '0'";} else {$done="where 1";}
			    $query = "SELECT * FROM `" . $type . "` $done AND is_delete = '0' ";
                $result = mysqli_query($con, $query);
               if(mysqli_num_rows($result) > 0 )
                 {
              while($row = mysqli_fetch_array($result))
            	{?>
    	   <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
            <?php	}}}?>

			</select>
        </div>
      </div>
      <div class='set'>
      
		<div class='pets-birthday'>
          <label for='pets-birthday'>ملاحظات</label>
						    <input style ='width: 30vw !important; ' type="text" name="notes[]"  placeholder="ملاحظات">
        </div>

        </div>
    </header>
	<br>
	  		<?php  } ?>
			  <footer>
      <div class='set'>
        <input name='out_button' id='next' type='submit' value ='حفظ'>
      </div>
    </footer>
				</form>
  </div>

</div>


	</body>
</html>



