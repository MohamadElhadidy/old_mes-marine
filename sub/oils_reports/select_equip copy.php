<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}


?>
<html>
	  <meta charset="utf-8">
		<title>تقرير صيانة مُعِده </title>
		  <link href="../../assets/images/icons/favicon.png" rel="icon">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/form.css">
<script>
		$(document).ready(function() {
    $('#equip').select2();
    $('#type').select2();
});
	</script>
</head>
	<body>
	
	<div class="center">
  <h1>تقرير صيانة مُعِده </h1>
  <form method='get' action='equip_report'>
    
    <div class="inputbox">
      	<select id="equip"  style="width:100%;height:40px;" name="equip"   required>
			    <option selected disabled VALUE="">اختر اسم المُعِده  </option>
			    <?php

				$query1 = "SELECT * FROM equipments";
				$result1 = mysqli_query($con, $query1);
				if(mysqli_num_rows($result1) > 0 )
					{
						while($row1 = mysqli_fetch_array($result1))
					{?>
	   				<option value="<?php echo $row1['id'];?>" required><?php echo $row1['name'];?></option>
				<?php	}} ?>
			</select>
    </div>
    <div class="inputbox">
     
				<select id="type"  name="type"  style="width:100%;height:40px;"   required>
			    <option selected disabled VALUE=""> اختر نوع الصنف  </option>
			    <?php
			    $query = "SELECT * FROM oil_type";
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
      <input  type="submit" style='margin-top: 20px;' name="add_button" value="ابحث">
    </div>                   
  </form>
</div>
	
	</body>
</html>


