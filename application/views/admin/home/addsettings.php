<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Group 1</div>
        <?php echo form_open_multipart('admin/home/addsettings'); ?>
        <div class="element">
          <label for="title">Title
            <?php if(form_error('title')){ $err=' err'; echo form_error('title'); } else { $err=''; ?>
            <span> (required)</span>
            <?php } ?>
          </label>
          <input id="title" name="title" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('title'); ?>" />
        </div>
        <div class="element">
          <label for="settingkey">Key
            <?php if(form_error('settingkey')){ $err=' err'; echo form_error('settingkey'); } else { $err=''; ?>
            <span> (required)</span>
            <?php } ?>
          </label>
          <input id="settingkey" name="settingkey" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('settingkey'); ?>" />
        </div>
        <div class="element">
          <label for="settingtype">Type
            <?php if(form_error('settingtype')){ $err=' err'; echo form_error('settingtype'); } else { $err=''; ?>
            <span> (required)</span>
            <?php } ?>
          </label>
          <input id="settingtype" name="settingtype" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('settingtype'); ?>" />
        </div>
        <div class="element">
          <label for="settingvalue">Value (<?php echo $this->languagesarr[$this->session->userdata('admin_language')]?>)
            <?php if(form_error('settingvalue')){ $err=' err'; echo form_error('settingvalue'); } else { $err=''; ?>
            <span> (required)</span>
            <?php } ?>
          </label>
          <input id="settingvalue" name="settingvalue" type="text" class="text<?php echo $err; ?>" value="<?php echo set_value('settingvalue'); ?>" />
        </div>
        <div class="element">
          <label for="status">Status
            <?php if(form_error('status')){ $err=' err'; echo form_error('status'); } else { $err=''; ?>
            <span> (required)</span>
            <?php } ?>
          </label>
          <input type="radio" name="status" value="Y" <?php echo set_radio('status', 'Y', TRUE); ?> />
          Enabled
          <input type="radio" name="status" value="N" <?php echo set_radio('status', 'N'); ?> />
          Disabled </div>
        <div class="entry">
          <button type="submit" class="add">Save</button>
          <a class="button cancel" href="<?php echo site_url('admin/home/addsettings'); ?>">Cancel</a> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
