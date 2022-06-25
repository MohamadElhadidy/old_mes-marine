<?php

include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$equip = $_GET["equip"];
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>
    إستهلاك 
   - 
 
<?php echo $equip; ?>

</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
<style>
    body {
    line-height: 1 !important;
}
table {
  table-layout: auto !important;
}
table th {
	color: #fff !important;
	border: 2px solid #000 !important;
}
</style>
</head>
<body>
<img src="../../assets/images/headers/reports/equip_spare-report.png" width="100%">



<?php


$result1 = mysqli_query($con,  "SELECT * FROM  equipments WHERE id = '".$_GET["equip"]."'");
if(mysqli_num_rows($result1) > 0 ) $row1 = mysqli_fetch_array($result1);


        
        
$query = "
SELECT 
    *
FROM
   spare_store_out  WHERE direction = '".$_GET["equip"]."' AND tb = 'equipments'  order by order_num DESC
";
$sql = mysqli_query($con, $query);
 require "../../headers/spares_store/navbar_search_date.php";
?>

<div class="container">

<table style="margin-bottom:20px;">

    <td>اسم المُعِدة : <?php echo $row1["name"]; ?> </td>
    <td>كود المُعِدة : <?php echo $row1["code"]; ?> </td>
</table>    

  
  
 
<div id="purchase_order">
  <?php   

   $query2 = " SELECT SUM(price *balance) As sum,sum(balance) as qnt FROM spare_store_out   
 WHERE  direction = '".$_GET["equip"]."'  AND tb = 'equipments' 
";
$sql2 = mysqli_query($con, $query2);


if(mysqli_num_rows($sql2) > 0 )
{
    
  $row2 = mysqli_fetch_array($sql2);

    
}
$row2["sum"]=number_format((float)$row2["sum"], 2, '.', '');
$qnt=$row2["qnt"];

echo '<table align="center" style="margin:20px 0px 20px 0px;">
        <td> إجمالي الكمية / العدد : '.$qnt.'</td>
        <td>إجمالي السعر بالجنية :  '.number_format((float)$row2["sum"], 2, '.', '').'</td>
        </table>';
        ?>
<table>
<tr>
     <th>رقم الإذن</th>
    <th>التاريخ</th>
<th>اسم الصنف</th>
<th>عدد</th>
<th>سعر الوحدة</th>
<th>السعر الإجمالي</th>
<th>اسم المستلم</th>
<th>ملاحظات</th>
</tr>
<?php
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row= mysqli_fetch_array($sql))
{
    $query3 = " SELECT SUM(price * balance) As sums FROM spare_store_out   WHERE  id = '".$row["id"]."'
";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 )
{
    
  $row3 = mysqli_fetch_array($sql3);

    
}
        $query3 = " SELECT * FROM spares  WHERE  id = '".$row["name"]."'
";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 )
{
    
  $row13 = mysqli_fetch_array($sql3);

    
}

    $count++;
?>
<tr>
<td><?php echo $row["order_num"]; ?></td>
<td><?php echo $row["order_date"]; ?></td>
<td><?php echo $row13["name"]; ?></td>
<td><?php echo $row["balance"]; ?></td>
<td><?php echo number_format((float)$row["price"], 2, '.', ''); ?></td>
<td><?php echo number_format((float)$row3["sums"], 2, '.', ''); ?></td>
<td><?php echo $row["recipient"]; ?></td>
<td><?php echo $row["notes"]; ?></td>
</tr>
<?php
}

}
else
{
?>
</table>
<table>
<tr>
<td >لا يوجد بيانات</td>
</tr>
</table>
<?php }?>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<!-- Script -->
<script>
$(document).ready(function(){
$.datepicker.setDefaults({
dateFormat: 'yy-mm-dd'
});
$(function(){
$("#From").datepicker();
$("#to").datepicker();
});
$('#range').click(function(){
var From = $('#From').val();
var to = $('#to').val();
if(From != '' && to != '')
{
$.ajax({
url:"../../controllers/spares_reports/equip_report.php?equip=<?php echo $equip; ?>",
method:"POST",
data:{From:From, to:to},
success:function(data)
{
$('#purchase_order').html(data);
}
});
}
else
{
alert("اختر تاريح");
}
});
});
</script>
</body>
</html>