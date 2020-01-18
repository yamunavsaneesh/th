<?php if($hunts) {?>
<div class="table-responsive">
  <table class="table card-table">
    <thead>
      <tr class="headings">
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Last Login</th> 
      </tr>
    </thead>
    <tbody>
      <?php $statusarray = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning','fa-Y'=>'fa-check','fa-N'=>'fa-close');   foreach($hunts as $key => $hunt):?>
      <tr class="even pointer">
        <td col="row" align="left"><?php echo $hunt['firstname'].' '.$hunt['lastname'];?></td>
        <td col="row" align="left"><?php echo $hunt['mobile'];?></td>
        <td col="row" align="left"><?php echo $hunt['email'];?></td>
        <td col="row" align="left"><?php echo ($hunt['last_login'] !='') ? date('d/m/Y h:i A',strtotime($hunt['last_login'])) : '';?></td> 
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php  } ?>
