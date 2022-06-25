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
$searchQuery = "";
if($searchValue != ''){
   $searchQuery = " AND (code like '%".$searchValue."%' or 
        balance like '%".$searchValue."%' or 
        type like '%".$searchValue."%' or 
        name like '%".$searchValue."%' or 
        unit like '%".$searchValue."%' or 
        notes like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = "SELECT * FROM spares    ";
$Records = mysqli_query($con, $sel);
$totalRecords = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecords ++;


## Total number of record with filtering

$sel = "SELECT * FROM spares    where   1  ".$searchQuery." ";
$Records = mysqli_query($con, $sel);
$totalRecordwithFilter = 0 ;
while($records = mysqli_fetch_assoc($Records))$totalRecordwithFilter ++;

## Fetch records


$empQuery = "SELECT * FROM spares where  1  ".$searchQuery." order by  balance desc ".$columnName." ".$columnSortOrder."  ".$rowLength.""; 
   

$empRecords = mysqli_query($con, $empQuery);

$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    


   $data[] = array( 
      "code"=>$row['code'],
      "name"=>$row['name'],
      "balance"=>$row['balance'],
      "unit"=>$row['unit'],
      "price"=>number_format((float)$row["price"], 3, '.', ''),
      "lmit"=>$row['lmit'],
      "notes"=>$row['notes'],
      "show"=>'<a href="move_report.php?id='.$row["id"].'"class="btn btn-success">عرض</a>',

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