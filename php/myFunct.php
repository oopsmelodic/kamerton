<?php
include 'conn.php';
$scripts_controll =  Array(1=>Array('newmain.js'),
                          10=>Array('mainjs.js'),
                          11=>Array('newmain.js'),
                          33=>Array('audio_user.js'),
                          12=>Array('audiosearch.js'),
                          999=>Array('angular.js','jquery.mousewheel.js','jquery.jscrollpane.min.js','melodic.js','angular-toastr.tpls.js','angular-animate.js'),
                          90=>Array('admin.js'));
$css_controll =  Array(1=>Array('usermain.css','main.css'),
                          10=>Array('main.css'),
                          11=>Array('usermain.css','main.css'),
                          33=>Array('audio_user.css'),
                          12=>Array('audiosearch.css'),
                          999=>Array('melodic.css','jquery.jscrollpane.css','angular-toastr.css'),
                          90=>Array('admin.css','main.css','usermain.css'));

function getWeekChampions($weeknumber){
    $query=mysql_query("SELECT name,name_en FROM weeks 
                        LEFT JOIN champ ON champ.id = weeks.championid  
                   WHERE `weeknumber`='".$weeknumber."' LIMIT 10");
                   
    $champions=array();
    while($row=mysql_fetch_assoc($query)){
        $champions[$row['name']]=$row['name_en'];
    }
return $champions;
}

function loadScripts($ui_id){
    global $scripts_controll;
    if (isset($ui_id)){
        foreach ($scripts_controll[$ui_id] as $key => $value) {
            echo '<script type="text/javascript" src="js/'.$value.'"></script>';
        }
    }
    global $css_controll;
    if (isset($ui_id)){
        foreach ($css_controll[$ui_id] as $key => $value) {
            echo '<link rel="stylesheet" type="text/css" href="css/'.$value.'">';
        }
    }    
}

function sendmail($subject,$body){
        require("/usr/share/nginx/www/php/class/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();
        $mail->Host = "smtp.mail.ru";
        $mail->Port = 25;
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = "tls";
        $mail->Username = "oops.melodic@mail.ru";  
        $mail->Password = "9293709b13537235"; 
        $mail->SetFrom('oops.melodic@mail.ru', 'Фонемный поиск');
        $mail->AddAddress('o.fedotov@in-line.ru');
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        return $mail->Send();   
   }
   
   
function registration(){
    $result=array('status'=>'ok','error'=>array());
    
    if (isset($_POST['login'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['password2'])&&isset($_POST['captcha'])){
        $login=$_POST['login'];   
        $email=$_POST['email'];   
        $password=$_POST['password'];   
        $password2=$_POST['password2'];   
        $captcha=$_POST['captcha'];   
    }else{
        $result['status']='error';
        $result['error'][]='Заполните все поля.';
    }
    
    if (!isset($_POST['acceptlegacy'])){
        $result['status']='error';
        $result['error'][]='Вы должны принять пользовательское соглашение.'; 
    }
    
   
    
    if(preg_match("/^[a-zA-Z0-9]+$/",$login)){ 
        $res=mysql_query("SELECT name FROM members WHERE name='".addslashes($login)."'");
        if (mysql_num_rows($res)>0){
            $result['status']='error';
            $result['error'][]='Данный логин занят.';
        }
//        if ($password!=$password2){
//            $result['status']='error';
//            $result['error'][]='Пароли не совпадают.';
//        }
        
        if (strlen($login)<2){
            $result['status']='error';
            $result['error'][]='Логин слишком короткий.';
        }
        if ($captcha!=$_SESSION['captcha_keystring']){
            $result['status']='error';
            $result['error'][]='Неверно введен код с картинки.';
        }
        if (strlen($password)<6){
            $result['status']='error';
            $result['error'][]='Пароль меньше 6 символов.';
        }

        }else{
            $result['status']='error';
            $result['error'][]='Недопустимые символы в логине.';
        }
        if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)){
            $result['status']='error';
            $result['error'][]='Не заполнено поле или неверный email.';
        }
        $res=mysql_query("SELECT email FROM members WHERE email='".addslashes($email)."'");
        if (mysql_num_rows($res)>0){
            $result['status']='error';
            $result['error'][]='Данный email занят.';
        }

        if ($result['status']=='ok'){
             $regkey=md5('THIS IS REGAAAAA!!!'.time());
             $sendmemail=0;
             if (isset($_POST['sendmemail'])) $sendmemail=1;
            if(!mysql_query("INSERT INTO members SET name='".addslashes($login)."', password='".md5(FISH.md5($password))."', email='".$email."', regkey='".$regkey."',sendmemail='".$sendmemail."'")){
                $result['status']='error';
                $result['error'][]='Ошибка. Обратитесь к администратору';
            }else{
              /*  $qw=mysql_query("SELECT * FROM members WHERE password='".md5(FISH.md5($password))."' AND name='".addslashes($login)."'");
                $user=mysql_fetch_assoc($qw);
                $_SESSION=array('id'=>$user['id'],'password'=>md5($user['password']),'name'=>$user['name']);
              */  
           
            
            $message='Приветствуем, '.$login.'!<br />

                    С вашего почтового адреса совершена регистрация на сайте LOLplay.ru. Если Вы не подавали заявки на регистрацию, проигнорируйте это письмо - возможно, кто-то совершил ошибку.<br />
                    Чтобы активировать регистрацию, пройдите по ссылке:<br />
                    http://lolplay.ru/activate/'.$regkey.'/<br />
                    Используя ваш логин '.$login.', вы можете оставлять комментарии на сайте и форуме, писать дневники и заполнять свою личную галерею, скачивать записи игр, видео, аудио и другие файлы, общаться с друзьями и администрацией сайта через личные сообщения.<br />
                    Вы также можете принять участие в жизни сайта, добавляя свои новости, статьи, демки, видео, аудио и другие файлы, которые, после предварительной оценки модератором, будут выложены на сайт.<br />
                    Желаем удачи!<br />
                    С уважением,<br />
                    Администрация LOLplay.ru';
            sendmail('Добро пожаловать на LOLplay.ru!',$message,$email); 

            }
        }
        return $result;
}

function activate($code){
     $qw=mysql_query("SELECT * FROM members WHERE regkey='".addslashes($code)."' LIMIT 1");
     if (mysql_numrows($qw)){
        $user=mysql_fetch_assoc($qw);
        if ($user['status']==0){
            mysql_query("UPDATE members SET status=1 WHERE regkey='".addslashes($code)."' LIMIT 1");
            $_SESSION=array('id'=>$user['id'],'password'=>md5($user['password']),'name'=>$user['name']);
            return 1;
        }else{
            return 2;
        }
                
     }else{
         return 3;
     }
}


function lastaction(){
    if (isset($_SESSION['id']))
        mysql_query("UPDATE members SET last_action='".time()."' WHERE id='".$_SESSION['id']."'");
     
}

function mylog($action,$type='primary'){    
    $uid = isset($_SESSION['UID'])?$_SESSION['UID']:0;
    $sql= "Insert Into dblogs (uiid,sesid,fromip,action,type) Values('".$uid."','".session_id()."','".$_SERVER['REMOTE_ADDR']."','".$action."','".$type."')";
    mysql_query($sql);
}


function auth(){
    if (isset($_POST['login'])&&isset($_POST['pwd'])){
        $query=mysql_query("SELECT * FROM dbusers WHERE login='".$_POST['login']."' AND  pwd='".$_POST['pwd']."' LIMIT 1");
        if (mysql_numrows($query)){
            $row=mysql_fetch_assoc($query);
//            if ($row['status']==1){
                $_SESSION=array('UID'=>$row['id'],'name'=>$row['login'],'password'=>$row['pwd'],'uiid'=>$row['uiid']);
                mylog('Successful log in by "'.$row['login'].'" ');
                return 1;
//            }else{
//                return 4;
//            }
            
        }else{
            mylog('Error log in: errno=3','error');
            return 3;
        }
        
    }else{
        mylog('Error log in: errno=2');
        return 2;
    }
}

function logout(){
    mylog('Successful unlogin by "'.$_SESSION['name'].'" ');
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['password']);
    unset($_SESSION['uiid']);
    unset($_SESSION['UID']);
}

function getserverstatus(){
    $query=mysql_query("SELECT * FROM server_status");
    $status=array();
    $status[0]=array();
    $status[1]=array();
    while($row=mysql_fetch_assoc($query)){
        $status[$row['status']][]=$row['name']; 
    }
return $status;
}




//////////////////////////////
//FORUM
//////////////////////////////


function getBread($id,$topic){
    $query=mysql_query("SELECT * FROM forum WHERE id='".$id."' LIMIT 1");
    $row=mysql_fetch_assoc($query);
    if ($row['parentid']!=0){
        
        return getBread($row['parentid'],$topic).'<li>'.($topic!=$id?'<a href="/forum/'.$row['id'].'/">':'').$row['title'].($topic!=$id?'</a>':'').'</li>';
    }else{
        return '<li><a href="/forum/'.$row['id'].'/">'.$row['title'].'</a></li>';
    }
}

//////////////////////////////
//END OF FORUM
//////////////////////////////
?>