<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="app-heading">
        <div class="app-title">
          <p class="mt30">&nbsp;</p>
          <div class="title"><span class="highlight">Hunts</span></div>
        </div>
      </div>
      <?php echo form_open_multipart('admin/business/addbranch',array('class'=>'form-huts','id'=>'obj-form')); ?>
      <div class="col-md-12">
        <div class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label class="control-label <?php echo form_error('title') ? 'red' : '' ?>" >Name<span class="required">*</span> </label>
                <div class="">
                  <input type="text" id="title" name="title" value="<?php echo set_value('title'); ?>" placeholder="Name" class="form-control required">
                </div>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="middle-name" class="control-label">Logo</label>
                <div class="">
                  <input id="gymlogo" class="form-control " type="file" placeholder="Logo" name="logo">
                </div>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label class="control-label">Status <span class="required">*</span></label>
                <div class="">
                  <div id="gender" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                      <input type="radio" name="status" value="Y" <?php echo set_radio('status', 'Y', true); ?> />
                      &nbsp;Enabled &nbsp; </label>
                    <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                      <input type="radio" name="status" value="N" <?php echo set_radio('status', 'N'); ?> />
                      &nbsp; Disabled &nbsp; </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group"> <?php echo $this->ckeditor->editor("description",html_entity_decode(set_value('description'))); ?> </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group  pull-right"> <a href="<?php echo site_url('admin/business/branches'); ?>" class="btn btn-primary">Cancel</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>