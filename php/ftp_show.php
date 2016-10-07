<?php
//if( !array_key_exists('HTTP_REFERER', $_SERVER) ) exit('No direct script access allowed');
//ini_set('display_errors', 1);
/**
 * jQuery File Tree PHP Connector
 *
 * Version 1.1.0
 *
 * @author - Cory S.N. LaViska A Beautiful Site (http://abeautifulsite.net/)
 * @author - Dave Rogers - https://github.com/daverogers/jQueryFileTree
 *
 * History:
 *
 * 1.1.1 - SECURITY: forcing root to prevent users from determining system's file structure (per DaveBrad)
 * 1.1.0 - adding multiSelect (checkbox) support (08/22/2014)
 * 1.0.2 - fixes undefined 'dir' error - by itsyash (06/09/2014)
 * 1.0.1 - updated to work with foreign characters in directory/file names (12 April 2008)
 * 1.0.0 - released (24 March 2008)
 *
 * Output a list of files for jQuery File Tree
 */

/**
 * filesystem root - USER needs to set this!
 * -> prevents debug users from exploring system's directory structure
 * ex: $root = $_SERVER['DOCUMENT_ROOT'];
 */
$root = '';
//$root = $_SERVER['DOCUMENT_ROOT'];
//if( !$root ) exit("ERROR: Root filesystem directory not set in jqueryFileTree.php");

//$_POST['dir'] = '';
//$_POST['host'] = '10.129.15.113';
//$_POST['login'] = 'customer';
//$_POST['password'] = 'Qwerty123';

include 'conn.php';

$postDir = rawurldecode($root.(isset($_POST['dir']) ? $_POST['dir'] : null ));

$sql = "Select * From dbftp_data Where ftp_id='".$_POST['id']."'";
$res = mysql_query($sql);
$data = null;
while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
    $data[]=$row['path'];
}
// set checkbox if multiSelect set to true
$checkbox = ( isset($_POST['multiSelect']) && $_POST['multiSelect'] == 'true' ) ? "<input type='checkbox' />" : null;
$onlyFolders = ( isset($_POST['onlyFolders']) && $_POST['onlyFolders'] == 'true' ) ? true : false;
$onlyFiles = ( isset($_POST['onlyFiles']) && $_POST['onlyFiles'] == 'true' ) ? true : false;

//echo $postDir;
//if( file_exists($postDir) ) {
        $ftp_user_name = $_POST['login'];
        $ftp_user_pass = $_POST['password'];
        $ftp_server = $_POST['host'];  
        $ftp_url = 'ftp://'.  rawurldecode($_POST['login']).':'.  rawurldecode($_POST['password']).'@'.  rawurldecode($ftp_server);
        $conn_id = ftp_connect($ftp_server);
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);        
	//$files		= scandir($postDir,0,$conn_id);
	$files = ftp_nlist($conn_id,$postDir);
//        print_r($files);
	$returnDir	= $postDir;
	natcasesort($files);

	if( count($files) > 0 ) { 

		echo "<ul class='jqueryFileTree'>";

		foreach( $files as $file ) {                    
			$file		= str_replace($postDir, '', $file);                        
			$htmlRel	= htmlentities($returnDir . $file);
			$htmlName	= htmlentities($file);
                        if (in_array($htmlRel.'/', $data)){
                            $checkbox = "<input type='checkbox' checked/>";
                        }else{
                            $checkbox = "<input type='checkbox'/>";
                        }
                        //echo $file;
                        //echo $ftp_url.$postDir;
			//if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {
				if( is_dir($ftp_url.$postDir . $file) && (!$onlyFiles || $onlyFolders) )
					echo "<li class='directory collapsed'>{$checkbox}<a href='#' rel='" .$htmlRel. "/'>" . $htmlName . "</a></li>";
				else if (!$onlyFolders || $onlyFiles)
					echo "<li class='file ext_{$ext}'>{$checkbox}<a href='#' rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
			//}
		}

		echo "</ul>";
	}
//}

?>
