<?php

global $data, $install_step;
global $admin_user, $admin_pass, $missing_admin, $short_password;

?>

<div class="block_parent<?php if ($install_step != 3) echo " hidden";?>" id="step_3">

    <div class="block admin">

        <div class="title">Admin credentials</div>

        <div class="sub_block admin">

            <div class="info admin">To connect as administrator to your instance. Keep those credentials safe !</div>

            <label for="admin_user"><div class="label">Username</div></label>
            <label for="admin_pass"><div class="label">Password</div></label>
            <input type="text" name="admin_user" id="admin_user" value="<?php echo $admin_user; ?>">
            <input type="text" name="admin_pass" id="admin_pass" value="<?php echo $admin_pass; ?>">
            
            <?php if (isset($missing_admin) && $missing_admin) echo '<div class="msg_error admin">Missing admin username or password</div>'; ?>
            <?php if (isset($short_password) && $short_password) echo '<div class="msg_error admin">Password too short, minimum '.$min_size.' characters</div>'; ?>

        </div>

    </div>
    
    <div class="block_btn">
        <button type="submit" name="validate_step" value="4">Next</button>
    </div>
    
</div>