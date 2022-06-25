<?php

require "../../config.php";
 if(!isset($_SESSION['userid'])){
 header('Location: ../');
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>حركة الوارد اليومي</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
<style>
    #wrapper {
  margin: 0 auto;
  display: block;
  width: 960px;
}
.page-header {
  text-align: center;
  font-size: 1.5em;
  font-weight: normal;
  border-bottom: 1px solid #ddd;
  margin: 30px 0;
}
#pagination {
  margin: 0;
  padding: 0;
  text-align: center;
}
#pagination li {
  display: inline;
}
#pagination li a {
  display: inline-block;
  text-decoration: none;
  padding: 5px 10px;
  color: #000;
}

/* Active and Hoverable Pagination */
#pagination li a {
  border-radius: 5px;
  -webkit-transition: background-color 0.3s;
  transition: background-color 0.3s;
}
#pagination li a.active {
  background-color: #4caf50;
  color: #fff;
}
#pagination li a:hover:not(.active) {
  background-color: #ddd;
}

/* border-pagination */
.b-pagination-outer {
  width: 100%;
  margin: 0 auto;
  text-align: center;
  overflow: hidden;
  display: flex;
}
#border-pagination {
  margin: 0 auto;
  padding: 0;
  text-align: center;
}
#border-pagination li {
  display: inline;
}
#border-pagination li a {
  display: block;
  text-decoration: none;
  color: #000;
  padding: 5px 10px;
  border: 1px solid #ddd;
  float: left;
}
#border-pagination li a {
  -webkit-transition: background-color 0.4s;
  transition: background-color 0.4s;
}
#border-pagination li a.active {
  background-color: #4caf50;
  color: #fff;
}
#border-pagination li a:hover:not(.active) {
  background: #ddd;
}

</style>
</head>
<body>
<img src="../../assets/images/headers/oils_store/204.png" width="100%">


<?php

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

$query = "SELECT *  FROM  oil_store_enter  where is_delete = 0 order by order_date DESC,order_num DESC LIMIT  $offset,  $limit";

$sql = mysqli_query($con, $query);
 require "../../headers/oils_store/navbar_search_date.php";
?>

<div class="container">

   

  
<div id="purchase_order">
    <table style="margin-bottom:20px;">
    
    
<?php
$query2 = "SELECT 
    * 
FROM
   oil_type
";

$sql2 = mysqli_query($con, $query2);
if(mysqli_num_rows($sql2) > 0)
{
while($row2= mysqli_fetch_array($sql2))
{
    $id = $row2['id'];
    $name = $row2['name'];
    $query2 = "SELECT  count(*) as count ,Sum(balance) as balance FROM  oil_store_enter where type ='$id' ";
$result2 = mysqli_query($con, $query2);
    if(mysqli_num_rows($result2) > 0 )
        {
              $row2 = mysqli_fetch_array($result2);
              $count = $row2["count"];
              $balance = $row2["balance"];

        }    
    if($count != 0){          
    ?>
    
        <td><?php echo $name ?> : <span style='color: red;'> <?php echo $balance; ?></span></td>

    <?php
    
}
}
    
}

?>
</table>   
<table>
<tr>
<th>رقم الإذن</th>
<th>التاريخ</th>
<th>الصنف</th>
<th>عدد / كمية</th>
<th>سعر الوحدة</th>
<th>اسم المورد </th>
<th>ملاحظات</th>
</tr>
<?php
if(mysqli_num_rows($sql) > 0)
{
while($row= mysqli_fetch_array($sql))
{
$oils = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM  oils where id =  '".$row["name"]."'   "));

$suppliers = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM oil_suppliers where id = '".$row["supplier"]."'  "));

?>
<tr>
<td><?php echo $row["order_num"]; ?></td>
<td><?php echo $row["order_date"]; ?></td>
<td><?php echo $oils["name"]; ?></td>
<td><?php echo $row["balance"]; ?></td>
<td><?php echo number_format((float)$row["price"], 2, '.', ''); ?></td>
<td><?php echo $suppliers["name"]; ?></td>
<td><?php echo $row["notes"]; ?></td>
</tr>
<?php
}
}?>
</div>
</div>
  <div class="b-pagination-outer  print">
 
  <ul id="border-pagination">
  <?php
								
								$sql2 = mysqli_query($con, "SELECT count(*) as count  FROM  oil_store_enter  where is_delete = 0");
					
								
								if(mysqli_num_rows($sql2) > 0)
								{
                                    $row2= mysqli_fetch_array($sql2);
									$total_page = ceil($row2['count'] / $limit);    
 
  if($page > 1)
									{	
										echo  '<li><a class="" href="all_enter.php?page='.($page - 1).'">«</a></li>';	
									} 
                                    for($i=1; $i<=$total_page; $i++)
									{
										if($i == $page){
											
											$active = "active";	
										}
										else{
											
											$active = "";
										}
                                      
   
   echo '  <li><a href="all_enter.php?page='.$i.'" class=" '.$active.' ">'.$i.'</a></li>';
                                    }

    if($total_page > $page)
									{	
										echo  '<li><a class="" href="all_enter.php?page='.($page + 1).'">»</a></li>';	
									} 
                                    
                                }?>
  </ul> 
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<!-- Script -->
<script>
$(document).ready(function(){
$.datepicker.setDefaults({
dateFormat: 'yy-mm-dd'
});
$(function(){
$("#From").datepicker();
$("#to").datepicker();
});
$('#range').click(function(){
var From = $('#From').val();
var to = $('#to').val();
if(From != '' && to != '')
{
$.ajax({
url:"../../controllers/oils_reports/all_enter.php",
method:"POST",
data:{From:From, to:to},
success:function(data)
{
$('#purchase_order').html(data);
}
});
}
else
{
alert("اختر تاريح");
}
});
});
</script>
</body>
</html>