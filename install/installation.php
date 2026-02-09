<?php

global $install_step;

?>

<script>
function reload(){
    let btn_reload = document.getElementById('btn_reload');
    btn_reload.click();
}
<?php if ($install_step == 4) echo 'setTimeout(reload, 3000);'?>
</script>


<div class="block_parent<?php if ($install_step != 4) echo " hidden";?>" id="step_4">

    <div class="block installation">

        <div class="title">Installation</div>

        <div class="info installation">The installation is running.<br>Please wait. It can take several minutes.<br>The page will refresh automatically when finished.</div>
        <div class="wait"></div>

        <button type="submit" name="validate_step" value="5" class="hidden" id="btn_reload">Next</button>

    </div>

</div>