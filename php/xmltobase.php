<?php
    $hostname = 'localhost';
    $user = 'root';
    $pwd = '';
    $filepath = 'speech2text/russian01.mp3.xml';
    $catid = 0;
    $link = mysql_connect($hostname, $user, $pwd)
        or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    
    $data = implode("", file($filepath));
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);
    
    
//    for ($i=0; $i<=count($values);$i++){
//         if ($values[$i]['tag']=='properties'){
//             $mas['lang'] = $values[$i]['attributes']['lang'];
//             $mas['type'] = $values[$i]['attributes']['type'];
//             $mas['filesize'] = $values[$i]['attributes']['filesize'];
//             $db['properties'][] = $mas;
//         }
//         else{
//            $row['value'] = $values[$i]['value'];
//            $row['timestart'] = $values[$i]['attributes']['timestart'];
//            $row['timeend']= $values[$i]['attributes']['timestart'];
//            $row['length']= $values[$i]['attributes']['length'];
//            $db['data'][] = $row;
//         }
//    }
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
                            "Values('1','".$row['timestart']."','".$row['timeend']."','".$row['value']."')";
                    mysql_query($sql);                    
                    $row['value'] = '';
                    $wordcount = 0;
                }
            }
        }
    }
    unlink($filepath);
//    echo json_encode($dbwords);
    //To Mysql
//    echo 'File: '. basename($filepath, '.xml').'<br>';
//    echo print_r($db);
//    for ($i=0; $i<count($db['properties'])-1;$i++){
//        $sql = "Insert Into dbfilenames (catid,filename,processed,type,filepath,file_lang) ".
//            "Values('".$catid."','".  basename($filepath,'.xml')."','1','". end(explode(".", basename($filepath,'.xml')))."','".$filepath."','".$db['properties'][$i]['lang']."')";
//        mysql_query($sql);
//    }
//    echo "Запись добавленна id=".$idfilenames = mysql_insert_id();
//    
//    for ($i=0; $i<count($db['data'])-1;$i++){
//        $sql = "Insert Into dbfilestext (fileid,timestart,timeend,text,length) ".
//                "Values('".$idfilenames."','".$db['data'][$i]['timestart']."','".$db['data'][$i]['timeend']."','".$db['data'][$i]['value']."','".$db['data'][$i]['length']."')";
//        mysql_query($sql);
//    }
//    mysql_close($link);
?>
