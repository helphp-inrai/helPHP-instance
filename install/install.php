<?php

global $install_step, $max_step, $validate_step, $home_folder, $launched_install;

// this file is separated in parts depending of the step is the install

// before that, script try to get main config
if (is_file($home_folder.'config/main.php')){
    include_once($home_folder.'config/main.php');
    global $CONFIG;
    $CONFIG = new \Config();
} else {
    $CONFIG = [];
}
// The values to get from Config that can be modified during the install
$config_values = [
    'string'=>[
        'HELPHP_FOLDER'=>'/home/helPHP/',

        'SITE_NAME'=>'helPHP',
        'DOMAIN'=>'helPHP.com',
        'SITE_FOLDER'=>'',
        'BASE_URL'=>'https://helPHP.com/',
        'ADMIN_FOLDER'=>'admin',
        
        'LOG_FILE'=>'/var/log/apache2/helPHP.log',
        'ROOT_FS'=>'/home/default/fs/',

        'LIBTRANSLATE_URL'=>'http://libretranslate:5000/',
        'LIBTRANSLATE_APIKEY'=>'e43158fd-ff6d-487f-85bc-31732234187a',

        'REDIS_HOST'=>'redis',
        'REDIS_PORT'=>'6379',
    ],

    'boolean'=>[
        'REDIS'=>true,
        'API_MODE'=>true,
        'CLUSTER_MODE'=>false,
    ]
];
// $data will store the values choose by the user
$data = [];
foreach($config_values as $type => $list){
    foreach($list as $name => $default_value){
        if ($type == 'string') {
            $data[$name] = isset($_POST[$name]) ? $_POST[$name] : false;
            if ($data[$name] === false) {
                $data[$name] = ($CONFIG::{$name}!=null && $CONFIG::{$name}!='')? $CONFIG::{$name} : $default_value;
            }

            $data[$name] = trim($data[$name]);

            // some special cases
            if ($name == 'HELPHP_FOLDER' || $name == 'HOME_FOLDER' || $name == 'ROOT_FS') if ($data[$name] != '') $data[$name] = '/'.trim($data[$name], '/').'/';
            if ($name == 'SITE_FOLDER' || $name == 'ADMIN_FOLDER') if ($data[$name] != '') $data[$name] = trim($data[$name], '/').'/';
            if ($name == 'LOG_FILE') if ($data[$name] != '') $data[$name] = '/'.trim($data[$name], '/');
        }

        if ($type == 'boolean') {
            $data[$name] = (isset($_POST[$name]) && intval($_POST[$name]) == 1) ? true : false;
            if (!isset($_POST['action']) && $data[$name] === false) {
                $data[$name] = (!is_null($CONFIG::{$name})) ? $CONFIG::{$name} : $default_value;
            }
        }
    }
}

// do the same thing than with main config but for db config
if (is_file($home_folder.'config/db.php')){
    include_once($home_folder.'config/db.php');
    global $CONFIG_DB;
    $CONFIG_DB = new \Config_db();
} else {
    $CONFIG_DB = [];
}
$config_db_values = [
    'string'=>[
        'DB_HOST'=>'mariamysql',
        'DB_BASE'=>'helPHP',
        'DB_USER'=>'helPHP',
        'DB_PASS'=>'',
        'DB_TABLE_PREFIX'=>'hlp',

        'DB_SLAVE_HOST'=>'',
        'DB_SLAVE_USER'=>'',
        'DB_SLAVE_BASE'=>'',
        'DB_SLAVE_PASS'=>'',

        'DB_CENTRAL_HOST'=>'',
        'DB_CENTRAL_USER'=>'',
        'DB_CENTRAL_BASE'=>'',
        'DB_CENTRAL_PASS'=>'',

        'DB_JOBS_HOST'=>'',
        'DB_JOBS_USER'=>'',
        'DB_JOBS_BASE'=>'',
        'DB_JOBS_PASS'=>'',
    ],
    
    'boolean'=>[
        'MASTER_SLAVE_MODE'=>false,
        'DB_CENTRAL'=>false,
        'DB_JOBS'=>true,
    ]
];
foreach($config_db_values as $type => $list){
    foreach($list as $name => $default_value){
        if ($type == 'string') {
            $data[$name] = isset($_POST[$name]) ? $_POST[$name] : false;
            if ($data[$name] === false) $data[$name] = ($CONFIG_DB::{$name} !=null && $CONFIG_DB::{$name}!='') ? $CONFIG_DB::{$name} : $default_value;
        }

        if ($type == 'boolean') {
            $data[$name] = (isset($_POST[$name]) && intval($_POST[$name]) == 1) ? true : false;
            if (!isset($_POST['action']) && $data[$name] === false) {
                $data[$name] = (!is_null($CONFIG_DB::{$name})) ? $CONFIG_DB::{$name} : $default_value;
            }
        }
    }
}

// and now with email config
if (is_file($home_folder.'config/email.php')){
    include_once($home_folder.'config/email.php');
    global $CONFIG_EMAIL;
    $CONFIG_EMAIL = new \Config_email();
} else {
    $CONFIG_EMAIL = [];
}
$config_email_values = [
    'string'=>[
        'EMAIL_ADMIN'=>'contact@domain.com',
        'EMAIL_CONTACT'=>'contact@domain.com',
        'EMAIL_MAILING'=>'contact@domain.com',
    
        'SMTP_HOST'=>'',
        'SMTP_USER'=>'',
        'SMTP_PASS'=>'',
        'SMTP_SECURITY'=>'',
        'SMTP_PORT'=>'',
    ]
];
foreach($config_email_values as $type => $list){
    foreach($list as $name => $default_value){
        if ($type == 'string') {
            $data[$name] = isset($_POST[$name]) ? $_POST[$name] : false;
            if ($data[$name] === false) $data[$name] = ($CONFIG_EMAIL::{$name} !=null && $CONFIG_EMAIL::{$name}!='') ? $CONFIG_EMAIL::{$name} : $default_value;
        }

        if ($type == 'boolean') {
            $data[$name] = (isset($_POST[$name]) && intval($_POST[$name]) == 1) ? true : false;
            if (!isset($_POST['action']) && $data[$name] === false) {
                $data[$name] = (!is_null($CONFIG_EMAIL::{$name})) ? $CONFIG_EMAIL::{$name} : $default_value;
            }
        }
    }
}

// initiate some variables required to work properly
// db root
$db_root_user = (isset($_POST['db_root_user']) && $_POST['db_root_user']!='') ? $_POST['db_root_user'] : '';
$db_root_pass = (isset($_POST['db_root_password']) && $_POST['db_root_password']!='') ? $_POST['db_root_password'] : '';
// db root central
$db_root_user_central = (isset($_POST['db_root_user_central']) && $_POST['db_root_user_central']!='') ? $_POST['db_root_user_central'] : '';
$db_root_password_central = (isset($_POST['db_root_password_central']) && $_POST['db_root_password_central']!='') ? $_POST['db_root_password_central'] : '';
// db root slave
$db_root_user_slave = (isset($_POST['db_root_user_slave']) && $_POST['db_root_user_slave']!='') ? $_POST['db_root_user_slave'] : '';
$db_root_password_slave = (isset($_POST['db_root_password_slave']) && $_POST['db_root_password_slave']!='') ? $_POST['db_root_password_slave'] : '';
// db root jobs
$db_root_user_jobs = (isset($_POST['db_root_user_jobs']) && $_POST['db_root_user_jobs']!='') ? $_POST['db_root_user_jobs'] : '';
$db_root_password_jobs = (isset($_POST['db_root_password_jobs']) && $_POST['db_root_password_jobs']!='') ? $_POST['db_root_password_jobs'] : '';
// instance admin
$admin_user = (isset($_POST['admin_user']) && $_POST['admin_user']!='') ? $_POST['admin_user'] : '';
$admin_pass = (isset($_POST['admin_pass']) && $_POST['admin_pass']!='') ? $_POST['admin_pass'] : '';

// will be set to true if there is a problem, at each step end, check if it's false to continue with the next step or not
$err = false;

// verify the access rights on home folder
$home_folder_not_writable = false;
if (is_writable($home_folder)){
    $home_folder_writable = true;
} else {
    $err = true;
}
// verify the access rights on config folder and files
$config_files_are_writable = false;
if (is_writable($home_folder.'config/') && is_writable($home_folder.'config/main.php') && is_writable($home_folder.'config/db.php')) {
    $config_files_are_writable = true;
} else {
    $err = true;
}

// if the install is already launched, can stop the script here
if ($launched_install) {
    $install_step = 4; // to display the installation page
    return;
}

$install_params = '';

// before each step validating process, verify user has seen the step and has clicked on next button
if ($max_step == 0) return;

/* TEST FOR 1st STEP - FOLDERS ************************************************************************************** */
// try to access the helPHP folder
$helphp_folder_found = false;
if ($data['HELPHP_FOLDER'] != '' && file_exists($data['HELPHP_FOLDER']) && file_exists($data['HELPHP_FOLDER'].'libs/Utils.php') && file_exists($data['HELPHP_FOLDER'].'autoload.php')) {
    $helphp_folder_found = true;
} else {
    $err = true;
}

// verify the access rights on home folder
$home_folder_writable = false;
if (is_writable($home_folder)){
    $home_folder_writable = true;
} else {
    $err = true;
}

// check if script can write log file
$missing_log_file = ($data['LOG_FILE'] == '') ? true : false;

$parent = explode('/', $data['LOG_FILE']);
array_pop($parent);
$parent = implode('/', $parent);
$log_file_writable = true;
if (!$missing_log_file) {
    $test = @touch($data['LOG_FILE']);
    if (!$test) {
        $log_file_writable = false;
        $err = true;
    }
} else {
    $err = true;
}

// stopping here will display the step to fix the bad data
if (!$err) $install_step++;
if ($max_step == 1 || $err) return;

/* TEST FOR 2nd STEP - DATABASE ************************************************************************************* */

// verify if the root login and password are given
$missing_root = false;
if ($db_root_user == '' || $db_root_pass == '') {
    // display a message for missing information
    $missing_root = true;
    $err = true;
}

// verify the main db 
$missing_db = false;
if ($data['DB_HOST'] == '' || $data['DB_BASE'] == '' || $data['DB_TABLE_PREFIX'] == '' || $data['DB_USER'] == '' || $data['DB_PASS'] == '') {
    // display a message for missing information
    $missing_db = true;
    $err = true;
}

// test connection to db with root user before calling install_db_and_modules to ensure that it will work
$wrong_root = false;
if (!$missing_root && !$missing_db){
    try {
        $link = mysqli_connect(gethostbyname($data['DB_HOST']), $db_root_user, $db_root_pass);
        mysqli_close($link);
    } catch (\Exception $e) {
        $err = true;
        $wrong_root = true;
    }
}

// verify root user and pass for central if activate
if ($data['DB_CENTRAL']) {
    $missing_root_central = false;
    if ($db_root_user_central == '' || $db_root_password_central == '') {
        // display a message for missing information
        $missing_root_central = true;
        $err = true;
    }

    $missing_db_central = false;
    if ($data['DB_CENTRAL_HOST'] == '' || $data['DB_CENTRAL_BASE'] == '' || $data['DB_CENTRAL_USER'] == '' || $data['DB_CENTRAL_PASS'] == '') {
        // display a message for missing information
        $missing_db_central = true;
        $err = true;
    }

    if (!$missing_root_central && !$missing_db_central){
        // test connection to db with root user before calling install_db_and_modules to ensure that it will work
        $wrong_root_central = false;
        try {
            $link = mysqli_connect(gethostbyname($data['DB_CENTRAL_HOST']), $db_root_user_central, $db_root_password_central);
            mysqli_close($link);
            $install_params.= ' --central_user='.$db_root_user_central.' --central_pass='.$db_root_password_central;
        } catch (\Exception $e) {
            $err = true;
            $wrong_root_central = true;
        }
    }
    
}

// verify root user and pass for slave if activate
if ($data['MASTER_SLAVE_MODE']) {
    $missing_root_slave = false;
    if ($db_root_user_slave == '' || $db_root_password_slave == '') {
        // display a message for missing information
        $missing_root_slave = true;
        $err = true;
    }

    $missing_db_slave = false;
    if ($data['DB_SLAVE_HOST'] == '' || $data['DB_SLAVE_BASE'] == '' || $data['DB_SLAVE_USER'] == '' || $data['DB_SLAVE_PASS'] == '') {
        // display a message for missing information
        $missing_db_slave = true;
        $err = true;
    }

    if (!$missing_root_slave && !$missing_db_slave){
        // test connection to db with root user before calling install_db_and_modules to ensure that it will work
        $wrong_root_slave = false;
        try {
            $link = mysqli_connect(gethostbyname($data['DB_SLAVE_HOST']), $db_root_user_slave, $db_root_password_slave);
            mysqli_close($link);
            $install_params.= ' --slave_user='.$db_root_user_slave.' --slave_pass='.$db_root_password_slave;
        } catch (\Exception $e) {
            $err = true;
            $wrong_root_central = true;
        }
    }
}

// verify root user and pass for jobs if activate
if ($data['DB_JOBS']) {
    $missing_root_jobs = false;
    if ($db_root_user_jobs == '' || $db_root_password_jobs == '') {
        // display a message for missing information
        $missing_root_jobs = true;
        $err = true;
    }

    $missing_db_jobs = false;
    if ($data['DB_JOBS_HOST'] == '' || $data['DB_JOBS_BASE'] == '' || $data['DB_JOBS_USER'] == '' || $data['DB_JOBS_PASS'] == '') {
        // display a message for missing information
        $missing_db_jobs = true;
        $err = true;
    }

    if (!$missing_root_jobs && !$missing_db_jobs){
        // test connection to db with root user before calling install_db_and_modules to ensure that it will work
        $wrong_root_jobs = false;
        try {
            $link = mysqli_connect(gethostbyname($data['DB_JOBS_HOST']), $db_root_user_jobs, $db_root_password_jobs);
            mysqli_close($link);
        } catch (\Exception $e) {
            $err = true;
            $wrong_root_central = true;
        }
    }
}

if (!$err) $install_step++;
if ($max_step == 2 || $err) return;

/* TEST FOR 3rd STEP - WEBSITE AND OTHERS *************************************************************************** */

$missing_site_name = false;
if ($data['SITE_NAME'] == '') {
    $missing_site_name = true;
    $err = true;
}

$missing_domain = false;
if ($data['DOMAIN'] == '') {
    $missing_domain = true;
    $err = true;
}

$missing_base_url = false;
if ($data['BASE_URL'] == '') {
    $missing_base_url = true;
    $err = true;
}

$missing_admin_folder = false;
if ($data['ADMIN_FOLDER'] == '') {
    $missing_admin_folder = true;
    $err = true;
}

if (!$err) $install_step++;
if ($max_step == 3 || $err) return;

/* TEST FOR 4th STEP - ADMIN **************************************************************************************** */

// verify if the admin login and password are given
$missing_admin = false;
if ($admin_user == '' || $admin_pass == '') {
    // display a message for missing information
    $missing_admin = true;
    $err = true;
}

// verify password size
$min_size = ($CONFIG::USERPASSWORD_MINIMUM_LENGTH !=null && $CONFIG::USERPASSWORD_MINIMUM_LENGTH !='') ? 6 : $CONFIG::USERPASSWORD_MINIMUM_LENGTH;
$short_password = false;
if (strlen($admin_pass) <= $min_size) {
    $short_password = true;
    $err = true;
}

if (!$err) $install_step++;
if ($err) return;

// every fields are ok
// can write in config files and launch the installation process
// load utils
include_once($data['HELPHP_FOLDER'].'libs/Utils.php');

// write into main.php
$types = [];
$names = [];
$values = [];
foreach($config_values as $type => $list){
    foreach($list as $name => $default_value) {
        $t = $type == 'string' ? 's' : 'b';
        array_push($types, $t);
        array_push($names, $name);
        array_push($values, $data[$name]);
    }
}
// add home_folder value to the list
array_push($types, 's');
array_push($names, 'HOME_FOLDER');
array_push($values, '/'.trim($home_folder, '/').'/');
\helPHP\libs\Utils::write_in_config($names, $types, $values, $home_folder.'config/main.php');

// write into db.php
$types = [];
$names = [];
$values = [];
foreach($config_db_values as $type => $list){
    foreach($list as $name => $default_value) {
        $t = $type == 'string' ? 's' : 'b';
        array_push($types, $t);
        array_push($names, $name);
        array_push($values, $data[$name]);
    }
}
\helPHP\libs\Utils::write_in_config($names, $types, $values, $home_folder.'config/db.php');

$cmd = 'php '.$data['HELPHP_FOLDER'].'utils/install_instance.php '.$home_folder.' '.$admin_user.' '.$admin_pass.' '.$db_root_user.' '.$db_root_pass.$install_params.' > /dev/null 2>&1 &';
exec($cmd);
$launched_install = true;