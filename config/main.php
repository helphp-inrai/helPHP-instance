<?php

class Config{
    const DEVMODE = true;

    const DEMO = false;
    const FIRST_USE = false;
    const SECUVID = true;
    const MONOPOSTE = false;

    const SITE_NAME = 'helPHP';

    const THEME_ID = 1;
    const THEME_ID_ADMIN = 1;
    const SVG_SPRITE_ICONS_FILE = 'feather-sprite.svg';

    const STORAGE_COTA = 5368709120;
    const GLUSTER_STORAGE = false;
    const CLUSTER_MODE = false; // when the app is running on multiple nodes

    const DOMAIN = 'my_domain.com';
    const SITE_FOLDER = '';
    const HOME_FOLDER = '/home/default/'.Config::SITE_FOLDER;
    const BASE_URL = 'https://'.Config::DOMAIN.'/'.Config::SITE_FOLDER;
    const ADMIN_FOLDER = 'admin/';
    const HELPHP_FOLDER = '/home/helPHP/';

    const ROOT_FS = '/home/default/';
    const LOG_FOLDER = Config::HOME_FOLDER.'log/';
    const APACHE_USER = 'www-data';

    const LIBTRANSLATE_URL = 'http://libretranslate:5000/';
    const LIBTRANSLATE_APIKEY = 'e43158fd-ff6d-487f-85bc-31732234187a';

    const API_MODE = true;

    const TINYMCE_UPLOAD = false;

    // Session duration in hours
    const SESSION_HOURS = 24;

    const REDIS = true;
    const REDIS_HOST = 'redis';
    const REDIS_PORT = '6379';
    const REDIS_ADDRESS = 'tcp://'.CONFIG::REDIS_HOST.':'.CONFIG::REDIS_PORT;

    // Token duration for connecting to api, also used for lock on file
    const TOKEN_MINUTE = 10;

    // Number of connection try before ban
    const MAX_USER_CONNECTION_ATTEMPTS = 4;
    // Ban duration in hour
    const CONNECTION_TRY_BAN_HOURS = 12;

    const CRYPT_KEY = 'lmjsg2354sdh5234sfdgj25fcn5874sdfh52fg58df25';

    // liste des caractères autorisés pour la création du login utilisateur
    const USERNAME_VALID_STRING = 'abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ_0123456789';
    const USERPASSWORD_MINIMUM_LENGTH = 6;

    const DEFAULT_LANGUAGE = 'fr';

    const MODULES_BASIC = [
        'core',
        'hierarchy',
        'burger',
        'languages',
        'connection',
        'media',
        'tabs',
        'preview'
    ];

    //>>>lang>>>
    const AVAILABLE_LANGUAGES = array (
        0 => 'en',
    );
    //<<<lang<<<

    const INCLUDE_JS_ANIMATE = true;

    const MINIFICATION_TIME = '1756909162';

    //>>>modules>>>
    const MODULES_LIST = array (
        'core' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => 'id',
            'public_param' => 'disposition',
            'hierarchy' => false,
        ),
        'hierarchy' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => 'id',
            'public_param' => 'id',
            'hierarchy' => false,
        ),
        'connection' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => 'connection_action',
            'hierarchy' => false,
        ),
        'csseditor' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'languages' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => 'id',
            'public_param' => 'id',
            'hierarchy' => false,
        ),
        'users' => array(
            'options' => '{
                "address": true
            }',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'group' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => 'id',
            'hierarchy' => false,
        ),
        'burger' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => 'menu_id',
            'public_param' => 'menu_id',
            'hierarchy' => false,
        ),
        'media' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => 'id',
            'public_param' => 'id',
            'hierarchy' => false,
        ),
        'preview' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'tabs' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'maintenance' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'config' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'category' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'document' => array(
            'options' => '',
            'indexable' => true,
            'admin_param' => '',
            'public_param' => 'id',
            'hierarchy' => true,
        ),
        'block' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'blockeditor' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
	'indexation' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
	'deco' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'icons' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        'unban' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
	'uitranslate' => array(
            'options' => '',
            'indexable' => false,
            'admin_param' => '',
            'public_param' => '',
            'hierarchy' => false,
        ),
        //>>>temporarymodule>>>
        //<<<temporarymodule<<<
    );
    //<<<modules<<<
    public function __construct() {

    }
}
