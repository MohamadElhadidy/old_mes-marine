<?php
include "../../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}
$id = $_GET['id'];

$result = mysqli_query($con, "SELECT  * FROM external_spare_store  WHERE id = '$id' ");
if(mysqli_num_rows($result) > 0 ) $row = mysqli_fetch_array($result);
$row1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM equipments WHERE id ='".$row['equipment']."'"));

    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
            <title>
            
                طباعه مستند صيانة خارجية
            
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
    <img src="../../assets/images/headers/spares_store/external-report.png" width="100%">

<div class="container">
    <table style="margin-bottom:20px;">
        <td>رقم المستند : <?php echo $row['order_num']?></td>
        <td>اسم المُعِدة : <?php echo $row1['code']; ?></td>
        <td>كود المُغِدة : <?php echo $row1['name']; ?></td>
        <td>التاريخ : <?php echo $row['order_date']; ?></td>
    </table>
    <div id="result">

		<table >
  <thead>
            <tr>
                <th>اسم الورشة</th>
                <th>الإصلاحات</th>
                <th>التكلفة</th>
                <th>مُلاحظات</th>
                <th class="print">#</th>
            </tr>
        </thead>
        <tbody>
             
	
            <tr>
                <td><?php echo $row['ex_name'] ; ?></td>
                <td><?php echo $row["details"] ;?></td>
                <td><?php echo number_format((float)$row["price"], 2, '.', '') ;?></td>
                <td><?php echo $row["notes"] ;?></td>
                <td class="print" ><a href="external_delete.php?id=<?php echo $row["id"] ;?>"  onclick="return confirm('هل أنت متأكد من عملية الحذف ؟')" class="btn btn-danger">حذف</a></td>

                <!-- <td class="print" ><a href="enter_update.php?id=<?php echo $row2["id"] ;?> " class="btn btn-primary ">تعديل</a><a href="../../controllers/spares_store/enter_delete.php?id='.$row['id'].' " class="btn btn-danger   confirmation">حذف</a></td> -->
            </tr>
	
        </tbody>
      
</table>

</div>
<table>
        <td class="color">القائم بالعمل</td>
        <td  class="color">مسئول الصيانة</td>
        <td  class="color">موظف المخزن</td>
    </table>
    <table >
        <td  class="color"><?php echo $row['worker']; ?></td>
        <td class="color"><?php echo $row['supervisor']; ?></td>
        <td  class="color"><?php echo $row['employee']; ?></td> 
    </table>
    <table >
        <td class="color">..............</td>
        <td class="color">...............</td>
        <td class="color">.............</td>
    </table>
</div>

</body>
   
</html>
