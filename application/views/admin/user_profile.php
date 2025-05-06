<!DOCTYPE html>
<html lang="en">
   <head>
      <title>My Profile</title>
      <meta name="robots" content="noindex, nofollow">
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>

      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
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
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">User</a>
                  </li>
                  <li class="breadcrumb-item active">My Profile</li>
               </ol>
               <!-- Page Content -->
                  <!-- <h1><b><?php echo $profile->name; ?></h1> -->
               <hr>
               <!---- Success Message ---->
               <?php if ($this->session->flashdata('success')) { ?>
                  <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('success');?>
                  </div>
               <?php }?>
               <!---- Error Message ---->
               <?php if ($this->session->flashdata('error')) { ?>
                  <div class="alert alert-danger" role="alert">
                    <?php echo $this->session->flashdata('error');?>
                  </div>
               <?php }?> 
               <h3><b><?php echo $profile->name; ?></h3>
               <h6><?php echo $profile->designation; ?></h6></b>  
               <p style="background-color:<?php echo $profile->member_color;?>; width: 50%;">MEMBER COLOR</p>
               <hr>
            <?php echo form_open_multipart('admin/Member/updateprofile');?>
            <!-- <p> <strong>Reg Date :</strong> <?php echo $profile->regDate; ?> -->
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php $image = $profile->image ? $profile->image : 'default.png' ;?>
                        <input type="file" id="profile_image" name="profile_image">
                        <img src="<?php echo base_url()?>image/<?php echo $image;?>" height='auto' width='80'/>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'name','id'=>'name','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('name',$profile->name)]);?>
                        <?php echo form_label('Enter your Name', 'name'); ?>
                        <?php echo form_error('name',"<div style='color:red'>","</div>");?> 
                     </div>
                  </div>
               </div>
            </div>
             <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name '=>'designation','id'=>'designation ','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('designation',$profile->designation )]);?>
                        <?php echo form_label('Enter your designation ','designation '); ?>
                        <?php echo form_error('designation',"<div style='color:red'>","</div>");?> 
                     </div>
                  </div>
               </div>
            </div> 
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <input type="text" id="date_of_birth" name="date_of_birth" class="form-control" value="<?php echo $profile->date_of_birth; ?>">
                        <?php echo form_label('Enter your date of birth ','date of birth '); ?>
                        <?php echo form_error('date_of_birth',"<div style='color:red'>","</div>");?> 
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('email',$profile->email)]);?>
                        <?php echo form_label('Enter your Email', 'email'); ?>
                        <?php echo form_error('email',"<div style='color:red'>","</div>");?>
                        <span id="msg" style="color: red;"></span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <textarea id="address" name="address" placeholder="Enter Address" class="form-control"style="height:100px;"><?php echo $profile->address; ?></textarea>
                        <?php echo form_error('address',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'city','id'=>'city','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('city',$profile->city)]);?>
                        <?php echo form_label('Enter your City', 'city'); ?>
                        <?php echo form_error('city',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'state','id'=>'state','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('state',$profile->state)]);?>
                        <?php echo form_label('Enter valid state', 'state'); ?>
                        <?php echo form_error('state',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'country','id'=>'country','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('country',$profile->country)]);?>
                        <?php echo form_label('Enter valid country', 'country'); ?>
                        <?php echo form_error('country',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <div class="form-label-group">
                        <?php echo form_input(['name'=>'phone_no','id'=>'phone_no','class'=>'form-control','autofocus'=>'autofocus','value'=>set_value('phone_no',$profile->phone_no)]);?>
                        <?php echo form_label('Enter phone No', 'phone_no'); ?>
                        <?php echo form_error('phone_no',"<div style='color:red'>","</div>");?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="form-row">
                  <div class="col-md-6">
                     <p style="background-color:<?php echo $profile->member_color;?>; width: 50%;">Profile Color</p>
                     <div class="form-group">
                        <input type="color" name="profilecolor" id="profilecolor" value="<?php echo $profile->member_color;?>">
                     </div>
                  </div>
               </div>
            </div>
            <div class="form-row">
               <div class="col-md-6">  
                  <?php echo form_submit(['name'=>'Update','value'=>'Update','class'=>'btn btn-primary btn-block']); ?>
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
      <!-- Bootstrap core JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <!-- Core plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
      <!-- Custom scripts for all pages-->
      <script src="<?php echo base_url('assests/js/sb-admin.min.js '); ?>"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
   </body>
</html>
<style type="text/css">
   #profile_image
   {
   margin-left:-1px;
   }
</style>
<script type="text/javascript">
   $('#date_of_birth').datepicker();
   $(document).on('change','#email',function(){
        var email = $("#email").val();
          jQuery.ajax({
            type:"post",
            url: "<?php echo base_url(); ?>user/User_profile/filename_exists",
            data:{ 'email':email},
            success: function(response) {
              console.log(response);
              if(response == "1")
              {
                $("#msg").text("Email is already exist!");
              }
              else
              {
                $("#msg").text("");
              }
             }
          });
      });
</script>