<?php
// $siteroot=explode('/public',$_SERVER['SCRIPT_FILENAME'])[0];
// $siteroot=explode('/index.php',$siteroot)[0];
// if (is_link($siteroot)){
//     $siteroot=rtrim(readlink($siteroot),'/');
// }
// include_once($siteroot.'/libs/incs.php');
// include_once('hierarchy/public/hierarchy_public_class.php');

// affichage du résultat
// $module_hierarchy = new helPHP\hierarchy_Public_Class();
// $module_hierarchy->process_data($_POST);
// $module_hierarchy->publish_output();

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

$module = new helPHP\modules\hierarchy\public\Hierarchy();
$module->process_data($_POST);
$module->publish_output();