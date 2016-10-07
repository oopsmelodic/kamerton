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
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/enjoyhint.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">  
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/video.js/dist/video-js/video.js"></script>
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
    <script src="/bower_components/snackbarjs-master/dist/snackbar.min.js"></script>  
    <link href="/bower_components/snackbarjs-master/dist/snackbar.min.css"  rel="stylesheet">    
    <!--<script src="/js/app.js"></script>-->
    <link rel="stylesheet" type="text/css" href="/css/animate.css">
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