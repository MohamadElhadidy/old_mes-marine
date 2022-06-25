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
        recipient like '%".$searchValue."%' or 
        employee like '%".$searchValue."%' or 
        date like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = "SELECT count(*) as allcount FROM oil_store_out   WHERE oil_store_out.is_delete = 0  group by order_num ";
$Records = mysqli_query($con, $sel);
$totalRecords = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecords ++;


## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM oil_store_out  WHERE    1  ".$searchQuery."  AND oil_store_out.is_delete = 0 group by order_num ";
$Records = mysqli_query($con, $sel);
$totalRecordwithFilter = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecordwithFilter ++;


## Fetch records


$empQuery = "SELECT * FROM oil_store_out  WHERE      1  ".$searchQuery." AND oil_store_out.is_delete = 0 group by order_num order by  order_num desc ".$columnName." ".$columnSortOrder."  ".$rowLength."" ; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    
if($row["tb"] == "equipments") $row["type"] = 'صيانة مُعدات' ; 
elseif($row["tb"] == "places") $row["type"]  = 'صيانة مُنشآت'; 
elseif($row["tb"] == "workshops") $row["type"]  = 'صيانة الورش'; 
elseif($row["tb"] == "pre_equipments") $row["type"] = 'تصنيع معدات';
	    
	   


   $data[] = array( 
      "order_num"=>$row['order_num'],
      "order_date"=>$row['order_date'],
      "employee"=>$row['employee'],
      "recipient"=>$row['recipient'],
      "type"=>$row['type'],
      "show"=>'<a href="out_info.php?id='.$row["id"].'"class="btn btn-success">عرض</a>',

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