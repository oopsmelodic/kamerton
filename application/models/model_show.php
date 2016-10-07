<?php

class Model_Show extends Model{
    public function show_file($id){
        include_once './php/conn.php';
        $sql = "Select id,filename,type,filepath,file_lang,processed,title,length_record,date_upload,peaks From dbfilenames Where id='".$id."' and public_url!=0";
        $result = mysql_query($sql);
        $db = null;
        if ($result) {
            while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                if ($row['processed']==4){
                    $db['meta']=$row;
                    $sql1 = "Select id,timestart,timeend,text,alttext,speakerid From dbfilestext Where fileid='".$id."' Order by timestart";
                    $result1= mysql_query($sql1);
                    if ($result1){
                       while ($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)) {
                           $db['text'][] = $row1;                           
                       }
                    }
                }else{
                    $db['meta']=$row;
                }
            }
            return $db;
        }          
    }
}
