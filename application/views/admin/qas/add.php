<?php 
//if(isset($hunt)){
	//$dur = explode(':',$hunt->duration); 
	//$pen = explode(':',$hunt->penalty); 
//}
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="app-heading">
          <div class="app-title">
            <div class="title"><span class="highlight">Manage Questions</span></div>
          </div>
        </div>
      </div>
      <div class="card-body"> <?php echo form_open_multipart('admin/qas/'.(isset($hunt) ? 'edit/'.$hunt->id : 'add'),array('class'=>'form form-horizontal','id'=>'obj-form')); ?>
        <input id="id" name="id" type="hidden" value="<?php echo isset($hunt) ? set_value("id", $hunt->id) : set_value("id");  ?>" />
        <div class="section">
          <div class="section-body">
            <div class="form-group <?php echo form_error('question') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Question</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" name="question" value="<?php echo isset($hunt) ? set_value("question", $hunt->question) : set_value("question"); ?>" placeholder="Question" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('location') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Location</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" name="location" value="<?php echo isset($hunt) ? set_value("location", $hunt->location) :  set_value("location") ?>" placeholder="Location" class="form-control required">
              </div>
            </div>
            <div class="form-group <?php echo form_error('answer') ? 'has-error' : '' ?>">
              <label class="col-md-3 control-label">Answer</label>
              <div class="col-md-6 col-sm-9">
                <input type="text" name="answer" value="<?php echo isset($hunt) ? set_value("answer", $hunt->answer) : set_value("answer"); ?>" placeholder="Answer" class="form-control required">
              </div>
            </div>
            <?php /*?><div class="form-group">
              <label class="col-md-3 control-label">Duration</label>
              <div class="col-md-2">
                <div class="input-group <?php echo  form_error('durhr') ? 'has-error' : '' ?>">
                  <select class="select2" name="durhr">
                    <?php for($i=0;$i<=23;$i++):?>
                    <option value="<?php echo str_pad($i,2,'0',STR_PAD_LEFT); ?>" <?php echo set_select('durhr',str_pad($i,2,'0',STR_PAD_LEFT),isset($dur)?($dur[0]==$i?true:false):false); ?>><?php echo str_pad($i,2, '0',STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Hour</span> </div>
              </div>
              <div class="col-md-2">
                <div class="input-group <?php echo  form_error('durmin') ? 'has-error' : '' ?>">
                  <select class="select2" name="durmin">
                    <?php for($i=0;$i<=59;$i++):?>
                    <option value="<?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?>" <?php echo set_select('durmin',isset($dur)?$dur[1]:str_pad($i,2,'0',STR_PAD_LEFT),isset($dur)?($dur[1]==$i?true:false):false); ?>><?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Min</span> </div>
              </div>
              <div class="col-md-2 <?php echo  form_error('dursec') ? 'has-error' : '' ?>">
                <div class="input-group">
                  <select class="select2" name="dursec">
                    <?php for($i=0;$i<=59;$i++):?>
                    <option value="<?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?>" <?php echo set_select('dursec',isset($dur)?$dur[2]:str_pad($i , 2, '0', STR_PAD_LEFT),isset($dur)?($dur[2]==$i?true:false):false); ?>><?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Sec</span> </div>
              </div></div><?php */?>
              <?php /*?><div class="col-md-6 col-sm-9">
                <input type="text" name="duration" value="<?php echo isset($hunt) ? set_value("duration", $hunt->duration) : set_value("duration"); ?>" placeholder="Duration" class="form-control timepicker">
              </div>
            
            <div class="form-group ">
              <label class="col-md-3 control-label">Penalty</label><?php */?>
              <?php /*?><div class="col-md-6 col-sm-9">
                <input type="text" name="penalty" value="<?php echo isset($hunt) ? set_value("penalty", $hunt->penalty) : set_value("penalty"); ?>" placeholder="Penalty" class="form-control timepicker">
              </div>
              <div class="col-md-2">
                <div class="input-group  <?php echo  form_error('penhr') ? 'has-error' : '' ?>">
                  <select class="select2" name="penhr">
                    <?php for($i=0;$i<=23;$i++):?>
                    <option value="<?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?>"  <?php echo set_select('penhr',str_pad($i , 2, '0', STR_PAD_LEFT),isset($pen)?($pen[0]==$i?true:false):false); ?>><?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Hour</span> </div>
              </div>
              <div class="col-md-2">
                <div class="input-group  <?php echo  form_error('penmin') ? 'has-error' : '' ?>">
                  <select class="select2" name="penmin">
                    <?php for($i=0;$i<=59;$i++):?>
                    <option value="<?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?>" <?php echo set_select('penmin',str_pad($i , 2, '0', STR_PAD_LEFT),isset($pen)?($pen[1]==$i?true:false):false); ?>><?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Min</span> </div>
              </div>
              <div class="col-md-2  <?php echo  form_error('pensec') ? 'has-error' : '' ?>">
                <div class="input-group">
                  <select class="select2" name="pensec">
                    <?php for($i=0;$i<=59;$i++):?>
                    <option value="<?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?>"  <?php echo set_select('pensec',str_pad($i , 2, '0', STR_PAD_LEFT),isset($pen)?($pen[2]==$i?true:false):false); ?>><?php echo str_pad($i , 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor;?>
                  </select>
                  <span class="input-group-addon">Sec</span> </div>
              </div>
            </div><?php */?>
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
              <a href="<?php echo site_url('admin/qas'); ?>" class="btn btn-primary">Cancel</a> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div> 