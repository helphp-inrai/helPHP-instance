<?php

global $data, $install_step, $helphp_folder_found, $log_folder_writable, $home_folder_writable, $home_folder, $missing_log_file, $log_file_writable;

?>

<div class="block_parent<?php if ($install_step != 0) echo " hidden";?>" id="step_0">

    <div class="block folders">

        <div class="title">Folders</div>

        <?php 
        if (!$home_folder_writable){
            echo '<div class="msg_error home_folder_writable">The folder of your instance '.$home_folder.' is not writable ! You have to give access to www-data before continuing !</div>';
        }
        ?>

        <div class="sub_block one_col helphp ">
            <label for="HELPHP_FOLDER">
                <div class="label">helPHP folder</div>
                <div class="info">
                    Path to the helPHP folder libs is needed. Usually is something like /home/helPHP/<br>
                    The installation can't work without the right path.
                </div>
            </label>
            <input type="text" name="HELPHP_FOLDER" value="<?php echo $data['HELPHP_FOLDER']; ?>" id="HELPHP_FOLDER">
            <?php if (isset($helphp_folder_found) && !$helphp_folder_found) echo '<div class="msg_error folder_not_found">helPHP libs folder not found at '.$data['HELPHP_FOLDER'].'</div>'; ?>
        </div>
        
        <div class="sub_block one_col log">
            <label for="LOG_FILE">
                <div class="label">Logs file</div>
                <div class="info">
                    Path to the file where the logs are written
                </div>
            </label>
            <input type="text" name="LOG_FILE" value="<?php echo $data['LOG_FILE']; ?>" id="LOG_FILE">
            <?php if (isset($missing_log_file) && !$missing_log_file) echo '<div class="msg_error log_file_missing">You need to put the path to a file here.</div>'; ?>
            <?php if (isset($log_file_writable) && !$log_file_writable) echo '<div class="msg_error log_file_not_writable">Log file is not writable at '.$data['LOG_FILE'].'<br><b>Change rights and give access to user www-data before continuing please.</b></div>'; ?>
        </div>

        <div class="sub_block one_col log">
            <label for="ROOT_FS">
                <div class="label">Root FS folder name (storage folder)</div>
                <div class="info">
                    Path to the folder where the files are stocked. Useful if you plan to use helPHP's filesystem, otherwise ignore it.<br>
                </div>
            </label>
            <input type="text" name="ROOT_FS" value="<?php echo $data['ROOT_FS']; ?>" id="ROOT_FS">
        </div>

    </div>

    <div class="block_btn">
        <button type="submit" name="validate_step" value="1">Next</button>
    </div>
    
</div>