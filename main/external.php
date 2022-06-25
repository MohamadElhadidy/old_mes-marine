<?php
include "../config.php";

// Check user login or not
 if(!isset($_SESSION['userid'])){
 header('Location: ../');
}

// logout
if(isset($_POST['but_logout'])){

if (isset($_SESSION['userid'])) {
    unset($_SESSION['userid']);
    session_destroy();
}
 // Remove cookie variables
if (isset($_COOKIE['rememberme'])) {
    unset($_COOKIE['rememberme']);
  setcookie('rememberme', '', time() - 3600, '/mes'); // Empty value and old timestamp
}
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- mobile metas -->
    <link href="../assets/images/icons/favicon.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
<!-- site metas -->
<title>برنامج  المخازن والصيانه</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">	
<!-- bootstrap css -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- style css -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- Responsive-->
<link rel="stylesheet" href="css/responsive.css">
<!-- fevicon -->
<!-- Scrollbar Custom CSS -->
<!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<!-- owl stylesheets --> 

</head>
<body>
    <form method='post' action="" id='the_form'>
        <input type="hidden"  name="but_logout">
    </form>
        <div class="navs">
            <div class="container_nav">
                <div id="mainListDiv" class="main_list">
                    <ul class="navlinks">
                        <li><a href="spares_store"> <i class="fas fa-podcast" style="color: red"></i> الرئيسية </a></li>
                        <li><a href="javascript:{}" onclick="document.getElementById('the_form').submit(); return false;">تسجيل الخروج</a></li>
                    </ul>
                </div>
                <div class="logo">
                    <a href="spares_store">الشَركةُ البَحرية</a>
                </div>
                <span class="navTrigger">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </div>
        </div>
     
 
	<!-- product start-->
	<div id="products" class="layout_padding product_section ">
		<div class="container">
			<div class="row" style="text-align: center; color:#00004d; font-family: 'Lateef', serif; font-size:30px;padding-top: 15px;padding-bottom: 0px;">
				<div class="col-sm-12">
<strong>
  {   
  صيانة خارجية }

</strong>
				</div>
			</div>
			
		    <div class="product_section_2 images">
			    <div class="row">
				<div class="col-sm-4">
			    		<div class="images"><a href="../sub/spares_store/external_enter"><img src="images/a27.jpg" title="إذن  صيانة خارجية  " style="max-width: 100%; width: 100%;"></a></div>
			    	</div>
			    	<div class="col-sm-4">
			    		<div class="images"><a href="../sub/spares_store/external_report"><img src="images/a28.jpg" title="مستند صيانة خارجية" style="max-width: 100%; width: 100%;"></a></div>
			    	</div>
					
			    </div>
		    </div>
		</div>
	</div>
	<!-- product end-->
	
	


    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/custom.js"></script>
      <!-- javascript --> 
     

      




</body>
</html>