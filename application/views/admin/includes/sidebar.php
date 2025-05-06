      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>  
        </li>
      <?php
         $admin_id = $this->session->userdata('adid');
         $this->db->select("role_id, company_id");
         $this->db->from("member");
         $this->db->where('user_id',$admin_id);
         $user_id_new = $this->db->get()->row();

         $this->db->select("image");
         $this->db->from("company");
         $this->db->where('id',$user_id_new->company_id);
         $company_image = $this->db->get()->row();

      ?>
      <?php if($user_id_new->role_id == 2){ ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Member/HRProfile'); ?>">
            <i class="fas fa fa-users"></i>
            <span>My Profile</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Member/my_leaves'); ?>">
            <i class="fas fa-address-card"></i>
            <span>My Leaves</span></a>
        </li>
        <?php }?>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Fullcalendar'); ?>">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span>Leaves Calendar</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Member'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Members</span></a>
        </li>
       <?php if($user_id_new->role_id == 1 || $user_id_new->role_id == 5){ ?>
        <li class="nav-item active" style="display: none;">
          <a class="nav-link" href="<?php echo site_url('admin/Member/Requestleave'); ?>">
            <i class="fas fa fa-paper-plane"></i>
            <span>Request Leave</span></a>
        </li>
         <?php }else{?>
          <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/Member/Requestleave'); ?>">
            <i class="fas fa fa-paper-plane"></i>
            <span>Request Leave</span></a>
        </li>
         <?php }?>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/leave_type'); ?>">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Leaves Types</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/leavespolicy'); ?>">
           <i class="fa fa-lock" aria-hidden="true"></i>
            <span>Leaves Policy</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/holiday'); ?>">
            <i class="fa fa-suitcase" aria-hidden="true"></i>
            <span>Holidays</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="<?php echo site_url('admin/companyprofile'); ?>">
            <i class="fa fa-building" aria-hidden="true"></i>
            <span>Company Profile</span></a>
        </li>
        <li class="nav-item">
          <?php $comp_image = $company_image->image ? $company_image->image :'default.png'; ?>
          <img class="nav-link" src="<?php echo base_url(); ?>image/<?php echo $comp_image; ?>" id="cls_images">
        </li>
      </ul>