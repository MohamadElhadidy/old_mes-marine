<?php
// Range.php
$emp = $_GET['emp'];
$type = $_GET["type"];
if(isset($_POST["From"], $_POST["to"]))
{
require "../../../config/config.php";
$result = '';

    $query = "SELECT 
    *
FROM

   oil_store_out  WHERE type = '".$_GET["type"]." ' And recipient = '".$_GET["emp"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."' order by date
";
$sql = mysqli_query($con, $query);

$result .='
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
</tr>';
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row = mysqli_fetch_array($sql))
{
    $count++;
$result .='
<tr>
<td>'.$row["order_num"].'</td>
<td>'.$row["order_date"].'</td>
<td>'.$row["name"].'</td>
<td>'.$row["out_balance"].'</td>
<td>'.$row["unit"].'</td>
<td class="print">'.$row["price"].'</td>
<td>'.$row["direction"].'</td>
<td>'.$row["notes"].'</td>
</tr> ';
}
echo $result;


    $query2 = " SELECT SUM(price * out_balance) As sum FROM oil_store_out   WHERE type = '".$_GET["type"]."' And recipient = '".$_GET["emp"]."' AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'
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
$result2 .='
<table>
<tr>
<td >لا يوجد بيانات</td>
</tr>
</table>
';
}
echo $result2;
}
?>