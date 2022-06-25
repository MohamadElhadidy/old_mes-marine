<?php

require "../../config.php";
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
 }
?>
<!doctype html>
<html>
<head>
    		  <link href="../../assets/images/icons/favicon.png" rel="icon">

<meta charset="UTF-8">
<title>تقرير الحركة على صنف</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
</head>
<body>
<img src="../../assets/images/headers/spares_store/sapre_move-report.png" width="100%">


<?php

$items =array();
$row1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spares WHERE id ='".$_GET['id']."'"));


$query = "SELECT  *  FROM  spare_store_enter WHERE name = '".$_GET["id"]."'  order by order_num DESC ";

$sql = mysqli_query($con, $query);
if(mysqli_num_rows($sql) > 0)
{
    
    foreach ($sql as $item) {
    $items[] = array(
        'order_date' => $item['order_date'],
        'order_num' => $item['order_num'],
        'in_balance' => $item['balance'],
        'out_balance' => 0,
        'supplier' => $item['supplier'],
        'direction' =>"--",
        'tb' =>"",
        'notes' => $item['notes']
    );
}

}
$query = "SELECT  *  FROM  spare_store_out WHERE name = '".$_GET["id"]."'  order by order_num DESC ";

$sql = mysqli_query($con, $query);
if(mysqli_num_rows($sql) > 0)
{
 foreach ($sql as $item) {
    $items[] = array(
        'order_date' => $item['order_date'],
        'order_num' => $item['order_num'],
        'out_balance' => $item['balance'],
        'in_balance' => 0,
        'supplier' => $item['recipient'],
        'direction' =>$item['direction'],
        'tb' =>$item['tb'],
        'notes' => $item['notes']
    );
}
}
    arsort($items);
   $in_balance = array_column($items, 'in_balance');
   $out_balance = array_column($items, 'out_balance');
    require "../../headers/spares_store/navbar_search_date.php";

?>

<div class="container">

<table style="margin-bottom:20px;">

    <td>اسم الصنف : <?php echo $row1['name']; ?> </td>
    <td>كود الصنف : <?php echo $row1['code']; ?> </td>
</table>    

  
<div id="purchase_order">
    <table style="margin-bottom:20px;">

    <td>إجمالي الحركات : <?php echo count($items) ?> </td>
    <td>رصيد أول المدة  : <?php echo $row1['first'];?> </td>
    <td>إجمالي الوارد :  <?php echo array_sum($in_balance); ?></td>
    <td>إجمالي المنصرف : <?php echo array_sum($out_balance); ?></td>
    <td>الرصيد الحالى  :  <?php echo $row1['balance'];?></td>

</table>   
<table>
<tr>
<th>رقم الإذن</th>
<th>التاريخ</th>
<th>نوع الإذن</th>
<th>الوارد</th>
<th>المنصرف</th>
<th>التوجيه / الاستخدام</th>
<th>اسم المورد /   المستلم </th>
<th>ملاحظات</th>
</tr>
<?php
    foreach ($items as $item) {
  
    if($item["in_balance"] == 0 ){
     $order_type = "خروج" ;
    if($item["tb"] == "other") $item["direction"] = 'أخرى';
    else {
            if($item["tb"]=='pre_equipments') {$done="where done = '0'";} else {$done="where 1";}
                $row3 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `" . $item["tb"] . "` $done  AND id=   '".$item["direction"]."'  AND is_delete = '0' "));
                $item["direction"] = $row3['name'];
    }


    
     } else {
        $order_type = "دخول";
        $row2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spare_suppliers WHERE id ='".$item["supplier"]."'"));
        $item["supplier"] = $row2['name'];
    }
     

?>
<tr>
<td><?php echo $item["order_num"]; ?></td>
<td><?php echo $item["order_date"]; ?></td>
<td><?php echo $order_type; ?></td>
<td><?php echo $item["in_balance"]; ?></td>
<td><?php echo $item["out_balance"]; ?></td>

<td><?php echo $item["direction"]; ?></td>
<td><?php echo $item["supplier"]; ?></td>
<td><?php echo $item["notes"]; ?></td>
</tr>
<?php
}
?>
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
url:"../../controllers/spares_reports/move_report.php?id=<?php echo $_GET['id']; ?>",
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