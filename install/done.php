<?php

global $install_step, $folder;

?>


<div class="block_parent<?php if ($install_step != 5) echo " hidden";?>" id="step_5">

    <div class="block done">

        <div class="title">Success</div>

        <div class="info installation">Installation done.<br>Connect to your <a href="<?php echo $CONFIG::BASE_URL.$CONFIG::ADMIN_FOLDER; ?>">admin</a> and start working with helPHP !<br> Note : check the BASE_URL constant in config/main.php if you can't connect.</div>

    </div>

</div>

<?php
    if ($install_step == 5) {
        if (file_exists($folder)) exec('rm -r '.$folder);
    }
?>