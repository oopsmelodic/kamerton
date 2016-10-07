<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Главная</title>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bower_components/video.js/dist/video-js/video-js.css"  type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="/bower_components/font-awesome-4.4.0/css/font-awesome.min.css">
    <link href="/css/roboto.min.css" rel="stylesheet">
    <link href="/css/material.min.css" rel="stylesheet">
    <!--<link href="/css/simple-sidebar.css" rel="stylesheet">-->
    <link href="/css/ripples.min.css" rel="stylesheet">
    <link href="/css/audioSpectrum.css" rel="stylesheet">
    <link href="/css/typeahead.css" rel="stylesheet">
    <link href="/css/spinner.css" rel="stylesheet">
    <!--<link href="/new/data/www/css/main.css" rel="stylesheet">-->
    <link href="/css/enjoyhint.css" rel="stylesheet">
    <link href="/css/uploadfile.css"  rel="stylesheet">    
    <link href="/css/landing.css"  rel="stylesheet">    
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
    <script src="/js/jquery.uploadfile.js"></script> 
    <script src="/js/audioSpectrum.js"></script>
    <script src="/js/jquery.scrollTo-1.4.3.1.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <script src="/js/affix.js"></script>
    <script src="/js/wavesurfer.min.js"></script>
    <script src="/js/wavesurfer.regions.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/auth.js"></script>
    <script src="/js/app.js"></script>
        <!--<link rel="stylesheet" type="text/css" href="/css/main.css">-->
    <!--<link rel="stylesheet" type="text/css" href="/css/auth.css">-->  
        <link rel="stylesheet" type="text/css" href="/css/animate.css">
    <!--<script src="/new/data/www/js/main.js"></script>-->    
   <script type="text/javascript">
   $(document).ready(function() {
//           $.material.init();
   	   $("body").css("display", "none"); 

	   $("body").fadeIn(600); 
	   $("a.fade").click(function(event){ 
		   event.preventDefault();
		   linkLocation = this.href;
		   $("body").fadeOut(500, redirectPage); 
	   });

	   function redirectPage() {
		   window.location = linkLocation;
	   }
   });
   
   </script>        
</head>
<body>
    <?php include 'application/views/'.$content_view; ?>
</body>
</html>