<?php

    include 'conn.php';
    session_start();
    ini_set('display_errors', 1);
    
    $sql = "Select * From db_events Where user_id='".$_SESSION['user']['id']."' and del=0";
    $query = mysql_query($sql);
//    $out[]= '';
    if ($query) {
        while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
            if ($row['repeat']>0){
                $start = strtotime($_GET['start']);
                $end = strtotime($_GET['end']);
                $days = explode(',', $row['repeat_day']);
                for ($index = $start; $index <= $end; $index = strtotime('+1 day', $index) ) {
                    if (in_array(date('N',$index), $days)){
                        $out[]=Array('id'=> $row['id'],'title'=>$row['title'],'repeat'=> $row['repeat'],'allDay' => $row['allDay'],'repeat_day' => $row['repeat_day'],'start'=>date('Y-m-d',$index).' '.date('H:i:s',strtotime($row['start'])),'end'=>date('Y-m-d',$index).' '.date('H:i:s',strtotime($row['end'])));
                    }
                }
            }else{
                $out[]=$row;
            }
        }        
//        echo json_encode($out);
    }
    echo json_encode($out);
    ?>