<?php
include "../../config.php";

// Check user login or not
 if(!isset($_COOKIE['rememberme'])){
 header('Location: ../../');
}
$name = $_GET["name"];

$query1 = "SELECT * FROM  oil_suppliers WHERE name = '".$_GET["name"]."'";
$result1 = mysqli_query($con, $query1);
    if(mysqli_num_rows($result1) > 0 )
        {
              $row1 = mysqli_fetch_array($result1);
              $code=$row1["code"];
              $notes=$row1["notes"];

        }


$query = "SELECT 
    * 
FROM
   oil_store_enter WHERE supplier = '".$_GET["name"]."'  order by date DESC
";
$sql = mysqli_query($con, $query);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>تقرير مشتريات من مورد</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>

</head>
<body>
<br/>
<img src="../../assets/images/headers/oils_store/spp_move-report.png" width="100%">
<?php
 require "../../headers/oils_store/navbar_search_date.php";

?>
<div class="container">

<table style="margin-bottom:20px;">

    <td>اسم المورد : <?php echo $name; ?> </td>
    <td>كود المورد : <?php echo $code; ?> </td>
    <td>مجال التعامل : <?php echo $notes; ?> </td>
</table>    

  
<div id="purchase_order">
<table>
<tr>
<th>التاريخ</th>
<th>اسم الصنف</th>
<th>عدد</th>
<th>الوحدة</th>
<th>سعر الوحدة</th>
<th>الإجمالي</th>
</tr>
<?php
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row= mysqli_fetch_array($sql))
{
    $sum1 = "
            SELECT SUM(price * in_balance) As sums  FROM oil_store_enter WHERE id = '".$row["id"]."' ";

$result3 = mysqli_query($con, $sum1);
    if(mysqli_num_rows($result3) > 0 )
{
    
  $row3 = mysqli_fetch_array($result3);

    
}
    $count++;

?>
<tr>
<td><?php echo $row["order_date"]; ?></td>
<td><?php echo $row["name"]; ?></td>
<td><?php echo $row["in_balance"]; ?></td>
<td><?php echo $row["unit"]; ?></td>
<td><?php echo $row["price"]; ?></td>
<td><?php echo $row3["sums"]; ?></td>
</tr>
<?php
}?>
</table>
<?php

$sum = "
            SELECT SUM(price * in_balance) As sum FROM oil_store_enter WHERE supplier = '".$_GET["name"]."'";

$result2 = mysqli_query($con, $sum);
if(mysqli_num_rows($result2) > 0 )
{
    
  $row2 = mysqli_fetch_array($result2);

    
}

echo '<table align="center" style="margin:20px 0px 20px 0px;">
        <td>إجمالي عدد الأصناف :  '.$count.'</td>
        <td>إجمالي السعر بالجُنيه :  '.$row2["sum"].'</td>
    </table>';
     
}else
{
    ?>
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
url:"../../controllers/oils_store/supplier_move_report.php?name=<?php echo $name; ?>",
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