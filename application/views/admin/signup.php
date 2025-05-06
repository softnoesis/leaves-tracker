<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin - Signup</title>
      <meta name="robots" content="noindex, nofollow">
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
   </head>
   <body class="bg-dark">
      <div class="container">
         <div class="card card-register mx-auto mt-5">
           <center><div class="card-header">Register As  Company Account</div></center>
            <div class="card-body">
               <?php if ($this->session->flashdata('error')) { ?>
               <p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('error');?></p>
               <?php } ?> 

               <div class="card-body">
                  <?php echo form_open('admin/Signup/register');?>
                  <div class="form-group">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'company_name','id'=>'company_name','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('company_name')]);?>
                        <?php echo form_label('Enter your Company Name', 'company_name'); ?>
                        <?php echo form_error('company_name',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'emailid','id'=>'emailid','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('emailid')]);?>
                        <?php echo form_label('Enter your Email', 'emailid'); ?>
                        <?php echo form_error('emailid',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="form-label-group">
                        <?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('password')]);?>
                        <?php echo form_label('Enter your Password', 'password'); ?>
                        <?php echo form_error('password',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>


                  <?php echo form_submit(['name'=>'Register','value'=>'Create my account','class'=>'btn btn-primary btn-block']); ?>
                  <?php echo form_close(); ?>
                  </form>
                  <div class="text-center">
                     <a class="d-block small mt-3" href="<?php echo site_url('admin/Login'); ?>">Login Page</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
   </body>
</html>