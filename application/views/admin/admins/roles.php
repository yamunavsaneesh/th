<?php $statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');
?><div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Settings<small> </small> </h3>
    </div>
    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
          <button class="btn btn-default" type="button">Go!</button>
          </span> </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Roles <small></small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-striped responsive-utilities jambo_table bulk_action">
            <thead>
              <tr class="headings">
                 <th scope="col">ID</th>
                <th scope="col" width="60%">Role</th> 
                <th width="5%">Status </th>
                <th width="5%">Permission </th>
              </tr>
            </thead>
            <tbody>
              <?php if($roles) foreach($roles as $key => $role): ?>
              <tr class="even pointer">
                <td class="align-center"><?php echo ++$key; ?></td>
                <td><?php echo $role['role']; ?></td>
                 <td class="a-right a-right"><span class="btn btn-<?php echo $statusarray['class'.$role['status']];  ?> btn-xs"><i class="fa <?php echo $statusarray['fa-'.$hunts['status']]; ?>"></i></span></td>
                 <td class="a-right a-right"><span class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Access</span></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
