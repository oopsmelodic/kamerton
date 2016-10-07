<?php

    include '../../php/conn.php';
    $langs = '{"af":"Африкаанс","ar":"Арабский","az":"Азербайджанский","be":"Белорусский","bg":"Болгарский","bs":"Боснийский","ca":"Каталанский","cs":"Чешский","cy":"Валлийский","da":"Датский","de":"Немецкий","el":"Греческий","en":"Английский","es":"Испанский","et":"Эстонский","eu":"Баскский","fa":"Персидский","fi":"Финский","fr":"Французский","ga":"Ирландский","gl":"Галисийский","he":"Иврит","hr":"Хорватский","ht":"Гаитянский","hu":"Венгерский","hy":"Армянский","id":"Индонезийский","is":"Исландский","it":"Итальянский","ja":"Японский","ka":"Грузинский","kk":"Казахский","ko":"Корейский","ky":"Киргизский","la":"Латынь","lt":"Литовский","lv":"Латышский","mg":"Малагасийский","mk":"Македонский","mn":"Монгольский","ms":"Малайский","mt":"Мальтийский","nl":"Голландский","no":"Норвежский","pl":"Польский","pt":"Португальский","ro":"Румынский","ru":"Русский","sk":"Словацкий","sl":"Словенский","sq":"Албанский","sr":"Сербский","sv":"Шведский","sw":"Суахили","tg":"Таджикский","th":"Тайский","tl":"Тагальский","tr":"Турецкий","tt":"Татарский","uk":"Украинский","uz":"Узбекский","vi":"Вьетнамский","zh":"Китайский"}';
    $langs = json_decode($langs,true);
    ini_set('display_errors', 1);
//API YANDEX KEY   
    $key = 'trnsl.1.1.20150916T093008Z.1c4cd3c359658d51.1f54c9ef25966db7e661274985c2a6011038e422';
    
    if (isset($_GET['text'])){
        $orign_text = $_GET['text'];
        if( $curl = curl_init() ) {
          curl_setopt($curl, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate?lang=ru&key='.$key);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
          curl_setopt($curl, CURLOPT_POSTFIELDS,Array("text"=>$orign_text));
          $out = curl_exec($curl);  
          $out = json_decode($out,true);
          $str= '';
          if ($out['code']=='200'){
              if (count($out['text'])){
                  foreach ($out['text'] as $value) {
                      $str .= $value;
                  }                 
                  mysql_query('Insert Into `db_translate_history` (`from_ip`,`service`,`orign_text`,`text`,`lang`) Values("'.$_SERVER['REMOTE_ADDR'].'","Yandex","'.$orign_text.'","'.$str.'","'.$out['lang'].'")');
//                  echo 'Insert Into db_translate_history (from_ip,service,orign_text,text,lang) Values("'.$_SERVER['REMOTE_ADDR'].'","Yandex","'.$orign_text.'","'.$str.'","'.$out['lang'].'")';
                  $from_lang=explode('-',$out['lang']);
                    $results = mysql_query('Select length(orign_text) as cl From db_translate_history');
                    $count = 0;
                    while ($row = mysql_fetch_array($results)) {
                         $count+=$row['cl'];
                    }       
                  echo 'Оригинал: '.$_GET['text'].' <br>'; 
                  echo 'Язык оригинала: '.$langs[$from_lang[0]].' <br>'; 
                  echo 'Перевод: '.$str.' <br><br><br>';
                  echo 'Всего было переведенно '.$count.' '.pluralForm($count,'символ','символа','символов').'!';
              }
          }
        }
    }

    
    function pluralForm($n, $form1, $form2, $form5) {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $form5;
        if ($n1 > 1 && $n1 < 5) return $form2;
        if ($n1 == 1) return $form1;
        return $form5;
    }