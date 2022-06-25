<?php
require "../../config.php";

 if(!isset($_SESSION['userid'])){
 header('Location: ../../');
}

	$query1 = mysqli_query($con,"SELECT * FROM oil_store_out WHERE id ='".$_GET['id']."'");
    if(mysqli_num_rows($query1) > 0 ) $row1 = mysqli_fetch_array($query1);

     $query = mysqli_query($con,"SELECT * FROM oils WHERE id ='".$row1['name']."'");
    if(mysqli_num_rows($query) > 0 ) $row = mysqli_fetch_array($query);

        $today = strtotime(date("Y-m-d H:i:s"));
        $date = date("Y-m-d H:i:s");

        $expire = strtotime($row1["date"]. ' + 30 days');
     /*   if($today >= $expire){
    	        echo "<script>
                alert('لا يسمح التعديل بعد مرور شهر')
                window.location.href = 'out_report';
                    </script>";
        }else{
*/

            $newBalance = $row['balance'] +  $row1['balance'];
            mysqli_query($con,"update oils set balance = '$newBalance' where id = '".$row1['name']."'");
            mysqli_query($con,"update oil_store_out set is_delete = 1 where id = '".$_GET['id']."'");
		
	        echo "<script>
                alert('تم حذف البيانات بنجاح')
                window.location.href = 'out_report';
            </script>";


  //  }
   
    



?>