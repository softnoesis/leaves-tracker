<link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="<?php echo base_url(); ?>" style="margin-left: -29px;"><img class="nav-link" src="<?php echo base_url(); ?>image/leaves1.png" alt=""></a>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
       
          <div class="input-group-append">
           
          </div>
        </div>
      </form>
        <ul class="navbar-nav ml-auto ml-md-0">      
          <li class="nav-item dropdown down-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" test="test1397" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
                 $user_id = $this->session->userdata('uid');
                 $this->db->select("role_id, name");
                 $this->db->from("member");
                 $this->db->where('user_id',$user_id);
                 $user_id_new=$this->db->get()->row();
              ?>
              <i class="fas fa-user-circle fa-fw"></i>
                <span>Welcome, <?php echo $user_id_new->name; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?php echo site_url('user/Change_password'); ?>">Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo site_url('admin/Login/logout'); ?>" >Logout</a>
          </div>
          </li>
        </ul>
  </nav>
  



