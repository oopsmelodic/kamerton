<?php

    include 'conn.php';
    include 'streaming.php';
    
    $sql = "Select * From dbstreams";
    $result = mysql_query($sql);
    if ($result) {
        $streams = vlc_view_streams();
        print_r($streams);
        while ($row = mysql_fetch_array($result)) {
            foreach ($streams as $key => $value) {
                if ($value['name']==$row['streamname'] && $value['state']!='playing' && $value['type']=='http' && $row['state']=='playing'){
                    vlc_cmd_play($row['streamname']);
                }
            }
        }       
    }          
?>
