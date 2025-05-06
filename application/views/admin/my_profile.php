<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin Change Email</title>
      <meta name="robots" content="noindex, nofollow">
      
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
   </head>
   <body id="page-top">
      <?php include APPPATH.'views/admin/includes/header.php';?>
      <div id="wrapper">
         <!-- Sidebar -->
         <?php include APPPATH.'views/admin/includes/sidebar.php';?>
         <div id="content-wrapper">
            <div class="container-fluid">
               <!-- Breadcrumbs-->
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a>
                  </li>
                  <li class="breadcrumb-item active">Change Email</li>
               </ol>
               <!-- Page Content -->
              <h1><b>Change Email</h1></b>
          <hr>
               <!---- Success Message ---->
               <?php if ($this->session->flashdata('success')) { ?>
                  <div class="alert alert-success" role="alert">
                     <?php echo $this->session->flashdata('success');?>
                  </div>
            </div>
            <?php } ?>
            <!---- Error Message ---->
            <?php if ($this->session->flashdata('error')) { ?>
               <div class="alert alert-danger" role="alert">
                  <?php echo $this->session->flashdata('error');?>
               </div>
            <?php } ?> 
            <?php echo form_open('admin/Change_password/update_profile');?>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'currentemail','id'=>'email','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('currentemail',$email->email)]);?>
                        <?php echo form_label('Current Email', 'currentemail'); ?>
                        <?php echo form_error('currentemail',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('email')]);?>
                        <?php echo form_label('New Email', 'email'); ?>
                        <?php echo form_error('email',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <?php echo form_submit(['name'=>'chnagepwd','value'=>'Change Email','class'=>'btn btn-primary btn-block']); ?>
                  </div>
               </div>
            </div>
            <?php echo form_close();?>
         </div>
         <!-- /.container-fluid -->
         <!-- Sticky Footer -->
         <?php include APPPATH.'views/admin/includes/footer.php';?>
      </div>
      <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <!-- Core plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
      <!-- Page level plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/chart.js/Chart.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
      <!-- Custom scripts for all pages-->
      <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/js/demo/datatables-demo.js'); ?>"></script>
      <script src="<?php echo base_url('assests/js/demo/chart-area-demo.js'); ?>"></script>
   </body>
</html>