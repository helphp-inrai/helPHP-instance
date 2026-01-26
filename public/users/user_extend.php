<?php

use helPHP\libs\Utils;
if (is_file('../config/main.php')){
    include_once('../config/main.php');
}else{
    include_once('../../config/main.php');
}

include_once(Config::HELPHP_FOLDER.'autoload.php');

$post = $_POST;
// UTILS_Class::error_log($post);

if (isset($post['mode'])){
    switch ($post['mode']){
        case 'create':
            global $DB_CENTRAL;
            /* ******************************************************** *
             *                          GROUPS                          *
             * ******************************************************** */
            $inst_grp = new \helPHP\modules\group\admin\Group();
            foreach($inst_grp->base_grp as $name => $id){
                $q = 'INSERT INTO '.$DB_CENTRAL->table('group_users').' SET id_group_data='.$id.', id_users_data=?';
                $DB_CENTRAL->prepared_query($q,'i',[$post['id']]);
            }
        break;
        case 'activate':
        break;
        case 'edit':
        break;
        case 'delete':
        break;
    }
} else {
    Utils::error_log('ERROR missing mode');
}