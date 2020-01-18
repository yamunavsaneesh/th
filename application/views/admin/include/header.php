<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>
        </li>
        <li class="logo"> <a class="navbar-brand" href="<?php echo site_url('admin')?>"><span class="highlight"> TREASURE HUNT </span></a> </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title"><strong>ADMIN PANEL</strong></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php /*?> <li class="dropdown notification danger">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
            <div class="title">System Notifications</div>
            <div class="count">10</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Notification</li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">8</span>
                  <div class="message">
                    <div class="content">
                      <div class="title">New </div>
                      <div class="description"> total</div>
                    </div>
                  </div>
                </a>
              </li> 
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li><?php */?>
        <li class="dropdown profile"> <a href="<?php echo site_url('admin/profile') ?>" class="dropdown-toggle"  data-toggle="dropdown">
          <div class="icon"><i class="fa fa-user fa-3x" aria-hidden="true"></i></div>
          <div class="title">Profile</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username"><?php echo $this->session->userdata('admin_name') ?></h4>
            </div>
            <ul class="action">
              <?php /*?><li> <a href="<?php echo site_url('admin/home') ?>"> Profile </a> </li><?php */?>
              <li> <a href="<?php echo site_url('admin/home/changepwd') ?>"> Change Password </a> </li>
              <li> <a href="<?php echo site_url('admin/home/settings') ?>"> Settings </a> </li>
              <li> <a href="<?php echo site_url('admin/home/logout') ?>"> Logout </a> </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php /*?><div class="top_nav">
  <div class="nav_menu">
    <nav  role="navigation">
      <div class="nav toggle col-md-2"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
      <div class="nav col-md-6"><img src="<?php echo base_url('public/admin/images/logo.png'); ?>" alt="logo" vspace="10" class="img-responsive pull-right">
        </div>
      <div class="col-md-4 pull-right">
      <ul class="nav navbar-nav navbar-right">
        <li class=""> <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <strong><?php echo ucwords($this->session->userdata('admin_name')) ?></strong> <span class=" fa fa-angle-down"></span> </a>
          <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
             
            <li> <a href="<?php echo site_url('admin/home/settings'); ?>">  <span>Settings</span> </a> </li> 
            <li><a href="<?php echo site_url('admin/home/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a> </li>
          </ul>
        </li> 
      </ul></div>
    </nav>
  </div>
</div><?php */?>
