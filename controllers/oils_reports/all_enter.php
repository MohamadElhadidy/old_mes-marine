<?php
// Range.php
if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";



$query3 = "SELECT  count(*) as count ,Sum(balance) as balance FROM  oil_store_enter  WHERE
  order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'
";
$result3 = mysqli_query($con, $query3);
    if(mysqli_num_rows($result3) > 0 )
        {
              $row3 = mysqli_fetch_array($result3);
              $count = $row3["count"];
              $balance = $row3["balance"];

        }    
                 

$result = '';
$query = "SELECT 
    *
FROM
   oil_store_enter WHERE  order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'  

order by order_date DESC,order_num DESC "; 
$sql = mysqli_query($con, $query);
}

$query2 = "SELECT 
    * 
FROM
   oil_type  
";

$sql2 = mysqli_query($con, $query2);
if(mysqli_num_rows($sql2) > 0)
{
    $result .='
<table style="margin-bottom:20px;">';
while($row2= mysqli_fetch_array($sql2))
{
        $id = $row2['id'];
    $name = $row2['name'];
    $query2 = "SELECT  count(*) as count ,Sum(balance) as balance FROM  oil_store_enter where type ='$id'   AND  order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'  ";
$result22 = mysqli_query($con, $query2);
    if(mysqli_num_rows($result22) > 0 )
        {
              $row2 = mysqli_fetch_array($result22);
              $count = $row2["count"];
              $balance = $row2["balance"];

        }    
    if($count != 0){          

       $result .='

    <td>'.$name.'  : <span style="color: red;">'. $balance .'</span> </td>

 ';


}
}
   $result .='
</table> ';  
}


$result .='
  
<table>
<tr>
<th>رقم الإذن</th>
<th>التاريخ</th>
<th>الصنف</th>
<th>عدد / كمية</th>
<th>سعر الوحدة</th>
<th>اسم المورد </th>
<th>ملاحظات</th>
</tr>';
if(mysqli_num_rows($sql) > 0)
{
while($row = mysqli_fetch_array($sql))
{
$oils = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  oils where id =  '".$row["name"]."'   "));

$suppliers = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM oil_suppliers where id = '".$row["supplier"]."'  "));
$result .='
<tr>
<td>'.$row["order_num"].'</td>
<td>'.$row["order_date"].'</td>
<td>'.$oils["name"].'</td>
<td>'.$row["balance"].'</td>
<td>'.number_format((float)$row["price"], 2, '.', '').'</td>
<td>'.$suppliers["name"].'</td>
<td>'.$row["notes"].'</td>

</tr>';
}
echo $result;

}
else
{
$result2 ='
<table>
<tr>
<td >لا توجد حركه علي الصنف</td>
</tr>
</table>
';
}
echo $result2;


?>