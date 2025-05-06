<!DOCTYPE html>
<html lang="en">
  <head>
     <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
    <title>companyprofile</title>
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
   <?php include APPPATH.'views/user/includes/header.php';?>
    <div id="wrapper">
      <!-- Sidebar -->
      <?php include APPPATH.'views/user/includes/sidebar.php';?>
      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('user/Dashboard'); ?>">User</a>
            </li>
            <li class="breadcrumb-item active">companyprofile</li>
          </ol>
          <hr>
          <!---- Success Message ---->
          <?php if ($this->session->flashdata('success')) { ?>
          <p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
          </div>
          <?php } ?>
          <!---- Success Message ---->
          <?php echo form_open('user/companyprofile/updateprofile');?>
            <div class="container">
              <div id="compay_pro">
                <div class="box box-primary">
                  <div class="box-body box-profile">
                    <?php $company_image = $com_profile->company_image ? $com_profile->company_image :'default.png'; ?>
                    <center>
                      <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>image/<?php echo $company_image; ?>" style="height: auto;border-radius: 120px;" width='150' alt="Company profile">
                    </center>
                    <h3 class="text-muted text-center"><?php echo $com_profile->company_name; ?></h3>
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item"style="margin: 321px;margin-top: 13px;">
                        <b>Company Name</b> <a class="pull-right"style="margin:40px;"><?php echo $com_profile->company_name; ?></a>
                      </li>
                      <li class="list-group-item" style="margin: 321px;margin-top: -311px;height: 47px;">
                        <p><b>Website Name</b><a class="pull-right" style="margin:50px;"target="_blank" href="<?php echo $com_profile->website_name ?>"><?php echo $com_profile->website_name; ?></a></p>
                      </li>
                      <li class="list-group-item"style="margin: 321px;margin-top: -313px;height: 47px;">
                        <b>Company Email</b> <a style="margin-left: 37px;" href="mailto:contact@softnoesis.com" class="pull-right"><?php echo $com_profile->emailid; ?></a>
                      </li>
                      <li class="list-group-item"style="margin: 321px;margin-top: -311px;height: 47px;">
                        <b>Phone No</b> <a style="margin:79px;"href="tel:9033482030" class="pull-right"><?php echo $com_profile->phone_no; ?></a>
                      </li>
                      <li class="list-group-item"style="margin: 321px;margin-top: -311px;">
                      <div class="col-md-3">
                        <b style="margin: -11px;">Address</b> 
                      </div>
                      <div class="col-md-8" style="float: right;margin-top: -30px;">
                        <a class="pull-right"><?php echo $com_profile->address; ?></a>
                      </div>
                      </li>
                    </ul>     
                  </div>
                </div>
              </div>
           </div>
          <?php echo form_close();?>
        </div>
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
     <?php include APPPATH.'views/user/includes/footer.php';?>
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
  <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assests/js/sb-admin.min.js '); ?>"></script>
  </body>
</html>