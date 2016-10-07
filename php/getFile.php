<?php
    ini_set('display_errors', 1);
    $urlTo1 = 'http://10.153.0.77/vnm/login.do'; // Куда данные послать первый раз
    $login = 'glonass';                            // Логин
    $password = '123';                            // Пароль  
    $post1 = 'userName='.$login.'&password='.$password; // POST данные авторизации (укажите правильно)

//    $urlTo2 = 'http://xyz.com/action/add'; // Куда данные послать второй раз
//    $post2 = 'имя=значение&имя=значение'; // POST данные второй раз
//
//    $urlTo3 = 'http://xyz.com/action/buy'; // Куда данные послать третий раз
//    $post3 = 'имя=значение&имя=значение'; // POST данные третий раз

    $ch = curl_init(); // Инициализация сеанса
    curl_setopt($ch, CURLOPT_URL, $urlTo1);
    curl_setopt($ch, CURLOPT_HEADER, 1); // получать заголовки
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
    curl_setopt($ch, CURLOPT_REFERER, 'http://xyz.com');
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$_SERVER['DOCUMENT_ROOT'].'/cookiefile.txt'); // записываем/запоминаем куки
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post1); // куда посылаем пост первый раз
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Говорим скрипту, чтобы он следовал за редиректами которые происходят во время авторизации
    $result = curl_exec($ch);

//    curl_setopt($ch, CURLOPT_URL, $urlTo2);
//    curl_setopt($ch, CURLOPT_HEADER, 1); // получать заголовки
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
//    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
//    curl_setopt($ch, CURLOPT_REFERER, $urlTo1); // с какой страницы пришли (желательно указать)
//    curl_setopt($ch, CURLOPT_POST,1);
//    curl_setopt($ch, CURLOPT_COOKIEFILE,$_SERVER['DOCUMENT_ROOT'].'/cookiefile.txt'); // говорим что уже авторизованы и показываем куки
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $post2); // куда посылаем пост второй раз
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     // Говорим скрипту, чтобы он следовал за редиректами которые происходят во время авторизации
//    $result = curl_exec($ch);
//
//    curl_setopt($ch, CURLOPT_URL, $urlTo3);
//    curl_setopt($ch, CURLOPT_HEADER, 0);    // получать заголовки
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
//    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
//    curl_setopt($ch, CURLOPT_REFERER, $urlTo2); // с какой страницы пришли (желательно указать)
//    curl_setopt($ch, CURLOPT_POST,1);
//    curl_setopt($ch, CURLOPT_COOKIEFILE,$_SERVER['DOCUMENT_ROOT'].'/cookiefile.txt'); // говорим что уже авторизованы и показываем куки
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $post3); // куда посылаем пост второй раз
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);     // Говорим скрипту, чтобы он следовал за редиректами которые происходят во время авторизации
//    $result = curl_exec($ch);

    curl_close($ch);         // Завершаем сеанс

    echo $result; // выводим результат
    
?>