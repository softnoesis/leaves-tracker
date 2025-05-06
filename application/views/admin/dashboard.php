<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>Admin - Dashboard</title>
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
                  <li class="breadcrumb-item active">Dashboard</li>
               </ol>
               <div role="alert" id="success_msg"></div>
                <?php if ($this->session->flashdata('massage')) { ?>
                  <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('massage');?>
                  </div>
                <?php }?>
            <div class="tab-content card pt-5" id="myTabContentMD" style="padding: 5px;">
               <ul class="nav nav-tabs md-tabs" id="mydashboard" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
                        aria-selected="true">Pending Leaves</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
                        aria-selected="false">Approved Leaves</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="reject-tab-md" data-toggle="tab" href="#reject-md" role="tab" aria-controls="reject-md"
                        aria-selected="false">Rejected Leaves</a>
                  </li>
               </ul>
               <!-- Pending Leaves -->
               <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th style="width: 100px;">Start Date</th>
                           <th style="width: 100px;">End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Requested Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th style="width: 100px;">Start Date</th>
                           <th style="width: 100px;">End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Requested Date</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                          $userid = $this->session->userdata('adid');
                          $this->db->select('role_id');
                          $this->db->from('member');
                          $this->db->where('user_id',$userid);
                          $role_id = $this->db->get()->row();
                          
                          if(count($pending)) :
                            $cnt=1; 
                            foreach ($pending as $row) :
                              
                              if($row->half_day == 0)
                              {
                                  $duration_total = "0.5";
                                  $end_date_s = $row->startdate;
                              }
                              else
                              {
                                 $date1 = $row->startdate;
                                 $date2 = $row->enddate;
                             
                                 $diff = abs(strtotime($date2) - strtotime($date1));
                             
                                 $years = floor($diff / (365*60*60*24));
                                 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                 $duration_total = $days + 1; 
                                 $end_date_s = $row->enddate;
                              }
                              if($duration_total == 1 ||$duration_total == 0.5)
                              {
                                $day=" Day";
                              }
                              else
                              {
                                $day=" Days";
                              }
                           ?>  
                          <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($row->name)?></td>
                            <td><?php echo htmlentities($row->leavetype)?></td>
                            <td><?php echo htmlentities(date('d-m-Y',strtotime($row->startdate)))?></td>
                            <td><?php echo htmlentities(date('d-m-Y',strtotime($end_date_s)))?></td>
                            <td><?php echo htmlentities($duration_total. $day)?></td>
                            <td><?php echo htmlentities($row->reason)?></td>
                            <td><?php echo htmlentities(date("d-m-Y", strtotime($row->created_at)))?></td>
                            <?php if($row->role_id == 2 && $role_id->role_id == 2) {?>
                              <td></td>
                            <?php }else{ ?>
                            <td>
                              <a href="javascript:void(0);" onclick="changeStatus(<?php echo $row->id ?>,1)"><button class="cls_accept">ACCEPT</button></a>  
                              <a title="REJECT Leave" href="<?php echo site_url()?>admin/member/updatedata/<?php echo $row->id;?>" data-getueid="<?php echo $row->id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_member_Model"><button class="cls_reject">REJECT</button></a>
                              <!-- <a href="javascript:void(0);" onclick="changeStatus(<?php echo $row->id ?>,2)"><button class="cls_reject">REJECT</button></a> -->
                            </td>
                            <?php }?>
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
               <!-- Approval Leaves -->               
               <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                  <table class="table table-bordered" id="myholiday" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Approved By</th>
                           <th>Requested Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Approved By</th>
                           <th>Requested Date</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                            if(count($upcoming)) :
                              $cnt=1; 
                              $currentDate = date('Y-m-d');
                              foreach ($upcoming as $row_leavesnext1) :
                              $startDate = date('Y-m-d', strtotime($row_leavesnext1->startdate));
                              if($row_leavesnext1->half_day == 0)
                              {
                                $duration_total = "0.5";
                              }
                              else
                              {
                                
                                 $date1 =$row_leavesnext1->startdate;
                                 $date2 =$row_leavesnext1->enddate;
                           
                                 $diff = abs(strtotime($date2) - strtotime($date1));
                           
                                 $years = floor($diff / (365*60*60*24));
                                 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                 $duration_total = $days + 1; 
                              }
                              if($duration_total == 1 ||$duration_total == 0.5)
                              {
                                $day=" Day";
                              }
                              else
                              {
                                $day=" Days";
                              }
                        ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($row_leavesnext1->name)?></td>
                           <td><?php echo htmlentities($row_leavesnext1->leavetype)?></td>
                           <td style="width:82px"><?php echo htmlentities(date('d-m-Y',strtotime($row_leavesnext1->startdate)))?></td>
                           <td style="width:82px"><?php echo htmlentities(date('d-m-Y',strtotime($row_leavesnext1->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total.$day)?></td>
                           <td><?php echo htmlentities($row_leavesnext1->reason)?></td>
                           <td><?php echo htmlentities($row_leavesnext1->approved_name)?></td>
                           <td><?php echo htmlentities(date("d-m-Y", strtotime($row_leavesnext1->created_at)))?></td>
                           <?php
                          if($row_leavesnext1->role_id == 2 && $role_id->role_id == 2 || $startDate <= $currentDate) { ?>
                              <td></td>
                          <?php } else { ?>
                            <td> 
                              <a href="javascript:void(0);" onclick="changeStatus(<?php echo $row_leavesnext1->id ?>,2)">
                                <button class="cls_reject">REJECT</button>
                              </a>
                            </td>
                          <?php } ?>
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
               <!-- Recejct -->
               <div class="tab-pane fade" id="reject-md" role="tabpanel" aria-labelledby="profile-tab-md">
                  <table class="table table-bordered" id="rejecttbl" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Rejected By</th>
                           <th>Requested Date</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Rejected By</th>
                           <th>Requested Date</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($reject)) :
                           $cnt=1; 
                           foreach ($reject as $row_leavesnext2) :
                              if($row_leavesnext2->half_day == 0)
                            {
                                $duration_total = "0.5";
                            }
                            else
                            {
                           
                             $date1 =$row_leavesnext2->startdate;
                               $date2 =$row_leavesnext2->enddate;
                           
                           
                               $diff = abs(strtotime($date2) - strtotime($date1));
                           
                               $years = floor($diff / (365*60*60*24));
                               $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                               $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                               $duration_total = $days + 1; 
                            }
                             if($duration_total == 1 ||$duration_total == 0.5)
                            {
                              $day=" Day";

                            }
                            else
                            {
                              $day=" Days";
                            }

                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($row_leavesnext2->name)?></td>
                           <td><?php echo htmlentities($row_leavesnext2->leavetype)?></td>
                           <td><?php echo htmlentities(date("d-m-Y", strtotime($row_leavesnext2->startdate)))?></td>
                           <td><?php echo htmlentities(date("d-m-Y", strtotime($row_leavesnext2->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total.$day)?></td>
                           <td><?php echo htmlentities($row_leavesnext2->reason)?></td>
                           <td><?php echo htmlentities($row_leavesnext2->approved_name)?></td>
                           <td><?php echo htmlentities(date("d-m-Y",strtotime($row_leavesnext2->created_at)))?></td>
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
   </body>
</html>
<div id="editAdmin_member_Model" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
            echo form_open_multipart("admin/Member/reject_leave", $attrib); ?>
            <div class="modal-header">
               <h4 class="modal-title">Reject leave reason </h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <input type="hidden" name="leave_id" id="leave_id" value="">
            <div class="modal-body">
               <div class="form-group">
                  <label>Reason</label>
                  <textarea id="reason" name="reason" class="form-control" required="required" placeholder="Write your Reason..." style="height:100px;"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <input type="submit" class="btn btn-success" name="edit_member" value="Submit">
            </div>
            <?php echo form_close(); ?>
      </div>
   </div>
</div>
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
<script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
<!-- Custom scripts for all pages-->
<script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
<style type="text/css">
   .cls_accept {
   border: none;
   color: white;
   padding: 10px 20px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 15px;
   margin: 4px 2px;
   cursor: pointer;
   background-color: green;
   font-weight: bold;
   }
   .cls_reject {
   border: none;
   color: white;
   padding: 10px 20px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 15px;
   margin: 4px 2px;
   cursor: pointer;
   background-color: red;
   font-weight: bold;
   }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dataTable').DataTable();
    $('#myholiday').DataTable();
    $('#rejecttbl').DataTable();
  });
  $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
         localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab){
         $('#mydashboard a[href="' + activeTab + '"]').tab('show');
      }
   });
  jQuery(document).on('click', '#update-emp-details', function(){
    var id = jQuery(this).data('getueid');
    $("#leave_id").val(id);                  
  });
  function changeStatus(id,leave_status)
  {
    var x=confirm("Are you sure, you want to approved the leave!!")
    if (x) 
    {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>admin/Dashboard/update_status",
        data: {'id' :id,'status' :leave_status},
        success: function(data){
          location.reload();
        }
      });
    } 
    else
    {
        return false;
    }
  }
</script>