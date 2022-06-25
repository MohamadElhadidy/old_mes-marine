<?php
/*session_start();
if(!isset($_SESSION["equip_user_id"])){
   header("Location:../../../../mes");
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
        color: #000000;
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
           background-color: #e6f2ff;
             
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
    </style>
</head>

<body>
    <header class="print">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">مارين لوجيستك</a>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../../main/equipments_places_manufacturing">الرئيسية</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" onclick="myFunction()" href="#"><i class="fa fa-print"></i></a>
                    </li>
                </ul>
                <div class="form-inline  mr-auto my-2 my-lg-0">
                    <input type="text" name="search_text" id="search_text" placeholder="ابحــــــث هنا" class="form-control">
                </div>
            </div>
        </nav>
    </header>