<?php
/*
 * COPYRIGHT (c) 2024-2026 INRAI / Mickaël Bourgeoisat / Emile Steiner
 * COPYRIGHT (c) 2017-2024 Mickaël Bourgeoisat / Emile Steiner
 * COPYRIGHT (c) 2009-2017 Mickaël Bourgeoisat
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * Licence type : MIT.
 */
ini_set('error_reporting', E_ALL); // because we are mad guys who hates warning
ini_set('display_errors', 'on');
$home_folder = __DIR__.'/';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (is_file($home_folder.'config/main.php')){
    include_once($home_folder.'config/main.php');
    global $CONFIG;
    $CONFIG = new \Config();
}else{
    $CONFIG = [];
}

if (is_file($home_folder.'config/db.php')){
    include_once($home_folder.'config/db.php');
    global $CONFIG_DB;
    $CONFIG_DB = new \Config_db();
}else{
    $CONFIG_DB = [];
}

// values to get from Config
$config_values = [
    'string'=>[
        'HELPHP_FOLDER'=>'/home/helPHP/',

        'SITE_NAME'=>'helPHP',
        'DOMAIN'=>'helPHP.com',
        'SITE_FOLDER'=>'',
        'BASE_URL'=>'https://helPHP.com/',
        'ADMIN_FOLDER'=>'admin',
        
        'LOG_FOLDER'=>'/home/default/log',
        'ROOT_FS'=>'/home/default/fs',

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
            if ($name == 'HELPHP_FOLDER' || $name == 'HOME_FOLDER' || $name == 'LOG_FOLDER' || $name == 'ROOT_FS') if ($data[$name] != '') $data[$name] = '/'.trim($data[$name], '/').'/';
            if ($name == 'SITE_FOLDER' || $name == 'ADMIN_FOLDER') if ($data[$name] != '') $data[$name] = trim($data[$name], '/').'/';
        }

        if ($type == 'boolean') {
            $data[$name] = (isset($_POST[$name]) && intval($_POST[$name]) == 1) ? true : false;
            if (!isset($_POST['action']) && $data[$name] === false) {
                $data[$name] = (!is_null($CONFIG::{$name})) ? $CONFIG::{$name} : $default_value;
            }
        }
    }
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

            // some special cases
            if ($name == 'HELPHP_FOLDER') if ($data[$name] != '') $data[$name] = '/'.trim($data[$name], '/').'/';
        }

        if ($type == 'boolean') {
            $data[$name] = (isset($_POST[$name]) && intval($_POST[$name]) == 1) ? true : false;
            if (!isset($_POST['action']) && $data[$name] === false) {
                $data[$name] = (!is_null($CONFIG_DB::{$name})) ? $CONFIG_DB::{$name} : $default_value;
            }
        }
    }
}

// db root
$db_root_user = (isset($_POST['db_root_login']) && $_POST['db_root_login']!='') ? $_POST['db_root_login'] : '';
$db_root_pass = (isset($_POST['db_root_password']) && $_POST['db_root_password']!='') ? $_POST['db_root_password'] : '';

// db root central
$db_root_user_central = (isset($_POST['db_root_login_central']) && $_POST['db_root_login_central']!='') ? $_POST['db_root_login_central'] : '';
$db_root_password_central = (isset($_POST['db_root_password_central']) && $_POST['db_root_password_central']!='') ? $_POST['db_root_password_central'] : '';

// db root slave
$db_root_user_slave = (isset($_POST['db_root_login_slave']) && $_POST['db_root_login_slave']!='') ? $_POST['db_root_login_slave'] : '';
$db_root_password_slave = (isset($_POST['db_root_password_slave']) && $_POST['db_root_password_slave']!='') ? $_POST['db_root_password_slave'] : '';

// instance admin
$admin_user = (isset($_POST['admin_user']) && $_POST['admin_user']!='') ? $_POST['admin_user'] : '';
$admin_pass = (isset($_POST['admin_pass']) && $_POST['admin_pass']!='') ? $_POST['admin_pass'] : '';

if (isset($_POST['action']) && $_POST['action'] == 'install') {
    
    $install_success = false;
    $err = false;

    // verify if the root login and password are given
    $missing_root = false;
    if ($db_root_user == '' || $db_root_pass == '') {
        // display a message for missing information
        $missing_root = true;
        $err = true;
        $error_msg="Missing root user or root pass";
    }

    // verify the main db 
    $missing_db = false;
    if ($data['DB_HOST'] == '' || $data['DB_BASE'] == '' || $data['DB_TABLE_PREFIX'] == '' || $data['DB_USER'] == '' || $data['DB_PASS'] == '') {
        // display a message for missing information
        $missing_db = true;
        $err = true;
        $error_msg="Missing DB parameter";
    }

    $helphp_folder_found = false;
    if ($data['HELPHP_FOLDER'] != '' && file_exists($data['HELPHP_FOLDER']) && file_exists($data['HELPHP_FOLDER'].'libs/Utils.php')) {
        $helphp_folder_found = true;
    } else {
        $err = true;
        $error_msg="not the good HelPHP folder";
    }

    // verify if the admin login and password are given
    $missing_admin = false;
    if ($admin_user == '' || $admin_pass == '') {
        // display a message for missing information
        $missing_admin = true;
        $err = true;
        $error_msg="Admin Pass or name missing";
    }
    // verify password size
    $min_size = ($CONFIG::USERPASSWORD_MINIMUM_LENGTH !=null && $CONFIG::USERPASSWORD_MINIMUM_LENGTH !='') ? 6 : $CONFIG::USERPASSWORD_MINIMUM_LENGTH;
    $short_password = false;
    if (strlen($admin_pass) <= $min_size) {
        $short_password = true;
        $err = true;
        $error_msg = "Password too short";
    }

    // verify root user and pass for central if activate
    if ($data['DB_CENTRAL']) {
        $missing_root_central = false;
        if ($db_root_user_central == '' || $db_root_password_central == '') {
            // display a message for missing information
            $missing_root_central = true;
            $err = true;
            $error_msg = "Missing root user or password for central DB";
        }
    }

    // verify root user and pass for slave if activate
    if ($data['MASTER_SLAVE_MODE']) {
        $missing_root_slave = false;
        if ($db_root_user_slave == '' || $db_root_password_slave == '') {
            // display a message for missing information
            $missing_root_slave = true;
            $err = true;
            $error_msg = "Missing root user or password for slave DB";
        }
    }

    if ($err === false) {
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

        // test connection to db with root user before calling install_db_and_modules to ensure that it will work
        $wrong_root = false;
        try {
            $link = mysqli_connect(gethostbyname($data['DB_HOST']), $db_root_user, $db_root_pass);
            mysqli_close($link);
        } catch (\Exception $e) {
            $err = true;
            $wrong_root = true;
            $error_msg = "Can't connect to main DB with root credential given.";
        }

        // same thing with other db we may connect
        $wrong_root_central = false;
        if ($data['DB_CENTRAL']) {
            $install_params=' --central_user='.$db_root_user_central.' --central_pass='.$db_root_password_central;
            try {
                $link = mysqli_connect(gethostbyname($data['DB_CENTRAL_HOST']), $db_root_user_central, $db_root_password_central);
                mysqli_close($link);
            } catch (\mysqli_sql_exception $e) {
                $err = true;
                $wrong_root_central = true;
                $error_msg = "Can't connect to central DB with root credential given.";
            }
        }
        $wrong_root_slave = false;
        if ($data['MASTER_SLAVE_MODE']) {
            $install_params.=' --slave_user='.$db_root_user_slave.' --slave_pass='.$db_root_password_slave;
            try {
                $link = mysqli_connect(gethostbyname($data['DB_SLAVE_HOST']), $db_root_user_slave, $db_root_password_slave);
                mysqli_close($link);
            } catch (\mysqli_sql_exception $e) {
                $err = true;
                $wrong_root_slave = true;
                $error_msg = "Can't connect to slave DB with root credential given.";
            }
        }

        if ($err === false){
            $cmd = 'php '.$data['HELPHP_FOLDER'].'utils/install_instance.php '.$home_folder.' '.$admin_user.' '.$admin_pass.' '.$db_root_user.' '.$db_root_pass.$install_params.' > /dev/null 2>&1 &';
            exec($cmd);

            $action = 'installing';
        }
    }

}

if ($action == 'installing') {
    if (is_file($home_folder.'originals/installed.html')){
        file_put_contents($home_folder.'originals/index.html', '');
        $install_success = true;
        unlink($home_folder.'originals/installed.html');
        unlink($home_folder.'installscript.php');
        if (file_exists($home_folder.'install.json')) unlink($home_folder.'install.json');
        if (file_exists($home_folder.'install_extra.php')) unlink($home_folder.'install_extra.php');
    } else {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Install helPHP instance</title>
                <style>
                    body {
                        display: grid;
                        align-content: center;
                        justify-content: center;
                        grid-template-columns: 60vw;
                        font-family: sans;
                    }
                    .welcome {
                        text-align: center;
                        margin: 10px;
                    }
                    .block {
                        background: #eee;
                        padding: 10px;
                        border-radius: 5px;
                        border-top: 2px solid #3a80bd;
                    }
                    .logo {
                        width: 100%;
                        align-content: center;
                        display: block;
                    }
                    .logo img {
                        width: 50%;
                        margin: auto;
                        display: block;
                    }
                    .wait {
                        background-image: url(shu.png);
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: auto;
                        width: 50px;
                        height: 50px;
                        animation: rotate linear 1s infinite;
                        margin: auto;
                    }
                    @keyframes rotate {
                        0% {
                            animation-timing-function: ease-in;
                            transform: rotate(0deg);
                        }

                        25% {
                            animation-timing-function: ease-out;
                            transform: rotate(-180deg);
                        }

                        50%,
                        100% {
                            transform: rotate(-360deg);
                        }
                    }

                </style>
                <script language="javascript">
                    function reload(){
                        if (document.location.href.includes('installing')) document.location.reload();
                        else document.location.href += '?action=installing';
                    }
                    setTimeout(reload, 3000);
                </script>
            </head>
            <body>
                <div class="logo"><img src="images/logo.svg" width="100%"></div>
                <div class="welcome">Your instance is installing. Please wait.<br>It takes several minutes.<br>The page will refresh automatically.</div>
                <div class="wait"></div>
            </body>
        </html>
            <?php
        exit;
    }
}

?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Install helPHP instance</title>
        <!-- <link href="./public/install/install.css" type="text/css" rel="stylesheet"> -->
        <style>
            body {
                display: grid;
                align-content: center;
                justify-content: center;
                grid-template-columns: 60vw;
                font-family: sans;
            }
            .welcome {
                text-align: center;
                margin: 10px;
            }
            .block {
                background: #eee;
                padding: 10px;
                border-radius: 5px;
                border-top: 2px solid #3a80bd;
            }
            label {
                vertical-align: middle;
                font-weight: bold;
            }
            input[type="text"] {
                vertical-align: middle;
                padding: 6px 8px;
                border-radius: 5px;
                border-style: solid;
                border-width: 1px;
                font-size: 1em;
            }
            .form {
                display: grid;
                grid-gap: 40px;
                margin-top: 40px;
            }

            .block.db_root, .block.admin_credentials {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 5px;
            }
            .info.db_root, .info.admin_credentials {
                grid-column: 1 / 3;
            }
            #db_root_login, #db_root_login_slave, #db_root_login_central {
                grid-row: 5;
            }
            #admin_user {
                grid-row: 4;
            }
            .msg_error {
                color: #bd3a3a;
                grid-column: 1/3;
            }
            .block.db_main, .block.site, .block.helphp_folder {
                display: grid;
                gap: 5px;
            }
            .block.other {
                display: grid;
                grid-template-columns: auto auto;
                justify-content: left;
                gap: 5px;
            }
            input[type="checkbox"] {
                margin: 0;
                vertical-align: middle;
                width: 20px;
                height: 20px;
            }
            .fields {
                flex-direction: column;
                gap: 5px;
            }
            .fields_db_root {
                margin: 20px 0px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 5px;
            }
            .fields_db_root .info {
                grid-column: 1/3;
            }
            button {
                height: 40px;
                background: #3a80bd;
                border-radius: 5px;
                cursor: pointer;
                border: 2px solid #3a80bd;
                color: #eee;
                font-weight: bold;
                font-size: 1em;
            }
            button:hover {
                background: #eee;
                color: #000;
            }
            .logo {
                width: 100%;
                align-content: center;
                display: block;
            }
            .logo img {
                width: 50%;
                margin: auto;
                display: block;
            }
        </style>
        <script language="javascript">
            function init(){

                let toggles = [
                    'MASTER_SLAVE_MODE',
                    'DB_CENTRAL',
                    'DB_JOBS',
                    'REDIS'
                ];

                toggles.forEach( (name) => {
                    let input = document.getElementById(name);
                    input.addEventListener('change', toggle);

                    toggle({target: input});
                });

            }

            function toggle(evt){
                let target = evt.target;
                let state = target.checked;
                let container = document.getElementById(target.id + '_fields');
                if (container) container.style.display = (state) ? 'flex' : 'none';
            }
        </script>
    </head>
    <body>
        <div class="logo"><img src="images/logo.svg" width="100%"></div>
        <?php if(isset($install_success)) {
            if ($install_success === true) { ?>
                <div class="welcome">Installation success !</div>
                <div class="welcome">Connect to your <a href="<?php echo $CONFIG::BASE_URL.$CONFIG::ADMIN_FOLDER; ?>">admin</a> and start working with helPHP !<br> Note : check the BASE_URL constante in config/main.php if you can't connect.</div>
                </body>
            </html>
            <?php exit; ?>
            <?php } else { ?>
                <div class="msg_error">There is some errors :</div>
            <?php } ?>
        <div class="msg_error">
            Error : <?php echo $error_msg ?>;
        </div>
        <?php }else{ ?>
        <div class="welcome">Welcome to the installation of your helPHP instance</div>
        <div class="info">
            To start we need some crucial information. Please enter the required data and enjoy.
        </div>
        <?php } ?>
        <form class="form" action="./" method="POST" enctype="multipart/form-data" >
            
            <!-- helPHP folder -->
            <div class="block helphp_folder">

                <label for="HELPHP_FOLDER">Path to the helPHP folder</label>
                
                <?php if (isset($helphp_folder_found) && !$helphp_folder_found) echo '<div class="msg_error folder_not_found">helPHP libs not found at '.$helphp_folder.'</div>'; ?>
                <?php if (isset($lib_db_not_found) && !$lib_db_not_found) echo '<div class="msg_error db_not_found">Can\'t find the lib DB.php in the folder '.$helphp_folder.'libs/.</div>'; ?>
                
                <input type="text" name="HELPHP_FOLDER" value="<?php echo $data['HELPHP_FOLDER']; ?>" id="HELPHP_FOLDER">

            </div>

            <!-- db root -->
            <div class="block db_root">

                <div class="info db_root">User root to create the database, will not be saved and used only during the installation.</div>

                <div class="msg_error db_root"><?php if (isset($missing_root) && $missing_root) echo 'Missing root username or password';?></div>
                <div class="msg_error db_root"><?php if (isset($wrong_root) && $wrong_root) echo 'Incorrect root username or password, can\'t connect to database';?></div>

                <label for="db_root_login">Username</label>
                <input type="text" name="db_root_login" id="db_root_login" value="<?php echo $db_root_user; ?>">

                <label for="db_root_password">Password</label>
                <input type="text" name="db_root_password" value="<?php echo $db_root_pass; ?>" id="db_root_password">

            </div>

            <div class="block db_main">

                <!-- explain block -->
                <div class="info db_main">Database information to create the user and the base</div>

                <?php 
                    // error messages
                    if (isset($missing_db) && $missing_db) echo '<div class="msg_error db">Please fill every field below</div>';

                    // inputs
                    $field_to_display = ['DB_HOST', 'DB_BASE', 'DB_USER', 'DB_PASS', 'DB_TABLE_PREFIX'];
                    foreach($field_to_display as $name){
                        $t = explode('_', $name);
                        echo '<label for="'.$name.'">'.ucfirst(strtolower(array_pop($t))).'</label>';
                        echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data[$name].'">';
                    }
                ?>

            </div>

            <!-- site information -->
            <div class="block site">
                
                <label for="SITE_NAME">Website name</label>
                <input type="text" name="SITE_NAME" value="<?php echo $data['SITE_NAME']; ?>" id="SITE_NAME">
                
                <label for="DOMAIN">Domain name</label>
                <input type="text" name="DOMAIN" value="<?php echo $data['DOMAIN']; ?>" id="DOMAIN">

                <label for="SITE_FOLDER">Website folder (append it to the url)</label>
                <input type="text" name="SITE_FOLDER" value="<?php echo $data['SITE_FOLDER']; ?>" id="SITE_FOLDER">
                
                <label for="BASE_URL">Full URL<br><span style="font-size: 0.8em;">https://domain.com/</span><br><span style="font-size: 0.8em;">http://localhost/</span></label>
                <input type="text" name="BASE_URL" value="<?php echo $data['BASE_URL']; ?>" id="BASE_URL">

                <label for="ADMIN_FOLDER">Admin (backfoffice) folder name</label>
                <input type="text" name="ADMIN_FOLDER" value="<?php echo $data['ADMIN_FOLDER']; ?>" id="ADMIN_FOLDER">

                <label for="LOG_FOLDER">Logs folder</label>
                <input type="text" name="LOG_FOLDER" value="<?php echo $data['LOG_FOLDER']; ?>" id="LOG_FOLDER">

                <label for="ROOT_FS">Root FS folder name (storage folder)</label>
                <input type="text" name="ROOT_FS" value="<?php echo $data['ROOT_FS']; ?>" id="ROOT_FS">

            </div>

            <div class="block db_master_slave">

                <!-- explain block -->
                <div class="info db_master_slave">Database information about master slave mode</div>

                <!-- checkbox for activate field -->
                <label for="MASTER_SLAVE_MODE">Activate master/slave mode</label>
                <input type="checkbox" name="MASTER_SLAVE_MODE" id="MASTER_SLAVE_MODE" value=1 <?php echo $data['MASTER_SLAVE_MODE'] ? 'checked' : '' ?>>

                <div class="fields db_master_slave" id="MASTER_SLAVE_MODE_fields">


                    <div class="fields_db_root db_master_slave">

                        <div class="info root_slave">User root to access the slave database, will not be saved and used only during the installation.</div>

                        <div class="msg_error db_slave"><?php if (isset($missing_root_slave) && $missing_root_slave) echo 'Missing root username or password'; ?></div>
                        <div class="msg_error db_slave"><?php if (isset($wrong_root_slave) && $wrong_root_slave) echo 'Incorrect root username or password, can\'t connect to database';?></div>

                        <label for="db_root_login_slave">Username</label>
                        <input type="text" name="db_root_login_slave" id="db_root_login_slave" value="<?php echo $db_root_user_slave; ?>">

                        <label for="db_root_password_slave">Password</label>
                        <input type="text" name="db_root_password_slave" value="<?php echo $db_root_password_slave; ?>" id="db_root_password_slave">
                    </div>

                    <?php
                        // error messages
                        if (isset($missing_db_slave) && $missing_db_slave) echo '<div class="msg_error db">Please fill every field below</div>';

                        // inputs
                        $field_to_display = ['DB_SLAVE_HOST', 'DB_SLAVE_BASE', 'DB_SLAVE_USER', 'DB_SLAVE_PASS'];
                        foreach($field_to_display as $name){
                            $t = explode('_', $name);
                            echo '<label for="'.$name.'">'.ucfirst(strtolower(array_pop($t))).'</label>';
                            echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data[$name].'">';
                        }
                    ?>

                </div>

            </div>


            <div class="block db_central">

                <!-- explain block -->
                <div class="info db_central">Database information about central mode</div>

                <!-- checkbox for activate field -->
                <label for="DB_CENTRAL">Activate central mode</label>
                <input type="checkbox" name="DB_CENTRAL" id="DB_CENTRAL" value=1 <?php echo $data['DB_CENTRAL'] ? 'checked' : '' ?>>

                <div class="fields db_central" id="DB_CENTRAL_fields">

                    <div class="fields_db_root db_central">
                        <!-- explain block -->
                        <div class="info root_central">User root to access the central database, will not be saved and used only during the installation.</div>

                        <div class="msg_error db_central"><?php if (isset($missing_root_central) && $missing_root_central) echo 'Missing root username or password'; ?></div>
                        <div class="msg_error db_central"><?php if (isset($wrong_root_central) && $wrong_root_central) echo 'Incorrect root username or password, can\'t connect to database';?></div>

                        <!-- inputs -->
                        <label for="db_root_login_central">Username</label>
                        <input type="text" name="db_root_login_central" id="db_root_login_central" value="<?php echo $db_root_user_central; ?>">

                        <label for="db_root_password_central">Password</label>
                        <input type="text" name="db_root_password_central" value="<?php echo $db_root_password_central; ?>" id="db_root_password_central">
                    </div>

                    <?php
                    
                        // error messages
                        if (isset($missing_db_central) && $missing_db_central) echo '<div class="msg_error db">Please fill every field below</div>';

                        // inputs
                        $field_to_display = ['DB_CENTRAL_HOST', 'DB_CENTRAL_BASE', 'DB_CENTRAL_USER', 'DB_CENTRAL_PASS'];
                        foreach($field_to_display as $name){
                            $t = explode('_', $name);
                            echo '<label for="'.$name.'">'.ucfirst(strtolower(array_pop($t))).'</label>';
                            echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data[$name].'">';
                        }
                    ?>

                </div>
                
            </div>

            <div class="block db_jobs">

                <!-- explain block -->
                <div class="info db_jobs">Database information about jobs base</div>

                <!-- checkbox for activate field -->
                <label for="DB_JOBS">Activate jobs base</label>
                <input type="checkbox" name="DB_JOBS" id="DB_JOBS" value=1 <?php echo $data['DB_JOBS'] ? 'checked' : '' ?>>

                <div class="fields db_jobs" id="DB_JOBS_fields">

                    <?php 
                        // error messages
                        if (isset($missing_db_jobs) && $missing_db_jobs) echo '<div class="msg_error db">Please fill every field below</div>';

                        // inputs
                        $field_to_display = ['DB_JOBS_HOST', 'DB_JOBS_BASE', 'DB_JOBS_USER', 'DB_JOBS_PASS'];
                        foreach($field_to_display as $name){
                            $t = explode('_', $name);
                            echo '<label for="'.$name.'">'.ucfirst(strtolower(array_pop($t))).'</label>';
                            echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data[$name].'">';
                        }
                    ?>

                </div>

                
            </div>

            <div class="block redis">

                <!-- explain block -->
                <div class="info redis">Redis information</div>

                <label for="REDIS">Activate Redis</label>
                <input type="checkbox" name="REDIS" id="REDIS" value=1 <?php echo $data['REDIS'] ? 'checked' : '' ?>>

                <div class="fields redis" id="REDIS_fields">

                    <?php
                        $field_to_display = ['REDIS_HOST', 'REDIS_PORT'];
                        foreach($field_to_display as $name){
                            $t = explode('_', $name);
                            echo '<label for="'.$name.'">'.ucfirst(strtolower(array_pop($t))).'</label>';
                            echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.$data[$name].'">';
                        }
                    ?>

                </div>

            </div>

            <div class="block other">

                <label for="API_MODE">Activate API</label>
                <input type="checkbox" name="API_MODE" id="API_MODE" value=1 <?php echo $data['API_MODE'] ? 'checked' : '' ?>>

                <label for="CLUSTER_MODE">In a cluster</label>
                <input type="checkbox" name="CLUSTER_MODE" id="CLUSTER_MODE" value=1 <?php echo $data['CLUSTER_MODE'] ? 'checked' : '' ?>>

            </div>

            <div class="block admin_credentials">
                <!-- explain block -->
                <div class="info admin_credentials">Admin credentials to connect to your instance. You will need those credentials to connect after the installation.</div>

                <div class="msg_error admin_credentials">
                    <?php if (isset($missing_admin) && $missing_admin) echo 'Missing admin username or password<br>'; ?>
                    <?php if (isset($short_password) && $short_password) echo 'Password too short, minimum '.$min_size.' characters.'; ?>
                </div>

                <label for="admin_user">Username</label>
                <input type="text" name="admin_user" id="admin_user" value="<?php echo $admin_user; ?>">

                <label for="admin_pass">Password</label>
                <input type="text" name="admin_pass" id="admin_pass" value="<?php echo $admin_pass; ?>">
                
            </div>

            <button type="submit" name="action" value="install">INSTALL</button>

        </form>

        <script language="javascript">
            init();
        </script>
    </body>
</html>