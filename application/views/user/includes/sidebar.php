      <ul class="sidebar navbar-nav">
      	<li class="nav-item active">
          <br>
	  	    <center>
            <?php $profile_image = $profile->image ? $profile->image :'default.png'; ?>
            <img src="<?php echo base_url(); ?>image/<?php echo $profile_image;?>" class="nav-link" id="cls_images">
          </center> 
      	</li>
        <?php
         $admin_id = $this->session->userdata('uid');
         $this->db->select("role_id, company_id");
         $this->db->from("member");
         $this->db->where('user_id',$admin_id);
         $user_id_new = $this->db->get()->row();

         $this->db->select("image");
         $this->db->from("company");
         $this->db->where('id',$user_id_new->company_id);
         $company_image = $this->db->get()->row();

        ?>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/User_Profile'); ?>">
            <i class="fas fa fa-users"></i>
            <span>My Profile</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/User_Profile/my_leaves'); ?>">
            <i class="fas fa-address-card"></i>
            <span>My Leaves</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/Requestleave'); ?>">
            <i class="fas fa fa-paper-plane"></i>
            <span>Request Leave</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/Fullcalendar'); ?>">
            <i class="fas fa fa-calendar"></i>
            <span>Calendar</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/holiday'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Holidays</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/Companyprofile'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Company Profile</span></a>
        </li>
        
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/attendance'); ?>">
            <i class="fa fa-hourglass" aria-hidden="true"></i>
            <span>Attendance</span></a>
        </li>
        
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('user/Change_password'); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Change password</span></a>
        </li>

        <li class="nav-item">
          <?php $co_image = $company_image->image ? $company_image->image :'default.png'; ?>
          <img class="nav-link" src="<?php echo base_url(); ?>image/<?php echo $co_image; ?>" class="nav-link" id="cls_images">
        </li>
      </ul>

