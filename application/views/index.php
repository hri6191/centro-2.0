<div id="flashdata"><?php if ($this->session->flashdata('invalid')) { ?>
        <div class="row">
            <div class="large-12 small-12 columns">
                <center>
                    <div style="background: #fcc1ca; border: 1px solid; padding-bottom: 10px; padding-top: 10px; width: 400px; color: #f5220d; border-color: #fb1902;">
                        <?php echo $this->session->flashdata('invalid'); ?>
                    </div>
                </center>
            </div>
        </div>
    <?php } ?>
    </div>
<div class="row" style="width: 600px;">
    <div class="six columns">
        <form action="<?php echo base_url(); ?>Index_ctrlr/check_login" data-abide method="post">
            <fieldset style="border: 1px solid #7FBA00; background: #cffcc1;">
                <div class="large-12 small-12 columns" id="navigate">
                    <h4>USER LOGIN</h4>
                </div>
                <input type="text" name="username" id="username" placeholder="Enter Username" autofocus tabindex="1" required>
                <small class="error">Please Enter Username</small>
                <input type="password" name="password" id="password" placeholder="Enter Password" tabindex="2">
                <center><input type="submit" value="Login" tabindex="3" class="button" style="background-color: #0A5E0D;"></center>
            </fieldset>
        </form>
    </div>
</div>