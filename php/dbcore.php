<?php


    include 'conn.php';
    include 'streaming.php';
//    include 'myFunct.php';
    session_start();
    
    
    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $action = $_GET['action'];
        $str='';
        foreach ($_POST as $key => $value) {
            $str.=$key.':'.$value.'; ';
        }
        if ($action=="checkMsg" or $action=="getLog" or $action=="getStreamList" or $action=="loadfilelist") {            
        }else{
            mylog('Start action "'.$action.'" // Data: '.$str);
        }      
        switch($action) {
            case 'loadfilelist' : loadFilelist();break;
            case 'getFtp' : getFtp($_GET['ftpid']);break;
            case 'updateEvent' : updateEvent();break;
            case 'newEvent' : newEvent();break;
            case 'delEvent' : delEvent();break;
            case 'updateFtp' : updateFtp();break;
            case 'newFtp' : newFtp();break;
            case 'updateFtpData' : updateFtpData();break;
            case 'downloadYoutube': downloadFromYoutube($_POST['url'],$_POST['fonem'],$_POST['text'],$_POST['rel']);break;
            case 'getData': getData($_POST['id']);break;
            case 'checkFiles': checkFiles();break;
            case 'addFileLocal': uploadFile($_POST['name'],$_POST['type']);break;
            case 'getModal': getModal($_POST['modaltype']);break;
            case 'addStream': addStream($_POST['stream_url']);break;
            case 'delAllStreams':vlc_del_all();break;
            case 'addTask':addTask();break; 
            case 'mediaSettings':mediaSettings($_POST['fileid'],$_POST['public_url']);break; 
            case 'getStream':getStream($_POST['data']);break;
            case 'getStreamList':getStreamList();break;            
            case 'getStreamFiles':getStreamFiles($_GET['streamid']);break;            
            case 'closeStream': closeStream($_POST['name']);break;
            case 'getLog':getLog();break;
            case 'getTable':getTable($_GET['data_show']);break;
            case 'test': test();break;
            case 'searchSome': searcher($_POST['text']);break;
            case 'updatePeaks': updatePeaks($_POST['id'],$_POST['peaks']);break;
            case 'updateData': updateData($_POST['id'],$_POST['text']);break;
            case 'fonemSearch': fonemSearch($_POST['text'],$_POST['rel']);break;
            case 'streamCut': streamCut($_POST['type'], $_POST['id'], $_POST['url']);break;
            case 'checkMsg': checkMsg();break;
            case 'updateTables': updateTables($_POST['']);break;
            case 'updateMsg': updateMsg();break;
        }
    }
    
    
    function mediaSettings($fileid,$val){
        $sql= "Update dbfilenames set public_url='".$val."' Where id='".$fileid."' and userid='".$_SESSION['user']['id']."'";
        mysql_query($sql);
        echo json_encode($sql);
    }
    
    function test(){
////        addTask('1', 'speech2text', 'youtube', '123');
//                    $client = new  
//            SoapClient(  
//                "http://{$_SERVER['HTTP_HOST']}/soap_server/server.wsdl.php"  
//            );                  
////            $ret= $client->add();
////            print_r($client->__getFunctions());
//            $ret= $client->__soapCall('add', array('fileid'=>'123','type'=>'ads'));
//            print_r($client->__getFunctions());
//            echo "Response:\n" . $ret . "<br>";
        $url ='http://www.youtube.com/watch?v=gbYXv23ZeZs';
        downloadFromYoutube($url);
    }
    
    function streamCut($type,$id,$url){
        $status = 30;
        $fromtype = 'stream';
        $client = new  
        SoapClient(  
            "http://{$_SERVER['HTTP_HOST']}/soap_server/server.wsdl.php"  
        );  
        $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
        "Values ('".$type."','".$id."','".$url."','".$fromtype."','0','".$status."')";                  
        $client->sendTask($sql); 
        echo json_encode('send');
    }

    function fonemSearch($text,$rel){
        $client = new  
        SoapClient(  
            "http://{$_SERVER['HTTP_HOST']}/soap_server/server.wsdl.php"  
        );  
        $send_text=str_replace(' ', '|', $text);
        $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status,data1,data2) ".
        "Values ('fonemSearch','0','IPUSER','UserTask','".$_SESSION['UID']."','80','". $send_text."','".$rel."')";                  
        $client->sendTask($sql); 
        echo json_encode('send');
    }
    
    
        function loadFilelist(){
        $sql = "Select public_url,id,filename,processed,type,title,date_upload,filepath,length_record From dbfilenames Where streamid=0 and "
                ."userid='".$_SESSION['user']['id']."'";
           $result = mysql_query($sql);
           if ($result) {
               while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {   
                   $data=$row;
                   $data['url']="<a href='".  rawurldecode("/user/show/".$data['id'])."'>Перейти к файлу</a>";
       //                if ($row['processed']==1){
       //                    $data['status']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'></i>";
       //                }
       //                else{
       //                    $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";
       //                }
                   $sql = "Select word From db_key_words Where fileid='".$data['id']."'";
                   $res = mysql_query($sql);
                   if ($res) {
                        while ($row_tags = mysql_fetch_array($res)) {
                            $data['tags'] .= '<a href="/user/show/'.$data['id'].'" class="label label-primary">'.$row_tags['word'].'</a> ';
                        }
                   }
                   if ($data['public_url']!=0){
                       $data['public_url']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'> Открыт</i>";
                   }else{
                       $data['public_url']="<i style='color:#F44336;' class='glyphicon glyphicon-remove'> Закрыт</i>";
                   }
                    switch ($data['processed']) {
                        case 0:
                              $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-cloud-upload'> Загрузка</i>";
                            break;
                        case 3:
                              $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'> Обработка</i>";
                            break;
                        case 4:
                              $data['status']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'> Готово</i>";
                            break;
                        case 123:
                              $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-cloud-upload'> Загрузка</i>";
                            break;
                        case 61:
                              $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'> Обработка</i>";
                            break;

                        default:
                              $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";               
                            break;
                    }
                   $db[]=$data;
               }
           }else
           {
               $db=null;
           }
           echo json_encode($db);
    }
    
    
    function checkMsg(){
        $sql = "Select * From dbmsg as dm Left Join dbfilenames as df on df.id=dm.fileid Where dm.toid='".$_SESSION['user']['id']."' and dm.del='0' Order By dm.id DESC";
           $result = mysql_query($sql);
           if ($result) {
               while ($row = mysql_fetch_array($result)) {    
                   $data=$row;
                   $data['id']=$row['fileid'];
                   $data['isgroup']=0;
                   $data['parentid']=0;
                   $m = explode('/',$data['msg']);
                   $data['word']=$m[0];
                   $data['id']=$m[1];
                   $db[]=$data;
               }
           }else
           {
               $db=null;
           }
           echo json_encode($db);        
    }
    
    function getLog(){
        $pagesize = isset($_POST['rows'])?$_POST['rows']:0;
        $page = isset($_POST['page'])?$_POST['page']:0;
        $cur_count= $pagesize*$page;
        $sql = "Select count(*) as count From dblogs";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $row_count = $row['count'];
        if ($page>1){
            $step = ($pagesize*$page)-$pagesize;
            $sql = "Select * From dblogs Order By id desc Limit ".$step.",".$pagesize."";
        }else{
            $sql = "Select * From dblogs Order By id desc Limit 0,".$pagesize."";
        }
        $result = mysql_query($sql);
           if ($result) {
               while ($row = mysql_fetch_array($result)) {                    
                   $data=$row;  
                   switch ($row['uiid']) {
                       case '':


                           break;

                       default:
                           break;
                   }
                   $data['isgroup']=0;
                   $data['parentid']=0;
                   $db['data'][]=$data;
               } 
               $db['totalrows']=$row_count;
           }else{
               $db=null;
           }
        echo json_encode($db);
    }
    
    function getTable($data_show){
        $pagesize = isset($_POST['rows'])?$_POST['rows']:0;
        $page = isset($_POST['page'])?$_POST['page']:0;
        $cur_count= $pagesize*$page;
        if ($data_show=='filenames'){
            $sql = $sql = "Select count(*) as count From db".$data_show;
        }else{
            $sql = "Select count(*) as count From db".$data_show;
        }        
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $row_count = $row['count'];
        if ($page>1){
            $step = ($pagesize*$page)-$pagesize;
            $sql = "Select * From db".$data_show." Order By id desc Limit ".$step.",".$pagesize."";
        }else{
            $sql = "Select * From db".$data_show." Order By id desc Limit 0,".$pagesize."";
        }
        $result = mysql_query($sql);
           if ($result) {
               while ($row = mysql_fetch_array($result)) {                    
                   $data=$row;  
                   switch ($data_show) {
                       case 'tasks':
                            switch ($data['status']) {
                                case 0:
                                      $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-cloud-upload'></i>";
                                    break;
                                case 3:
                                      $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";
                                    break;
                                case 4:
                                      $data['status']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'></i>";
                                    break;
                                case 123:
                                      $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-cloud-upload'>Загрузка</i>";
                                    break;
                                case 61:
                                      $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'>Обработка</i>";
                                    break;

                                default:
                                      $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";               
                                    break;
                            }
                       
                           break;

                       default:
                           break;
                   }
                   $data['name']= $data['filename'];
                   $db['data'][]=$data;
               } 
               $db['totalrows']=$row_count;
           }else{
               $db=null;
           }
        echo json_encode($db);
    }
    
    
    function getFtp($ftpid){
        $data = null;
        if (is_null($ftpid)){
            $sql = "Select * From dbftp Where "
                    ."userid='".$_SESSION['user']['id']."'";
        }else{
            $sql = "Select * From dbftp_data Where "
                    ."ftp_id=".$ftpid;            
        }
           $result = mysql_query($sql);
           if ($result) {
               if (mysql_num_rows($result)>0){
                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                        $data[]=$row;
                    }
               }else{
                   $data['status']='error';
               }
           }else{
               $data[]=Array('status'=>'error');
           }
           echo json_encode($data);
    }
    
    
    function updateFtpData(){
        //$check = explode(',',$_POST['checked']);
        $check = json_decode($_POST['checked'],true);
        if (!is_null($check)){
            $sql = "Select * From dbftp_data Where ftp_id='".$_POST['ftp_id']."'";
            $query = mysql_query($sql);
            $data = null;
            $keys = null;
            while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
                $keys[]=$row['path'];
            }
            foreach ($check as $value) {                
                if ($value['ch']){
                    if (!in_array($value['path'], $keys)){
                        mysql_query("Insert Into dbftp_data (path,status,ftp_id,checked) Values('".$value['path']."','0','".$_POST['ftp_id']."','1')");
                    }
                }else{
                    mysql_query("Delete From dbftp_data Where ftp_id='".$_POST['ftp_id']."' and path='".$value['path']."'");
                }
            }
        }            
    }
    
    function updateEvent(){    
        $array = json_decode($_POST['event'],true);
//        echo json_encode($array['start']);
        $sql = "Update db_events Set `start`='".$array['start'];
        $sql .= !is_null($array['end']) ? "',`end`='".$array['end'] : '';
        $sql .= "',`title`='".$array['title'].
                "',`repeat`='".$array['repeat'].
                "',`repeat_day`='".$array['repeatday'].
                "',`allDay`='".$array['allday'].
                "' Where `user_id`='".$_SESSION['user']['id'].
                "' and `id`='".$array['id']."'";
        mysql_query($sql);
        echo json_encode($sql);
    }
    
    function newEvent(){    
        $array = json_decode($_POST['event'],true);
        $sql = "Insert Into `db_events` (`title`,`type`,`task_id`,`start`,`end`,`repeat`,`allDay`,`repeat_day`,`user_id`) Values('".
                $array['title']."','".
                $array['type']."','".
                $array['task_id']."','".
                $array['start']."','".
                $array['end']."','".
                $array['repeat']."','".
                $array['allday']."','".
                $array['repeatday']."','".$_SESSION['user']['id']."')"; 
        mysql_query($sql);
        echo json_encode($sql);
    }
    
    function delEvent(){    
        $sql = "Update `db_events` Set `del`='1' Where `id`='".$_POST['id']."'";
        mysql_query($sql);
        echo json_encode($sql);
    }
    
    function updateFtp(){    
        $sql = "Update dbftp Set host='".$_POST['ftp_host']."', login='".$_POST['ftp_login']."', password='".$_POST['ftp_password']."' Where userid='".$_SESSION['user']['id']."' and id='".$_POST['ftp_id']."'";
        mysql_query($sql);
    }
      
    function newFtp(){    
        $sql = "Insert Into `dbftp` (`userid`,`host`,`login`,`password`) Values('".$_SESSION['user']['id']."','".$_POST['ftp_host']."','".$_POST['ftp_login']."','".$_POST['ftp_password']."')";
        mysql_query($sql);
    }
      
    function searcher($text){
        if ($text!=''){
            $sql = "Select ft.text,fn.id as fileid,ft.id as textid,fn.title,ft.timestart,fn.userid,ft.alttext From dbfilestext as ft ".
                    "Left Join dbfilenames as fn on ft.fileid=fn.id ".
                    "Where fn.userid='".$_SESSION['UID']."' and (ft.text like '%".$text."%' or ft.alttext like '%".$text."%')";
            $result = mysql_query($sql);
            while ($row = mysql_fetch_array($result)) {
                $data['fileid']=$row['fileid'];
                $data['textid']=$row['textid'];
                $data['title']=$row['title'];
                $data['time']=$row['timestart'];
                $data['text']=$row['text'];
                $data['alttext']=$row['alttext'];
                $db[]=$data;
            }
            echo json_encode($db);
        }
    }
    
    function getModal($modaltype){
        $data = null;
        if ($modaltype!=null){
            switch ($modaltype) {
                case 'settings':
                    $data['modal-body'] = 
                    '<!--<nav style="width:300px" class="navbar navbar-default" role="navigation">'.
                     '<div class="container-fluid">'.
                        '<div class="navbar-header">'.
                            '<a class="navbar-brand" href="">Авто-Обновление:</a>'.                        
                        '</div>'.
                        '<div class="collapse navbar-collapse">'.
                          '<div class="nav navbar-nav">'.
                            '<span class="input-group">'.
                               '<input style="height: 42px;width: 20px;" type="checkbox">'.
                            '</span>'.
                          '</div>'.
                          '<ul class="nav navbar-nav navbar-right">'.
                            '<li class="dropdown">'.
                              '<a href="#" class="dropdown-toggle" data-toggle="dropdown">1 мин.<span class="caret"></span></a>'.
                              '<ul class="dropdown-menu" role="menu">'.
                                '<li count="60"><a href="#">1 мин.</a></li>'.
                                '<li count="120"><a href="#">2 мин.</a></li>'.
                                '<li count="300"><a href="#">5 мин.</a></li>'.
                                '<li count="600"><a href="#">10 мин.</a></li>'.
                              '</ul>'.
                            '</li>'.
                          '</ul>'.
                        '</div>'.
                      '</div>'.
                    '</nav>-->'.
                    '<label style="">Слова для автомотического поиска:</label><br>'.
                    '<div class="form-group animated" style="padding-left:20px">'.                        
                        '<div class="form-group animated" style="">'.
                            '<label style="color:#5CB85C">Введите положительные слова для поиска:</label><br>'.
                            '<textarea class="textData" rows="4" cols="70"></textarea>'.                       
                        '</div>'.
                        '<div class="form-group animated" style="">'.
                            '<label style="color:#B85C5C">Введите отрицательные слова для поиска:</label><br>'.
                            '<textarea class="textData" rows="4" cols="70"></textarea>'.                       
                        '</div>'.
                        '<div class="form-group animated" style="">'.
                            '<label style="color:#F0AD4E">Введите нейтральные слова для поиска:</label><br>'.
                            '<textarea class="textData" rows="4" cols="70"></textarea>'.                       
                        '</div>'. 
                    '</div>'; 
                    break;
                case 'addSome':
                    $data['modal-body'] =
                        '<div class="form-group"><label> Выберете тип задания:</label><br>'.
                        '<div class="btn-group typeTask">'.
                          '<button task="0" type="button" class="btn btn-primary" >Распознование речи</button>'.
                          '<button task="1" type="button" class="btn btn-primary" >Фонемный поиск</button>'.
//                          '<button type="button" class="btn btn-default">Right</button>'.
                        '</div></div>'.
                        '<div class="form-group typeLoad" disabled="disabled"><label> Выберете тип загрузки:</label><br>'.
                        '<div class="btn-group ">'.
                          '<button task="0" type="button" class="btn btn-primary">Локально</button>'.
                          '<button task="1" type="button" class="btn btn-primary">YouTube</button>'.
//                          '<button type="button" class="btn btn-default">Right</button>'.
                        '</div></div>'.                        
                        '<div class="form-group youtubeLoader" style="display:none">'.
                          '<label>Поле для ввода ссылки на YouTube</label><br>'.
                           '<input type="url" class="form-control input-lg search_name" placeholder="Введите URL для загрузки">'.
                           '<input type="checkbox" id="fonemCheck"><label for="fonemCheck">  Фонемный поиск</label>'.
                            '<div class="form-group fonemSearch animated" style="display:none;">'.
                                '<label>Введите слова для поиска:</label><br>'.
                                '<textarea class="textData" rows="4" cols="70"></textarea>'.
                                '<label>Задайте минимальную релевантность в %:</label><br>'.
                                '<input class="relData" type="number" value="80" min="10" max="100" step="10">'.                        
                            '</div>'.                        
                        '</div>'.
                        '<div class="form-group localLoader" style="display:none;">'.
                            '<div class="form-group">'.
                              '<label>Выберете язык обработки файла:</label><br>'.
                                '<div class="btn-group">'.
                                  '<button type="button" class="btn btn-primary">Русский</button>'.
                                  '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">'.
                                    '<span class="caret"></span>'.
                                    '<span class="sr-only">Toggle Dropdown</span>'.
                                  '</button>'.
                                  '<ul class="dropdown-menu" role="menu">'.
                                    '<li><a href="#">Русский</a></li>'.
                                    '<li><a href="#">Ангийский</a></li>'.
                                  '</ul>'.                              
                                '</div>'.
                            '</div>'.
                            '<div class="form-group">'.    
                                '<span class="btn btn-success fileinput-button">'.
                                    '<i class="glyphicon glyphicon-plus"></i>'.
                                    '<span>Загрузить файл</span>'.
                                    '<input id="fileupload" type="file" name="files[]" multiple>'.                          
                                 '</span>'.
                                '<div id="progress" class="progress">'.
                                    '<div class="progress-bar progress-bar-success"></div>'.
                                '</div>'.
                                '<div id="files" class="files"></div>'.                           
                            '</div>'.
                        '</div>'.
                        '<div class="form-group streamCut animated" style="display:none;">'.
                            '<label>Введите слова для поиска:</label><br>'.
                            '<textarea class="textData" rows="4" cols="70"></textarea>'.
                            '<label>Задайте минимальную релевантность в %:</label><br>'.
                            '<input class="relData" type="number" value="80" min="10" max="100" step="10">'.                        
                        '</div>';                        
                break;
                default:
                    break;
            }
            echo json_encode($data);
        }
        
    }
    
    function updateData($id,$alttext){
//        $sql = "Select id,filename,type,filepath,file_lang,processed,title,length_sec From dbfilenames Where id='".$id."'";
        $sql = "Update dbfilestext Set alttext='".$alttext."' Where id='".$id."'";
        mysql_query($sql);
        echo json_encode($id);
    }
    
    function updatePeaks($id,$peaks){
//        $sql = "Select id,filename,type,filepath,file_lang,processed,title,length_sec From dbfilenames Where id='".$id."'";
        $sql = "Update dbfilenames Set peaks='".$peaks."' Where id='".$id."'";
        mysql_query($sql);
        echo json_encode($id);
    }
    
    function updateTables($sql){
        
    }
    
    function getData($id){
        $sql = "Select id,filename,type,filepath,file_lang,processed,title,length_sec,date_upload From dbfilenames Where id='".$id."'";
        $result = mysql_query($sql);
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                if ($row['processed']==4){
                    $db['file']=$row;
                    $sql1 = "Select id,timestart,timeend,text,alttext,speakerid From dbfilestext Where fileid='".$id."' Order by timestart";
                    $result1= mysql_query($sql1);
                    if ($result1){
                       while ($row1 = mysql_fetch_array($result1)) {
                           $db['data'][] = $row1;                           
                       }
                    }
                }else{
                    $db['file']=$row;
                }
            }
            echo json_encode($db);
        }        
    }
    
    function getStreamList(){
        $sql = "Select id,title,restream,streamname,datetime_,source From dbstreams";
        $result = mysql_query($sql);
        $mass = vlc_view_streams();
        if ($result) {
            while ($row = mysql_fetch_array($result)) {    
                $data['id'] =$row['id'];
                $data['name']=$row['title'];
    //                if ($row['processed']==1){
    //                    $data['status']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'></i>";
    //                }
    //                else{
    //                    $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";
    //                }
                $data['isgroup']=0;
                $data['parentid']=0;
                $data['restream']=$row['restream'];
                $data['source']=$row['source'];
                $data['streamname']=$row['streamname'];
                
                foreach ($mass as $key => $value){
                    if ($value['name']==$row['streamname']){
                        if ($value['state']=='playing'){
                            $data['status']='<span class="label label-success">Онлайн</span>';               
                        }else{
                            $data['status']='<span class="label label-danger">Оффлайн</span>';
                        }
                    }    
                }                
                $db[]=$data;
            }
        }else
        {
            $db=null;
        }
        echo json_encode($db);        
    }
    function getStreamFiles($id){
        $sql = "Select id,filename,type,filepath,processed,title,date_upload From dbfilenames Where streamid='".$id."'";
        $result = mysql_query($sql);
        if ($result) {
            while ($row = mysql_fetch_array($result)) {    
                $data['id'] =$row['id'];
                $data['name']=$row['title'];
                switch ($row['processed']) {
                    case 0:
                          $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-download'></i>";
                        break;
                    case 3:
                          $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";
                        break;
                    case 4:
                          $data['status']="<i style='color:#5cb85c;' class='glyphicon glyphicon-ok'></i>";
                        break;

                    default:
                          $data['status']="<i style='color:#f0ad4e;' class='glyphicon glyphicon-time'></i>";               
                        break;
                }                
                $data['isgroup']=0;
                $data['datetime']=$row['date_upload'];
                $data['parentid']=0;                
                $db[]=$data;
            }
        }else
        {
            $db=null;
        }
        echo json_encode($db);        
    }
    
    
    function downloadFromYoutube($url,$fonem=false,$text = '',$rel = 80){             
            $type='speech2text';
            $fromtype='youtube';
            parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
            $id =$my_array_of_vars['v'];  
            $return=$id;
            $format = 'video/webm'; 
            parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$id),$info); 
            $streams = $info['url_encoded_fmt_stream_map']; 
            $streams = explode(',',$streams);
            foreach($streams as $stream){
            parse_str($stream,$data);
            if(stripos($data['type'],$format) !== false && $data['stereo3d']!=1){ 
                    $title = $info['title'];
                    $request['type']=123;               
                    $request['title'] = $title;
                    $request['data'] = $data;
                    $time=$info['length_seconds'];                
            //        $file = fopen('video.'.str_replace($format,'video/',''),'w');
                    $videoid = md5(time()+rand(10000,99999));
                    $filename= 'video_'.$videoid.'.webm';
                    $filepath = '../files/import/';
    //                $contents = "";
                    $f = get_headers($data['url'].'&amp;signature='.$data['sig'],1);
                    $request['content'] = $f;
                    $request['search'] = array_search('Content-Length', $f);
                    if (array_key_exists('Content-Length', $f)){
                        $file_size = intval($f['Content-Length']);
                    }else{
                        $file_size = 0;
                    }
                    $name = explode('.',basename($filename));                   
                    $sql = "Insert Into dbfilenames (userid,filename,processed,type,filepath,file_lang,title,length_record,streamid) ".
                            "Values('".$_SESSION['user']['id']."','".$name[0]."','".$request['type']."','".$data['type']."','".$filepath.$filename."','en_GB','".$title."','".$time."','0')";
                    mysql_query($sql);     
//                    echo mysql_error();
                    $fileid = mysql_insert_id();
    //                        rename($filepath.'video_'.$videoid.'.dat',$filepath.$filename); 
    //                        addTask($fileid,'speech2text','youtube',$url,'loaded');
                    if ($fonem){
                        $send_text=str_replace(' ', '|', $text);
                        $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status,data1,data2) ".
                        "Values ('fonemSearch','".$fileid."','".$url."','".$fromtype."','".$_SESSION['user']['id']."','".$request['type']."','".$send_text."','".$rel."')";                  
                        mysql_query($sql);                         
                    }else{
                        $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
                        "Values ('".$type."','".$fileid."','".$url."','".$fromtype."','".$_SESSION['user']['id']."','".$request['type']."')";                  
                        mysql_query($sql); 
//                        echo mysql_error();
                    }                
                }
            }
        echo json_encode($request);
    }
    
    
    
    
//    function addTask($fileid,$type,$fromtype,$urlfrom){
//            $client = new  
//            SoapClient(  
//                "http://{$_SERVER['HTTP_HOST']}/soap_server/server.wsdl.php"  
//            );  
//            $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
//            "Values ('".$type."','".$fileid."','".$urlfrom."','".$fromtype."','0','loaded')";                  
//            $client->sendTask($sql);                   
//    }
    
    
    
    function uploadFile($filename,$file_type){
            $from = '../files/';
            $file_type = end(explode('/', $file_type));
            $filepath = '../files/import/';
            $type='speech2text';
            $fromtype='local'; 
            $request['type']=61;
            $filen = iconv("utf-8", "cp1251//IGNORE",$filename);
            $title=reset(explode('.',$filename));
            $newfilename = 'video_'.md5(time()+rand(10000,99999));
            rename($from.$filen,$filepath.$newfilename.'.'.$file_type);
            $sql = "Insert Into dbfilenames (userid,filename,processed,type,filepath,file_lang,title,length_sec) ".
                    "Values('".$_SESSION['UID']."','".$newfilename."','0','".$file_type."','".$filepath.$newfilename.'.'.$file_type."','en_GB','".str_replace('_', ' ', $title)."','0')";
            mysql_query($sql);
            $fileid = mysql_insert_id();
            $client = new  
            SoapClient(  
                "http://{$_SERVER['HTTP_HOST']}/soap_server/server.wsdl.php"  
            );  
            $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
            "Values ('".$type."','".$fileid."','localPath','".$fromtype."','".$_SESSION['UID']."','".$request['type']."')";                  
            $client->sendTask($sql);             
            echo json_encode($filename);
    }
    
    
    function checkFiles(){
        $filespath = '../files/temp/';
        $files = scandir($filespath);
        for ($i = 0; $i <= count($files); $i++) {
            if (end(explode(".", basename($files[$i])))=='ctm'){
                $targetfile =basename($files[$i]);
                $targetfile = explode('.',$targetfile);
                echo $targetfile[0];   
                $sql = "Select id,filename,type,filepath From dbfilenames Where processed='0' and loaded='1' and filename='".$targetfile[0]."'";
                $result = mysql_query($sql);
                if ($result) {
                    echo $row['id'];
                    while ($row = mysql_fetch_array($result)) {                             
//                                xmlToBase($str,$row['id']);
//                        ctmToBase($filespath.$files[$i],$row['id']);
//                        unlink($filespath.$files[$i]);
//                                xmlToBase($filespath.$files[$i],$row['id']);
                        echo json_encode('ok');
                    }
                } 
            }            
        }
    }
    
//        function checkFiles(){
//        $filespath = '../files/temp/';
//        $files = scandir($filespath);
//        for ($i = 0; $i <= count($files); $i++) {
//            if (end(explode(".", basename($files[$i])))=='ctm'){
//                $targetfile =substr(basename($files[$i]),0,strlen(basename($files[$i]))-4);
//                $sql = "Select id,filename,type,filepath From dbfilenames Where processed='0' and filename='".$targetfile."'";
//                $result = mysql_query($sql);
//                if ($result) {
//                    while ($row = mysql_fetch_array($result)) {
//                        $data = implode("", file($filespath.$files[$i]));
//                        $parser = xml_parser_create();
//                        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
//                        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
//                        xml_parse_into_struct($parser, $data, $values, $tags);
//                        xml_parser_free($parser);                               
//                        for ($i=0; $i<=count($values);$i++){
//                            if ($values[$i]['tag']=='data'){
//                                $str= str_replace('\\','/', $values[$i]['value']);
////                                xmlToBase($str,$row['id']);
//                                ctmToBase($str,$row['id']);
//                                unlink($filespath.$files[$i]);
////                                xmlToBase($filespath.$files[$i],$row['id']);
//                                echo json_encode('ok');
//                            }
//                        }
//                    }
//                } 
//            }            
//        }
//    }
    
    
    function xmlToBase($filepath,$fileid){        
        $data = implode("", file($filepath));
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $values, $tags);
        xml_parser_free($parser);        
        $SPACER = ' ';
        $wordcount=0;
        $row;
        for ($i=0; $i<=count($values);$i++){
            if ($values[$i]['tag']=='data'){            
                if ($values[$i]['value']!= '.' and $values[$i]['value']!='...'){
                    if ($wordcount>0){
                        $row['value'] .= $SPACER.$values[$i]['value'];
                    }else{
                        $row['value'] .= $values[$i]['value'];
                        $row['timestart'] = $values[$i]['attributes']['timestart'];
                    }              
                    $wordcount++;
                }else{
                    if ($wordcount>0){
                        $row['timeend']= $values[$i]['attributes']['timestart'];
                        $sql = "Insert Into dbfilestext (fileid,timestart,timeend,text) ".
                                "Values('".$fileid."','".$row['timestart']."','".$row['timeend']."','".$row['value']."')";
                        mysql_query($sql);  
                        $sql = "Update dbfilenames Set processed='1' Where id='".$fileid."'";
                        mysql_query($sql); 
                        $row['value'] = '';
                        $wordcount = 0;
                    }
                }
            }
        }
        unlink($filepath);
    }
    
    
    function ctmToBase($filepath,$fileid){
        $fp = fopen( $filepath,'r');
        if ($fp) {
            $mass = array();
            $i =0;
            while (!feof($fp)){
                $str = fgets($fp, 4089);
                list($num,$type,$timestart,$timeend,$value,$length) = explode(' ', $str);
                $value = str_replace('<s>', '.', $value);
                $value = str_replace('<SIL>', '...', $value);
                $mass[$i] = array(
                    "timestart" => $timestart,
                    "timeend" => $timestart+$timeend,
                    "value"=> $value
                );
                $i++;            
            }
            $SPACER = ' ';
            echo '<br>'.json_encode($mass);
            for ($i=0; $i<=count($mass);$i++){           
                    if ($mass[$i]['value']!= '.' and $mass[$i]['value']!='...'){
                        if ($wordcount>0){
                            $row['value'] .= $SPACER.$mass[$i]['value'];
                        }else{
                            $row['value'] .= $mass[$i]['value'];
                            $row['timestart'] = $mass[$i]['timestart'];
                        }              
                        $wordcount++;
                    }else{
                        if ($wordcount>0){
                            $row['timeend']= $mass[$i]['timestart'];
                            $sql = "Insert Into dbfilestext (fileid,timestart,timeend,text) ".
                                    "Values('".$fileid."','".$row['timestart']."','".$row['timeend']."','".$row['value']."')";
                            mysql_query($sql);  
                            $sql = "Update dbfilenames Set processed='1' Where id='".$fileid."'";
                            mysql_query($sql); 
                            $row['value'] = '';
                            $wordcount = 0;
                        }
                    }
            }        
        }
        fclose($fp);          
    }
    
    function addStream($url){
    //        vlc_del_all();
        $name ='stream_'.md5(time()+rand(10000,99999)).'.ogg';
//        $dst = '127.0.0.1:8081/'.$name;
        $dst = stream_source.$name;
        vlc_cmd_addstream(reset(explode('.', $name)), $url, $dst);
        $data['name'] = reset(explode('.', $name));
        $data['source'] = stream_source.$name;
//        $data['source'] = '127.0.0.1:8081/'.$name;
        echo json_encode($data);
    }
    
    function getStream($data){
//        vlc_cmd_stop($name);
//        vlc_cmd_play($name);
        $row['id'] = $data['id'];
        $row['title'] = $data['name'];
        $row['name'] = $data['streamname'];
        $row['filepath'] = $data['restream'];
        $row['source']= $data['source'];
        $db['file'] = $row;
        echo json_encode($db);
    }
    
    function closeStream($name){
//        vlc_cmd_stop($name);
    }
    
//function rus2translit($string) {
//
//    $converter = array(
//
//        'а' => 'a',   'б' => 'b',   'в' => 'v',
//
//        'г' => 'g',   'д' => 'd',   'е' => 'e',
//
//        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
//
//        'и' => 'i',   'й' => 'y',   'к' => 'k',
//
//        'л' => 'l',   'м' => 'm',   'н' => 'n',
//
//        'о' => 'o',   'п' => 'p',   'р' => 'r',
//
//        'с' => 's',   'т' => 't',   'у' => 'u',
//
//        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
//
//        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
//
//        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
//
//        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
//
//        
//
//        'А' => 'A',   'Б' => 'B',   'В' => 'V',
//
//        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
//
//        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
//
//        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
//
//        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
//
//        'О' => 'O',   'П' => 'P',   'Р' => 'R',
//
//        'С' => 'S',   'Т' => 'T',   'У' => 'U',
//
//        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
//
//        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
//
//        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
//
//        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
//
//    );
//
//    return strtr($string, $converter);
//
//    }
    
    function addNewFile(){
        
    }
?>
