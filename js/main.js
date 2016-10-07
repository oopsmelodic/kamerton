

$(document).ready(function() {
    var settings = {
        url: "/php/upload.php",
        dragDrop:false,
        fileName: "myfile",
        returnType:"json",
             onSuccess:function(files,data,xhr)
        {
           console.log(data);
        },
        showDelete:true,
        deleteCallback: function(data,pd)
            {
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
    

    
    var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
//TUTORIAL
    var enjoyhint_instance;
    $('#start_tutorial').click(function(){    
        enjoyhint_instance = new EnjoyHint({});
        var enjoyhint_script_steps = [
            {
              'trigger #getFilelist' : 'Нажмите сюда чтобы перейти к списку ваших записей.'
            },
            {
              'next .breadcrumb' : 'Меню навигации по сайту.'
            },            
            {
                selector:'.my-table tbody>tr',
                event:'trigger',
                description:'Выберите одну из ваших записей'
            },  
            {
                'click .vjs-big-play-button' : 'Нажмите для начала воспроизведения записи.'
            },                                         
            {
                'next #text-type' : 'Виды отображения извлеченного текста из звуковой дорожки.'
            },                                                          
            {
                'next #wave' : 'Визуализатор звуковой дорожки'
            },                                                          
            {
                'next #metadata' : 'Метаданные вашей звуковой дорожки.'
            },                                                         
            {
                'click video' : 'Остоновите воспроизведение просто кликнов по окошку с записью.'
            },                                                         
            {
                'trigger .typeahead' : 'Введите слово для поиска'
            },                                                        
            {
                'trigger .tt-menu' : 'Результаты вашего поиска'
            }                                                       
          ];        
        enjoyhint_instance.set(enjoyhint_script_steps);
        enjoyhint_instance.run();
    });

    
    function getFile(id, time) {
        if ($('#video_main').length > 0) {
//                alert('dispose');
            videojs("video_main").dispose();
            $('body').remove('#container');
        }        
        if (id == null) {
            id = $('#filelist').myTreeView('getSelected').id;
        }
//                    NProgress.start();
//                $('.content').hide();
//                $(".container-loader").show(); 
        $.ajax({
            url: "/php/dbcore.php?action=getData",
            type: "POST",
            dataType: "json",
            data: {id: id}
        }).success(function(data) {
//                    NProgress.done();
            console.log(data);
            if (data != null) {
                loadVideo(data, time);
            } else {
//                            $('.content').hide();
//                            $(".container-loader").hide(); 
            }
            data = null;
        });
    }
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            matches = [];

            substrRegex = new RegExp(q, 'i', 'm');

            $.each(strs['value'], function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push({'value': str, 'id': strs['id'][i]});
                }
            });

            cb(matches);
        };
    };

    var fonemList = '';

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
            rateLimitWait: 1500,
//        filter: function (fonem) {
//            if (fonem!='empty'){
//                return fonem;
//            }else{
//                fonem = {'value':'Ничего нету','id':'','score':''};
//                return fonem;
//            }
//        }, 
            beforeSend: function() {
                alert('Гружу');
            },
            complete: function() {
                alert('Готово');
            },
            success: function(data) {
                return typeahead.process($.parseJSON(data));
            }
        }
    });


//var promise = fonem.initialize();
//promise
//.done(function() { console.log('ready to go!'); })
//.fail(function() { console.log('err, something went wrong :('); });    

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
        templates: {
            notFound: [
                '<div class="empty-message">',
                'Нет результатов',
                '</div>'
            ].join('\n'),
            header: '<a class="btn btn-primary btn-raised">Текст</a>',
            suggestion: function(data) {
                console.log(data);
                return '<div class="tt-suggest-page">' + data.value + '</div>';
            }
        }
    },
    {
        displayKey: 'value',
        source: name.ttAdapter(),
        templates: {
            notFound: [
                '<div class="empty-message">',
                'Нет результатов',
                '</div>'
            ].join('\n'),
            header: '<a class="btn btn-primary btn-raised">Имя</a>',
            suggestion: function(data) {
                console.log(data);
                return '<div class="tt-suggest-page">' + data.value + '</div>';
            }
        }
    },
    {
        displayKey: 'value',
        source: fonem,
        async: false,
        templates: {
            header: '<a class="btn btn-primary btn-raised">Фонемный поиск</a>',
            notFound: [
                '<a class="btn btn-primary btn-raised">Фонемный поиск</a>',
                '<div class="spinner">',
                '<div class="rect1"></div>',
                '<div class="rect2"></div>',
                '<div class="rect3"></div>',
                '<div class="rect4"></div>',
                '<div class="rect5"></div>',
                '</div>',
            ].join('\n'),
            suggestion: function(data) {
//                console.log(data);
                if (data.status != 'error') {
                    return '<div class="tt-suggest-page"><span class="label label-primary">' + data.score * 100 + ' %</span>  ' + data.value + '</div>';
                } else {
                    return '<div class="tt-suggest-page">' + data.value + '</div>';
                }
            }
        }
    }).on('typeahead:selected', function(obj, datum) {
        $('.typeahead').typeahead('val', '');
        $('.glass-close').hide();
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
        enjoyhint_instance.trigger('next');
    });
//    $.ajax({
//        url:'/php/search.php',
//        dataType:'json',
//        type: "POST"
//    }).success(function (data){
//        console.log(data);
//        $('.typeahead').typeahead({
//          hint: true,
//          highlight: true,
//          minLength: 3
//         
//        },
//        {
//          name: 'filestext',
//          display:'value',
//          source: substringMatcher(data['filestext']),
//            templates: {
//                header:'<h3>Текст:</h3>',
//                suggestion: function(data) {                     
//                    return '<div class="tt-suggest-page">' + data.value + '<a file_id="'+data.id+'">Открыть файл</a></div>';
//                }
//            }           
//
//        },
//        {
//          name: 'filenames',
//          display:'value',
//          source: substringMatcher(data['filenames']),
//            templates: {
//                header:'<h3>Имя:</h3>',
//                suggestion: function(data) {                     
//                    return '<div class="tt-suggest-page">' + data.value + '<a file_id="'+data.id+'">Открыть файл</a></div>';
//                }
//            }           
//
//        },
//        {
//          name: 'fonem',
//          display:'value',
//          source:  movies.ttAdapter(),
//            templates: {
//                header:'<h3>Фонемный поиск:</h3>',
//                suggestion: function(data) {                     
//                    return '<div class="tt-suggest-page">' + data.value + '<a file_id="'+data.id+'">Открыть файл</a></div>';
//                }
//            }           
//
//        }                  
//            ).on('typeahead:selected', function (obj, datum) {
//            console.log(datum);
//            getFile(datum['id']);
//        }).on('typeahead:');
//    });



    $.material.init();

    $('#getFilelist').click(function() {
        if ($('#video_main').length > 0) {
//                alert('dispose');
            videojs("video_main").dispose();
            $('body').remove('#container');
        }
        $('.breadcrumb').html('<li class="active"><a href="/">Главная</a></li><li>Список Записей</li>');
//        if (!$(this).hasClass('active')){
        $('.left_menu button').removeClass('active');
        $(this).addClass('active');
        $('#main').html('');
        $('#main').append('<div id="container" class="well row"><button type="button" class="close" data-dismiss="alert">×</button><h4>Список записей:</h4></div>');
        $('#main #container').append('<div id="filelist"></div></div>');
        var filelistHeaders = new Array({"id": 0, "name": "id", "title": "№"},
        {"id": 1, "name": "name", "title": "Имя"},
        {"id": 2, "name": "date_upload", "title": "Дата/Время"},
        {"id": 3, "name": "status", "title": "Статус"});
        $('#container .close').click(function() {
            $('.left_menu button').removeClass('active');
            $('.content_all').html('');
        });
        $("#filelist").myTreeView({
            url: '/php/dbcore.php?action=loadfilelist',
            headers: filelistHeaders,
            dblclick: getFile
        });
//        }       
        enjoyhint_instance.trigger('next');
    });



    function loadVideo(data, data_time) {

        window.requestAnimFrame = (function() {
            return  window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
        })();
        var wavesurfer = Object.create(WaveSurfer);
     
        $('.breadcrumb').html('<li class="active"><a href="/">Главная</a></li><li><a href="javascript:$(`#getFilelist`).click()">Список Записей</a></li>' +
                '<li>' + data['file']['title'] + '</li>');
        $('.fileMeta').empty();
        var cont =  '<button type="button" class="close" data-dismiss="alert">×</button><div class="well row" style="margin-bottom: 0;padding-top: 0px;padding-left: 0px;padding-right: 0px;">' +
    //              '<button type="button" class="close" data-dismiss="alert">×</button>'+
                    '<ul class="nav nav-tabs">' +
                        '<li class="active"><a href="#home">' + data['file']['title'] + '</a></li>' +
        //              '<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>'+
        //              '<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>'+
        //              '<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>'+
                    '</ul>' +
                    '<div style="  height: calc(100% - 230px);">' +
                    '<div class="tab-pane active">' +
                    '<div class="col-lg-6">' +
                    '<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered"' +
                    'controls preload="auto" width="100%" height="50%" poster="/img/audio_poster.png">' +
                    '</video>' +
                    '<div id="metadata" class="col-lg-12">' +
                    '<h4><span class="label label-primary">Дата загрузки:</span>  ' + data['file']['date_upload'] + '</h4>' +
                    '<h4><span class="label label-primary">Имя:</span>  ' + data['file']['title'] + '</h4>' +
                    '<h4><span class="label label-primary">Тип:</span>  ' + data['file']['type'] + '</h4>' +
                    '<h4><span class="label label-primary">Статус задач:</span>  В разработке</h4>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-lg-6">' +
                        '<ul id="text-type" class="nav nav-tabs" style="">'+
                            '<li class="active"><a href="#filetext" data-toggle="tab">Диалог</a></li>'+
                            '<li><a href="#alltext" data-toggle="tab">Сплошной текст</a></li>'+
                            '<li class="dropdown">'+
                                '<a class="dropdown-toggle" data-toggle="dropdown" href="" data-target="#" aria-expanded="true">'+
                                    '<i class="mdi-file-file-download"></i>'+
                               '<div class="ripple-wrapper"></div></a>'+
                                '<ul class="dropdown-menu">'+
                                    '<li class="disabled"><a href="#" >Текст</a></li>'+
                                    '<li class=""><a href="' + data['file']['filepath'] + '" download="' + data['file']['title'].replace('.', "_") +'">Файл</a></li>'+
                                '</ul>'+
                            '</li>'+                            
                        '</ul>'+
                        '<div  class="tab-content">'+
                            '<div class="tab-pane fade active in" id="filetext">'+
                                '<div class="filedata"></div>' +
                            '</div>'+
                            '<div class="tab-pane fade" id="alltext">'+
                                '<div class="filedataAll"></div>' +
                            '</div>'+
                        '</div>'+                     
    //                '<div id="wave"></div>'+
                    '</div>' +
                    '</div>' +
    //              '<div role="tabpanel" class="tab-pane" id="profile">'+         
    //
    //              '</div>'+
    //              '<div role="tabpanel" class="tab-pane" id="messages">.432234..</div>'+
    //              '<div role="tabpanel" class="tab-pane" id="settings">..5553245.</div>'+
                    '<footer class="col-lg-12">'+
                        '<div id="wave" >'+
                            '<div id="progress-bar" class="progress">'+                        
                                '<div class="progress-bar"></div>'+
                            '</div>'+
                        '</div>'+
                    '</footer>' +
                            ''+
                    '</div>' +
                    '</div>';
        $('#main').html(cont);   
        var to_time = data_time || 0;
        var scroll = true;
        var surfReady = false;
        var path = data['file']['filepath'];
        path = path.replace('..', '');        
        var video = videojs('video_main',{            
        });
        video.src([
            {type: data['file']['type'], src: path}
        ]);

        video.load();   
        wavesurfer.init({
            container: '#wave',
            waveColor: '#009688',
            progressColor: '#4CAF50'
        });      
        var progressDiv = document.querySelector('#progress-bar');
        var progressBar = progressDiv.querySelector('.progress-bar');

        var showProgress = function (percent) {
            progressDiv.style.display = 'block';
            progressBar.style.width = percent + '%';
        };

        var hideProgress = function () {
            var regions = data['data'];
            regions.forEach(function (region) {                
                if (region.timestart==to_time){
                    var mass = {'data':region.text,'start':region.timestart,'end':region.timeend,'color':randomColor(0.8)};                
                    wavesurfer.addRegion(mass);
                }
            });               
            progressDiv.style.display = 'none';
        };

        wavesurfer.on('loading', showProgress);
        wavesurfer.on('ready', hideProgress);
        wavesurfer.on('destroy', hideProgress);
        wavesurfer.on('error', hideProgress);         
        wavesurfer.on('region-click', function (region, e) {
                video.currentTime(region.start);           
            });        
        wavesurfer.load(path);     
        wavesurfer.toggleMute();
        console.log(video);
        if (true) {
            var marks = new Array();
            var curmark = 0;
            console.log(video);
            if (data['data'] != null) {
                $(' .filedata').show();
                var fileData = $(' .filedata');
                var fileDataAll = $(' .filedataAll');
                fileDataAll.html('');
                fileData.html('');
                var speakersCount = 0;
                for (var i = 0; i < data['data'].length - 1; i++) {
                    speakersCount += data['data'][i]['speakerid'];
                    var row = "<div class='msg speaker-" + data['data'][i]['speakerid'] + "'><record class=''  timestart='" + data['data'][i]['timestart'] + "' timeend='" + data['data'][i]['timeend'] + "' id='" + data['data'][i]['id'] + "'>";
                    var row_text = "<record timestart='" + data['data'][i]['timestart'] + "' timeend='" + data['data'][i]['timeend'] + "' id='" + data['data'][i]['id'] + "'>";
                    var text = '';
                    var str = '';
                    if (data['data'][i]['alttext'] != null) {
                        str = data['data'][i]['alttext'];
                        text += "<span>";
                        str = str.replace(/[ ]/g, "</span> <span>");
                        text += str;
                        text += "</span>";
                    } else {
                        str = data['data'][i]['text'];
                        text += "<span>";
                        str = str.replace(/[ ]/g, "</span> <span>");
                        text += str;
                        text += "</span>";
                    }
                    row += text + "</record></div> ";
                    row_text += text + "</record>";
                    fileData.append(row);
                    fileDataAll.append(row_text);
                }
                if (speakersCount>0){
                    $('.msg').css('width','55%');
                }else{
                    $('.msg').css('width','97%');
                }
                $('.filedata').click(function() {
                    $('input', this).remove();
                });
                $('.filedata').hover(function() {
                    $('input', this).remove();
                });
                $('.filedata record').each(function() {
                    var ts = $(this).attr('timestart');
                    var td = $(this).attr('timeend');
                    var id = $(this).attr('id');
                    marks.push({"id": id, "timestart": parseFloat(ts), "timeend": parseFloat(td)});
                });
                $('.filedata .msg').click(function(e) {
                    $('.filedata .msg').removeClass('success');
                    $(this).addClass('success');
                    video.currentTime(parseFloat($(this).children('record').attr('timestart')));
                    video.play();
                    for (var i = 0; i <= marks.length - 1; i++) {
                        if (marks[i].id == $(this).children('record').attr('id')) {
                            curmark = i;
                        }
                    }
                });
            }
//            $('.video_time').text('00:00:00');
//            $(".panel-title").html('<a href="' + data['file']['filepath'] + '" download="' + data['file']['title'].replace('.', "_") + '">' + data['file']['title'] + '</a>');
//            $(".downloadVideo").attr('href',data['file']['filepath']).attr('download',data['file']['title'].replace('.', "_") + '">' + data['file']['title']);
//            $('.progress-bar').width(0);          

  
////SPECTRUM    
//
//            var audioVisual = document.getElementById('audio-visual');
//            console.log(audioVisual);
//            // canvas stuff
//            var canvas = document.getElementById('c');
//            canvas_context = canvas.getContext('2d');
//
//            // audio stuff
//
//            // analyser stuff
//            console.log(canvas_context);
//            var AudioContext = window.AudioContext || window.webkitAudioContext;
//            var context = new AudioContext();
//            var analyser = context.createAnalyser();
//            analyser.fftSize = 2048;
//
//            // connect the stuff up to eachother
//            console.log(video);
//            var source = context.createMediaElementSource($('video').get(0));
//            source.connect(analyser);
//            analyser.connect(context.destination);
//            freqAnalyser();
//            function freqAnalyser() {
//                window.requestAnimFrame(freqAnalyser);
//                var sum;
//                var average;
//                var bar_width;
//                var scaled_average;
//                var num_bars = 60;
//                var data = new Uint8Array(2048);
//                analyser.getByteFrequencyData(data);
//
//                // clear canvas
//                canvas_context.clearRect(0, 0, canvas.width, canvas.height);
//                var bin_size = Math.floor(data.length / num_bars);
//                for (var i = 0; i < num_bars; i += 1) {
//                    sum = 0;
//                    for (var j = 0; j < bin_size; j += 1) {
//                        sum += data[(i * bin_size) + j];
//                    }
//                    average = sum / bin_size;
//                    bar_width = canvas.width / num_bars;
//                    scaled_average = (average / 256) * canvas.height;
//                    canvas_context.fillRect(i * bar_width, canvas.height, bar_width - 2, -scaled_average);
//                }
//            }
////SPECTRUM END            

//            video.volume = getCookie('volume') / 100 || 0.5;
            $('body').keydown(function(e) {
                var $focused = $(':focus');
                console.log($focused);
            });
            $('.filedata record span, .filedataAll record span').dblclick(function() {
                video.pause();
                $('.filedata input').remove();
                clearSelection();
                var span = $(this);
                $(this).append('<input type="text" value="' + $(this).text() + '"></input>');
                $('input', this).select();
                $('input', this).keydown(function(e) {
                    arrow = {left: 37, up: 38, right: 39, down: 40};
                    if (e.which == 13) {
                        span.text($(this).val());
                        $.ajax({
                            url: "php/dbcore.php?action=updateData",
                            type: "POST",
                            dataType: "json",
                            data: {id: span.parents('record').attr('id'), text: span.parents('record').text()}
                        }).success(function(data) {
                            console.log(data);
                            if (data != null) {

                            } else {
                            }
                            data = null;
                        });
                    }
                    if (e.which == 27) {
                        $(this).remove();
                    }
                    if (e.ctrlKey) {
                        switch (e.which) {
                            case arrow.left:
                                if (span.prev().length > 0) {
                                    if (span.prev().get(0).tagName == 'RECORD') {
                                        if (span.prev().children().length > 0) {
                                            span.prev().children(':last').dblclick();
                                        } else {
                                            span.parents(':first').prev().dblclick();
                                        }
                                    } else {
                                        span.prev().dblclick();
                                    }
                                } else {
                                    if (span.parents().prev().get(0).tagName == 'RECORD') {
                                        if (span.parents(':first').prev().children().length > 0) {
                                            span.parents(':first').prev().children(':last').last().dblclick();
                                        } else {
                                            span.parents(':first').prev().dblclick();
                                        }
                                        span.parents(':first').prev().dblclick();
                                    }
                                }
                                break;
                            case arrow.right:
                                console.log(span.next().length);
                                if (span.next().length > 0) {
                                    if (span.next().get(0).tagName == 'RECORD') {
                                        if (span.next().children().length > 0) {
                                            span.next().children(':first').dblclick();
                                        } else {
                                            span.parents(':first').next().dblclick();
                                        }
                                    } else {
                                        span.next().dblclick();
                                    }
                                } else {
                                    console.log(span.parents().next());
                                    if (span.parents().next().get(0).tagName == 'RECORD') {
                                        if (span.parents(':first').next().children().length > 0) {
                                            span.parents(':first').next().children(':first').dblclick();
                                        } else {
                                            span.parents(':first').next().dblclick();
                                        }
                                        span.parents(':first').next().dblclick();
                                    }
                                }
                                break;
                        }
                    }
                });
            });
//            video.on('play', function() {
////                freqAnalyser();
//                wavesurfer.play();
//            });
//            video.on('pause', function() {
////                freqAnalyser();
//                wavesurfer.pause();
//            });
           
            video.on("ended", function() {
                curmark = 0;
                video.currentTime(0);
                $('.filedata .msg').removeClass('success');
                $('.filedata').scrollTop(0);
                $('.playbtn').removeClass('btn-success').removeClass('btn-primary').addClass('btn-primary');
            });
            var scrollTimer;
            $('.filedata').scroll(function() {
                scroll = false;
                clearInterval(scrollTimer);
                scrollTimer = setTimeout(function() {
                    scroll = true;
                    clearInterval(scrollTimer);
                }, 5000);
            });
            video.on("played", function() {
                
            });
            wavesurfer.on('ready', function (q){
                surfReady = true;
            });            
//            wavesurfer.on('seek', function (q){
//                alert(123);
//                video.currentTime(wavesurfer.getCurrentTime());
//            });            
            video.on("seeked", function() {                
                var timeclick = video.currentTime();
                var duration = video.duration();
                var percent = timeclick/duration*100;   
                wavesurfer.seekTo(percent); 
                for (var i = 0; i <= marks.length - 1; i++) {
                    if (parseFloat(marks[i].timestart) >= parseFloat(timeclick) && parseFloat(timeclick) <= parseFloat(marks[i].timeend)) {
                        $('.filedata record').removeClass('success');
                        $('.filedata').scrollTo($('.filedata record[id="' + marks[i].id + '"]').parent('.msg'), 500);
                        curmark = i;
                        break;
                    }
                    else {
                        curmark = 0;
                        $('.filedata .msg').removeClass('success');
                    }
                }
                $('.filedata record[id="' + marks[i].id + '"]').parent('.msg').addClass('success');
            });
            video.on("timeupdate", function() {               
                var curT = video.currentTime();
                var duration = video.duration();
                var percent = curT / duration;
                console.log('curT: '+curT+', Duration: '+duration+', Percentage: '+percent);
                if (surfReady){
                    wavesurfer.seekTo(percent);   
                }
                $('.video_time').text(toHHMMSS(curT));
//                var percent = curT / video.duration * 100;
//                $('.progress-bar').width(percent + '%');
                if (curT >= marks[curmark].timestart && curmark < marks.length) {
                    $('.filedata .msg').removeClass('success');
                    $('.filedata record[id="' + marks[curmark].id + '"]').parent('.msg').addClass('success');
                    if (scroll) {
                        $('.filedata').scrollTo($('.filedata record[id="' + marks[curmark].id + '"]').parent('.msg'), 500, {top: '+=50px'});
                    }
                    if (curmark < marks.length - 1)
                        curmark++;
                }
            });
            video.on("loadeddata", function(cur) {
                if (cur > 0) {
                    to_time = cur;
                }
                for (var i = 0; i <= marks.length - 1; i++) {
                    if (parseFloat(marks[i].timestart) >= parseFloat(to_time) && parseFloat(to_time) <= parseFloat(marks[i].timeend)) {
                        $('.filedata .msg').removeClass('success');
                        $('.filedata record[id="' + marks[i].id + '"]').parent('.msg').addClass('success');
                        $('.filedata').scrollTo($('.filedata record[id="' + marks[i].id + '"]').parent('.msg'), 500);
                        curmark = i;
                        break;
                    }
                    else {
                        curmark = 0;
                        $('.filedata .msg').removeClass('success');
                    }
                }
                video.currentTime(to_time);
//                    video.timeupdate();
            });
            $('.getText').off('click').click(function() {
                var allData = '';
                $('.filedata span').each(function() {
                    var cellText = $(this).text();
                    allData += cellText + " ";
                });
//                var textToWrite = document.getElementByClass("filedata").value;
                var textFileAsBlob = new Blob([allData], {type: 'text/plain'});
//                var fileNameToSaveAs = document.getElementById("inputFileNameToSaveAs").value;

                var downloadLink = document.createElement("a");
                downloadLink.download = data['file']['title'];
                downloadLink.innerHTML = "Download File";
                if (window.webkitURL != null)
                {
                    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
                }
                else
                {
                    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
                    downloadLink.onclick = destroyClickedElement;
                    downloadLink.style.display = "none";
                    document.body.appendChild(downloadLink);
                }

                downloadLink.click();
            });
            $('.fileMeta .close').off('click').click(function() {
                swal({title: "",
                    text: "Закрыть вкладку с файлом?",
                    showCancelButton: true,
                    cancelButtonText: "Отмена",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да, закрыть!",
                    closeOnConfirm: true}, function() {
                    $('.fileMeta').children().filter("audio").each(function() {
                        this.pause();
                        this.currentTime(0);
                        this.setAttribute('src', '');
                        this.load();
                        delete(this);
                    });
                    $('.fileMeta').children().filter("video").each(function() {
                        this.pause();
                        this.currentTime = 0;
                        this.setAttribute('src', '');
                        this.load();
                        delete(this);
                    });
                    $('.playbtn').removeClass('btn-success').removeClass('btn-primary').addClass('btn-primary').css("enabled", "false");
                    $('.playbtn i').removeClass('glyphicon glyphicon-play').removeClass('glyphicon glyphicon-pause').addClass('glyphicon glyphicon-play');
                    $('.progress-bar').width(0 + '%');
                    $('.fileMeta').remove();
                    $('#panel-controll').prop("disabled", false);
                });
            });
            enjoyhint_instance.trigger('next');
        } else {
            if (to_time > 0) {
                video = $('audio').get(0);
                video.onloadeddata(to_time);

            } else {
                NProgress.done();
                toastr.warning('Видео уже открыто!');
            }
        }
    }



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

      function clearSelection() {
    if (window.getSelection) {
      window.getSelection().removeAllRanges();
    } else { 
      document.selection.empty();
    }
  }
function randomColor(alpha) {
    return 'rgba(' + [
        ~~(Math.random() * 255),
        ~~(Math.random() * 255),
        ~~(Math.random() * 255),
        alpha || 1
    ] + ')';

}
});

