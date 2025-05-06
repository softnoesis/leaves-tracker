<!DOCTYPE html>
<html lang="en">
  <head>
     <meta name="robots" content="noindex, nofollow">
    <title>Login</title>
    <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
    <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
    <?php echo link_tag('assests/css/sb-admin.css'); ?>
  </head>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Member Login</div>
        <!---- Error Message ---->
          <?php if ($this->session->flashdata('error')) { ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('error');?>
          </div>
          <?php } ?>  
        <div class="card-body">
          <?php echo form_open('user/login');?>
            <div class="form-group">
              <div class="form-label-group">
                <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('email')]);?>
                <?php echo form_label('Enter valid email id', 'email'); ?>
                <?php echo form_error('email',"<div style='color:red'>","</div>");?>
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
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
   <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  </body>
</html>