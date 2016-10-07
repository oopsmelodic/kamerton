<div id="tasks">
</div>
<script>
    function taskManager(limit){
        $.ajax({
            url:'/php/test.php',
            type: 'post',
            data: {limit: limit},
            timeout: 10000
        }).success(function (data){
            if (data!=null){
                data = JSON.parse(data);   
                console.log(data);
                for (var i=0; i< data.server.length;i++){                      
//                    $.each(data.database,function (i,v) {
//                        if (data.server.token.)
//                    });                    
                    var ind = data.tokens.indexOf(data.server[i].token.$);
                    console.log(data.server[i].token.$);
                    if (ind > -1){
                        console.log(data.database[ind]);
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
                        var type = data.database[ind].type;
                        if (data.server[i].status.$=='Processing'){                                                                              
                            $('#tasks').children('div').each(function (){
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
                                $('#tasks').prepend('<div token="'+data.server[i].token.$+'"><p>'+
                                                            '<a href="/user/show/'+data.database[ind].fileid+'"><strong>'+data.database[ind].title+'</strong></a>'+
                                                            '<span class="pull-right text-muted">'+percent+'% Готово</span>'+
                                                        '</p>'+
                                                        '<div class="progress progress-striped active">'+
                                                            '<div class="progress-bar progress-bar-'+progress_color+'" role="progressbar" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percent+'%">'+
                                                                '<span class="sr-only">% Готово (danger)</span>'+
                                                            '</div>'+ 
                                                        '</div>'+
                                                    '</div>');                        
                            }
                            }else{
                                  if (data.server[i].status.$=='Finished'){
                                      progress_color = "success";
                                      percent = "100";
                                  }else{
                                      progress_color = "danger";
                                      percent = "0";
                                  }    
                                  $('#tasks').children('div').each(function (){
                                      if ($(this).attr('token')==data.server[i].token.$){
                                          token_ready = true;
                                          //console.log(val_now);
                                          $('.progress-bar',this).css('width',percent+'%').attr('aria-valuenow',percent);
                                          $('.text-muted',this).html(percent+'% Готово');
                                      };                         
                                  });
                                  if (!token_ready){
                                      $('#tasks').append('<div token="'+data.server[i].token.$+'"><p>'+
                                                                  '<strong><a href="/user/show/'+data.database[ind].fileid+'">'+data.database[ind].title+'</a></strong>'+
                                                                  '<span class="pull-right text-muted">'+percent+'% Готово</span>'+
                                                                  '<p><strong>'+type+'</strong></p>'+
                                                              '</p>'+
                                                              '<div class="progress progress-striped active">'+
                                                                  '<div class="progress-bar progress-bar-'+progress_color+'" role="progressbar" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percent+'%">'+
                                                                      '<span class="sr-only">% Готово (danger)</span>'+
                                                                  '</div>'+
                                                              '</div>'+
                                                          '</div>');                        
                                  }                        
                            }                        
                    }else{
//                        alert('ЕСТЬ МЕРТВЫЕ ТОКЕНЫ');
                    }
               }
            }else{
            }
        });        
    }
    
    $(function (){
        $('.tasks').parents('li').hide();
        taskManager(20);
        setInterval(taskManager,10000);
    });
</script>