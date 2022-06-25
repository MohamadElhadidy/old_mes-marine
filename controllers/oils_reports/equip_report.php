<?php
$equip = $_GET["equip"];
$type= $_GET["type"];

$result2 ='';
if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";
$result = '';

$query = "SELECT * FROM    oil_store_out  WHERE direction = '".$_GET["equip"]."' AND type = '".$_GET["type"]."' AND tb = 'equipments'  
        AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."' 
        order by order_num DESC  
";
$sql = mysqli_query($con, $query);

$result .='
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
</tr>';
if(mysqli_num_rows($sql) > 0)
{
    $count=0;
while($row = mysqli_fetch_array($sql))
{
        $query3 = " SELECT SUM(price * balance) As sums FROM oil_store_out   WHERE  id = '".$row["id"]."'
";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 )
{
    
  $row3 = mysqli_fetch_array($sql3);

    
}
        $query3 = " SELECT * FROM oils  WHERE  id = '".$row["name"]."'
";
$sql3 = mysqli_query($con, $query3);
if(mysqli_num_rows($sql3) > 0 )
{
    
  $row13 = mysqli_fetch_array($sql3);

    
}
    $count++;
$result .='
<tr>
<td>'.$row["order_num"].'</td>
<td>'.$row["order_date"].'</td>
<td>'.$row13["name"].'</td>
<td>'.$row["balance"].'</td>
<td>'.number_format((float)$row["price"], 2, '.', '').'</td>
<td>'.number_format((float)$row3["sums"], 2, '.', '').'</td>
<td>'.$row["recipient"].'</td>
<td>'.$row["notes"].'</td>
</tr> ';
}


 $query2 = "  SELECT SUM(price *balance) As sum,sum(balance) as qnt FROM oil_store_out   
 WHERE  direction = '".$_GET["equip"]."' AND
   type = '".$_GET["type"]."' AND tb = 'equipments'  AND order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."' 
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
        <td>إجمالي السعر بالجنية :  '.$row2["sum"].'</td>
        </table>';
        echo $result;
}
else
{
$result2 ='
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