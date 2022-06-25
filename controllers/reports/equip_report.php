<?php
$equip = $_GET["equip"];

$result2 ='';
if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";
$result = '';


$result1 = mysqli_query($con,  "SELECT * FROM  equipments WHERE id = '".$_GET["equip"]."'");
if(mysqli_num_rows($result1) > 0 ) $row1 = mysqli_fetch_array($result1);


$query = "SELECT  *  FROM  spare_store_out WHERE direction = '".$_GET["equip"]."' AND tb= 'equipments' AND is_delete = 0 AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'   order by order_num DESC ";

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
        'price' => $item['price']  ,
        'total' => $item['price'] * $item['balance'] ,
        'recipient' => $item['recipient'],
        'notes' => $item['notes'],
        'table' => 'spares'
    );
}

}
$query = "SELECT  *  FROM  oil_store_out WHERE direction = '".$_GET["equip"]."'   AND tb= 'equipments'  AND is_delete = 0 AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'   order by order_num DESC ";

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


$query = "SELECT  *  FROM   external_spare_store WHERE equipment = '".$_GET["equip"]."'  AND is_delete = 0   AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'   order by order_num DESC ";

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
        'total' => $item['price']  ,
        'recipient' => $item['worker'],
        'notes' => $item['notes'],
        'table' => 'ex'
    );
}
}

    arsort($items);
   $balance = array_column($items, 'balance');
   $total = array_column($items, 'total');

$result .='
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
</tr>';
 foreach ($items as $item) {

   if( $item["order_type"] ==  'صيانة داخلية' )  {

    if($item["table"] != 'ex' ){
        $table = $item["table"] ;
$query3 = " SELECT * FROM $table  WHERE  id = '".$item["name"]."'";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 ) $row13 = mysqli_fetch_array($sql3);
$item["name"]  = $row13['name'];

    }

}
$result .='
<tr>
<td>'.$item["order_num"].'</td>
<td>'.$item["order_date"].'</td>
<td>'.$item["order_type"].'</td>
<td>'.$item["name"].'</td>
<td>'.$item["balance"].'</td>
<td>'.number_format((float)$item["price"], 2, '.', '').'</td>
<td>'.number_format((float)$item["total"], 2, '.', '').'</td>
<td>'.$item["recipient"].'</td>
<td>'.$item["notes"].'</td>
</tr> ';
}
echo '<table align="center" style="margin: 0 auto;max-width: 50%;margin-bottom: 20px;">
        <td>إجمالي السعر  :  '.number_format((float)array_sum($total), 2, '.', '').' جنيها</td>
        </table>';
echo $result;




}
?>