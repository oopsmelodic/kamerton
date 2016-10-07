<?php
    
   include 'conn.php';
   include 'streaming.php';
    $sql = "Select id,title,restream,streamname,datetime_ From dbstreams";
    $result = mysql_query($sql);
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
            $data['source']=$row['restream'];
            $data['streamname']=$row['streamname'];
            $db[]=$data;
        }
    }else
    {
        $db=null;
    }
    echo json_encode($db);
?>
