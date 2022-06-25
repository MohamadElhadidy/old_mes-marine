<?php
require "../../../config/config.php";
$type = $_GET["type"];
$emp = $_GET["emp"];

    $query = "SELECT 
    *
FROM

   oilstore_out  WHERE type = '".$_GET["type"]."' And recipient = '".$_GET["emp"]."' order by date
";
$sql = mysqli_query($con, $query);
 require "../../../includes/headers/spares_store/navbar_search_date.php";
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>
                       تقرير بعُهدة موظف

</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>

</head>
<body>
<br/>
<img src="../../../assets/images/headers/spares_store/emp_move-report.png" width="100%">

<div class="container">
 <table style="margin-bottom:20px;">

    <td>اسم الموظف : <?php echo $emp; ?> </td>
     <?php

    $queryj = "SELECT job FROM ab2065_hr1_users.user WHERE name = '$emp' ";
    $resultj = mysqli_query($con, $queryj);
    if(mysqli_num_rows($resultj) > 0 )
        {
           $rowj = mysqli_fetch_array($resultj); 
        }
    ?>
    <td>الوظيفة : <?php echo $rowj["job"];?></td>
    <td>نوع الاصناف : <?php echo $type;?></td>

</table>   
<div id="purchase_order">
<table>
<tr>
<th>رقم الإذن</th>
<th>تاريخ الاستلام</th>
<th>اسم الصنف</th>
<th>العدد</th>
<th>الوحدة</th>
<th class="print">سعر الواحدة</th>
<th>التوجيه / الاستخدام</th>
<th>ملاحظات</th>

</tr>
<?php
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row= mysqli_fetch_array($sql))
{
    $count++;
     

?>
<tr>
<td><?php echo $row["order_num"]; ?></td>
<td><?php echo $row["order_date"]; ?></td>
<td><?php echo $row["name"]; ?></td>
<td><?php echo $row["out_balance"]; ?></td>
<td><?php echo $row["unit"]; ?></td>
<td class="print"><?php echo $row["price"]; ?></td>
<td><?php echo $row["direction"]; ?></td>
<td><?php echo $row["notes"]; ?></td>
</tr>
<?php
}

    $query2 = " SELECT SUM(price * out_balance) As sum FROM oilstore_out   WHERE type = '".$_GET["type"]."' And recipient = '".$_GET["emp"]."'
";
$sql2 = mysqli_query($con, $query2);


if(mysqli_num_rows($sql2) > 0 )
{
    
  $row2 = mysqli_fetch_array($sql2);

    
}
echo '<table align="center" style="margin:20px 0px 20px 0px;">
        <td>إجمالي الأصناف :  '.$count.'</td>
        <td class="print">إجمالي السعر بالجنية :  '.$row2["sum"].'</td>
        </table>';
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
url:"../../../includes/controllers/spares_store/emp_move_report.php?emp=<?php echo $emp; ?>&type=<?php echo $type; ?>",
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