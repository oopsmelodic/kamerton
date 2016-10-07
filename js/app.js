 'use strict';
 var app = angular.module("app", []);
    app.controller("myCtrl", function($scope) {
        $scope.firstName = "John";
        $scope.lastName = "Doe";
    });
    app.controller("sideMenu", function($scope) {
    });
   
    $(function (){
        
$('#files_upload').click(function (){
            var uploadObj = null;
            bootbox.dialog({
                    title:  '<i class="glyphicon glyphicon-upload"></i> '+ 'Загрузка файлов',
                    message: '<div class="row">  ' +
                                '<div class="col-md-12"> ' +
                                '<form class="form-horizontal"> ' +
                                    '<div class="form-group type_load"> ' +
                                        '<label class="col-md-3 control-label" for="name">Тип загрузки:</label> ' +
                                        '<div class="col-md-7 type_load"> ' +
                                            '<div class="btn-group" data-toggle="buttons">'+
                                              '<label class="btn btn-primary active">'+
                                                '<input type="radio" name="options" id="local" autocomplete="off" checked value="local"><i class="fa fa-upload"> Локальная</i>'+
                                              '</label>'+
                                              '<label class="btn btn-primary">'+
                                                '<input type="radio" name="options" id="youtube" autocomplete="off" value="YouTube"><i class="fa fa-youtube"> YouTube</i> '+
                                              '</label>'+
                                            '</div>'+                                             
                                        '</div> ' +
                                    '</div>' +                                   
                                    '<div class="form-group"> ' +
                                        '<label class="col-md-3 control-label" for="name">Обработка:</label> ' +
                                        '<div class="col-md-7"> ' +
                                            '<select class="input-large combobox">'+
                                              '<option value="stream2text">Речь в текст</option>'+
                                            '</select>'+                                                          
                                        '</div> ' +
                                    '</div>' +                                                             
                                    '<div class="form-group lang"> ' +
                                        '<label class="col-md-3 control-label" for="name">Язык обработки:</label> ' +
                                        '<div class="col-md-7"> ' +
                                            '<select class="input-large combobox">'+
                                              '<option value="ru-RU">Русский</option>'+
                                              '<option value="en-US">Английский</option>'+
                                            '</select>'+                                                          
                                        '</div> ' +
                                    '</div>' +                                
                                    '<div class="form-group local"> ' +
                                        '<label class="col-md-2 control-label" for="name"></label> ' +
                                        '<div class="controls col-md-10"> ' +
                                            '<div id="mulitplefileuploader"><a class="btn btn-primary"><i class="glyphicon glyphicon-arrow-down"></i> Выбрать файлы</a></div> '+
                                        '</div> ' +
                                    '</div>' +                                   
                                    '<div class="form-group youtube"> ' +
                                        '<label class="col-md-2 control-label" for="name"></label> ' +
                                        '<div class="controls col-md-10"> ' +
                                            '<input type="text" min="3" class="form-control" name="youtube" id="youtube" placeholder="Ссылка на YouTube">'+
                                        '</div> ' +
                                    '</div>' +                                   
                              '</form> </div>  </div>',
                    buttons: {
//                        danger: {
//                            label: "Удалить"
//    ,                                       className: "btn-danger",
//                                callback: function () {
//                                    $.ajax({
//                                        url: '/php/dbcore.php?action=delEvent',
//                                        type: 'post',
//                                        data: {id:event.id}
//                                    }).success(function (data){
//                                        $('#calendar').fullCalendar( 'refetchEvents' );
//                                    });
//                                }
//                        },                                            
                        success: {
                            label: "Загрузить"
    ,                               className: "btn-success",
                                    callback: function () {
                                        if($('.type_load select').val()=='local'){
                                            uploadObj.startUpload();
                                        }else{
                                             var url = $('#youtube').val();
                                             $.ajax({
                                                 url: "/php/dbcore.php?action=downloadYoutube",
                                                 type: "POST",
                                                 dataType: "json",
                                                 asynk:true,
                                                 data: {url:url},
                                                 success: function(data){
                                                     console.log(data);
                                                     if (data!=null){ 
     //                                                    swal('Загружаем!','Файл "'+data['title']+'" загружается на сервер для поставновки в очередь на обработку.','success');  
                                                         $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-ok"></i>&nbsp;Данные успешно добавленны и поставленны на обработку. <a href="/user/files" on click="">Перейти к просмотру</a>'});
                                                     }else{
                                                         $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-remove"></i>&nbsp;При загрузке файлов произошла ошибка <span class="text-danger">'+errMsg+'</span> попробуйте снова.'});
                                                     }
                                                 }                      
                                             }).error(function (xhr, ajaxOptions, thrownError){
                                                        $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-remove"></i>&nbsp;При загрузке файлов произошла ошибка <span class="text-danger">'+errMsg+'</span> попробуйте снова.'});
                                             });                                               
                                        }                                        
                                }
                        }
                    }
                }).on("shown.bs.modal", function(e) { 
                    $('.youtube').hide();
                    $('.type_load input').change(function (){
                        ;
                    });
                    var settings = {
                        url: "/php/upload.php",
                        autoSubmit :false,
                        dragDrop:false,
                        dynamicFormData: function()
                        {
//                            var data ={"XYZ":1,"ABCD":2};
//                            return data;        
                        },               
                        fileName: "myfile",                        
                        returnType:"json",
                             onSuccess:function(files,data,xhr)
                                {
                                    $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-ok"></i>&nbsp;Данные успешно добавленны и поставленны на обработку. <a href="/user/files" on click="">Перейти к просмотру</a>'});
                                    console.log(data);
                                },
                                onError: function(files,status,errMsg,pd){
                                    $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-remove"></i>&nbsp;При загрузке файлов произошла ошибка <span class="text-danger">'+errMsg+'</span> попробуйте снова.'});
                                },
                        showDelete:true,
                        deleteCallback: function(data,pd){
                            for(var i=0;i<data.length;i++)
                            {
                                $.post("delete.php",{op:"delete",name:data[i]},
                                function(resp, textStatus, jqXHR)
                                {
                                    //Show Message  
                                    $("#status").append("<div>Файл Удален</div>");      
                                });
                             }      
                            pd.statusbar.hide(); //You choice to hide/not.
                        }
                    };
                    uploadObj = $("#mulitplefileuploader").uploadFile(settings);        
                    $('.type_load input').change(function (el,item){                       
                        var type = $('input[name=options]:checked').val();
                        if (type!='local'){
                            $('.local').hide();
                            $('.youtube').show();
                        }else{
                            $('.youtube').hide();
                            $('.local').show();                            
                        }
                    });
                });    
        });        
    });
   
    function toHHMMSS(v) {
        var sec_num = parseInt(v, 10);
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        var time = hours + ':' + minutes + ':' + seconds;
        return time;
    }   
   
    function getMsg(){
        $.ajax({
            url:"/php/dbcore.php?action=checkMsg"
        }).success(function (data){
            data = $.parseJSON(data);
            if (data!=null){               
               var html =""; 
               var to = 5;    
               if (data.length<=5){
                   to= data.length-1;
               }
               for (var i=0;i<=to;i++){
                    var temp = data[i].msg;
                    var word = temp.split('/')[0];
                    var time = data[i].when;
                    var timestart = data[i].timestart;
                    var id = data[i].fileid;
                    html+='<li><a href="/user/show/'+id+'/'+timestart+'"><span class="label label-primary">'+word+
                            '</span> <small><time class="timeago" datetime="'+time+'"></time></small></a></li>';
                }
                $("#alerts").html(html+'<li class="divider"></li><li><a class="text-center" href="/user/alerts/"><strong>Все уведомления</strong></a></li>');
                jQuery("time.timeago").timeago();
    //            $.snackbar({timeout: 8500,htmlAllowed: true,content: '<i class="glyphicon glyphicon-ok"></i>&nbsp;У вас появились новые уведомления. <a href="/user/alerts" on click="">Посмотреть</a>'});
            }else{
                $("#alerts").html('<li><a href="">У вас нет уведомлений</a></li><li class="divider"></li><li><a class="text-center" href="/user/alerts/"><strong>Все уведомления</strong></a></li>');
            }            
        });    
    }

    function updateTasks(limit){
        $.ajax({
            url:'/php/test.php',
            type: 'post',
            data: {limit: limit},
            timeout: 5000,
            asynk:false
        }).success(function (data){
            if (data!=null){
                data = JSON.parse(data);   
                console.log(data.tokens);
                for (var i=0; i< data.server.length;i++){                      
//                    $.each(data.database,function (i,v) {
//                        if (data.server.token.)
//                    });
                    console.log(data.tokens.indexOf(data.server[i].token.$));
                    var ind = data.tokens.indexOf(data.server[i].token.$);
                    if (ind > -1){
                        //alert('match');
                        var token_ready = false;
                        var av_val = parseInt(data.database[ind].length_record)*3.5;
                        var percent = 0;
                        var progress_color="primary";
                        if (parseInt(data.server[i].time_processing.$)<=av_val){
                            percent = Math.floor((parseInt(data.server[i].time_processing.$)/av_val)*100);                        
                        }else{
                            percent =100;
                            progress_color="success";
                        }                    
                        if (data.server[i].status.$=='Processing'){                                                                              
                            $('.tasks').children('li').each(function (){
                            //    console.log($(this));
                                var val_now = $('.progress-bar',this).attr('aria-valuenow');
                                //if ($('.text-muted',this).text())
                                if ($(this).attr('token')==data.server[i].token.$){
                                    token_ready = true;
                                    //console.log(val_now);
                                    if (parseInt(val_now)<parseInt(percent)){
                                        $('.progress-bar',this).css('width',percent+'%').attr('aria-valuenow',percent);
                                        $('.text-muted',this).html(percent+'% Готово'); 
                                    }
                                };
                            });
                            if (!token_ready){
                                $('.tasks').prepend('<li token="'+data.server[i].token.$+'"><p>'+
                                                            '<a href="/user/show/'+data.database[ind].fileid+'"><strong>'+data.database[ind].title+'</strong></a>'+
                                                            '<span class="pull-right text-muted">'+percent+'% Готово</span>'+
                                                        '</p>'+
                                                        '<div class="progress progress-striped active">'+
                                                            '<div class="progress-bar progress-bar-'+progress_color+'" role="progressbar" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percent+'%">'+
                                                                '<span class="sr-only">% Готово (danger)</span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</li>');                        
                            }
                            }else{
                                  if (data.server[i].status.$=='Finished'){
                                      progress_color = "success";
                                      percent = "100";
                                  }else{
                                      progress_color = "danger";
                                      percent = "0";
                                  }    
                                  $('.tasks').children('li').each(function (){
                                      if ($(this).attr('token')==data.server[i].token.$){
                                          token_ready = true;
                                          //console.log(val_now);
                                          $('.progress-bar',this).css('width',percent+'%').attr('aria-valuenow',percent);
                                          $('.text-muted',this).html(percent+'% Готово');
                                      };                         
                                  });
                                  if (!token_ready){
                                      $('.tasks').prepend('<li token="'+data.server[i].token.$+'"><p>'+
                                                                  '<a href="/user/show/'+data.database[ind].fileid+'"><strong>'+data.database[ind].title+'</strong></a>'+
                                                                  '<span class="pull-right text-muted">'+percent+'% Готово</span>'+
                                                              '</p>'+
                                                              '<div class="progress progress-striped active">'+
                                                                  '<div class="progress-bar progress-bar-'+progress_color+'" role="progressbar" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percent+'%">'+
                                                                      '<span class="sr-only">% Готово (danger)</span>'+
                                                                  '</div>'+
                                                              '</div>'+
                                                          '</li>');                        
                                  }                        
                            }                        
                    }
               }
            }
        }).error(function (){
//            alert(213);
        });        
    }
    
$(function(){
   getMsg(); 
   updateTasks(5);       
    setInterval(function (){
       getMsg(); 
       updateTasks(5);
    },15000);
    
});
 

                       