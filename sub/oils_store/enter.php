<?php
require "../../config.php";
// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

// logout

if(isset($_POST['enter_button'])){
	if(count($_POST['name']) != count(array_unique($_POST['name']))){
		echo "<script>
        alert(' يجب إدخال الصنف مرة واحدة ')
        window.location.href = 'enter_number';
    </script>";

	}else{
	
		//Variable
    $date = date("Y-m-d H:i:s");
	$newBalance = array();
	
	for($i=0;$i< $_POST['numbers'];$i++)
	{
        $query = mysqli_query($con,"SELECT * FROM oils WHERE id ='".$_POST['name'][$i]."'");

    if(mysqli_num_rows($query) > 0 )
    {
         $row = mysqli_fetch_array($query);
		 $newBalance[$i] = $row['balance'] +$_POST['balance'][$i];
    }
	
    if (empty($_POST['notes'][$i])) $_POST['notes'][$i] =  '-';
    
    }

	$s = "insert into oil_store_enter (order_num, order_date, type, name, balance, price, supplier, employee, notes, date) values";

	for($i=0;$i<$_POST['numbers'];$i++)
	{
		$s .="('".$_POST['order_num']."', '".$_POST['order_date']."', '".$_POST['type']."', 
		'".$_POST['name'][$i]."','".$_POST['balance'][$i]."','".$_POST['price'][$i]."', 
		'".$_POST['supplier']."',  '".$_POST['employee']."', '".$_POST['notes'][$i]."', '$date'),";
	}
	$s = rtrim($s,",");

	
	if(!mysqli_query($con, $s)){
		echo "<script>
        alert('أعد المحاولة مرة أخرى')
        window.location.href = 'enter_number';
    </script>";
	}else
	{
		for($i=0;$i<$_POST['numbers'];$i++)
		{
	     	mysqli_query($con,"update oils set balance = '$newBalance[$i]', price = '".$_POST['price'][$i]."' where id = '".$_POST['name'][$i]."'");
		}
	       	echo "<script>
        alert('تم حفظ البيانات بنجاح')
        window.location.href = 'index';
    </script>";

		
	}
	
}	
}

?>


<html>
	<head>
		<title>اذن دخول صنف او اصناف</title>
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
	<form method="post"  autocomplete="off">

		  		<?php
		$numbers = $_POST['num'];
		$order_num = $_POST['order_num'];
		$order_date = $_POST['order_date'];
		$supplier = $_POST['supplier'];
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
		<input type="hidden" value="<?php echo $supplier;?>" name="supplier">
		<input type="hidden" value="<?php echo $type;?>" name="type">
		<input type="hidden" value="<?php echo $employee;?>" name="employee" >
      <div class='set'>
        <div class='pets-breed'>
          <label for='pets-breed'> اسم الصنف</label>
        	<select class="item" name="name[]"  required>
        <option selected disabled VALUE=""> اسم الصنف</option>
			    <?php
			    $query = "SELECT * FROM oils where type = '$type' ";
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
			<input type="text" pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}"  name="balance[]"  placeholder=" العدد" required>  
        </div>
		<div class='pets-birthday'>
          <label for='pets-birthday'>سعر الوحدة الواحدة</label>
		<input type="text" pattern="[0-9]{1,}[.]{0,1}[0-9]{0,}"  min="1" title="ادخل الرقم بشكل صحيح" name="price[]" placeholder="سعر الوحدة الواحدة" required>
        </div>
      </div>
      <div class='set'>
      
		<div class='pets-birthday'>
          <label for='pets-birthday'>ملاحظات</label>
						    <input style ='width: 30vw !important; ' type="text" name="notes[]"  placeholder="ملاحظات">
        </div>

			<input type="hidden" name="type"  value='<?php echo $type ?>' >
        </div>
    </header>
	<br>
	  		<?php  } ?>
			  <footer>
      <div class='set'>
        <input name='enter_button' id='next' type='submit' value ='حفظ'>
      </div>
    </footer>
				</form>
  </div>

</div>


	</body>
</html>



