<?php

global $data, $install_step;

global $missing_site_name, $missing_domain, $missing_base_url, $missing_admin_folder;

?>

<div class="block_parent<?php if ($install_step != 2) echo " hidden";?>" id="step_2">

    <div class="block website">

        <div class="title">Website</div>

        <div class="sub_block one_col site_name">
            <label for="SITE_NAME">
                <div class="label">Website name</div>
                <div class="info">
                    Used to set the session name, usually something similar to your domain name.
                </div>
            </label>
            <input type="text" name="SITE_NAME" value="<?php echo $data['SITE_NAME']; ?>" id="SITE_NAME">
            <?php if (isset($missing_site_name) && $missing_site_name) echo '<div class="msg_error missing_site_name">You need to set a site name.</div>'; ?>
        </div>
        
        <div class="sub_block one_col domain">
            <label for="DOMAIN">
                <div class="label">Domain name</div>
                <div class="info">
                    Domain name to access your site, if you are in a local instance, put localhost here.
                </div>
            </label>
            <input type="text" name="DOMAIN" value="<?php echo $data['DOMAIN']; ?>" id="DOMAIN">
            <?php if (isset($missing_domain) && $missing_domain) echo '<div class="msg_error missing_domain">You need to set a domain name.</div>'; ?>
        </div>

        <div class="sub_block one_col base_url">
            <label for="BASE_URL">
                <div class="label">Base url</div>
                <div class="info">
                    Full URL to access your site like <span style="font-size: 0.8em;">https://domain.com/</span>. If you are in local put http://localhost/ here.
                </div>
            </label>
            <input type="text" name="BASE_URL" value="<?php echo $data['BASE_URL']; ?>" id="BASE_URL">
            <?php if (isset($missing_base_url) && $missing_base_url) echo '<div class="msg_error missing_base_url">You need to set the base url.</div>'; ?>
        </div>

        <div class="sub_block one_col admin_folder">
            <label for="ADMIN_FOLDER">
                <div class="label">Admin (backfoffice) folder name</div>
                <div class="info">
                    We recommend to set a weird word here to make the hacker life a bit more difficult than writing admin to get to the backoffice.
                </div>
            </label>
            <input type="text" name="ADMIN_FOLDER" value="<?php echo $data['ADMIN_FOLDER']; ?>" id="ADMIN_FOLDER">
            <?php if (isset($missing_admin_folder) && $missing_admin_folder) echo '<div class="msg_error missing_admin_folder">You need to set an admin folder.</div>'; ?>
        </div>

    </div>

    <div class="block redis">

        <div class="title">Redis</div>

        <div class="sub_block activate redis">
            <div class="info activate_redis">To connect with a redis database to store the session. Otherwise session is stored in database.</div>
            <label for="REDIS"><div class="label">Activate Redis</div></label>
            <input type="checkbox" name="REDIS" id="REDIS" value=1 <?php echo $data['REDIS'] ? 'checked' : '' ?> onchange="toggle(event);">
        </div>

        <div class="redis<?php if (!$data['REDIS']) echo ' hidden'?>" id="REDIS_fields">

            <div class="sub_block fields_redis">

                <label for="REDIS_HOST"><div class="label">Host</div></label>
                <label for="REDIS_PORT"><div class="label">Port</div></label>
                <input type="text" name="REDIS_HOST" id="REDIS_HOST" value="<?php echo $data['REDIS_HOST']; ?>">
                <input type="text" name="REDIS_PORT" id="REDIS_PORT" value="<?php echo $data['REDIS_PORT']; ?>">

            </div>

        </div>

    </div>

    <div class="block others">

        <div class="title">Others</div>

        <div class="sub_block activate api">
            <div class="info activate_api">To enable access to the REST API.</div>
            <label for="API_MODE"><div class="label">Activate API</div></label>
            <input type="checkbox" name="API_MODE" id="API_MODE" value=1 <?php echo $data['API_MODE'] ? 'checked' : '' ?>>
        </div>

        <div class="sub_block activate cluster">
            <div class="info activate_cluster">Activate if your are using a cluster for your storage.</div>
            <label for="CLUSTER_MODE"><div class="label">In a cluster</div></label>
            <input type="checkbox" name="CLUSTER_MODE" id="CLUSTER_MODE" value=1 <?php echo $data['CLUSTER_MODE'] ? 'checked' : '' ?>>
        </div>

    </div>

    <div class="block_btn">
        <button type="submit" name="validate_step" value="3">Next</button>
    </div>
    
</div>