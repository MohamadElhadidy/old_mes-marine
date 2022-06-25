<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

$equip = $_GET["equip"];
$result1 = mysqli_query($con,  "SELECT * FROM  equipments WHERE id = '".$_GET["equip"]."'");
if(mysqli_num_rows($result1) > 0 ) $row1 = mysqli_fetch_array($result1);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>
    إستهلاك 
   - 
 
<?php echo $row1['name']; ?>

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
<img src="../../assets/images/headers/reports/all_equip-report.png" width="100%">



<?php



$query = "SELECT  *  FROM  spare_store_out WHERE direction = '".$_GET["equip"]."' AND tb= 'equipments' AND is_delete = 0  order by order_num DESC ";

$sql = mysqli_query($con, $query);
if(mysqli_num_rows($sql) > 0)
{
    
    foreach ($sql as $item) {
    $items[] = array(
        'order_date' => $item['order_date'],
        'order_num' => $item['order_num'],
        'name' => $item['name'],
        'order_type' => 'صيانة داخلية',
        'balance' =>  $item['balance'] ,
        'price' => $item['price']   ,
        'total' => $item['price'] * $item['balance'] ,
        'recipient' => $item['recipient'],
        'notes' => $item['notes'],
        'table' => 'spares'
    );
}

}
$query = "SELECT  *  FROM  oil_store_out WHERE direction = '".$_GET["equip"]."'   AND tb= 'equipments'  AND is_delete = 0  order by order_num DESC ";

$sql = mysqli_query($con, $query);
if(mysqli_num_rows($sql) > 0)
{
 foreach ($sql as $item) {
    $items[] = array(
        'order_date' => $item['order_date'],
        'order_num' => $item['order_num'],
        'name' => $item['name'],
        'balance' =>  $item['balance'] ,
        'order_type' => 'صيانة داخلية',
        'price' => $item['price']  ,
        'total' => $item['price'] * $item['balance'] ,
        'recipient' => $item['recipient'],
        'notes' => $item['notes'],
        'table' => 'oils'
    );
}
}


$query = "SELECT  *  FROM   external_spare_store WHERE equipment = '".$_GET["equip"]."'  AND is_delete = 0   order by order_num DESC ";

$sql = mysqli_query($con, $query);
if(mysqli_num_rows($sql) > 0)
{
 foreach ($sql as $item) {
    $items[] = array(
        'order_date' => $item['order_date'],
        'order_num' => $item['order_num'],
        'name' => $item['details'],
        'balance' =>  0 ,
        'order_type' => 'صيانة خارجية',
        'price' => $item['price'],
        'total' => $item['price'],
        'recipient' => $item['worker'],
        'notes' => $item['notes'],
        'table' => 'ex'
    );
}
}

    arsort($items);
   $total = array_column($items, 'total');


 require "../../headers/spares_store/navbar_search_date.php";
?>

<!-- <div class="container"> -->

<table style="margin: 0 auto;max-width: 50%;margin-bottom: 20px;">

    <td>اسم المُعِدة : <?php echo $row1["name"]; ?> </td>
    <td>كود المُعِدة : <?php echo $row1["code"]; ?> </td>
</table>    


  
 
<div id="purchase_order" style="margin: 0 auto;max-width: 80%;">
  <?php  
echo '<table align="center" style="margin: 0 auto;max-width: 50%;margin-bottom: 20px;">
        <td>إجمالي السعر  :  '.number_format((float)array_sum($total), 2, '.', '').' جنيها</td>
        </table>';

?>
<table>
<tr>
  <th>رقم الإذن</th>
  <th>التاريخ</th>
  <th>نوع الصيانة</th>
<th>البيان</th>
<th>عدد / كمية</th>
<th>سعر الوحدة</th>
<th>الإجمالي</th>
<th>اسم المستلم / القائم بالعمل</th>
<th>ملاحظات</th>
</tr>
<?php
  foreach ($items as $item) {

   if( $item["order_type"] ==  'صيانة داخلية' )  {
        $table = $item["table"] ;
$query3 = " SELECT * FROM $table  WHERE  id = '".$item["name"]."'";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 ) $row13 = mysqli_fetch_array($sql3);
$item["name"]  = $row13['name'];
  
}
?>
<tr>
<td><?php echo $item["order_num"]; ?></td>
<td><?php echo $item["order_date"]; ?></td>
<td><?php echo $item["order_type"]; ?></td>
<td><?php echo $item["name"];  ?></td>
<td><?php echo $item["balance"];  ?></td>
<td><?php echo number_format((float)$item["price"], 2, '.', ''); ?></td>
<td><?php echo number_format((float)$item["total"], 2, '.', ''); ?></td>
<td><?php echo $item["recipient"]; ?></td>
<td><?php echo $item["notes"]; ?></td>
</tr>
<?php
}




?>
</div>
<!-- </div> -->
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
url:"../../controllers/reports/equip_report.php?equip=<?php echo $equip; ?>",
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