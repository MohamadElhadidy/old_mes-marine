<?php
// Range.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";

$result = '';
$items =array();
$row1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spares WHERE id ='".$_GET['id']."'"));


$query = "SELECT  *  FROM  spare_store_enter WHERE name = '".$_GET["id"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'    order by order_num DESC ";

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
        'notes' => $item['order_num']
    );
}

}
$query = "SELECT  *  FROM  spare_store_out WHERE name = '".$_GET["id"]."'  AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'    order by order_num DESC ";

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
        'notes' => $item['order_num']
    );
}
}
    arsort($items);
   $in_balance = array_column($items, 'in_balance');
   $out_balance = array_column($items, 'out_balance');
}


$result .='
<table style="margin-bottom:20px;">

    <td>إجمالي الحركات : '.  count($items)  .' </td>
    <td>إجمالي الوارد :  '. array_sum($in_balance) .'</td>
    <td>إجمالي المنصرف : '. array_sum($out_balance) .'</td>
    <td>الرصيد الحالى :  '. $row1['balance'].'</td>

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
</tr>';
 foreach ($items as $item) {
  
    if($item["in_balance"] == 0 ){
     $order_type = "خروج" ;
    if($item["tb"] == "other") $item["direction"] = 'أخرى';
    else {
            if($item["tb"]=='pre_equipments') {$done="where done = '0'";} else {$done="where 1";}
                $row3 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `" . $item["tb"] . "` $done  AND is_delete = '0' "));
                $item["direction"] = $row3['name'];
    }


    
     } else {
        $order_type = "دخول";
        $row2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spare_suppliers WHERE id ='".$item["supplier"]."'"));
        $item["supplier"] = $row2['name'];
    }
     
$result .='
<tr>
<td>'. $item["order_num"].'</td>
<td>'.$item["order_date"].'</td>
<td>'.$order_type.'</td>
<td>'.$item["in_balance"].'</td>
<td>'.$item["out_balance"].'</td>
<td>'.$item["direction"].'</td>
<td>'.$item["supplier"].'</td>
<td>'.$item["notes"].'</td>
</tr>';
}
echo $result;


?>