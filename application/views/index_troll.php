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
        <form action="<?php echo base_url(); ?>Index_ctrlr/validate" data-abide method="post">
            <fieldset style="border: 1px solid #7FBA00; background: #cffcc1;">
                <div class="large-12 small-12 columns" id="navigate">
                    <h4>ENTER SECRET KEY FOR ACTIVATION</h4>
                </div>
                <label>Your ID
                    <input type="text" class="focus" name="your_id" value="<?php echo $troll; ?>" id="your_id" readonly tabindex="1" required >
                </label>
                <input type="text" name="secret_key" id="secret_key" placeholder="Enter Secret Key" tabindex="2">
                <center><input type="submit" value="VALIDATE" tabindex="3" class="button" style="background-color: #0A5E0D;"></center>
            </fieldset>
        </form>
    </div>
</div>