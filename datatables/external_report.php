<?php

// database connection
require "../config.php";


## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$rowLength = '';
if($rowperpage  == -1)$rowLength = '';
else $rowLength = "limit ".$row.",".$rowperpage;
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = ", ".$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " AND (order_num like '%".$searchValue."%' or 
        employee like '%".$searchValue."%' or 
        worker like '%".$searchValue."%' or 
        ex_name like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$sel = "SELECT count(*) as allcount FROM external_spare_store  group by order_num";
$Records = mysqli_query($con, $sel);
$totalRecords = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecords ++;


## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM external_spare_store where   1  ".$searchQuery."  group by order_num ";
$Records = mysqli_query($con, $sel);
$totalRecordwithFilter = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecordwithFilter ++;


## Fetch records


$empQuery = "SELECT * FROM external_spare_store where  1  ".$searchQuery." group by order_num order by  order_num desc ".$columnName." ".$columnSortOrder."  ".$rowLength."" ; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    
 
   $row1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM equipments WHERE id ='".$row['equipment']."'"));
   $equipment = $row1['name'];

   $data[] = array( 
      "order_num"=>$row['order_num'],
      "order_date"=>$row['order_date'],
      "equipment"=>$equipment,
      "worker"=>$row['worker'],
      "ex_name"=>$row['ex_name'],
      "employee"=>$row['employee'],
      "show"=>'<a href="external_info.php?id='.$row["id"].'"class="btn btn-success">عرض</a>',

   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);

?>