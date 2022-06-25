<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Range.php
if(isset($_POST["From"], $_POST["to"]))
{
require "../../config.php";



$query3 = "SELECT  count(*) as count ,Sum(balance) as balance FROM  spare_store_out  WHERE
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
if(isset($_GET['page']))
{
	$page=$_GET['page'];
}
else
{
	$page = 1;
	}
			$limit = 100;						
									
	$offset=($page-1)*$limit;
$query = "SELECT 
    *
FROM
   spare_store_out WHERE  is_delete = 0  AND order_date  BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'  

order by order_date DESC,order_num DESC LIMIT  $offset,  $limit "; 
$sql = mysqli_query($con, $query);
}

$query2 = "SELECT 
    * 
FROM
   spare_types  
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
    $query2 = "SELECT  count(*) as count ,Sum(balance) as balance FROM  spare_store_out where type ='$id'   AND  order_date BETWEEN '".$_POST["From"]."' AND '".$_POST["to"]."'  ";
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
<th>
التوجيه/الاستخدام
</th>
<th>
اسم المُستَلِم
</th>
<th>ملاحظات</th>
</tr>';
if(mysqli_num_rows($sql) > 0)
{
while($row = mysqli_fetch_array($sql))
{
$spares = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  spares where id =  '".$row["name"]."'   "));

 $type = $row['tb'];
        if($type == 'other') $direction2 = 'أخري' ;
        elseif($type == 'safety') $direction2 = 'مهمات وقائية' ;
        elseif($type == 'tools') $direction2 = 'عدد و أدوات' ;
        else{
		if($type=='pre_equipments') {$done="where done = '0'";} else {$done="where 1";}
            $result5 = mysqli_query($con, "SELECT * FROM `" . $type . "` $done AND  id = '".$row["direction"]."' AND is_delete = '0' ");
                if(mysqli_num_rows($result5) > 0 ){
                    $row14 = mysqli_fetch_array($result5);
                    $direction2 =  $row14['name'];
        }
                }  
                 
$result .='
<tr>
<td>'.$row["order_num"].'</td>
<td>'.$row["order_date"].'</td>
<td>'.$spares["name"].'</td>
<td>'.$row["balance"].'</td>
<td>'.number_format((float)$row["price"], 2, '.', '').'</td>
<td>'.$direction2.'</td>
<td>'.$row["recipient"].'</td>
<td>'.$row["notes"].'</td>

</tr>';
}
echo $result;

}



?>