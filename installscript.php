<?php

ini_set('error_reporting', E_ALL); // because we are mad guys who hates warning
ini_set('display_errors', 'on');
$home_folder = __DIR__.'/';
$folder = $home_folder.'install/';

$first_time = !isset($_POST['validate_step']);

$max_step = isset($_POST['max_step']) ? intval($_POST['max_step']) : 0;
$validate_step = isset($_POST['validate_step']) ? intval($_POST['validate_step']) : 0;
if ($validate_step > $max_step) $max_step = $validate_step;

$launched_install = (isset($_POST['launched_install']) && $_POST['launched_install']) ? true : false;

$install_step = 0;
include_once($folder.'install.php');

if (is_file($home_folder.'originals/installed.html')){
    // verify if the installation is done

    file_put_contents($home_folder.'originals/index.html', '');
    $install_success = true;
    unlink($home_folder.'originals/installed.html');
    unlink($home_folder.'installscript.php');
    if (file_exists($home_folder.'install.json')) unlink($home_folder.'install.json');
    if (file_exists($home_folder.'install_extra.php')) unlink($home_folder.'install_extra.php');
    $install_step = 5;
}

?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Install helPHP instance</title>
        <style>
            :root {
                --color1: #eeeeee;
                --color2: #3a80bd;
                --shadow: 0 0px 4px 0px #17354f70;
            }
            html {
                height: 100%;
            }
            body {
                display: grid;
                justify-content: center;
                grid-template-columns: minmax(60vw, auto);
                font-family: sans;
                height: 100%;
                box-sizing: border-box;
                margin: 0;
                padding: 8px;
                grid-template-rows: auto 1fr;
                grid-gap: 20px;
            }
            .logo img {
                display: block;
                height: 50px;
                width: auto;
            }
            .step_list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                margin-top: 8px;
                background: var(--color1);
                border-radius: 5px;
                border: 2px solid var(--color2);
                text-align: center;
            }
            .step_list_item {
                padding: 5px;
                height: 36px;
                box-sizing: border-box;
                flex-grow: 1;
            }
            .step_list_item.current {
                color: var(--color2);
                font-weight: bold;
            }
            .step_list_item.clickable:hover {
                cursor: pointer;
                text-decoration: underline;
            }
            .step_list_item.current.clickable:hover {
                cursor: initial;
                text-decoration: none;
            }
            .step_list_separator {
                padding: 5px;
                height: 36px;
                box-sizing: border-box;
                color: var(--color2);
                font-weight: bold;
            }
            .step_container {
                padding-bottom: 20px;
            }
            .block_parent {
                display: grid;
                grid-gap: 24px;
            }
            .block {
                display: grid;
                background: var(--color1);
                padding: 10px;
                border-radius: 5px;
                border-top: 2px solid var(--color2);
                box-shadow: 0 3px 6px 0px #0003;
            }
            .title {
                font-size: 1.2em;
                text-align: center;
                padding: 8px;
                font-weight: bold;
                border-radius: 2px;
            }
            .label {
                font-weight: bold;
            }
            .hidden {
                display: none !important;
            }
            .msg_error {
                color: #bd3a3a;
            }
            input[type="text"] {
                vertical-align: middle;
                padding: 6px 8px;
                border-radius: 5px;
                border-style: solid;
                border-width: 1px;
                font-size: 1em;
            }
            .sub_block {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-column-gap: 8px;
                padding: 8px;
            }
            .sub_block.activate {
                grid-template-columns: auto 1fr;
                grid-column-gap: 8px;
                align-items: center;
            }
            .sub_block.one_col {
                grid-template-columns: 1fr;
            }
            .sub_block .info, .sub_block .msg_error {
                grid-column: 1 / 3;
            }
            .sub_block.one_col .msg_error {
                grid-column: unset;
            }
            .info.replication_slave {
                padding: 8px;
                text-align: center;
                margin: 8px 0;
            }
            .sub_block.other {
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
                background: var(--color2);
                border-radius: 5px;
                cursor: pointer;
                border: 2px solid var(--color2);
                color: var(--color1);
                font-weight: bold;
                font-size: 1em;
                padding: 2px 40px;
            }
            button:hover {
                background: var(--color1);
                color: #000;
            }

            .info.installation {
                text-align: center;
            }
            .wait {
                background-image: url(images/shu.png);
                background-repeat: no-repeat;
                background-position: center;
                background-size: auto;
                width: 50px;
                height: 50px;
                animation: rotate linear 1s infinite;
                margin: auto;
            }
            .cmd {
                font-family: mono;
                padding: 0 15px;
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
    </head>
    <body>
        <script>
            function change_step(step){
                let inp_max_step = document.getElementById('max_step');
                let max_step = parseInt(inp_max_step.value);
                if (step > max_step) return; // force at least one display of each step

                let inp_current_step = document.getElementById('install_step');
                let current_step = parseInt(inp_current_step.value);
                if (step != current_step && current_step < 4) {
                    let current_container = document.getElementById('step_' + current_step);
                    let current_list = document.getElementById('step_list_' + current_step);
                    current_container.classList.add('hidden');
                    current_list.classList.remove('current');
                    
                    let new_container = document.getElementById('step_' + step);
                    let new_list = document.getElementById('step_list_' + step);
                    new_container.classList.remove('hidden');
                    new_list.classList.add('current');

                    inp_current_step.value = step;
                }
            }

            function toggle(evt){
                let target = evt.target;
                let state = target.checked;
                let container = document.getElementById(target.id + '_fields');
                if (state) container.classList.remove('hidden');
                else container.classList.add('hidden');
            }
        </script>
        <div class="step_list_container">
            <div class="logo"><img src="../images/logo.svg" width="100%"></div>
            <ul class="step_list">
                <?php 
                    $steps = [
                        ['step'=>0, 'label'=>'Folders'],
                        ['step'=>1, 'label'=>'Database'],
                        ['step'=>2, 'label'=>'Website and others'],
                        ['step'=>3, 'label'=>'Admin']
                    ];
                    foreach($steps as $step){
                        $html = '';
                        $html.= '<li id="step_list_'.$step['step'].'" class="step_list_item';
                        if ($install_step == $step['step']) $html.= ' current clickable';
                        elseif ($install_step > $step['step']) $html.= ' done clickable';
                        $html.='" onclick="change_step('.$step['step'].');">'.$step['label'].'</li>';
                        $html.='<li class="step_list_separator">></li>';
                        echo $html;
                    }
                ?>
                <li class="step_list_item <?php if ($install_step == 4) echo "current"; else if ($install_step > 4) echo "done";?>">Installation</li>
                <li class="step_list_separator">></li>
                <li class="step_list_item <?php if ($install_step == 5) echo "current";?>">Done</li>
            </ul>
        </div>
        
        <div class="step_container">
            <form class="form" action="./" method="POST" enctype="multipart/form-data">
                <input id="install_step" type="hidden" name="install_step" value="<?php echo $install_step; ?>">
                <input id="max_step" type="hidden" name="max_step" value="<?php echo $max_step; ?>">
                <input id="launched_install" type="hidden" name="launched_install" value="<?php echo $launched_install ? '1' : '0'; ?>">
                <?php
                include_once($folder.'folder.php');
                include_once($folder.'database.php');
                include_once($folder.'website_and_others.php');
                include_once($folder.'admin.php');
                include_once($folder.'installation.php');
                include_once($folder.'done.php');
                ?>
            </form>
        </div>

    </body>
</html>