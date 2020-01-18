<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Manage Groups</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/groups/'.(isset($hunt) ? 'edit/'.$hunt->id : 'add'),array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <input id="id" name="id" type="hidden" value="<?php echo isset($hunt) ? set_value("id", $hunt->id) : set_value("id");  ?>" />
        <div class="section">
          <div class="section-body">
            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Title</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" id="name" name="name" value="<?php echo isset($hunt) ? set_value("name", $hunt->name) : set_value("name"); ?>" placeholder="Title" class="form-control required">
              </div>
            </div> 
            <div class="form-group <?php echo form_error('short_desc') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Details</label>
              <div class="col-md-6 col-sm-9">
                <textarea type="text" name="short_desc" placeholder="Details" class="form-control required"><?php echo isset($hunt) ? set_value("short_desc", $hunt->short_desc) : set_value("short_desc"); ?></textarea>
              </div>
            </div> 
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-6 col-sm-9">
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio10" value="Y" <?php echo isset($hunt) ? ($hunt->status == 'Y' ? 'checked': '') : (set_radio('status', 'Y',true)); ?>>
                  <label for="radio10"> Active </label>
                </div>
                <div class="radio radio-inline">
                  <input type="radio" name="status" id="radio11" value="N" <?php echo isset($hunt) ? ($hunt->status == 'N' ? 'checked': '') : (set_radio('status', 'N',false)); ?>>
                  <label for="radio11"> Deactive </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-footer">
          <div class="form-group">
            <div class="col-md-6 col-sm-9 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="<?php echo site_url('admin/groups'); ?>" class="btn btn-primary">Cancel</a> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div> 