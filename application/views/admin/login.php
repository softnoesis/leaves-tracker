<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="robots" content="noindex, nofollow">
    <title>Login</title>
<link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
<?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
<?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
<?php echo link_tag('assests/css/sb-admin.css'); ?>
  </head>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <center>
          <!-- <div class="card-header">Login</div> -->
          <a class="navbar-brand mr-1" href="<?php echo base_url(); ?>" style="margin-left: -29px;"><img class="nav-link" src="<?php echo base_url(); ?>image/leaves1.png" alt=""></a>
        </center>
 
        <!---- Error Message ---->
          <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
          <?php echo $this->session->flashdata('error');?>
            </div>
          <?php } ?>
          <?php if ($this->session->flashdata('massage')) { ?>
            <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('massage');?>
            </div>
          <?php } ?>
        <!---- Error Message ---->
        <div class="card-body">
          <?php echo form_open('admin/login');?>
            <div class="form-group">
              <div class="form-label-group">
                <?php echo form_input(['name'=>'emailid','id'=>'emailid','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('emailid')]);?>
                <?php echo form_label('Enter Email Id', 'emailid'); ?>
                <?php echo form_error('emailid',"<div style='color:red'>","</div>");?>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('password')]);?>
                <?php echo form_label('Password', 'password'); ?>
                <?php echo form_error('password',"<div style='color:red'>","</div>");?>
              </div>
            </div>
            <?php echo form_submit(['name'=>'login','value'=>'Login','class'=>'btn btn-primary btn-block']); ?>
              <center><a class="d-block small" href="<?php echo site_url('admin/Login/forgot_pass'); ?>">Forgot Your Password?</a></center>
              <center><a class="d-block small" href="<?php echo site_url('admin/signup'); ?>">Need An Acccount?</a></center>
            <?php echo form_close(); ?>
            <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    //setInterval(function(){ sendBirthdayEmail() }, 3600000);
    //setInterval(function(){ sendEmail() }, 6200000);
  });
  function sendEmail()
  {
      $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>admin/Login/SendemailForMemberLeaves",
      success: function(data){
      }
    });
  }
  function sendBirthdayEmail()
  {
      $.ajax({
         type: "POST",
         url: "<?php echo base_url(); ?>admin/Login/send_birthday_notification_one_day_before",
      success: function(data){
      }
    });
  }
</script>