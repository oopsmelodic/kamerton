<html ng-app="app">

    <head>

    <meta charset="utf-8">
    <title>Главная</title>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bower_components/video.js/dist/video-js/video-js.css"  type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css">
    <link href="/css/roboto.min.css" rel="stylesheet">
    <link href="/css/material.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/css/ripples.min.css" rel="stylesheet">
    <link href="/css/audioSpectrum.css" rel="stylesheet">
    <link href="/css/typeahead.css" rel="stylesheet">
    <link href="/css/spinner.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/enjoyhint.css" rel="stylesheet">
    <link href="/css/uploadfile.css"  rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">  
    <!--<link href="css/video-js.css" rel="stylesheet">-->
    <!--<link href="/purchase/bootstrap/css/docs.min.css" rel="stylesheet">-->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/video.js/dist/video-js/video.js"></script>
    <script src="/js/typeahead.js"></script>
<!--        <script src="/new/bower_components/typeahead.js/dist/bloodhound.js"></script>
    <script src="/new/bower_components/typeahead.js/src/bloodhound/remote.js"></script>-->
    <!--<script src="/new/bower_components/angular-resource/angular-resource.min.js"></script>-->
    <!--<script src="/new/bower_components/angular-resource/angular-route.js"></script>-->
    <script src="/js/enjoyhint.min.js"></script>
    <script src="/js/jqBootstrapValidation.js"></script>
    <script src="/js/jquery.uploadfile.js"></script> 
    <script src="/js/jquery.steps.js"></script> 
    <script src="/js/audioSpectrum.js"></script>
    <script src="/js/jquery.scrollTo-1.4.3.1.js"></script>
    <script src="/js/mytreeview.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/affix.js"></script>
    <script src="/js/wavesurfer.min.js"></script>
    <script type="text/javascript" src="/js/jquery.maskedinput.js"></script>
    <script src="/js/wavesurfer.regions.min.js"></script>
    <script src="/bower_components/bootbox-4.4.0/bootbox.js"></script>
    <script src="/js/jquery.timeago.js"></script>
    <script src="/js/jquery.timeago.ru.js"></script>
    <script src="/js/typeaheadDataSource.js"></script>
    <script type="text/javascript" src="/js/jquery.maskedinput.js"></script>    
    <script src="/bower_components/zeroclipboard-2.2.0/dist/ZeroClipboard.js"></script>  
    <script src="/bower_components/snackbarjs-master/dist/snackbar.min.js"></script>  
    <link href="/bower_components/snackbarjs-master/dist/snackbar.min.css"  rel="stylesheet">  
    <script src="/bower_components/bootstrap-combobox-master/js/bootstrap-combobox.js"></script>  
    <link href="/bower_components/bootstrap-combobox-master/css/bootstrap-combobox.css"  rel="stylesheet">  
    <script src="/bower_components/bootstrap-table-master/bootstrap-table-all.min.js"></script>  
    <link href="/bower_components/bootstrap-table-master/bootstrap-table.min.css"  rel="stylesheet">  
    <script src="/bower_components/bootstrap-table-master/locale/bootstrap-table-ru-RU.js"></script>  
    <link href="/bower_components/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="/bower_components/bootstrap3-editable/js/bootstrap-editable.min.js"></script>       
    <!--<script src="/js/main.js"></script>-->
    <!--<script src="/js/auth.js"></script>-->
    <script src="/js/app.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="/css/main.css">-->
    <!--<link rel="stylesheet" type="text/css" href="/css/auth.css">-->  
        <link rel="stylesheet" type="text/css" href="/css/animate.css">
    <!--<script src="/new/data/www/js/main.js"></script>-->    
    </head>

    <body>

        
    <div id="wrapper" style="padding-left:0;">
        <?php echo $data['breadcrumb'] ?>
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
                <a class="navbar-brand" href="/user"><i class="glyphicon glyphicon-home"></i> Камертон - АМ</a>
            </div>
            <div class="search form-group has-primary">
                <input type="text" class="form-control typeahead" id="inputDefault" placeholder="Поиск...">
                <video id="preview" preload="auto" controls>
                </video>                
            </div>      
            
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="glyphicon glyphicon-tasks"></i> <b class="caret"></b></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks tasks" style="width: 300px;">
                        <li class="fo">
                            <a class="text-center" href="/user/tasks/">
                                <strong>Все задачи</strong>
                            </a>
                        </li>                        
                    </ul>                   
                </li>                
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="glyphicon glyphicon-bell"></i> <b class="caret"></b></a>
                    <ul id="alerts" class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Найденно слово <span class="label label-primary">"%NAME%"</span> </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="/user/alerts/">
                                <strong>Все уведомления</strong>
                            </a>
                        </li>
                    </ul>
                </li>                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <?php echo $data['user_name']?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="disabled">
                            <a href="/user/profile"><i class="glyphicon glyphicon-user disbled"></i> Профиль</a>
                        </li>
                        <li class="disabled">
                            <a href="#"><i class="glyphicon glyphicon-envelope"></i> Сообщения</a>
                        </li>
                        <li class="">
                            <a href="/user/settings"><i class="glyphicon glyphicon-cog"></i> Настройки</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/user/logout"><i class="glyphicon glyphicon-off"></i> Выход</a>
                        </li>
                    </ul>
                </li>
            </ul>            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<!--            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                <li> 
                   
                </li>
                <li class="divider"></li>                
                <li id="files" >
                    <a href="/user/files"><i class="glyphicon glyphicon-music"></i>&nbsp&nbsp&nbsp Записи</a>
                </li>
                <li id="files" >
                    <a href="/user/tasks"><i class="glyphicon glyphicon-tasks"></i>&nbsp&nbsp&nbsp Задачи</a>
                </li>
                <li class="disabled">
                    <a href="#"><i class="glyphicon glyphicon-signal"></i>&nbsp&nbsp&nbsp Потоки</a>
                </li>                       
                </ul>
            </div>-->
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">            
            <div id="main" class="container-fluid">
                <?php include 'application/views/'.$content_view; ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<div class="glass-close"></div>
</body>
</html>