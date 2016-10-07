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
    <link href="/css/ripples.min.css" rel="stylesheet">
    <link href="/css/audioSpectrum.css" rel="stylesheet">
    <link href="/css/typeahead.css" rel="stylesheet">
    <link href="/css/spinner.css" rel="stylesheet">
    <link href="/css/enjoyhint.css" rel="stylesheet">
    <link href="/css/uploadfile.css"  rel="stylesheet">    
    <link href="owl.carousel.2/assets/owl.carousel.css"  rel="stylesheet">    
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/video.js/dist/video-js/video.js"></script>
    <script src="/js/typeahead.js"></script>
    <script src="owl.carousel.2/owl.carousel.js"></script>
    
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
    <link rel="stylesheet" type="text/css" href="landing.css">  
    <script src="landing.js"></script>
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
    <div class="row">
        <div class="col-md-offset-1 col-sm-offset-1 col-sm-10 col-lg-7 header">
            <h1><i class="fa fa-info"></i> <i class="fa fa-play"></i> Информационно аналитический портал</h1>
        </div>
    </div>
    <div class="row carret">     
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-play"></i>
          <div class="caption">
            <h3>Камертон-АМ</h3>
            <p>Сервис транскрибирования и обработки медиа информации.</p>
            <a href="/auth/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-users"></i>
          <div class="caption">
            <h3>Социальный граф</h3>
            <p>Сервис поиска информации о людях в различных социальных сетях.</p>
            <a href="/social/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-exchange"></i>
          <div class="caption">
            <h3>Гос закупки</h3>
            <p>Сервис поиска различной информации по Государственным закупкам.</p>
            <a href="/purchase/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-pie-chart"></i>
          <div class="caption">
            <h3>Статистика СМИ</h3>
            <p>Информационная сводка по различным СМИ источникам.</p>
            <a href="/smi/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-bar-chart"></i>
          <div class="caption">
            <h3>ПСКОВ</h3>
            <p>Сервис поиска,обработки,анализа данных из различных источников данных.</p>
            <a href="http://research.in-line.ru/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-newspaper-o"></i>
          <div class="caption">
            <h3>Мониторинг новостей HPUS 8.1</h3>
            <p>Сервис мониторинга новостей из различных СМИ источников.</p>
            <a href="http://nevod.in-line.ru/iusNM/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-newspaper-o"></i>
          <div class="caption">
            <h3>Мониторинг новостей HPUS 8.1</h3>
            <p>Сервис мониторинга новостей из различных СМИ источников.</p>
            <a href="http://nevod.in-line.ru/iusNM/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="item item-list">
          <i class="fa fa-newspaper-o"></i>
          <div class="caption">
            <h3>Мониторинг новостей HPUS 8.1</h3>
            <p>Сервис мониторинга новостей из различных СМИ источников.</p>
            <a href="http://nevod.in-line.ru/iusNM/" class="btn btn-primary" role="button">Перейти</a>
          </div>
        </div>
      </div>
    </div>
    <div class="more-info">
        <div class="item col-md-12">
            <div class="slider">
                <div class="item_slide"><img src="img/slide1/1.png" alt="Slide1 Image"></div>
                <div class="item_slide"><img src="img/slide1/2.png" alt="Slide1 Image"></div>
                <div class="item_slide"><img src="img/slide1/3.png" alt="Slide1 Image"></div>            
            </div>
            <div>
                
            </div>
        </div>
    </div>
    <div class="row footer">
        <div><i class="fa fa-copyright"> 2015-...</i> Inline Technologies</div>
    </div>    
</body>
</html>