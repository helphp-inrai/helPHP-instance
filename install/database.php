<?php

// general variable
global $data, $install_step;
// main database variable
global $db_root_user, $db_root_pass, $wrong_root, $missing_root, $missing_db;
// master/slave variable
global $db_root_user_slave, $db_root_password_slave, $wrong_root_slave, $missing_root_slave, $missing_db_slave;
// central variable
global $db_root_user_central, $db_root_password_central, $wrong_root_central, $missing_root_central, $missing_db_central;
// jobs variable
global $db_root_user_jobs, $db_root_password_jobs, $wrong_root_jobs, $missing_root_jobs, $missing_db_jobs;

?>

<div class="block_parent<?php if ($install_step != 1) echo " hidden";?>" id="step_1">
    <div class="block database">

        <div class="title">Main database</div>

        <div class="sub_block db_root">

            <div class="info db_root">Root access to your database, will only be used during the installation and will not be saved.</div>

            <label for="db_root_user"><div class="label">Username</div></label>
            <label for="db_root_password"><div class="label">Password</div></label>
            <input type="text" name="db_root_user" id="db_root_user" value="<?php echo $db_root_user; ?>">
            <input type="text" name="db_root_password" value="<?php echo $db_root_pass; ?>" id="db_root_password">
            
            <?php if (isset($missing_root) && $missing_root) echo '<div class="msg_error db_root">Missing root username or password</div>'; ?>
            <?php if (isset($wrong_root) && $wrong_root) echo '<div class="msg_error db_root">Incorrect root username or password, can\'t connect to database</div>'; ?>

        </div>

        <div class="sub_block db_main">

            <div class="info db_main">Main database information, every fields are needed.</div>

            <label for="DB_HOST"><div class="label">Host name</div></label>
            <label for="DB_BASE"><div class="label">Base name</div></label>
            <input type="text" name="DB_HOST" id="DB_HOST" value="<?php echo $data['DB_HOST']; ?>">
            <input type="text" name="DB_BASE" id="DB_BASE" value="<?php echo $data['DB_BASE']; ?>">

            <label for="DB_USER"><div class="label">Username</div></label>
            <label for="DB_PASS"><div class="label">Password</div></label>
            <input type="text" name="DB_USER" id="DB_USER" value="<?php echo $data['DB_USER']; ?>">
            <input type="text" name="DB_PASS" id="DB_PASS" value="<?php echo $data['DB_PASS']; ?>">

            <label for="DB_TABLE_PREFIX"><div class="label">Prefix</div></label>
            <div></div>
            <input type="text" name="DB_TABLE_PREFIX" id="DB_TABLE_PREFIX" value="<?php echo $data['DB_TABLE_PREFIX']; ?>">
            <div></div>
            
            <?php if (isset($missing_db) && $missing_db) echo '<div class="msg_error db_main">Missing field</div>'; ?>

        </div>

    </div>

    <div class="block db_master_slave">

        <div class="title">Replication database</div>

        <div class="sub_block activate replication">
            
            <div class="info activate_replication">To enable a replication master/slave between two database</div>
            <label for="MASTER_SLAVE_MODE"><div class="label">Activate replication</div></label>
            <input type="checkbox" name="MASTER_SLAVE_MODE" id="MASTER_SLAVE_MODE" value=1 <?php echo $data['MASTER_SLAVE_MODE'] ? 'checked' : '' ?> onchange="toggle(event);">

        </div>

        <div class="replication_slave<?php if (!$data['MASTER_SLAVE_MODE']) echo ' hidden'?>" id="MASTER_SLAVE_MODE_fields">

            <div class="info replication_slave">The main database information (master) you give before will be used with the following information (slave) to activate the replication.</div>

            <div class="sub_block root_slave">

                <div class="info root_slave">User root to access the second database, will not be saved and used only during the installation.</div>

                <label for="db_root_user_slave"><div class="label">Username</div></label>
                <label for="db_root_password_slave"><div class="label">Password</div></label>
                <input type="text" name="db_root_user_slave" id="db_root_user_slave" value="<?php echo $db_root_user_slave; ?>">
                <input type="text" name="db_root_password_slave" id="db_root_password_slave" value="<?php echo $db_root_password_slave; ?>">

                <?php if (isset($missing_root_slave) && $missing_root_slave) echo '<div class="msg_error db_slave">Missing root username or password</div>'; ?>
                <?php if (isset($wrong_root_slave) && $wrong_root_slave) echo '<div class="msg_error db_slave">Incorrect root username or password, can\'t connect to database</div>'; ?>

            </div>

            <div class="sub_block db_slave">

                <div class="info db_slave">Second database information, every fields are needed.</div>

                <label for="DB_SLAVE_HOST"><div class="label">Host</div></label>
                <label for="DB_SLAVE_BASE"><div class="label">Base</div></label>
                <input type="text" name="DB_SLAVE_HOST" id="DB_SLAVE_HOST" value="<?php echo $data['DB_SLAVE_HOST']; ?>">
                <input type="text" name="DB_SLAVE_BASE" id="DB_SLAVE_BASE" value="<?php echo $data['DB_SLAVE_BASE']; ?>">

                <label for="DB_SLAVE_USER"><div class="label">Username</div></label>
                <label for="DB_SLAVE_PASS"><div class="label">Password</div></label>
                <input type="text" name="DB_SLAVE_USER" id="DB_SLAVE_USER" value="<?php echo $data['DB_SLAVE_USER']; ?>">
                <input type="text" name="DB_SLAVE_PASS" id="DB_SLAVE_PASS" value="<?php echo $data['DB_SLAVE_PASS']; ?>">
                
                <?php if (isset($missing_db_slave) && $missing_db_slave) echo '<div class="msg_error db_slave">Missing field</div>'; ?>

            </div>
        </div>
    </div>

    <div class="block db_central">

        <div class="title">Central database</div>

        <div class="sub_block activate central">
            
            <div class="info activate_central">To enable a central database to share users, groups and more between instances</div>
            <label for="DB_CENTRAL"><div class="label">Activate central</div></label>
            <input type="checkbox" name="DB_CENTRAL" id="DB_CENTRAL" value=1 <?php echo $data['DB_CENTRAL'] ? 'checked' : '' ?> onchange="toggle(event);">

        </div>

        <div class="central<?php if (!$data['DB_CENTRAL']) echo ' hidden'?>" id="DB_CENTRAL_fields">

            <div class="sub_block root_central">

                <div class="info root_central">User root to access the central database, will not be saved and used only during the installation.</div>

                <label for="db_root_user_central"><div class="label">Username</div></label>
                <label for="db_root_password_central"><div class="label">Password</div></label>
                <input type="text" name="db_root_user_central" id="db_root_user_central" value="<?php echo $db_root_user_central; ?>">
                <input type="text" name="db_root_password_central" id="db_root_password_central" value="<?php echo $db_root_password_central; ?>">

                <?php if (isset($missing_root_central) && $missing_root_central) echo '<div class="msg_error root_central">Missing root username or password</div>'; ?>
                <?php if (isset($wrong_root_central) && $wrong_root_central) echo '<div class="msg_error root_central">Incorrect root username or password, can\'t connect to database</div>'; ?>

            </div>

            <div class="sub_block db_central">

                <div class="info db_central">Central database information, every fields are needed.</div>

                <label for="DB_CENTRAL_HOST"><div class="label">Host name</div></label>
                <label for="DB_CENTRAL_BASE"><div class="label">Base name</div></label>
                <input type="text" name="DB_CENTRAL_HOST" id="DB_CENTRAL_HOST" value="<?php echo $data['DB_CENTRAL_HOST']; ?>">
                <input type="text" name="DB_CENTRAL_BASE" id="DB_CENTRAL_BASE" value="<?php echo $data['DB_CENTRAL_BASE']; ?>">

                <label for="DB_CENTRAL_USER"><div class="label">Username</div></label>
                <label for="DB_CENTRAL_PASS"><div class="label">Password</div></label>
                <input type="text" name="DB_CENTRAL_USER" id="DB_CENTRAL_USER" value="<?php echo $data['DB_CENTRAL_USER']; ?>">
                <input type="text" name="DB_CENTRAL_PASS" id="DB_CENTRAL_PASS" value="<?php echo $data['DB_CENTRAL_PASS']; ?>">
                
                <?php if (isset($missing_db_central) && $missing_db_central) echo '<div class="msg_error db_central">Missing field</div>'; ?>

            </div>
        </div>

    </div>

    <div class="block db_jobs">

        <div class="title">Jobs database</div>

        <div class="sub_block activate jobs">
            
            <div class="info activate_jobs">To enable a jobs database to asynchronously execute external process.</div>
            <label for="DB_JOBS"><div class="label">Activate jobs</div></label>
            <input type="checkbox" name="DB_JOBS" id="DB_JOBS" value=1 <?php echo $data['DB_JOBS'] ? 'checked' : '' ?> onchange="toggle(event);">

        </div>

        <div class="jobs<?php if (!$data['DB_JOBS']) echo ' hidden'?>" id="DB_JOBS_fields">

            <div class="sub_block root_jobs">

                <div class="info root_jobs">User root to access the jobs database, will not be saved and used only during the installation.</div>

                <label for="db_root_user_jobs"><div class="label">Username</div></label>
                <label for="db_root_password_jobs"><div class="label">Password</div></label>
                <input type="text" name="db_root_user_jobs" id="db_root_user_jobs" value="<?php echo $db_root_user_jobs; ?>">
                <input type="text" name="db_root_password_jobs" id="db_root_password_jobs" value="<?php echo $db_root_password_jobs; ?>">

                <?php if (isset($missing_root_jobs) && $missing_root_jobs) echo '<div class="msg_error root_jobs">Missing root username or password</div>'; ?>
                <?php if (isset($wrong_root_jobs) && $wrong_root_jobs) echo '<div class="msg_error root_jobs">Incorrect root username or password, can\'t connect to database</div>'; ?>

            </div>

            <div class="sub_block db_jobs">

                <div class="info db_jobs">Jobs database information, every fields are needed.</div>

                <label for="DB_JOBS_HOST"><div class="label">Host name</div></label>
                <label for="DB_JOBS_BASE"><div class="label">Base name</div></label>
                <input type="text" name="DB_JOBS_HOST" id="DB_JOBS_HOST" value="<?php echo $data['DB_JOBS_HOST']; ?>">
                <input type="text" name="DB_JOBS_BASE" id="DB_JOBS_BASE" value="<?php echo $data['DB_JOBS_BASE']; ?>">

                <label for="DB_JOBS_USER"><div class="label">Username</div></label>
                <label for="DB_JOBS_PASS"><div class="label">Password</div></label>
                <input type="text" name="DB_JOBS_USER" id="DB_JOBS_USER" value="<?php echo $data['DB_JOBS_USER']; ?>">
                <input type="text" name="DB_JOBS_PASS" id="DB_JOBS_PASS" value="<?php echo $data['DB_JOBS_PASS']; ?>">
                
                <?php if (isset($missing_db_jobs) && $missing_db_jobs) echo '<div class="msg_error db_jobs">Missing field</div>'; ?>

            </div>

        </div>

    </div>

    <div class="block_btn">
        <button type="submit" name="validate_step" value="2">Next</button>
    </div>

</div>