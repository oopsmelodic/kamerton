<?php
    header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <link rel="stylesheet" type="text/css" href="css/my-menu.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-social.css">
    <!--<link rel="stylesheet" type="text/css" href="/font_awesome/css/font-awesome.css">-->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-social.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/docs.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">    
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">        
    <link rel="stylesheet" type="text/css" href="css/jquery.circliful.css">        
    <link rel="stylesheet" type="text/css" href="css/sweet-alert.css">        
    <script type="text/javascript" src="js/sweet-alert.js"></script>
    <script type="text/javascript" src="js/moment.js"></script>    
    <script type="text/javascript" src="js/jquery.circliful.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootbox.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/readmore.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>


<title>Search</title>
</head>
<body>
        <div class="col-lg-12 head">            
            <div class="media-img"></div>
            <div class="col-sm-4">
                    <h2>Социальный граф</h2>
                    <p>Поиск по социальным сетям</p>
            </div>
            <div class="col-sm-4 inputs">
                 <input id="lname" type="text" class="form-control" placeholder="Фамилия">
                 <input id="fname" type="text" class="form-control" placeholder="Имя">
                 <input type="text" class="form-control" id="datetimepicker1" placeholder="Дата/Время">                            
            </div>     
            <div class="col-md-1">
                <button id="findbtn" class="btn btn-primary" ><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        <div class="container">

        </div>
   <div id="main-content" class="container">
   </div>
</body>    
</html>