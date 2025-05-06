<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin - Signup</title>
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
   </head>
   <body class="bg-dark">
      <div class="container">
         <div class="card card-register mx-auto mt-5">
           <center><div class="card-header">Forgot Password</div></center>
            <div class="card-body">
               <?php if ($this->session->flashdata('error')) { ?>
               <p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('error');?></p>
               <?php } ?> 

               <div class="card-body">
                  <?php echo form_open('admin/Login/changepassword');?>
                  <input type="hidden" name="hdn_forgot_code" id="hdn_forgot_code" value="<?php echo $q; ?>">
                  <div class="form-group">
                     <div class="form-label-group">
                        <?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('password')]);?>
                        <?php echo form_label('New Password', 'password'); ?>
                        <?php echo form_error('password',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-label-group">
                        <?php echo form_password(['name'=>'confirmpassword','id'=>'confirmpassword','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('confirmpassword')]);?>
                        <?php echo form_label('Confirm Password', 'confirmpassword'); ?>
                        <?php echo form_error('confirmpassword',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
                  <?php echo form_submit(['name'=>'Submit','value'=>'Change Password','class'=>'btn btn-primary btn-block']); ?>
                  <?php echo form_close(); ?>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
   </body>
</html>