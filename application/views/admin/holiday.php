<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>Admin - Holiday</title>
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
      <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"> -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
   </head>
   <body id="page-top">
      <?php include APPPATH.'views/admin/includes/header.php';?>
      <div id="wrapper">
         <?php include APPPATH.'views/admin/includes/sidebar.php';?>
         <div id="content-wrapper">
            <div class="container-fluid">
               <!-- Breadcrumbs-->
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">User</a>
                  </li>
                  <li class="breadcrumb-item active">Holiday</li>
               </ol>
               <!-- Page Content -->
               <h1><b>Holiday</h1>
               </b>
               <hr>
               <div class="">
                  <a href="#addAdmin_holiday_Model" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-square"></i> <span>Add Holiday</span></a>
               </div>
               <br>
               <!---- Success Message ---->
               <?php if ($this->session->flashdata('success')) { ?>
               <div class="alert alert-success" role="alert">
               <?php echo $this->session->flashdata('success'); ?>                           
               </div>
               <?php }?>
            <?php
            
             
            $today = new DateTime();
            $last_year = (new DateTime())->sub(new DateInterval('P1Y'));
            $previous_year = date("Y", strtotime("-2 years"));
            // $next_year = date("Y", strtotime("+ years"));

            $next_year = (new DateTime())->add(new DateInterval('P1Y'));
            ?>
            <div class="tab-content card pt-5" id="myTabContentMD" style="padding: 5px;">
               <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
                        aria-selected="true">Holidays For <?php echo $today->format('Y'); ?> </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
                        aria-selected="false">Holidays For <?php echo $last_year->format('Y'); ?> </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
                        aria-selected="false">Holidays For <?php echo $previous_year ?> </a>
                  </li>
               </ul>
               <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
                  <table class="table table-bordered" id="curremt_year" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($current_year_holidays)) :
                           $cnt=1; 
                           foreach ($current_year_holidays as $current_year_holidays_row) :
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($current_year_holidays_row->date)?></td>
                           <td><?php echo date('d F, Y l',strtotime($current_year_holidays_row->date))?></td>
                           <td><?php echo htmlentities($current_year_holidays_row->name)?></td>
                           <td>
                              <a title="Edit" href="<?php echo site_url()?>admin/holiday/adminedit/<?php echo $current_year_holidays_row->id;?>" data-getueid="<?php print $current_year_holidays_row->id;?>"  data-toggle="modal"data-target="#editAdmin_holiday_Model" id="update-emp-details"><i class="fa fa-edit"></i></a> |  
                              <?php echo  anchor("admin/holiday/deleteadmin/{$current_year_holidays_row->id}",' ','class="fa fa-trash"')?>
                           </td>
                        </tr>
                        <?php 
                           $cnt++;
                           endforeach;
                           else : ?>
                        <tr>
                           <td colspan="6">No Record found</td>
                        </tr>
                        <?php
                           endif;
                           ?>                
                     </tbody>
                  </table>
               </div>
               <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                  <table class="table table-bordered" id="next_year" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($previous_year_holidays)) :
                           $cnt=1; 
                           foreach ($previous_year_holidays as $row_previous_year_holidays) :
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($row_previous_year_holidays->date)?></td>
                           <td><?php echo date('d F, Y l',strtotime($row_previous_year_holidays->date))?></td>
                           <td><?php echo htmlentities($row_previous_year_holidays->name)?></td>
                           
                           <td><a title="Edit" href="<?php echo site_url()?>admin/holiday/adminedit/<?php echo $row_previous_year_holidays->id;?>" data-getueid="<?php print $row_previous_year_holidays->id;?>" id="update-emp-details"  data-toggle="modal"data-target="#editAdmin_holiday_Model"><i class="fa fa-edit"></i></a> | 
                              <?php echo  anchor("admin/holiday/deleteadmin/{$row_previous_year_holidays->id}",' ','class="fa fa-trash"')?>
                           </td>
                        </tr>
                        <?php 
                           $cnt++;
                           endforeach;
                           else : ?>
                        <tr>
                           <td colspan="6">No Record found</td>
                        </tr>
                        <?php
                           endif;
                           ?>                
                     </tbody>
                  </table>
               </div>
               <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                  <table class="table table-bordered" id="previous_year" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Day</th>
                           <th>Holiday Name</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($previous_year_holidays1)) :
                           $cnt=1; 
                           foreach ($previous_year_holidays1 as $row_previous_year_holidays1) :
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($row_previous_year_holidays1->date)?></td>
                           <td><?php echo date('d F, Y l',strtotime($row_previous_year_holidays1->date))?></td>
                           <td><?php echo htmlentities($row_previous_year_holidays1->name)?></td>
                           
                           
                           <td><a title="Edit" href="<?php echo site_url()?>admin/holiday/adminedit/<?php echo $row_previous_year_holidays1->id;?>" data-getueid="<?php print $row_previous_year_holidays1->id;?>" id="update-emp-details" data-toggle="modal"data-target="#editAdmin_holiday_Model"><i class="fa fa-edit"></i></a> | 
                              <?php echo  anchor("admin/holiday/deleteadmin/{$row_previous_year_holidays1->id}",' ','class="fa fa-trash"')?>
                           </td>
                        </tr>
                        <?php 
                           $cnt++;
                           endforeach;
                           else : ?>
                        <tr>
                           <td colspan="6">No Record found</td>
                        </tr>
                        <?php
                           endif;
                           ?>                
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div>
      <!-- ----------------------Add------------- -->
      <div id="addAdmin_holiday_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="post" id="insert-form" name="insert" enctype="multipart/form-data" action="<?php echo site_url('admin/holiday/insert'); ?>">
                  <div class="modal-header">
                     <h4 class="modal-title">Add Holiday</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" id="edit_holiday_date" class="form-control" placeholder="Enter Holiday Date" required>
                        
                     </div>
                     <div class="form-group">
                        <label>Holiday Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Holiday Name" required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Add">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- ----------------Edit------------ -->
      <div id="editAdmin_holiday_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="post" enctype="multipart/form-data" action="<?php echo site_url()?>admin/holiday/updatedata">
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Holiday</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="update_id" id="update_id" value="">
                  <div class="modal-body">
                     <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" id="holiday_date" value="" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label>Holiday Name</label>
                        <input type="text" name="name" id="name_edit" value="" class="form-control" required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
<!-- /.container-fluid -->
<!-- Sticky Footer -->
<?php echo form_close();?>
<!-- /.container-fluid -->
<!-- Sticky Footer -->
<?php include APPPATH.'views/admin/includes/footer.php';?>
<!-- /.content-wrapper -->
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
<script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
<!-- Custom scripts for all pages-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
<script type="text/javascript">
   $(document).ready(function() {
      $("#holiday_date").datepicker();
      $("#edit_holiday_date").datepicker();
      $('#curremt_year').DataTable();
      $('#next_year').DataTable();
      $('#previous_year').DataTable();
   });
   jQuery(document).on('click', '#update-emp-details', function(){
     var id = jQuery(this).data('getueid');
     $.ajax({
         type: "get",
         async: false,
         url: "<?= site_url('admin/holiday/edit') ?>/" + id,
         dataType: "json",
         data : {"id" : id},
         success: function (res) {
            console.log(res);
            $('#holiday_date').val(res.date);
            $('#name_edit').val(res.name);
            $('#update_id').val(res.id); 
         }
     });
   });
   $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
         localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
         $('#myTabMD a[href="' + activeTab + '"]').tab('show');
      }
   });
</script>