<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>Company Profile</title>
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
      <meta name="robots" content="noindex, nofollow">


   </head>
   <body id="page-top">
      <?php
         $admin_id = $this->session->userdata('adid');
         $this->db->select("role_id");
         $this->db->from("member");
         $this->db->where('user_id',$admin_id);
         $user_id_new=$this->db->get()->row();
      ?>
      <?php include APPPATH.'views/admin/includes/header.php';?>
      <div id="wrapper">
         <?php include APPPATH.'views/admin/includes/sidebar.php';?>
         <div id="content-wrapper">
            <div class="container-fluid">
               <!-- Breadcrumbs-->
            <?php if($user_id_new->role_id == 1){ ?>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a>
                  </li>
                  <li class="breadcrumb-item active">Company Profile</li>
               </ol>
            <?php }else{ ?>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">HR</a>
                  </li>
                  <li class="breadcrumb-item active">Company Profile</li>
               </ol>
            <?php } ?>
            
                <!-- <h1><b>Company Profile</h1></b> -->
                  <hr>
            <?php if ($this->session->flashdata('success')) { ?>
               <div class="alert alert-success" role="alert">
                  <?php echo $this->session->flashdata('success'); ?>
               </div>
            <?php } ?>
            </div>
            <?php echo form_open('admin/companyprofile/updateprofile');?>
            <!-- <p> <strong>Reg Date :</strong> <?php echo $profile->regDate; ?> -->
            <!-- <?php echo "<pre>";print_r($profile);echo "</pre>"; ?> -->
            <div class="container">
               <div id="compay_pro">
                  <div class="box box-primary">
                     <div class="box-body box-profile">
                        <?php $images = $profile->image ? $profile->image : 'default.png'; ?>
                        <center>
                           <img class="profile-user-img img-responsive img-circle cls_images" src="<?php echo base_url(); ?>image/<?php echo $images;?>">
                        </center> 
                        <h3 class="text-muted text-center"><?php echo $profile->company_name;?></h3>
                        <ul class="list-group list-group-unbordered">
                           <li class="list-group-item" id="cls_company_name">
                              <div class="col-md-3">
                                 <b>Company</b>    
                              </div>
                              <div class="col-md-8" id="cls_company">
                                 <a class="pull-right"><?php echo $profile->company_name;?></a>
                              </div>
                           </li>
                           <li class="list-group-item" id="cls_phone">
                              <div class="col-md-3">
                                 <b>Website</b>    
                              </div>
                              <div class="col-md-8" id="cls_company">
                                 <a class="pull-right"><?php echo $profile->website_name;?></a>
                              </div>
                           </li>
                           <li class="list-group-item" id="cls_phone">
                              <div class="col-md-3">
                                 <b>Email</b>    
                              </div>
                              <div class="col-md-8" id="cls_company">
                                 <a class="pull-right"><?php echo $profile->emailid; ?></a>
                              </div>
                           </li>
                           <li class="list-group-item" id="cls_phone">
                              <div class="col-md-3">
                                 <b>Phone No</b>    
                              </div>
                              <div class="col-md-8" id="cls_company">
                                 <a class="pull-right"><?php echo $profile->phone_no; ?></a>
                              </div>
                           </li>
                           <li class="list-group-item" id="cls_address">
                              <div class="col-md-3">
                                 <b>Address</b>    
                              </div>
                              <div class="col-md-8" id="cls_company">
                                 <a class="pull-right"><?php echo $profile->address; ?></a>
                              </div>
                           </li>
                        </ul>
                        <?php if($user_id_new->role_id == 2){ ?>
                           <a href="#" class="btn btn-primary btn-block cls_submit_hr" data-target="#addAdmin_holiday_Model" data-toggle="modal" data-getueid="<?php echo $profile->id; ?>" id="update-emp-details"><span>Update Proflie</span></a>
                        <?php }else { ?>
                           <a href="#" class="btn btn-primary btn-block cls_submit_admin" data-target="#addAdmin_holiday_Model" data-toggle="modal" data-getueid="<?php echo $profile->id; ?>" id="update-emp-details"><span>Update Proflie</span></a>
                        <?php } ?>
                     </div>
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
      <div id="addAdmin_holiday_Model" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
            <form method="post" id="insert-form" name="insert" enctype="multipart/form-data" action="<?php echo site_url('admin/companyprofile/updateprofile'); ?>">
               <div class="modal-header">
                  <h4 class="modal-title">Companyproflie</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <input type="hidden" name="update_id" id="update_id" value="">
               <div class="modal-body">
                  <div class="form-group">
                     <label></label>
                     <input type="file" name="images" id="image" onchange="readURL(this);" class="form-control" style="border: none; width: 230px;">
                     <div id="imagedisplay">
                     </div>
                     <img id="blah" src="#" style="border: none; width: 230px; display: none;" />
                     <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Website</label>
                        <input type="text" name="website_name" id="website_name" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Company Email</label>
                        <input type="text" name="emailid" id="emailid" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Phone No</label>
                        <input type="text" name="phone_no" id="phone_no" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" id="address" class="form-control"> </textarea>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" name="submit" class="btn btn-success" value="UpdateProflie">
                  </div>
            </form>
            </div>
         </div>
      </div>
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <!-- Core plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
      <!-- Page level plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
      <!-- Custom scripts for all pages-->
      <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/js/demo/datatables-demo.js'); ?>"></script>
   </body>
</html>
<script type="text/javascript">
   jQuery(document).on('click','#update-emp-details', function(){
     var id = jQuery(this).data('getueid');
     $.ajax({
         type: "get",
         async: false,
         url: "<?= site_url('admin/companyprofile/add') ?>/" + id,
         dataType: "json",
         data : {"id" : id},
         success: function (res) {
           console.log(res);
           var site_url = "<?php echo base_url(); ?>";
           $('#company_name').val(res.company_name);
           $('#website_name').val(res.website_name);
           $('#emailid').val(res.emailid);
           $('#phone_no').val(res.phone_no);
           $('#address').val(res.address);
           $("#update_id").val(res.id); 
           var images = res.image ? res.image : 'default.png'; 
           document.getElementById("imagedisplay").innerHTML = "<img src='"+site_url+"image/"+images+"' width=\"250px\" style=\"border-radius:130px;\" height=\"auto\"/>"; 
         }
     });        
   });
   function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
               $('#imagedisplay').remove();
               $("#blah").show();
               $('#blah').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
   }
</script>
<style type="text/css">
   table, th, td {
      border: 1px solid black;
   }
   table {
      width: 100%;
   }
   #cls_company{
      float: right;margin-top: -30px;
   }
   .cls_images{
      height: auto; width: 150px; border-radius: 60px;
   }
   .cls_submit_hr{
      margin: 321px; margin-top: -311px; width: 470px; height: 40px; display: none;
   }
   .cls_submit_admin{
      margin: 321px; margin-top: -311px; width: 470px; height: 40px
   }
   #cls_phone{
      margin: 321px;margin-top: -311px;height: 47px;
   }
   #cls_company_name{
      margin: 321px;margin-top: 13px;  
   }
   #cls_address{
      margin: 321px;margin-top: -311px;
   }
</style>