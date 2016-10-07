<a href="/user/files/" class="close" data-dismiss="alert"><i class="glyphicon glyphicon-arrow-left"></i></a><div id="meta" class="well row" style="margin-bottom: 0;padding-top: 0px;padding-left: 0px;padding-right: 0px;">

</div>
<script>
        var fileserver = 'http://10.129.15.111:8000/';
        var data = eval('(<?php echo json_encode($data['file'])?>)');
        console.log(data);
        var to_time = "<?php echo $data['timestart']; ?>" || 0;
        console.log(to_time);
        var wavesurfer = Object.create(WaveSurfer);
        var data_time = 0;
        var path = data['meta']['filepath'];
        path = path.replace('..', '');  
//        $('.breadcrumb').html('<li class="active"><a href="/">Главная</a></li><li><a href="javascript:$(`#getFilelist`).click()">Список Записей</a></li>' +
//                '<li>' + data['meta']['title'] + '</li>');
        var cont = 
    //              '<button type="button" class="close" data-dismiss="alert">×</button>'+
                    '<ul class="nav nav-tabs">' +
                        '<li class="active"><a href="#home">' + data['meta']['title'] + '</a></li>' +
                        '<li class=""><a href="' + path + '" download="' + data['meta']['title'].replace('.', "_") +'.'+data['meta']['type'].split('/').pop()+'"><i class="glyphicon glyphicon-floppy-save"></i></a></li>'+                               
//                      '<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>'+
        //              '<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>'+
        //              '<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>'+
                    '</ul>' +
                    '<div style="  height: calc(100% - 270px);">' +
                    '<div class="tab-pane active">' +
                    '<div class="col-lg-7 col-sm-7">' +
                    '<video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered"' +
                    'controls preload="auto" width="100%" height="70%" poster="/img/audio_poster.png">' +
                    '</video>' +
                    '<div id="metadata" class="col-lg-12 col-sm-12">' +
                        '<div class="col-lg-7 col-sm-7">'+
                            '<h4><span class="label label-primary">Дата загрузки:</span>  ' + data['meta']['date_upload'] + '</h4>' +
                            '<h4><span class="label label-primary">Имя:</span>  ' + data['meta']['title'] + '</h4>' +
                            '<h4><span class="label label-primary">Тип:</span>  ' + data['meta']['type'] + '</h4>' +
                        '</div>'+
                        '<div class="col-lg-5 col-sm-5">'+
//                            '<p class="">43%</p>'+
                        '</div>'+
    //                    '<h4><span class="label label-primary">Совпадение с:</span> <a href=""><i class="glyphicon glyphicon-music"></i>&nbsp;Физрук 01.04</h4>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-lg-5 col-sm-5">' +
                        '<ul id="text-type" class="nav nav-tabs" style="">'+
                            '<li class="active"><a href="#filetext" data-toggle="tab">Диалог</a></li>'+
                            '<li><a href="#alltext" data-toggle="tab">Сплошной текст</a></li>'+        
                            '<li class="getText"><a href="#" ><i class="glyphicon glyphicon-save-file"></i></a></li>'+ 
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
                    '<footer class="col-lg-12 col-sm-12">'+
                        '<div id="wave" >'+
                            '<div id="progress-bar" class="progress">'+                        
                                '<div class="progress-bar"></div>'+
                            '</div>'+
                        '</div>'+
                    '</footer>' +
                            ''+
                    '</div>';
        $('#meta').html(cont);           
        var scroll = true;
        var surfReady = false;      
        var video = videojs('video_main',{            
        });
        video.src([
            {type: data['meta']['type'], src: path}
        ]);

        video.load();       
        var progressDiv = document.querySelector('#progress-bar');
        var progressBar = progressDiv.querySelector('.progress-bar');

        var showProgress = function (percent) {
            progressDiv.style.display = 'block';
            progressBar.style.width = percent + '%';
        };

        var hideProgress = function () {
            if ('peaks' in data['meta']){
                var peaks = data['meta']['peaks'];
                if (!peaks.length>0){
                    peaks = JSON.stringify(wavesurfer.backend.getPeaks(512));
                    $.ajax({
                        url: "/php/dbcore.php?action=updatePeaks",
                        type: "POST",
                        dataType: "json",
                        data: {id: data['meta']['id'], peaks: peaks}
                    }).success(function(data) {
    //                    console.log(data);
                    });
                }   
            }
            var regions = data['text'];
            $.each(regions, function (index){
                var region = regions[index];
                var start = parseInt(region.timestart);
                var end = parseInt(region.timeend);
                if (to_time>=start && to_time<=end && to_time>0){
                    var mass = {'resize':false,'drag':false,'data':region.text,'start':region.timestart,'end':region.timeend,'color':'rgba(7, 20, 30, 0.3)'};                
                    wavesurfer.addRegion(mass);
                }                
            });
//            regions.forEach(function (region) {                
//                if (region.timestart==to_time && to_time>0){
//                    var mass = {'resize':false,'drag':false,'data':region.text,'start':region.timestart,'end':region.timeend,'color':randomColor(0.8)};                
//                    wavesurfer.addRegion(mass);
//                }
//            });     
            //КОСТЫЛЬ
            if (data['meta']['id']==259){      
                var mass = [[0.00,83.27,'Fizruk_04s01'],[103.5,5,'Fizruk_04s01'],[149.27,85,'Fizruk_04s01'],[255.54,112.03,'Fizruk_04s01']];
                mass.forEach(function (item) {                                              
                    var reg = {'resize':false,'drag':false,'data':item[2],'start':item[0],'end':parseInt(item[0])+parseInt(item[1]),'color':'rgba(7, 20, 30, 0.3)'};                          
                    wavesurfer.addRegion(reg);
                });  
            }
            //КОСТЫЛЬ
            progressDiv.style.display = 'none';
        };

        wavesurfer.on('loading', showProgress);
        wavesurfer.on('ready', hideProgress);
        wavesurfer.on('destroy', hideProgress);
        wavesurfer.on('error', hideProgress);         
        wavesurfer.on('region-click', function (region, e) {
                video.currentTime(region.start);           
            });        
        if ('peaks' in data['meta']){
            var peaks = data['meta']['peaks'];
            if (peaks.length>0){
                if (navigator.userAgent.toLowerCase().indexOf('firefox') == -1){
                    wavesurfer.init({
                        container: '#wave',
                        waveColor: '#009688',
                        progressColor: '#4CAF50',
                        cursorWidth: 3,
                        backend: 'MediaElement'
                    });   
                    wavesurfer.load(path,JSON.parse(data['meta']['peaks'])); 
                }else{
                    wavesurfer.init({
                        container: '#wave',
                        waveColor: '#009688',
                        progressColor: '#4CAF50',
                        cursorWidth: 3
                    });   
                    wavesurfer.load(path); 
                }                    
            }else{
                wavesurfer.init({
                    container: '#wave',
                    waveColor: '#009688',
                    progressColor: '#4CAF50',
                    cursorWidth: 3
                });                    
                wavesurfer.load(path);
            }
        }else{
            wavesurfer.load(path);
        }                  
        wavesurfer.toggleMute();
        console.log(video);
        
        //КОСТЫЛЬ
        if (data['meta']['id']==259){
            $('#metadata').append('<h4><span class="label label-primary">Совпадение: </span>&nbspФизрук 04s01</h4><p><h4><span class="label label-primary">Вероятность:</span>&nbsp 43%</h4></p><p><h4><span class="label label-primary">Ссылки: </span></h4></p><p><a target="_blank" href="http://www.youtube.com/watch?v=1k37s4oWpoU"><i class="glyphicon glyphicon-music"></i>&nbsp;Физрук сериал, лучшие моменты.</a></p>' );
        }
        //КОСТЫЛЬ
        if (true) {
            var marks = new Array();
            var curmark = 0;
            console.log(video);
            if (data['text'] != null) {
                $('.filedata').show();
                var fileData = $('.filedata');
                var fileDataAll = $('.filedataAll');
                fileDataAll.html('');
                fileData.html('');
                var speakersCount = 0;
                for (var i = 0; i < data['text'].length - 1; i++) {
                    speakersCount += data['text'][i]['speakerid'];
                    var row = "<div class='msg speaker-" + data['text'][i]['speakerid'] + "'><record class=''  timestart='" + data['text'][i]['timestart'] + "' timeend='" + data['text'][i]['timeend'] + "' id='" + data['text'][i]['id'] + "'>";
                    var row_text = "<record timestart='" + data['text'][i]['timestart'] + "' timeend='" + data['text'][i]['timeend'] + "' id='" + data['text'][i]['id'] + "'>";
                    var text = '';
                    var str = '';
                    if (data['text'][i]['alttext'] != null) {
                        str = data['text'][i]['alttext'];
                        text += "<span>";
                        str = str.replace(/[ ]/g, "</span> <span>");
                        text += str;
                        text += "</span>";
                    } else {
                        str = data['text'][i]['text'];
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
                    $('.msg').css('width','99%');
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
            $('.getText').off('click').click(function (){
                var allData ='';
                $('.filedataAll span').each(function (){
                    var cellText = $(this).text();
                    allData+=cellText+" ";
                });
//                var textToWrite = document.getElementByClass("filedata").value;
                var textFileAsBlob = new Blob([allData], {type:'text/plain'});
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
            var previousTime = 0;
            var wavePercent = 0;
            video.on("played", function() {
                
            });
            wavesurfer.on('ready', function (q){
                surfReady = true;
            });             
            wavesurfer.on('seek',function (time){
                if (time!=wavePercent){
                    var duration = video.duration();
                    video.currentTime((duration*(time/100))*100);
                }
            });
            video.on("seeked", function() {                
                var timeclick = video.currentTime();
                var duration = video.duration();
                var percent = timeclick/duration*100;   
                for (var i = 0; i <= marks.length - 1; i++) {
                    if (parseFloat(marks[i].timestart) >= parseFloat(timeclick) && parseFloat(timeclick) <= parseFloat(marks[i].timeend)) {
                        $('.filedata record, .filedataAll record').removeClass('success');
                        $('.filedataAll').scrollTo($('.filedataAll record[id="' + marks[i].id + '"]'), 500);
                        $('.filedata').scrollTo($('.filedata record[id="' + marks[i].id + '"]').parent('.msg'), 500);
                        curmark = i;
                        break;
                    }
                    else {
                        curmark = 0;
                        $('.filedata .msg, .filedata .msg, .filedataAll record').removeClass('success');
                    }
                }
                $('.filedata record[id="' + marks[i].id + '"]').parent('.msg').addClass('success');
                $('.filedataAll record[id="' + marks[i].id + '"]').addClass('success');
            });
            video.on("timeupdate", function() {   
                previousTime = video.currentTime();
                var curT = previousTime;
                var duration = video.duration();
                var percent = curT / duration;
                wavePercent = percent;
                console.log('curT: '+curT+', Duration: '+duration+', Percentage: '+percent);
                if (surfReady){
                    wavesurfer.seekTo(percent); 
                }
                $('.video_time').text(toHHMMSS(curT));
//                var percent = curT / video.duration * 100;
//                $('.progress-bar').width(percent + '%');
                if (curT >= marks[curmark].timestart && curmark < marks.length) {
                    $('.filedata .msg').removeClass('success');
                    $('.filedataAll record').removeClass('success');
                    $('.filedata record[id="' + marks[curmark].id + '"]').parent('.msg').addClass('success');
                    $('.filedataAll record[id="' + marks[curmark].id + '"]').addClass('success');
                    if (scroll) {
                        $('.filedataAll').scrollTo($('.filedataAll record[id="' + marks[curmark].id + '"]'), 500);
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
                        $('.filedataAll record').removeClass('success');
                        $('.filedata record[id="' + marks[i].id + '"]').parent('.msg').addClass('success');
                        $('.filedataAll record[id="' + marks[i].id + '"]').addClass('success');
                        $('.filedataAll').scrollTo($('.filedataAll record[id="' + marks[i].id + '"]'), 500);
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
                downloadLink.download = data['meta']['title'];
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
</script>