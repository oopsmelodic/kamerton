$(document).ready(function() {
        
    var fonem = new Bloodhound({
        datumTokenizer: function(datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        cache: false,
        remote: {
            url: '/php/fonemSearch.php',
            
            replace: function(url, query) {
                return url + "?phrase=" + query;
            },
//        rateLimitBy: "throttle",
            rateLimitWait: 2500,
//        filter: function (fonem) {
//            if (fonem!='empty'){
//                return fonem;
//            }else{
//                fonem = {'value':'Ничего нету','id':'','score':''};
//                return fonem;
//            }
//        }, 
            success: function(data) {
                return typeahead.process($.parseJSON(data));
            }
        }
    });
    
    var text = new Bloodhound({
            datumTokenizer: function(datum) {
                return Bloodhound.tokenizers.whitespace(datum.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/php/search.php',
                replace: function(url, query) {
                    return url + "?phrase=" + query;
                },
                filter: function(text) {
                    return text.filestext;
                }
            }
        });
        
        text.initialize();
        
        var tags = new Bloodhound({
            datumTokenizer: function(datum) {
                return Bloodhound.tokenizers.whitespace(datum.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/php/search.php',
                replace: function(url, query) {
                    return url + "?phrase=" + query;
                },
                filter: function(tags) {
                    return tags.tags;
                }
            }
        });


        tags.initialize();
        
        var name = new Bloodhound({
            datumTokenizer: function(datum) {
                return Bloodhound.tokenizers.whitespace(datum.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/php/search.php',
                replace: function(url, query) {
                    return url + "?phrase=" + query;
                },
                filter: function(name) {
                    return name.filenames;
                }
            }
        });


        name.initialize();
        

        $('.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            displayKey: 'value',
            source: text.ttAdapter(),
            async: false,
            templates: {
                notFound: [
                    '<h4><b><i class="fa fa-list"></i> Текст</b></h4>',
                    'Нет результатов'
                ].join('\n'),
                header: '<h4><b><i class="fa fa-list"></i> Текст</b><h4>',
                suggestion: function(data) {
                    console.log(data);
                    return '<div class="tt-suggest-page"><i onclick="javascript:play_btn(this,'+data.time+',\''+data.path+'\',\''+data.type+'\')" class="play_btn fa fa-play"></i>' + data.value + ' - '+data.title                            
                            +'</div>';                  
                }
            }
        },
        {
            displayKey: 'value',
            source: tags.ttAdapter(),
            async: false,
            templates: {
                notFound: [
                    '<h4><b><i class="fa fa-list"></i> Теги</b></h4>',
                    'Нет результатов'
                ].join('\n'),
                header: '<h4><b><i class="fa fa-list"></i> Теги</b></h4>',
                suggestion: function(data) {
                    console.log(data);
                    return '<div class="tt-suggest-page">' + data.value
                            +'</div>';   
                }
            }
        },        
        {
            displayKey: 'value',
            source: name.ttAdapter(),
            async: false,
            templates: {
                notFound: [
                    '<h4><b><i class="fa fa-list"></i> Имена</b></h4>',
                    'Нет результатов'
                ].join('\n'),
                header: '<h4><b><i class="fa fa-list"></i> Имена</b></h4>',
                suggestion: function(data) {
                    console.log(data);
                    return '<div class="tt-suggest-page"><i onclick="javascript:play_btn(this,'+data.time+')" data-start="'+ data.value +'" class="play_btn fa fa-play"></i>' + data.value + ' - '+data.title                            
                            +'</div>';   
                }
            }
        },
        {
            displayKey: 'value',
            source: fonem,
            async: false,
            templates: {
                header: '<h4><b><i class="fa fa-volume-up"></i> Фонемный поиск</b><h4>',
                pending: [
                    '<h4><b><i class="fa fa-volume-up"></i> Фонемный поиск</b><h4>',
                    '<div class="spinner">',
                    '<div class="rect1"></div>',
                    '<div class="rect2"></div>',
                    '<div class="rect3"></div>',
                    '<div class="rect4"></div>',
                    '<div class="rect5"></div>',
                    '</div>'
                ].join('\n'),
                notFound: [
                    '<h4><b><i class="fa fa-volume-up"></i> Фонемный поиск</b><h4>',
                        '<div class="spinner">',
                        '<div class="rect1"></div>',
                        '<div class="rect2"></div>',
                        '<div class="rect3"></div>',
                        '<div class="rect4"></div>',
                        '<div class="rect5"></div>',
                    '</div>'
                ].join('\n'),                
                suggestion: function(data) {
                    console.log(data);
                    if (data.status != 'error') {
                        return '<div class="tt-suggest-page"><i onclick="javascript:play_btn(this,'+data.time+')" data-start="'+ data.value +'" class="play_btn fa fa-play"></i><span class="label label-primary">' + Math.round(data.score * 100) + ' %</span>  ' + data.value +' - '+data.title
                            +'</div>';
                    } else {
                        return '<div class="tt-suggest-page">' + data.value + '</div>';
                    }
                }
            }
        }).on('typeahead:selected', function(obj, datum) {
            $('.typeahead').typeahead('val', '');
            fonem.clear();
            $('.glass-close').hide();
            var host = window.location.host;
            window.location = "http://"+host+"/user/show/"+datum['id']+"/"+Math.floor(datum['time']);
            getFile(datum['id'], datum['time']);
        }).on('typeahead:asyncrequest', function(obj, datum) {
            $('.glass-close').show();
    //        enjoyhint_instance.trigger('next');
        }).on('typeahead:active', function(obj, datum) {
            if (obj.currentTarget.value.length >= obj.isTrigger) {
                $('.glass-close').show();
            } else {
                $('.glass-close').hide();
            }
        }).on('typeahead:close', function(obj, datum) {
            $('.glass-close').hide(); 
        }).on('typeahead:asyncreceive', function(obj, datum) {
            //enjoyhint_instance.trigger('next');
        }).on('dblclick', function(obj, datum) {
//            fonem.clear();
//            alert('123');
        });
});

    function play_btn(tt,start_time,path,type){        
        var video = $('#preview').get(0);   
        console.log(video);
        $('.search .fa-volume-up').removeClass('fa-volume-up').addClass('fa-play');
        video.pause();
        var source = '<source src="'+path+'" type="'+type+'">';
        $('#preview').html('').append(source);
        var end_time = start_time+3;
        video.currentTime=start_time;
        var icon = $(tt).parent().find('.play_btn');          
        if (icon.hasClass('fa-play')){
            icon.removeClass('fa-play').addClass('fa-volume-up');
            video.play();         
            video.ontimeupdate=function (){
                var cur = video.currentTime;
                if (cur>=end_time){
                    video.pause();
                    icon.removeClass('fa-volume-up').addClass('fa-play');
                }
            };
        }else{           
            icon.removeClass('fa-stop').addClass('fa-play');
            video.pause();
        }        
    };  