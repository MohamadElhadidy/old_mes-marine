<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}
$id = $_GET['id'];

$result = mysqli_query($con, "SELECT  * FROM spare_store_out  WHERE id = '$id' ");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);

$order_num = $row['order_num'];

$sum = mysqli_query($con, "SELECT SUM(price * balance) As sum,  count(*) as total  FROM spare_store_out  WHERE  is_delete = 0 AND tb = 'safety'  AND order_num = '$order_num' ");
if(mysqli_num_rows($sum) > 0 ) $row5 = mysqli_fetch_array($sum);
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
            <title>
            
                طباعة مستند خروج
            
            </title>
    <link href="../../assets/images/icons/favicon.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 
    <script>
        function myFunction() {
            window.print();
        }
    </script>
     <style>
    body
    {
        width: 100%;
        direction: rtl;
        font-weight: bold;
    }
        @media print {
            .print {
                display: none;
            }

        }

        table th {
        font-family: Arial, Helvetica, sans-serif;   
        font-style: bold;
        background-color:#3399ff;
        color: #000000;
        padding: 4px;
        border: 2px solid #333333;

        }
        table td 
        {
            font-family: Arial, Helvetica, sans-serif;
            word-wrap: break-word;
            vertical-align: middle;
           padding: 2px;
           font-weight: bold;
           border: 2px solid #333333;
           background-color: #ffffff;
             
        }
        table
        {
            max-width: 100%;
            width: 100%;
            text-align: center;
           
        }
        .none
        {
            border: hidden;
            background-color: #fff;
        }
        .color
        {
            border: hidden;
        }
        .nav-item{
            cursor: pointer;
        }
    </style>
</head>

<body>
    <img src="../../assets/images/headers/spares_store/out-report1.png" width="100%">

<div class="container">
    <table style="margin-bottom:20px;">
        <td>رقم المستند : <?php echo $order_num?></td>
        <td>التاريخ : <?php echo $row['order_date']; ?></td>
        <td>اسم المستلم : <?php echo $row['recipient']; ?></td>
    </table>
    <div id="result">
        <?php 

$result2 = mysqli_query($con, "SELECT  * FROM spare_store_out  WHERE  is_delete = 0  AND tb = 'safety'   AND order_num = '$order_num' ");
if(mysqli_num_rows($result2) > 0 )
{
    ?>

		<table >
  <thead>
            <tr>
                <th>اسم الصنف</th>
                <th>عدد</th>
                <th>سِعر الوِحده</th>
                <th>التَوجِيه/الإستِخدَام</th>
                <th>مُلاحظات</th>
                <th class="print">#</th>
            </tr>
        </thead>
        <tbody>
              <?php 
	while($row2 = mysqli_fetch_array($result2))
	{
        $row3 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spares WHERE id ='".$row2['name']."'"));
        $name = $row3['name'];
        $type = $row2['tb'];
        $direction = $row2["direction"];
        $direction2 = '';
        if($type == 'other ') $direction2 = 'أخري' ;
        elseif($type=='safety')$direction2 ="مهمات وقائية" ;
		elseif($type=='tools')$direction2 = "عدد و أدوات" ;
                 
            	?>
            <tr>
                <td><?php echo $name ; ?></td>
                <td><?php echo $row2["balance"] ;?></td>
                <td><?php echo number_format((float)$row2["price"], 2, '.', '') ;?></td>
                <td><?php echo $direction2 ;?></td>
                <td><?php echo $row2["notes"] ;?></td>
                <td class="print" ><a href="out_delete.php?id=<?php echo $row2["id"] ;?>"  onclick="return confirm('هل أنت متأكد من عملية الحذف ؟')" class="btn btn-danger">حذف</a></td>
                <!-- <td class="print" ><a href="enter_update.php?id=<?php echo $row2["id"] ;?> " class="btn btn-primary ">تعديل</a><a href="../../controllers/spares_store/enter_delete.php?id='.$row['id'].' " class="btn btn-danger   confirmation">حذف</a></td> -->
            </tr>
 <?php 
	}
    ?>
        </tbody>
    
</table>
<?php  } ?>
<table align="center" style="margin:20px 0px 20px 0px;">
        <td>إجمالي الأصناف : <?php echo  $row5['total']; ?>  </td>
        <td>إجمالي السِعر بالجُنيه :  <?php echo  number_format((float)$row5["sum"], 2, '.', '') ; ?> جنيها </td>
    </table>
</div>
<table>
        <td  class="color">موظف المخزن</td>
        <td class="none"></td>
        <td  class="color"> اسم المستلم</td> 
    </table>
    <table >
        <td  class="color"><?php echo $row['employee']; ?></td>
        <td class="none"></td>
        <td  class="color"> <?php echo $row['recipient']; ?></td> 
    </table>
    <table >
        <td class="color">..............</td>
        <td class="none"></td>
        <td class="color">.............</td>
    </table>
</div>

</body>
   
</html>
