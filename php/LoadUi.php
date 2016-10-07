<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loadui
 *
 * @author oOpsm_000
 */
class LoadUi {
    function __construct( ){  }
    
    
    function loadPage($login){
        

            
            $query = mysql_query("Select * From dbusers Where login='$login' and pwd='$pwd'") or die('Запрос не удался: ' . mysql_error());
            $row = mysql_fetch_assoc($query);
            
        }
        
    }
    

?>
