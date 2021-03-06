<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>СМИ-Статистика</title>

        <!-- Bootstrap - Material-->
        <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css">
        <link href="/css/roboto.min.css" rel="stylesheet">
        <link href="/css/material.min.css" rel="stylesheet">
        <link href="/css/simple-sidebar.css" rel="stylesheet">
        <link href="/css/ripples.min.css" rel="stylesheet">    
        <link href="/css/main.css" rel="stylesheet">    
        
        <!-- Custom styles for this template -->
        <link href="grid.css" rel="stylesheet">
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/bower_components/angular/angular.min.js"></script>   
        <link rel="stylesheet" type="text/css" href="/css/animate.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-color: #eee;">
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><i class="fa fa-pie-chart"></i> Статистика СМИ</a>
            </div>
            <div class="search form-group has-primary">
                <input type="text" class="form-control typeahead" id="name" placeholder="Фильтр...">
            </div>           
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    <a href="/"><i class="glyphicon glyphicon-off"></i> Выход</a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav list-group-lol" style="width:262px;">
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <div id="main" class="container-fluid" style="background-color: #eee;">
                   <div class="container col-md-offset-1 col-sm-offset-1 col-lg-offset-1 col-md-10 col-sm-10 col-lg-10">
                            <div  class="col-md-12 col-sm-12 col-lg-12 shadow-block">
                                <div class="col-md-6 col-sm-6 col-lg-6" id="info">
                                    <p class="lead" align="center">Сводка: <strong></strong></p>
                                </div>                                                                
                                <div class="col-md-offset-1 col-md-5 col-lg-5 col-sm-5">
                                    <h4 class="brd" align="center">Процент посещаемости из России</h4>
                                    <canvas  id="myChartPolar" style="height:25%;"></canvas>       
                                </div>   
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <h4 class="brd" align="center">Рейтинг цитируемости</h4>
                                    <canvas  style="height:50%; width: 100%;" id="myChart"></canvas>
                                </div>                              
                            </div>

                    </div>
                    <script src="js/bootstrap3-typeahead.js" language='javascript'></script>
                    <script src="js/Chart.js" language='javascript'></script>
                    <script src="js/info.js" language='javascript'></script>
                    <?php echo "<script language='javascript'> $(function(){reset('" . $_GET["name"] . "','gosReestrName');})</script>" ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<div class="glass-close"></div> 
    </body>
</html>

 