<?php
include 'conn.php';
session_start();
$output_dir = '../files/import/';
if(isset($_FILES["myfile"]))
{
	$error =$_FILES["myfile"]["error"]; 
	if(!is_array($_FILES["myfile"]["name"]))
	{
            $file_type = end(explode('/', $_FILES["myfile"]["type"]));
            $title=reset(explode('.',$_FILES["myfile"]["name"]));
            $type='speech2text';
            $fromtype='local'; 
            $request['type']=61;
            $ret = array();
            $newfilename = 'video_'.md5(time()+rand(10000,99999));            
            $fileName = $_FILES["myfile"]["name"];
            move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$newfilename.'.'.$file_type);                  
            $ret[]= $fileName;
            $ret[]= $_FILES["myfile"]["type"];
            $path = str_replace('..', '/var/www', $output_dir).$newfilename.'.'.$file_type;
            $time = exec("ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
            list($hms, $milli) = explode('.', $time);
            list($hours, $minutes, $seconds) = explode(':', $hms);
            $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;            
            $sql = "Insert Into dbfilenames (userid,filename,processed,type,filepath,file_lang,title,length_record) ".
                    "Values('".$_SESSION['user']['id']."','".$newfilename."','".$request['type']."','".$_FILES["myfile"]["type"]."','".$output_dir.$newfilename.'.'.$file_type."','en_GB','".str_replace('_', ' ', $title)."','".$total_seconds."')";
            mysql_query($sql);  
            $fileid = mysql_insert_id();
            $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
            "Values ('".$type."','".$fileid."','localPath','".$fromtype."','".$_SESSION['user']['id']."','".$request['type']."')";                  
            mysql_query($sql);       
            $ret[]=$sql;
	}
	else
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
                $file_type = end(explode('/', $_FILES["myfile"]["type"][$i]));
                $title=reset(explode('.',$_FILES["myfile"]["name"][$i]));
                $type='speech2text';
                $fromtype='local'; 
                $request['type']=61;
                $ret = array();
                $newfilename = 'video_'.md5(time()+rand(10000,99999));              
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$newfilename.'.'.$file_type);
                $ret[]= $fileName;
                $ret[]= $_FILES["myfile"]["type"][$i];
                $sql = "Insert Into dbfilenames (userid,filename,processed,type,filepath,file_lang,title,length_sec) ".
                        "Values('".$_SESSION['user']['wid']."','".$newfilename."','0','".$_FILES["myfile"]["type"]."','".$output_dir.$newfilename.'.'.$file_type."','en_GB','".str_replace('_', ' ', $title)."','0')";
                mysql_query($sql); 
                $fileid = mysql_insert_id();
                $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
                "Values ('".$type."','".$fileid."','localPath','".$fromtype."','".$_SESSION['user']['id']."','".$request['type']."')";    
                mysql_query($sql);  
	  }
	
	}
    echo json_encode($ret);
 }
 ?>