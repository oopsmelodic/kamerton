<?php

    ini_set('default_charset','UTF-8');
    ini_set("display_errors",1); 
    
    if ($_POST) {
//        $json = '{"name":"j" sdfs"ack","school":"colorado state","city":"NJ","id":"null"}';
        $json = $_POST['name'];
        $json= str_replace('null', '\"null\"', $json);
        $json = str_replace('{"', '{\'', $json);
        $json = str_replace('":"', '\':\'', $json);
        $json = str_replace('","', '\',\'', $json);
        $json = str_replace('"}', '\'}', $json);
        $json = str_replace('"', '\"', $json);
        $json = str_replace('\'', '"', $json);
        echo $json;
        $mass = json_decode($json,true);
        if ($mass !=null){
            print_r($mass);
        }else{
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Ошибок нет';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Достигнута максимальная глубина стека';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Некорректные разряды или не совпадение режимов';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Некорректный управляющий символ';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Синтаксическая ошибка, не корректный JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Некорректные символы UTF-8, возможно неверная кодировка';
        break;
        default:
            echo ' - Неизвестная ошибка';
        break;
    }
        }
        
    }
?>
<form action="" method="post">
    СТрока:  <input type="text" name="name" /><br />
    <input type="submit" value="Отправь меня!" />
</form>