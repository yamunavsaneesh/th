<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">Settings</span></div>
        </div>
      </div>
      <div class="card-body"><?php echo form_open('admin/home/settings',array('class' => 'form form-horizontals')); ?> <?php echo $this->session->flashdata('message'); ?>
        <div class="content">
          <div class="row">
            <?php foreach($settings as $key => $setting): ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label class="control-label" for="status"><?php echo $setting['title']; ?></label>
                <?php if($setting['settingtype']=='radio'){ ?>
                <input type="radio" name="setting[<?php echo $setting['id']; ?>]" class="form-control <?php echo $setting['inputclass'] ?>" value="Y" <?php if($setting['status']=='Y'){ echo 'checked="checked"';} ?> />
                Yes
                <input type="radio" name="setting[<?php echo $setting['id']; ?>]" class="form-control <?php echo $setting['inputclass'] ?>" value="N" <?php if($setting['status']=='N'){ echo 'checked="checked"';} ?> />
                No
                <?php } else if($setting['settingtype']=='textaera'){ ?>
                <input  name="setting[<?php echo $setting['id']; ?>]" type="text" class="form-control <?php echo $setting['inputclass'] ?>" value="<?php echo $setting['settingvalue']; ?>" />
                <?php } else { ?>
                <input  name="setting[<?php echo $setting['id']; ?>]" type="text" class="form-control <?php echo $setting['inputclass'] ?>" value="<?php echo $setting['settingvalue']; ?>" />
                <?php  } ?>
              </div>
            </div>
            <?php endforeach; ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group  pull-right">
                <button type="submit" class="btn btn-success">Save</button>
                <a class="btn btn-default" href="<?php echo site_url('admin/home'); ?>">Cancel</a> </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
