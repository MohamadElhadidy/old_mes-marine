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
   $searchQuery = " or (  code like '%".$searchValue."%' or 
         name like '%".$searchValue."%' or 
         location like '%".$searchValue."%' or 
         size like '%".$searchValue."%' or 
         notes like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$sel = "SELECT count(*) as allcount FROM places WHERE is_delete = 0 ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecords = $records['allcount'] ;


## Total number of record with filtering
$sel = "SELECT count(*) as allcount FROM places   WHERE  1  ".$searchQuery." AND  is_delete = 0 ";
$Records = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($Records);
$totalRecordwithFilter = $records['allcount'] ;


## Fetch records



$empQuery = "SELECT *
FROM places 
 WHERE    1 ".$searchQuery." AND  is_delete = 0    order by  code desc  ".$columnName." ".$columnSortOrder."  ".$rowLength." " ; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {


    

   $data[] = array( 
      "code"=>$row['code'],
      "name"=>$row['name'],
      "location"=>$row['location'],
      "size"=>$row['size'],
      "notes"=>$row['notes'],
      "show"=>'<a href="update.php?id='.$row["id"].'"class="btn btn-success">تعديل</a>',

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