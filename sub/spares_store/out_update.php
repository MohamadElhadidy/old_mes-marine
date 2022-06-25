<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}
$id = $_GET['id'];

$result = mysqli_query($con, "SELECT  * FROM spare_store_out  WHERE id = '$id' ");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);
if($row['tb'] != 'equipments'){
    	 echo "<script>
        alert('لا يسمح بالتعديل')
        window.location.href = 'out_report';
    </script>";
		 }


$order_num = $row['order_num'];

$sum = mysqli_query($con, "SELECT SUM(price * balance) As sum,  count(*) as total  FROM spare_store_out  WHERE  is_delete = 0  AND order_num = '$order_num' ");
if(mysqli_num_rows($sum) > 0 ) $row5 = mysqli_fetch_array($sum);
    
if(isset($_POST['post'])){
for($i=0;$i< count($_POST['id']);$i++)
	{

	mysqli_query($con,"update spare_store_out set direction ='".$_POST['equipment'][$i]."' where id = '".$_POST['id'][$i]."' ");

         header("Location: out_report");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
            <title>
            
                طباعة مستند خروج
            
            </title>
    <link href="../../assets/images/icons/favicon.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 
    <script>
        function myFunction() {
            window.print();
        }
    </script>
     <style>
    body
    {
        width: 100%;
        direction: rtl;
        font-weight: bold;
    }
        @media print {
            .print {
                display: none;
            }

        }

        table th {
        font-family: Arial, Helvetica, sans-serif;   
        font-style: bold;
        background-color:#3399ff;
        color: #000000;
        padding: 4px;
        border: 2px solid #333333;

        }
        table td 
        {
            font-family: Arial, Helvetica, sans-serif;
            word-wrap: break-word;
            vertical-align: middle;
           padding: 2px;
           font-weight: bold;
           border: 2px solid #333333;
           background-color: #ffffff;
             
        }
        table
        {
            max-width: 100%;
            width: 100%;
            text-align: center;
           
        }
        .none
        {
            border: hidden;
            background-color: #fff;
        }
        .color
        {
            border: hidden;
        }
        .nav-item{
            cursor: pointer;
        }
 .select2-results__option {
  text-align: center;
}
#bn{
    display: flex;
justify-content: center;
margin-top: 25px;
}
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
		$(document).ready(function() {

    $('.equipment').select2();
});
	</script>
</head>

<body>
    <img src="../../assets/images/headers/spares_store/out-report1.png" width="100%">

<div class="container">
    <table style="margin-bottom:20px;">
        <td>رقم المستند : <?php echo $order_num?></td>
        <td>التاريخ : <?php echo $row['order_date']; ?></td>
        <td>اسم المستلم : <?php echo $row['recipient']; ?></td>
    </table>
    <div id="result">
        <?php 

$result2 = mysqli_query($con, "SELECT  * FROM spare_store_out  WHERE  is_delete = 0  AND order_num = '$order_num' ");
if(mysqli_num_rows($result2) > 0 )
{
    ?>
<form method='post'>
		<table >
  <thead>
            <tr>
                <th>اسم الصنف</th>
                <th>عدد</th>
                <th>سِعر الوِحده</th>
                <th>التَوجِيه/الإستِخدَام</th>
                <th>مُلاحظات</th>
            </tr>
        </thead>
        <tbody>
              <?php 
	while($row2 = mysqli_fetch_array($result2))
	{
        $row3 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spares WHERE id ='".$row2['name']."'"));
        $name = $row3['name'];
        $type = $row2['tb'];
        $direction = $row2["direction"];
        $direction2 = '';
            $result = mysqli_query($con, "SELECT *  FROM equipments  WHERE  id = '$direction'  AND is_delete = '0' ");
                if(mysqli_num_rows($result) > 0 ){
                    $row14 = mysqli_fetch_array($result);
                    $direction2 =  $row14['name'];

                }  
                 
            	?>
            <tr>
                <input type= 'hidden' name='id[]' value='<?php  echo $row2["id"]; ?>'>
                <td><?php echo $name ; ?></td>
                <td><?php echo $row2["balance"] ;?></td>
                <td><?php echo number_format((float)$row2["price"], 2, '.', '') ;?></td>
            <td>    <select name='equipment[]' class="equipment" >
                    <?php   
                $result222 = mysqli_query($con, "SELECT *  FROM equipments   ");
                if(mysqli_num_rows($result222) > 0 ){
                while($row222 = mysqli_fetch_array($result222))
	            {                
                    if(  $row222['name'] ==  $direction2){
                    ?>

                    <option value='<?php  echo $row222['id'];?>' selected><?php  echo $row222['name'];?></option>
                    <?php  } else{?>
                    <option value='<?php  echo $row222['id'];?>'><?php  echo $row222['name'];?></option>
                    <?php } }}?>
                </select>
                </td>
                <td><?php echo $row2["notes"] ;?></td>
           </tr>
 <?php 
	}
    ?>
        </tbody>
    
</table>
<span id='bn'>
<input type='submit' name='post' value='تعديل' class="btn btn-primary">
</span>
</form>
<?php  } ?>

</div>

</div>

</body>
   
</html>
