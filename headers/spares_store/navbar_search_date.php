<?php
/*if(isset($_SESSION["spare_user_id"]) || isset($_SESSION["report_user_id"]) || isset($_SESSION["cost_user_id"])){
  
}else{
     header("Location: https://marine-co.org/mes_login/mes");
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="../../../assets/images/icons/favicon.png" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

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
        color: #ffffff;
        font-size: 17px;
        border: 2px solid #333333;

        }
        table td 
        {
            font-family: Arial, Helvetica, sans-serif;
            word-wrap: break-word;
            vertical-align: middle;
           padding: 2px;
           font-weight: bold;
           border: 2px solid #000000;
           background-color: #d6d6c2;
             
        }
        table
        {
            table-layout: fixed;
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
    </style>
</head>

<body>
    
    <header class="print" style="direction: rtl;">
        
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="form-inline  mr-auto my-2 my-lg-0"  style="display:block; margin:auto; ">
    

<input type="text" name="From" id="From" class="form-control" style=" text-align:center;" placeholder="من"/>
<input type="text" name="to" id="to" class="form-control" style="text-align:center;" placeholder="إلى"/>
</div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <ul class="navbar-nav mt-2 mt-lg-0" style="display:block; margin:auto;">   
<input type="button" name="range" id="range" value="تنفيذ" class="btn btn-success"/>
</nav>


<!--
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        
     <ul class="navbar-nav mt-2 mt-lg-0" style="display:block; margin:auto;">  
     <li class="nav-item"  onclick="myFunction()" href="#"><i class="fa fa-print" style="font-size:34px;"></i></a>
     </ul>
     </div>
   </nav>
   -->
</header>