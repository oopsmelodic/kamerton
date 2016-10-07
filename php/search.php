<?php
    session_start();
//    header('Content-Type: text/html; charset=utf-8');
//    ini_set("display_errors",1);   
    include './conn.php';
    $phrase =  strtolower($_GET['phrase']);
    $arr['filenames'] = '';
    $arr['filestext'] = '';
    $arr['tags'] = '';
    $sql = 'Select dt.timestart,df.type ,df.title,dt.text,df.filepath, df.id From dbfilenames as df '.
            'Left Join dbfilestext as dt on dt.fileid=df.id '
            .'Where userid='.$_SESSION['user']['id'].' and LOWER(dt.text) Like "%'.$phrase.'%"';
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        $arr['filestext'][]=Array('id'=>$row['id'],'value'=>$row['text'],'time'=>$row['timestart'],'title'=>$row['title'],'path'=>  str_replace('..', '', $row['filepath']),'type'=>$row['type']);
    }
    $sql = 'Select df.title, df.id From dbfilenames as df '
            .'Where userid='.$_SESSION['user']['id'].' and LOWER(df.title) Like "%'.$phrase.'%"';
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        $arr['filenames'][]=Array('id'=>$row['id'],'value'=>$row['title'],'time'=>$row['timestart'],'title'=>$row['title'],'path'=>  str_replace('..', '', $row['filepath']),'type'=>$row['type']);
    }
    $sql = 'Select df.word, df.fileid as id From db_key_words as df '
            .'Where  LOWER(df.word) Like "%'.$phrase.'%"';
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        $arr['tags'][]=Array('id'=>$row['id'],'value'=>$row['word'],'time'=>$row['timestart']);
    }
//    echo '<pre>';
//    print_r($arr);
//    echo '</pre>';
    echo json_encode($arr);
?>
