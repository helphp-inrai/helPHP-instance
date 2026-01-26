<?php
// $siteroot=explode('/public',$_SERVER['SCRIPT_FILENAME'])[0];
// $siteroot=explode('/index.php',$siteroot)[0];
// if (is_link($siteroot)){
//     $siteroot=rtrim(readlink($siteroot),'/');
// }
// include_once($siteroot.'/libs/config.php');
// $siteroot = explode('/www', $siteroot)[0];
// include_once($siteroot.'/helPHP/autoload.php');

// $baseroot = dirname($_SERVER['DOCUMENT_ROOT']);
// if (dirname($_SERVER['SCRIPT_NAME']) == '/') {
//     $siteroot = explode($_SERVER['SCRIPT_NAME'], $_SERVER['SCRIPT_FILENAME'])[0];
// } else {
//     $siteroot = explode(dirname($_SERVER['SCRIPT_NAME']), $_SERVER['SCRIPT_FILENAME'])[0];
// }
// include_once($siteroot.'/config/main.php');
// include_once($baseroot.'/helPHP/autoload.php');
if (is_file('../../config/main.php')) {
    include_once('../../config/main.php');
} else if (is_file('../config/main.php')){
    include_once('../config/main.php');
}
include_once(Config::HELPHP_FOLDER.'autoload.php');

$module = new helPHP\modules\core\public\Core();
$module->process_data($_POST);
$module->publish_output();