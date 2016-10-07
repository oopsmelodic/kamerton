<?php
    header('Content-Type: text/html; charset=utf-8');
    $stuff = array('id'=>'1','fname'=>$_GET['fname'],'lname'=>$_GET['lname'],'bday'=>$_GET['day'],'bmonth'=>$_GET['month'],'byear'=>$_GET['year'],'options'=>array('all_candidates'=>true));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.sociohub.ru:443/v2/search');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-token: 519f6a64A7ED5C9608de46396a44fFcc999cddE5f8E9ccD39639D350B3D68Bb2',
        'Content-type: application/json'
        ));

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stuff));
//    echo '<pre>'.json_encode($stuff).'</pre>';
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    $result = curl_exec($ch);
    $data = json_decode($result,true);
//    echo '<pre>';
//    print_r($data);
//    echo '</pre>';
    if (count($data)>=1){
        $content['body']='';
        $content['user']=$data;
        $fr_age=0;
      
        foreach ($content['user'] as $val) {
            $carret_graph= '';  
            foreach (array_keys($val['user'])as $key => $value) {
                                if ($value!='profiles'){
                                    if (!is_array($val['user'][$value])){
                                        $carret_graph.='<li class="list-group-item"><b>'.$value.'</b>: '.$val['user'][$value].'</li>';
                                    }else{
                                        $carret_graph.='<li class="list-group-item"><b>'.$value.'</b>: '.implode($val['user'][$value],', ').'</li>';
                                    }
                                }
                            };    
            $content['body'].='<div class="col-sm-12"><div class="media social_graph">'.
                                '<h4>'.
                                   '<b>Confidence:</b> '.$val['confidence'].' / <b>Hash:</b> '.$val['hash'].
                                '</h4>'.
                                '<div class="summary-data">'.
                                    $carret_graph.
                                '</div>'.
                              '</div>';
            for ($index = 0; $index < count($val['user']['profiles']); $index++) {
                $fr_age  = $val['user']['profiles'][$index]['fr_age'];
                switch ($val['user']['profiles'][$index]['social_net']) {
                    case 'vk':
                          $social_label='ВКонтакте';  
                          $social_class='vk';
                          $social_color='vk';
                        break;
                    case 'ok':
                          $social_label='Однокласники';  
                          $social_class='users';
                          $social_color='soundcloud';
                        break;                                
                    case 'fb':
                          $social_label='FaceBook';
                          $social_class='facebook';
                          $social_color='facebook';
                        break;
                    case 'mm':
                          $social_label='МойМир';
                          $social_class='globe';
                          $social_color='microsoft';
                        break;
                    default:
                          $social_label='';
                        break;
                }            
                try {
                    if (!array_key_exists('avatar_link',$val['user']['profiles'][$index])){
                        $avatar_link = 'http://supersmak.com.ua/wp-content/uploads/2014/10/noavatar.jpg';
                    }else{
                        $avatar_link=$val['user']['profiles'][$index]['avatar_link'];
                    }

                    $carret = '';
                    foreach (array_keys($val['user']['profiles'][$index]) as $key => $value) {
                        if (!is_array($val['user']['profiles'][$index][$value])){
                            $carret.='<li class="list-group-item"><b>'.$value.'</b>: '.$val['user']['profiles'][$index][$value].'</li>';
                        }else{
                            $carret.='<li class="list-group-item"><b>'.$value.'</b>: '.implode($val['user']['profiles'][$index][$value],', ').'</li>';
                        }
                    };                  
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                } 
                $content['body'].=                    
                    '<div class="media">'.
                        '<div class="media-left">'.
                            '<a target="_blank" href="'.$val['user']['profiles'][$index]['profile_link'].'" name="ava"><img style="float:left;max-width: 150px;max-height: 195px;margin-right: 35px;" class="avatar" src="'.$avatar_link.'" alt="'.$val['user']['profiles'][$index]['raw_full_name'].'"></a>'.   
                            '<div class="circles">'.
                                '<div class="circle" data-fgcolor="#61a9dc" data-dimension="170" data-text="'.$val['user']['profiles'][$index]['matched_profiles_n'].'" data-type="full"  data-info="Кол-во профилей" data-width="10" data-fontsize="38" data-total="10" data-part="'.$val['user']['profiles'][$index]['matched_profiles_n'].'" ></div>'.
                                '<div class="circle" data-fgcolor="#61a9dc" data-dimension="170" data-text="'.$fr_age.'" data-type="full"  data-info="Возраст" data-width="10" data-fontsize="38" data-total="100" data-part="'.$fr_age.'" ></div>'.
                                '<div class="circle" data-fgcolor="#61a9dc" data-dimension="170" data-text="'.$val['user']['profiles'][$index]['fill_rate'].'%" data-type="full"  data-info="Заполненность" data-width="10" data-fontsize="38" data-total="100" data-part="'.$val['user']['profiles'][$index]['fill_rate'].'" ></div>'.
                                '<div class="circle" data-fgcolor="#61a9dc" data-dimension="170" data-text="'.$val['user']['profiles'][$index]['activity_score'].'%" data-type="full"  data-info="Активность" data-width="10" data-fontsize="38" data-total="100" data-part="'.$val['user']['profiles'][$index]['activity_score'].'" ></div>'.
                                '<div class="circle" data-fgcolor="#61a9dc" data-dimension="170" data-text="'.$val['user']['profiles'][$index]['correctness_score'].'%" data-type="full"  data-info="Корректность" data-width="10" data-fontsize="38" data-total="100" data-part="'.$val['user']['profiles'][$index]['correctness_score'].'" ></div>'.
                            '</div>'.
                            '<div class="social_link">'.'<a target="_blank" href="'.$val['user']['profiles'][$index]['profile_link'].'" class="btn btn-social-icon btn-'.$social_color.'"><i class="fa fa-'.$social_class.'"></i></a>'.'<h3  style="margin-top: 6px;margin-left: 9px"><a target="_blank" href="'.$val['user']['profiles'][$index]['profile_link'].'">'.$val['user']['profiles'][$index]['raw_full_name'].'</a></h3>'.'</div>'.
                        '</div>'.
                        '<div class="media-body">'.
                            $carret.
                        '</div>'.
                    '</div>';                  
            }
        }
        $content['body'].=  '</div>';
//       echo '<pre>';
//       echo $carret_graph;
//       echo '</pre>';
       echo json_encode($content);
    }else{
        echo json_encode(" ");
    }

//$sock = fsockopen("ssl://api.sociohub.ru", 443, $errno, $errstr, 30);
//if (!$sock) die("$errstr ($errno)\n");
//
//$data = array('id' => '1', 'fname' => 'Vasya','lname' => 'Valuev','bday' => 27,'bmonth' => 12,
//    'byear' => 1948);
//
//
//echo json_encode($data)." Size:".sizeof($data)."<br>";
//fwrite($sock, "POST /v2/search HTTP/1.1\r\n");
//fwrite($sock, "Host: api.sociohub.ru\r\n");
//fwrite($sock, "Content-Type: application/json\r\n");
//fwrite($sock, "Content-length: " . sizeof($data) . "\r\n");
//fwrite($sock, "Accept: */*\r\n");
//fwrite($sock, "X-token: 519f6a64A7ED5C9608de46396a44fFcc999cddE5f8E9ccD39639D350B3D68Bb2\r\n");
//fwrite($sock, "\r\n");
//fwrite($sock, json_encode($data)."\r\n");
//fwrite($sock, "\r\n");
//
//$headers = "";
//while ($str = trim(fgets($sock, 4096)))
//$headers .= "$str\n";
//
//echo "\n";
//
//$body = "";
//while (!feof($sock))
//$body .= fgets($sock, 4096);
//
//echo $body;
//fclose($sock);

?>
