<style>
    body{ background-color: #f1f1f1;}
    #page-wrapper {

    background-color: #f1f1f1;
    #wrapper{
        height: 90%;
    }  
    
    
}


.filedataAll record{
  border: 0;
  background-image: linear-gradient(#1754C3, #1754C3), linear-gradient(transparent, transparent);
  background-size: 0 2px, 100% 2px;
  background-repeat: no-repeat;
  background-position: left bottom, left calc(100%);
  background-color: transparent;
  background-color: rgba(0, 0, 0, 0);
}
.filedataAll record.th{
  outline: none;
  background-image: linear-gradient(#1754C3, #1754C3), linear-gradient(#c0c0c0, #c0c0c0);
  -webkit-animation: text-highlight forwards;
          animation: text-highlight forwards;
  box-shadow: none;
  background-size: 0 2px, 100% 2px;    
}

@-webkit-keyframes text-highlight {
  0% {
    background-size: 0 2px, 100% 2px;
  }
  100% {
    background-size: 100% 2px, 100% 2px;
  }
}

</style>
<div class="col-lg-7 col-md-5 col-sm-5">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <video id="video_main" class="video-js vjs-default-skin vjs-big-play-centered" 
        controls preload="auto" width="100%" height="55%" poster="/img/audio_poster.png"> 
        </video>         
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="shadow-block">
            <h3> <?php echo $data['file']['meta']['title']; ?> <small><i class="glyphicon glyphicon-time"></i> <span><?php echo gmdate("H:i:s",$data['file']['meta']['length_record'] ) ?></span></small></h3>
            <p><b>Обработанно: <?php echo $data['file']['meta']['date_upload']; ?> </b></p>
            <p id="metadata"></p>
            <div class="footer">
                <span><i class="glyphicon glyphicon-floppy-save"></i> <a download="<?php echo $data['file']['meta']['title'] ?>" href="http://<?php echo $_SERVER['SERVER_NAME'].  str_replace('..', '', $data['file']['meta']['filepath']) ?>"> Файл</a> </span><span class="getText"><i class="glyphicon glyphicon-save-file"></i> Текст</span>
                <div class="public_url">
                    <div class="checkbox" style="display: <?php echo is_null($data['user_name'])? 'none': 'blob' ?>">
                        <label>
                          <?php echo $data['file']['meta']['public_url']? '<a target="_blank" href="http://'.$_SERVER['SERVER_NAME'].'/show/'.$data['file']['meta']['id'].'">http://'.$_SERVER['SERVER_NAME'].'/show/'.$data['file']['meta']['id'].'</a> <input type="checkbox" checked>' : '<input type="checkbox">' ?><span class="checkbox-material"><span class="check"></span></span> Публичный доступ
                        </label>
                    </div>                    
                </div>
            </div>
        </div>            
        <div class="shadow-block">
            <div id="wave">
                <div id="progress-bar" class="progress">                       
                    <div class="progress-bar"></div>
                </div>                
            </div>
        </div>        
    </div>
    
</div>
<div class="col-lg-5 col-md-7 col-sm-7">
    <div class="">
        <div class="shadow-block">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#text" data-toggle="tab">Текст</a></li>
                <li><a href="#textAll" data-toggle="tab">Диалог</a></li>
                <li class=""></li>
                <li><input type="text" id="find_text" class="form-control" placeholder="Локальный поиск..."></input></li>
                <li><button id="translate" class="btn btn-primary btn-xs">Перевод</button></li>
            </ul>
            <div id="myTabContent" class="tab-content" style="height: 80%;">
                <div class="tab-pane fade active in" id="text">
                    <div class="filedataAll"></div>
                </div>
                <div class="tab-pane fade" id="textAll">
                    <div class="filedata"></div>
                </div>
            </div>
        </div>
    </div>    
</div>


<script>
        //Get Main Data & Var
        var data = eval('(<?php echo json_encode($data['file'])?>)');
        console.log(data);
        var to_time = "<?php echo $data['timestart']; ?>" || 0;
        console.log(to_time);
        var wavesurfer = Object.create(WaveSurfer);
        var data_time = 0;
        var path = data['meta']['filepath'];
        path = path.replace('..', '');          
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
        
        //WaveSurfer Progress Function
        
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
            //КОСТЫЛЬ
            if (data['meta']['id']==259){      
                var mass = [[0.00,83.27,'Fizruk_04s01'],[103.5,5,'Fizruk_04s01'],[149.27,85,'Fizruk_04s01'],[255.54,112.03,'Fizruk_04s01']];
                mass.forEach(function (item) {                                              
                    var reg = {'resize':false,'drag':false,'data':item[2],'start':item[0],'end':parseInt(item[0])+parseInt(item[1]),'color':'rgba(7, 20, 30, 0.3)'};                          
                    wavesurfer.addRegion(reg);
//                    $(newreg.element).html(""+Math.round(Math.random()* (99-90)+90));
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
                        normalize:true,
                        waveColor: '#009688',
                        progressColor: '#4CAF50',
                        cursorWidth: 3,
                        backend: 'MediaElement'
                    });   
                    wavesurfer.load(path,JSON.parse(data['meta']['peaks'])); 
                }else{
                    wavesurfer.init({
                        container: '#wave',
                        normalize:true,
                        waveColor: '#009688',
                        progressColor: '#4CAF50',
                        cursorWidth: 3
                    });   
                    wavesurfer.load(path); 
                }                    
            }else{
                wavesurfer.init({
                    normalize:true, 
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
            $('#metadata').append('Совпадение с <a> Физрук 04s01</a>. Вероятность совпадения <b>83%</b><p><a target="_blank" href="http://www.youtube.com/watch?v=1k37s4oWpoU"><i class="fa fa-youtube gi-2x"></i>&nbsp;Физрук сериал, лучшие моменты.</a></p>' );
        }
        //КОСТЫЛЬ
        
        //Публичный доступ к файлу
        
        $('.public_url input').change(function (){
            $.ajax({
                url: "/php/dbcore.php?action=mediaSettings",
                type: "POST",
                dataType: "json",
                data: {fileid: data['meta']['id'], public_url: $(this).prop('checked')? 1 : 0}
            }).success(function (data){
                console.log(data);
            });
            if ($(this).prop('checked')){
                $(this).parent().prepend('<a target="_blank" href="http://'+window.location.host+'/show/'+data['meta']['id']+'">http://'+window.location.host+'/show/'+data['meta']['id']);
            }else{
                $(this).prev().remove();
            }
        });    
        
        //Поиск текста в файле
        
        $('#find_text').on('input',function (){
            var text =  $(this).val();
            if (text.length>=3 && text!==''){   
                var element = $('.filedataAll span:contains("'+text+'")');
                element.css( "text-decoration", "underline" );
                
            }else{
                $('.filedataAll span').css( "text-decoration", "none" );
            }
        });
        
        $('#translate').click(function (){
            $.each($('.filedataAll span'),function (id,item){
//                console.log($(item).text());
                $.ajax({
                    url:'/php/translate?text='+$(item).text(),
                }).success(function (data){
//                    console.log(data);
                    if (data!=null){
                        $(item).html(data);
                    }
                });
            });
        });
        
        if (true) {
            var marks = new Array();
            var curmark = 0;
            console.log(video);
            if (data['text'] != null) {
                $(' .filedata').show();
                var fileData = $(' .filedata');
                var fileDataAll = $(' .filedataAll');
                fileDataAll.html('');
                fileData.html('');
                var speakersCount = 0;
                for (var i = 0; i < data['text'].length - 1; i++) {
                    speakersCount += data['text'][i]['speakerid'];
                    var row = "<div class='msg speaker-" + data['text'][i]['speakerid'] + " '><record timestart='" + data['text'][i]['timestart'] + "' timeend='" + data['text'][i]['timeend'] + "' id='" + data['text'][i]['id'] + "'>";
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
                var testReg = null;
                $('.filedata .msg record, .filedataAll record').on('mouseenter',function() {
                    var reg = {'id':'test','resize':false,'drag':false,'start':parseInt($(this).attr('timestart')),'end':parseInt($(this).attr('timeend')),'color':'rgba(67, 167, 49, 0.61)'};                          
                    testReg = wavesurfer.addRegion(reg);
                });
                
                $('.filedata record, .filedataAll record').on('mouseleave',function() {     
                    var cur_elem = testReg;
                    $(cur_elem.element).remove();
                });
                $('.filedata, .filedataAll').click(function() {
                    $('input', this).remove();
                    $(testReg.element).remove();
                });
                $('.filedata, .filedataAll').hover(function() {
                    $('input', this).remove();
                    $(testReg.element).remove();
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
                $('.filedataAll record').click(function(e) {
                    $('.filedataAll record').removeClass('success');
//                    $(this).addClass('success');
                    $(this).addClass('th');
                    video.currentTime(parseFloat($(this).attr('timestart')));
                    video.play();
                    for (var i = 0; i <= marks.length - 1; i++) {
                        if (marks[i].id == $(this).attr('id')) {
                            curmark = i;
                        }
                    }
                });
            }
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
                        $('.filedataAll record').removeClass('th');
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
//                $('.filedataAll record[id="' + marks[i].id + '"]').addClass('success');
                var dur =  parseInt(marks[i].timeend) - parseInt(marks[i].timestart);
                $('.filedataAll record[id="' + marks[i].id + '"]').css('animationDuration',dur+'s').addClass('th');
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
//                    $('.filedataAll record').removeClass('success');
                    $('.filedataAll record').removeClass('th');
                    $('.filedata record[id="' + marks[curmark].id + '"]').parent('.msg').addClass('success');
//                    $('.filedataAll record[id="' + marks[curmark].id + '"]').addClass('success');
                    //TEST HIGHLITH
                    var dur =  parseInt(marks[curmark].timeend) - parseInt(marks[curmark].timestart);
                    $('.filedataAll record[id="' + marks[curmark].id + '"]').css('animationDuration',dur+'s').addClass('th');
                    
                    if (scroll) {
                        $('.filedataAll').scrollTo($('.filedataAll record[id="' + marks[curmark].id + '"]'), 500, {top: '+=50px'});
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
                        $('.filedataAll record').removeClass('th');
                        $('.filedata record[id="' + marks[i].id + '"]').parent('.msg').addClass('success');
                        $('.filedataAll record[id="' + marks[i].id + '"]').addClass('th');
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
        } else {
            if (to_time > 0) {
                video = $('audio').get(0);
                video.onloadeddata(to_time);

            } else {
                NProgress.done();
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