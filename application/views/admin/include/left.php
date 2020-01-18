<?php if($this->session->userdata('admin_role')){?>
<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header"> <a class="sidebar-brand" href="<?php echo site_url('admin')?>"><span class="highlight"> TREASURE HUNT </span></a>
    <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <?php $excharray = array('admin/hunts/add','admin/admins/add');
	 $exarray = array();
	if($this->session->userdata('admin_role')!='1'){ 
		$exarray = array('admin/hunts','admin/admins');		
		foreach ($menus as $key => $menu) {
			if(in_array($menu['link'],$exarray)) {
				unset($menus[$key]);
			}
		}
	}  
	$ic=0;
	foreach($menus as $menu): 
	$ic++; 
	$menuarr=explode('/',$menu['link']); 
	if(isset($menuarr['1'])){
		$currmenu=$menuarr['1'];
	}else{
		$currmenu='';
	}
	
	?>
      <?php if(count($menu['sub_menu'])>0){?>
      <li class="dropdown <?php echo $currmenu == $this->router->fetch_class() ? 'active' : '';?>"> <a href="<?php echo site_url($menu['link']) ?>" class="dropdown-toggle" data-toggle="dropdown">
        <div class="icon"><i class="fa <?php echo $menu['class']? $menu['class']:'fa-user' ?>"></i> </div>
        <div class="title"><?php echo  $menu['name']; ?></div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <?php if($menu['sub_menu']) foreach($menu['sub_menu'] as $submenu): 
		  		if($this->session->userdata('admin_role')=='1' && !in_array($submenu['link'],$excharray)){  
				if( $menu['link'].'/add' != $submenu['link']  ) { 
					?>
            <li> <a href="<?php echo site_url($submenu['link']); ?>"> <?php echo $submenu['name']; ?> </a>
              <?php if(count($submenu['child_menus'])>0 ){ } ?>
            </li>
            <?php  }
		  }else{?>
            <li> <a href="<?php echo site_url($submenu['link']); ?>"> <?php echo $submenu['name']; ?> </a>
              <?php if(count($submenu['child_menus'])>0 ){ } ?>
            </li>
            <?php }?>
            <?php endforeach;  ?>
          </ul>
        </div>
      </li>
      <?php } else{ ?>
      <li class="<?php echo $currmenu == $this->router->fetch_class() ? 'active' : '';?>"> <a href="<?php echo site_url($menu['link']) ?>">
        <div class="icon"> <i class="fa <?php echo $menu['class']? $menu['class']:'fa-user' ?>" aria-hidden="true"></i> </div>
        <div class="title"><?php echo  $menu['name']; ?></div>
        </a> </li>
      <?php } ?>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>
<?php }?>
<?php /*?><!-- menu prile quick info -->
<div class="profile">
  <div class="profile_pic"> <img class="img-circle profile_img" alt="..." src="<?php echo base_url('public/admin/images/profile.png'); ?>"> </div>
  <div class="profile_info"> <span>Welcome</span>
    <h2>
      <?php // echo $this->session->userdata('admin_name') ?>
    </h2>
  </div>
</div>
<!-- /menu prile quick info --> 
<br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3><?php echo $this->session->userdata('admin_name') ?></h3>
    <ul class="nav side-menu">
      <?php 
	$ic=0;
	foreach($menus as $menu): 
	$ic++; 
	$menuarr=explode('/',$menu['link']); 
	if(isset($menuarr['1'])){
		$currmenu=$menuarr['1'];
	}else{
		$currmenu='';
	}
	?>
      <?php if(count($menu['sub_menu'])>0){?>
      <li><a> <i class="fa <?php echo $menu['class']? $menu['class']:'fa-user' ?>"></i> <?php echo  $menu['name']; ?><span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" >>
          <?php foreach($menu['sub_menu'] as $submenu):?>
          <li> <a href="<?php echo site_url($submenu['link']); ?>"><i class="icon-chevron-right"></i><span class="hidden-tablet"> <?php echo $submenu['name']; ?></span></a>
            <?php if(count($submenu['child_menus'])>0 ){?>
            <ul>
              <?php foreach($submenu['child_menus'] as $childmenu):?>
              <li><a href="<?php echo site_url($childmenu['link']); ?>"><i class="icon-chevron-right"></i><span class="hidden-tablet"> <?php echo $childmenu['name']; ?></span></a></li>
              <?php endforeach; ?>
              
            </ul>
            <?php } ?>
          </li>
          <?php endforeach;  ?>
        </ul>
      </li>
      <?php } ?>
      <?php endforeach; ?>
      <li><a href="<?php echo site_url('admin/home/logout'); ?>"><i class="fa fa-home"></i> Logout </a></li>
    </ul>
  </div>
</div><?php */?>
