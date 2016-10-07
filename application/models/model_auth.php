<?php

class Model_Auth extends Model{
    
    public function get_login_data($login,$password){
        
        include_once './php/conn.php';
        include_once './php/auth_ldap.php';
        $FISH = 'KAMINLINE';
        if (isset($login)&&isset($password)){
            $query=mysql_query("SELECT * FROM dbusers WHERE login='".$login."' AND  pwd='".md5($FISH.md5(trim($password)))."' LIMIT 1");          
            if (mysql_numrows($query)){
                $row=mysql_fetch_assoc($query);
                return $row;
            }else{
//                include './php/auth_ldap.php';
//                $ad = ldap_connect($host,$port) or die('Could not connect to LDAP server.');
//                ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
//                ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
//                ldap_set_option($ad, LDAP_OPT_TIMELIMIT, 15);
//                ldap_bind($ad, "{$login}@{$domain}", $password) or die('Could not bind to AD. ');
//                $userdn = getDN($ad, $login, $basedn);
//                if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))) {
//                    $mass = getData($ad, $login, $basedn);
//                    $to_base = Array('login'=>$login,'password'=>$password,'fio'=>$login,'uiid'=>1,);
//                    
//                } else {
//                    return null;
//                }
//                ldap_unbind($ad);
            }

        }else{
            return null;
        }
    }
}
