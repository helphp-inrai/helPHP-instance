<?php
// $baseroot = dirname($_SERVER['DOCUMENT_ROOT']);
// $siteroot = explode(dirname($_SERVER['SCRIPT_NAME']), $_SERVER['SCRIPT_FILENAME'])[0];
// include_once($siteroot.'/config/main.php');
// include_once($baseroot.'/helPHP/autoload.php');
if (is_file('../../config/main.php')) {
    include_once('../../config/main.php');
} else if (is_file('../config/main.php')){
    include_once('../config/main.php');
}
include_once(Config::HELPHP_FOLDER.'autoload.php');

// include_once('media/admin/media_admin_class.php');

$field_identifier = isset($_POST['media-data-field_identifier']) ? $_POST['media-data-field_identifier'] : '';
$field_id = isset($_POST['media-data-field_id']) ? $_POST['media-data-field_id'] : 0;
$moduleName = isset($_POST['moduleName']) ? $_POST['moduleName'] : '';

$process = [];
$opts = [];

//~ $process['image']['process'][0]=['type'=>'image_resize','max_width'=>1500, 'max_height'=>1500];
//~ $process['image']['process'][1]=['type'=>'image_to_file','quality'=>70, 'path'=>Config::HOME_FOLDER.'public/'.$moduleName.'/images/'];
$process['image']['process'][0]=['type'=>'image_to_file','quality'=>'cop', 'path'=>Config::HOME_FOLDER.'public/'.$moduleName.'/images/'];
//~ $process['original']=false;
$process['video']['output'] = Config::HOME_FOLDER.'public/'.$moduleName.'/videos/video-'.$field_identifier.'-'.$field_id.'.mp4';
$process['video']['key'] = $field_identifier.'-'.$field_id;

$callback = isset($_POST['callback']) ? $_POST['callback'] : '';
$opts['callback'] = $callback;
$opts['big_view'] = true;
$opts['instances'] = true;
$opts['video'] = true;

$module_media = new helPHP\modules\media\admin\Media(null, $field_identifier, $field_id, $process, $opts);

$module_media->process_data($_POST);

$module_media->publish_output();
