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
$columnName = " spare_store_enter.".$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " or (  spare_store_enter.order_num like '%".$searchValue."%' or 
         spare_store_enter.employee like '%".$searchValue."%' or 
         spare_store_enter.date like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$sel = "SELECT count(*) as allcount FROM spare_store_enter
INNER JOIN spare_suppliers  ON spare_store_enter.supplier = spare_suppliers.id
INNER JOIN spare_types  ON spare_store_enter.type = spare_types.id  WHERE spare_store_enter.is_delete = 0  
   group by spare_store_enter.order_num";
$Records = mysqli_query($con, $sel);
$totalRecords = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecords ++;


## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM spare_store_enter  
INNER JOIN spare_suppliers  ON spare_store_enter.supplier = spare_suppliers.id
INNER JOIN spare_types  ON spare_store_enter.type = spare_types.id
    WHERE   (spare_suppliers.name LIKE '%".$searchValue."%'  or   spare_types.name LIKE '%".$searchValue."%')   ".$searchQuery." AND  spare_store_enter.is_delete = 0 
   group by spare_store_enter.order_num ";
$Records = mysqli_query($con, $sel);
$totalRecordwithFilter = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecordwithFilter ++;


## Fetch records



$empQuery = "SELECT spare_store_enter.*
FROM spare_store_enter 
 INNER JOIN spare_suppliers  ON spare_store_enter.supplier = spare_suppliers.id
INNER JOIN spare_types  ON spare_store_enter.type = spare_types.id
 WHERE     (spare_suppliers.name LIKE '%".$searchValue."%'  or   spare_types.name LIKE '%".$searchValue."%' )   ".$searchQuery." AND  spare_store_enter.is_delete = 0  group by spare_store_enter.order_num  order by ".$columnName." ".$columnSortOrder."  ".$rowLength." " ; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

   $row1 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spare_suppliers WHERE id ='".$row['supplier']."'"));
   $supplier = $row1['name'];

   $row3 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM spare_types WHERE id ='".$row['type']."'"));
   $type = $row3['name'];
    

   $data[] = array( 
      "order_num"=>$row['order_num'],
      "order_date"=>$row['order_date'],
      "employee"=>$row['employee'],
      "supplier"=>$supplier,
      "type"=>$type,
      "show"=>'<a href="enter_info.php?id='.$row["id"].'"class="btn btn-success">عرض</a>',

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