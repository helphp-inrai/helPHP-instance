<?php

// to load environment
$home_folder = __DIR__.'/';
include_once($home_folder.'config/main.php');
include_once(Config::HELPHP_FOLDER.'autoload.php');

// your command
$helphp_path = Config::HELPHP_FOLDER.'js/externals/shadertoylite.js';
if (file_exists($helphp_path)) {
    $cmd = 'ln -s '.$helphp_path.' '.$home_folder.'js/externals/shadertoylite.js';
    exec($cmd);
}