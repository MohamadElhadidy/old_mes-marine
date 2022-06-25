<?php
// Range.php
$name = $_GET['name'];
if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";
$result = '';
$query = "SELECT  *FROM oil_store_enter WHERE supplier = '".$_GET["name"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'  order by date"; 
$sql = mysqli_query($con, $query);
}

$result .='
<table>
<tr>
<th>التاريخ</th>
<th>اسم الصنف</th>
<th>عدد</th>
<th>الوحدة</th>
<th>سعر الوحدة</th>
<th>الإجمالي</th>
</tr>';
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row = mysqli_fetch_array($sql))
{
     $sum1 = "
            SELECT SUM(price * in_balance) As sums  FROM oil_store_enter WHERE id = '".$row["id"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."' ";

$result3 = mysqli_query($con, $sum1);
    if(mysqli_num_rows($result3) > 0 )
{
    
  $row3 = mysqli_fetch_array($result3);

    
}
     $count++;
$result .='
<tr>
<td>'. $row["order_date"].'</td>
<td>'. $row["name"].'</td>
<td>'. $row["in_balance"].'</td>
<td>'. $row["unit"].'</td>
<td>'. $row["price"].'</td>
<td>'. $row3["sums"].'</td>
</tr>';
}
echo $result;
$sum = "
            SELECT SUM(price * in_balance) As sum FROM oil_store_enter WHERE supplier = '".$_GET["name"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'";

$result4 = mysqli_query($con, $sum);
if(mysqli_num_rows($result4) > 0 )
{
    
  $row2 = mysqli_fetch_array($result4);

    
}

echo '<table align="center" style="margin:20px 0px 20px 0px;">
        <td>إجمالي عدد الأصناف :  '.$count.'</td>
        <td>إجمالي السعر بالجُنيه :  '.$row2["sum"].'</td>
    </table>';
}
else
{
$result2 ='
<table>
<tr>
<td >لا توجد أي مشتريات </td>
</tr>
</table>
';
}
echo $result2;


?>