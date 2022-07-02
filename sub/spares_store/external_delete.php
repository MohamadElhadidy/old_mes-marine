<?php
require "../../config.php";

if(!isset($_SESSION['userid'])){
    header('Location: ../../');
}       
        mysqli_query($con,"update external_spare_store set is_delete = 1 where id = '".$_GET['id']."'");
		
	echo "<script>
                alert('تم حذف البيانات بنجاح')
                window.location.href = 'external_report';
            </script>";
    
?>