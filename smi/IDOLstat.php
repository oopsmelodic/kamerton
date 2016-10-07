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
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">

        <!-- Custom styles for this template -->
        <link href="grid.css" rel="stylesheet">
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/bower_components/angular/angular.min.js"></script>   
        <script type="text/javascript" src="/js/jquery.maskedinput.js"></script>       
        <script type="text/javascript" src="/js/moment.js"></script>
        <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/jquery.bootpag.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="/css/animate.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-color: #eee;">
        <div id="wrapper" style="padding-left: 0px;">

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
                    <a class="navbar-brand" href=""><i class="fa fa-pie-chart"></i> Статистика IDOL</a>
                </div>
<!--                <div class="search form-group has-primary">
                    <input type="text" class="form-control typeahead" id="name" placeholder="Фильтр...">
                </div>           -->
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li>
                        <a href="/"><i class="glyphicon glyphicon-off"></i> Выход</a>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <!--                <div class="collapse navbar-collapse navbar-ex1-collapse">
                                    <ul class="nav navbar-nav side-nav list-group-lol" style="width:262px;">
                
                                    </ul>
                                </div>-->
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">
                <div id="main" class="container-fluid" style="background-color: #eee;">
                    <div class="container col-md-12 col-sm-12 col-lg-12">
                        <!--                        <div  class="col-md-12 col-sm-12 col-lg-12 shadow-block">
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
                                                </div>-->
                        <div  class="col-md-4 col-sm-4 col-lg-4">
                            <div  class="col-md-12 col-sm-12 col-lg-12">
                                <div class="col-md-12 col-sm-12 col-lg-12 shadow-block" style="margin-right: 10px;">
                                    <h4 class="brd" align="center">Настройка поиска</h4>
                                    <div class="col-md-12">
                                        <!--                                    <label class="control-label col-md-2 col-md-offset-2" for="name">Событие:</label>   -->
                                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;">
                                            <h5 class="brd" align="center">Текст: </h5>
                                            <input type="text" class="form-control" id="textFilter" placeholder="Искомое слово">
                                        </div>
                                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;">
                                            <h5 class="brd" align="center">Фильтры: </h5>
                                            <div id="lol" style=" overflow-y:auto; height:200px; margin-top: 15px;">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;">
                                            <h5 class="brd" align="center">Фильтр дат: </h5>
                                            <input type="text" class="form-control" id="startdate" placeholder="Начало">
                                        </div>
                                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;">
                                            <input type="text" class="form-control" id="enddate" placeholder="Конец">
                                        </div>
                                        <!--<div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;"><input type="text" class="form-control" id="textFilter" placeholder="Искомое слово..."></div>-->
                                        <div class="col-md-6 col-md-offset-1" style="margin-bottom: 10px;">
                                            <button data-bb-handler="success" type="button" class="btn btn-success" id="search">Поиск</button>
                                        </div>
                                        
                                        <div class="col-md-5" style="margin-bottom: 10px;">
                                            <button data-bb-handler="danger" type="button" class="btn btn-danger" id="clear">Сбросить</button>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
<!--                            <div  class="col-md-12 col-sm-12 col-lg-12">
                                <div class="col-md-12 col-sm-12 col-lg-12 shadow-block" style="margin-right: 10px; height:350px;">
                                    <h4 class="brd" align="center">История запросов</h4>
                                    <div class="col-md-12">
                                        <ul class="list-group-lol" style="width:262px;">

                                        </ul>
                                        
                                        
                                                                            <label class="control-label col-md-2 col-md-offset-2" for="name">Событие:</label>   
                                        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 10px;"><input type="text" class="form-control" id="textFilter" placeholder="Искомое слово"></div>

                                    </div>
                                </div>                              
                            </div>-->
                        </div>
                        <div  class="col-md-8 col-sm-8 col-lg-8">
                            <div class="shadow-block">
                            <ul class="nav nav-pills" style="margin-top: 5px; background-color: #fff;">
                                <li class="active"><a href="#doctab" data-toggle="tab" id="docclick">Документы</a></li>
                                <li><a href="#stattab" data-toggle="tab" id="statclick">Статистика</a></li>
                            </ul>
<!--                                <div class="text-center"><div class="docnav" style="border-top: 2px solid #009688; margin-top:5px"></div></div>-->
                                
                            </div>
                            <div id="myTabContent" class="tab-content" style="height: 90%;">
                                <div class="tab-pane fade active in" id="doctab">
                                    <div id="docdiv"> 

                                    </div>
                                    <div class='col-md-12 col-sm-12 col-lg-12 shadow-block' style="margin-bottom: 5px;"><div class="text-center "><div id="page-selection"></div></div></div>
                                </div>   
                                <div class="tab-pane fade" id="stattab">
                                    
                                    <div class="col-md-12 col-sm-12 col-lg-12 shadow-block chart1">
                                        <div class="brd">
                                            <button type="button" class="btn btn-success btn-sm" id="llim" style="display: inline-block; margin-left: 20px;"><span class="glyphicon glyphicon-chevron-left"></span></button>
                                            <button type="button" class="btn btn-success btn-sm" id="rlim" style="display: inline-block;"><span class="glyphicon glyphicon-chevron-right"></span></button>
                                            <h4  align="center" style="display: inline-block; width: 75%; text-align: center;">ПОЗИТИВ / НЕГАТИВ</h4>
                                        </div>
                                        <canvas  style="height:40%; width: 100%; max-height: 500px;" id="attitudeChart"></canvas>
                                    </div> 
                                    <div class="col-md-12 col-sm-12 col-lg-12 shadow-block chart1">
                                        <div class="brd" id="doctext">
                                            <h4 align="center">Количество документов</h4>

                                        </div>
                                        <canvas  style="height:40%; width: 100%; max-height: 500px;" id="docChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <script src="js/bootstrap3-typeahead.js" language='javascript'></script>
                    
                    <script src="js/Chart.js" language='javascript'></script>
                    <script src="js/IDOL.js" language='javascript'></script>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <div class="glass-close"></div> 
    </body>
</html>