<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="robots" content="noindex, nofollow">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>Admin dashboard</title>

      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?> 
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/djibe/clockpicker@1d03466e3b5eebc9e7e1dc4afa47ff0d265e2f16/dist/bootstrap4-clockpicker.min.css">
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
               <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success" role="alert">
                  <?php echo $this->session->flashdata('success');?>
                </div>
              <?php }?>
                <?php
                  $userid = $this->session->userdata('uid');
                  $this->db->select('company_id');
                  $this->db->from('member');
                  $this->db->where('user_id',$userid);
                  $company_id = $this->db->get()->row();

                  $this->db->select('sum(duration) as duration');
                  $this->db->from('leaves_policy');
                  $this->db->where('company_id',$company_id->company_id);
                  $duration = $this->db->get()->result();

                  $this->db->select('sum(duration) as total_leaves');
                  $this->db->from('leaves');
                  $this->db->where('leave_status',1);
                  $this->db->where('user_id',$userid);
                  $teken_leaves = $this->db->get()->result();
                 ?>
             <div class="tab-content card pt-5" id="myTabContentMD">
               <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Members Name</th>
                           <th>Leave Type</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Duration</th>
                           <th>Reason</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($leaves)) :
                           $cnt=1; 
                           foreach ($leaves as $row_leaves) :
                            if($row_leaves->half_day == 0)
                            {
                              $start_date = $row_leaves->startdate;
                              $expire = strtotime($start_date);
                              $today = strtotime("today midnight");
                            }
                            else
                            {
                              $end_date = $row_leaves->enddate;
                              $expire = strtotime($end_date);
                              $today = strtotime("today midnight");
                            }
                            if($row_leaves->leave_status == 0)
                            {
                               $status = "Pending";
                            }
                            else if($row_leaves->leave_status == 1)
                            {
                               $status = "Approved";
                            }
                            else if($row_leaves->leave_status == 0 && $today >= $expire)
                            {
                               $status =  "expired";
                            }
                            else if($row_leaves->leave_status == 2)
                            {
                                $status = "Decline"; 
                            }
                            else
                            {
                               $status = "Cancelled";
                            }
                            if($row_leaves->half_day == 0)
                            {
                                $duration_total = "0.5 day";
                            }
                            else
                            {
                               $date1 =$row_leaves->startdate;
                               $date2 =$row_leaves->enddate;
                           
                               $diff = abs(strtotime($date2) - strtotime($date1));
                           
                               $years = floor($diff / (365*60*60*24));
                               $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                               $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                               $duration_total = $days + 1; 
                            }                      
                           ?>  
                        <tr>
                          <td><?php echo htmlentities($cnt);?></td>
                          <td><?php echo htmlentities(date("Y-m-d", strtotime($row_leaves->created_at)))?></td>
                          <td><?php echo htmlentities($row_leaves->name)?></td>
                          <td><?php echo htmlentities($row_leaves->leave_type_name)?></td>
                          <td><?php echo htmlentities($row_leaves->startdate)?></td>
                          <td><?php echo htmlentities($row_leaves->enddate)?></td>
                          <td><?php echo htmlentities($duration_total." Days")?></td>
                          <td><?php echo htmlentities($row_leaves->reason)?></td>
                          <td><?php echo htmlentities($status)?></td>
                          <td style="width: 145px;">
                          <?php if($row_leaves->leave_status == 0) {?>
                            <a title="Cancel Leave" href="<?php echo site_url()?>admin/member/updatedata/<?php echo $row_leaves->id;?>" data-getueid="<?php echo $row_leaves->id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_member_Model"><button class="cls_accept">Cancel</button></a>
                            <a title="Edit" href="<?php echo site_url()?>admin/member/updatedata/<?php echo $row_leaves->id;?>" data-getueid="<?php echo $row_leaves->id;?>" id="edit-emp-details" data-toggle="modal" data-target="#edituser_member_Model"><button class="cls_reject">Edit</button></a>
                          <?php } else if($row_leaves->leave_status == 1) {?>
                            <!-- <a title="Cancel Leave" href="<?php echo site_url()?>admin/member/updatedata/<?php echo $row_leaves->id;?>" data-getueid="<?php echo $row_leaves->id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_member_Model"><button class="cls_accept">Cancel</button></a> -->
                          <?php } else if($row_leaves->leave_status == 2) {?>
                          <?php } else if($row_leaves->leave_status == 3) {?>
                          <?php }?>  
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
         <!-- /.container-fluid -->
         <!-- Sticky Footer -->
         <?php include APPPATH.'views/admin/includes/footer.php';?>
      </div>
      <!-- /.content-wrapper -->
      </div>
      <div id="editAdmin_member_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                  echo form_open_multipart("admin/Member/cancel_leave", $attrib); ?>
                  <div class="modal-header">
                     <h4 class="modal-title">Cancel leave reason </h4>
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
      <div id="edituser_member_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="post" enctype="multipart/form-data" action="<?php echo site_url()?>admin/Member/edit_leave">
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Leave</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="update_id" id="update_id" value="">
                  <div class="modal-body">
                      <div class="form-group">
                        <label>Leave Types</label>
                        <select name="leave_type" id="leave_type" class="form-control">
                          <?php foreach ($leave_types as $leaves_type_row) {?>
                          <option value="<?php echo $leaves_type_row->id ?>"><?php echo $leaves_type_row->leavetype ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Duration</label>
                        <div class="row">
                          <div class="col-md-6">
                            Half Day <input type="radio" id="half_day" name="half_day" value="" onchange="myFunction()">  
                          </div>
                          <div class="col-md-6">
                            Full Day <input type="radio" id="full_day" name="half_day" value="" checked="checked" onchange="fullFunction()">                        
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="clockpicker" style="display: none;">
                        <div class="row">
                          <div class="col-md-6">
                            <label for="time"class="labe1">Start Time</label>
                            <input type="text" id="start_time" name="start_time">
                          </div>
                          <div class="col-md-6">
                            <label for="time"class="labe1" style="margin-left: 10px;">End Time</label>
                            <input type="text" id="end_time" name="end_time">
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="start_date_hide">
                        <label>Start Date</label>
                        <input type="text" id="startdate" name="startdate" class="form-control" required="required">
                      </div>
                      <div class="form-group" id="end_date_hide">
                        <label>End Date</label>
                        <input type="text" id="enddate" name="enddate" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label>Reason</label>
                        <textarea id="edit_reason" name="reason" class="form-control" required="required" placeholder="Write your Reason..." style="height:100px;"></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update Leave">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <!-- Bootstrap core JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
      <!-- Custom scripts for all pages-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/djibe/clockpicker@6d385d49ed6cc7f58a0b23db3477f236e4c1cd3e/dist/bootstrap4-clockpicker.min.js"></script>
   </body>
</html>
<script type="text/javascript">
    $('#todayleaves').DataTable();
    $('#approval').DataTable();
    $('#reject').DataTable();
    $('#history').DataTable();
</script>
<style type="text/css">
  .cls_accept {
     border: none;
     color: white;
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
  $('#start_time').clockpicker({
    autoclose: true,
    twelvehour: true
  });
  $('#end_time').clockpicker({
    autoclose: true,
    twelvehour: true
  });
  $(function(){
    $('#startdate').datepicker({
        startDate: '-60d'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('#startdate').data('date'));
        $('#enddate').datepicker('hide');
    });
    $('#enddate').datepicker({
        startDate: '-60d'
    }).on('changeDate', function(ev){
        $('#sDate1').text($('#enddate').data('date'));
        $('#startdate').datepicker('hide');
    });
  })
  jQuery(document).on('click', '#update-emp-details', function(){
    var id = jQuery(this).data('getueid');
    $.ajax({
       type: "post",
       async: false,
       url: "<?php echo base_url('admin/Member/getReason'); ?>",
       dataType: "json",
       data : {"id" : id},
       success: function (res) {
         $("#leave_id").val(res.id);
         $("#reason").val(res.reason); 
       }
    });                  
  });
  jQuery(document).on('click', '#edit-emp-details', function(){
    var id = jQuery(this).data('getueid');
    $.ajax({
       type: "post",
       async: false,
       url: "<?php echo base_url('admin/Member/getReason'); ?>",
       dataType: "json",
       data : {"id" : id},
       success: function (res) {
        console.log(res);
        if(res.half_day == 0)
        {
          $("#half_day").prop("checked", true);
          $('#clockpicker').show();
          $('#end_date_hide').hide();
          $("#half_day").val(res.half_day);
          $("#full_day").val(1);
        }
        else
        {
          $("#half_day").prop("checked", false);
          $("#half_day").val(1);
          $("#full_day").val(0);
          $('#end_date_hide').show();
          $('#clockpicker').hide();
        }
        if(res.half_day == 1)
        {
          $("#full_day").prop("checked", true);
          $('#start_date_hide').show();
          $('#end_date_hide').show();
          $('#clockpicker').hide();
          $("#half_day").val(0);
          $("#full_day").val(1);
        }
        else
        {
          $("#full_day").prop("checked", false);
          $("#half_day").val(res.half_day);
          $("#full_day").val(1);
          $('#clockpicker').show();
          $('#end_date_hide').hide();
        }
        $("#update_id").val(res.id);
        $("#leave_type").val(res.leave_type);
        $("#start_time").val(res.start_time);
        $("#end_time").val(res.end_time);
        $("#startdate").val(res.startdate);
        $("#enddate").val(res.enddate);
        $("#edit_reason").val(res.reason); 
       }
    });                  
  });
function myFunction()
{
    var half_day= $('#half_day').val();
    var full_day= $('#full_day').val();
    if (half_day == "0") 
    {
        $('#clockpicker').show();
        $('#end_date_hide').hide(); 
    }
    else 
    {
        $('#end_date_hide').show();
        $('#clockpicker').hide(); 
    }
}
function fullFunction()
{
    var half_day= $('#half_day').val();
    var full_day= $('#full_day').val();
    if (full_day == "1") 
    {
      $('#start_date_hide').show();
      $('#end_date_hide').show();
      $('#clockpicker').hide(); 
    }
    else
    {
      $('#clockpicker').show();
      $('#end_date_hide').hide(); 
    }
}
</script>