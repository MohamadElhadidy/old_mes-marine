<?php
require "../../../config/config.php";
require "../../../includes/headers/oils_store/navbar_nonosearch.php";


?>
<html>

<head>
    <title>

                   تقرير بعُهدة موظف

                </title>
    <style>
        input[type="text"] {

            width: 15%;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login_header">
                <h1>
                     اختر الصنف و اسم الموظف

                </h1>
            </div>


            <form method="GET" action="emp_move_report" autocomplete="off">

                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="type" required>
                   <option selected disabled value="">ادخل نوع الصنف او الأصناف</option>                                   
                 <?php
			    $query2 = "SELECT name FROM oil_type";
                $result2 = mysqli_query($con, $query2);
               if(mysqli_num_rows($result2) > 0 )
                 {
              while($row2 = mysqli_fetch_array($result2))
            	{?>
    	   <option value="<?php echo $row2['name'];?>"><?php echo $row2['name'];?></option>
            <?php	}}?>

                </select>

                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="emp" required>
                    <option selected disabled value="">اختر اسم الموظف</option>
                    <?php

                    $query = "SELECT name FROM ab2065_hr1_users.user ";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0 )      
                    {
                      while($row = mysqli_fetch_array($result))
                        {?>
                    <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                        <?php
                        }
                    }?>

                </select>

                <br>
                <input type="submit" value="ابحث" name="submit" />
            </form>
        </div>
    </div>
</body>

</html>
