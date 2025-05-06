<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <meta name="robots" content="noindex, nofollow">
      <title>Admin -member</title>
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" integrity="sha512-XLInoY7BRabO37CGsZjuNbQgIUq/XJAoP4iNGSjHpYt5JRGl4DYrPwjMcGhyBi+NZgocGJhRW3cTaQ1d8ecEig==" crossorigin="anonymous" />
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
                     <a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a>
                  </li>
                  <li class="breadcrumb-item active">Member</li>
               </ol>
               <h1><b style="margin-left: 18px;">Member</h1>
               </b>
               <div role="alert" id="success_msg"></div>
               <?php if($this->session->flashdata('error')!=""){ ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $this->session->flashdata('error');?>
                </div>
              <?php } else if($this->session->flashdata('message')!="") {?>
                <div class="alert alert-success" role="alert">
                  <?php echo $this->session->flashdata('message');?>
                </div>
              <?php } else {?>
                <div>
                  
                </div>
              <?php }?>
               <hr>
               <div class="">
                  <a href="#addAdmin_member_Model" class="btn btn-success" style="margin-left: 20px;" data-toggle="modal"><i class="fa fa-plus-square"></i> <span>Add Member</span></a>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <!---- Success Message ---->
                     <?php if ($this->session->flashdata('success')) { ?>
                     <p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
                  </div>
                  <?php } ?>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Profile</th>
                           <th>Member Name</th>
                           <th>Email</th>
                           <th>Role Name</th>
                           <th>Designation</th>
                           <th>Leaves</th>
                           <th>Created At</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th>No</th>
                           <th>Profile</th>
                           <th>Member Name</th>
                           <th>Email</th>
                           <th>Role Name</th>
                           <th>Designation</th>
                           <th>Leaves</th>
                           <th>Created At</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($usersdetails)) :
                           $cnt=1; 
                           foreach ($usersdetails as $row) :
                           if($row->role_id == 1){
                               $status = "Admin";
                             }
                             else if($row->role_id == 2){
                               $status = "HR Executive";
                             }
                             else if($row->role_id == 3){
                               $status = "Member";
                             }
                             else if($row->role_id == 4){
                               $status = "Super Admin";
                             }
                             else if($row->role_id == 5)
                             {
                              $status = "Company";
                             }
                             if($row->isActive == 0){
                               $enable = "Active";      
                             }
                             else{
                               $enable = "Dactive";
                             }
                             $currentMonth = date('m'); // Get the current month
                             $currentYear = date('Y'); // Get the current year
                            $this->db->select('sum(duration) as duration');
                            $this->db->from('leaves_policy');
                            $this->db->where('company_id',$row->company_id);
                            $this->db->where('year',date("Y"));
                            $duration = $this->db->get()->result();

                            $this->db->select('sum(duration) as total_leaves');
                            $this->db->from('leaves');
                            $this->db->where('leave_status',1);
                           //  $this->db->where('created_at >=',date( 'Y' ) . '-01-01');
                            $this->db->where('user_id',$row->user_id);
                            // Check if current month is January, and if so, include December of the previous year
                           // if ($currentMonth == '01') {
                           //    $this->db->where('created_at >=', ($currentYear - 1) . '-12-01'); // Include December from last year
                           // } else {
                           //    $this->db->where('created_at >=', $currentYear . '-01-01'); // Only current year data
                           // }


                           if ($currentMonth == '01') {
                              // Include leaves that started in December of the previous year and ended in the current year
                              $this->db->group_start();
                              // For the previous year (leaves that end in December but started before)
                              $this->db->where('enddate >=', ($currentYear - 1) . '-12-01');
                              $this->db->where('startdate <=', ($currentYear - 1) . '-12-31');
                              // Or leaves that started in the current year
                              $this->db->or_group_start();
                              $this->db->where('startdate >=', $currentYear . '-01-01');
                              $this->db->where('enddate <=', $currentYear . '-12-31');
                              $this->db->group_end();
                              $this->db->group_end();
                          } else {
                              // For other months, only consider leaves within the current year
                              $this->db->where('startdate >=', $currentYear . '-01-01');
                              $this->db->where('enddate <=', $currentYear . '-12-31');
                          }
                          



                            $teken_leaves = $this->db->get()->result();

                            if($teken_leaves[0]->total_leaves == "")
                            {
                               $leave_to = 0;
                            }
                            else
                            {
                              $leave_to = $teken_leaves[0]->total_leaves;
                            }
                           ?>                  
                        <tr class="member_link" id="<?php echo $row->user_id; ?>">
                          <?php $images = $row->image ? $row->image : 'default.png'; ?>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td>
                            <img src="<?php echo base_url()?>image/<?php echo $images;?>" style="height: auto;border-radius: 100px;" width='100' />
                           <td><a title="name" href="#" data-getueid="<?php echo $row->user_id;?>" id="name-emp-details" data-toggle="modal" data-target="#empAdmin_member_Model"><?php echo htmlentities($row->name)?></a></td>
                           <td><?php echo htmlentities($row->email)?></td>
                           <td><?php echo htmlentities($status)?></td>
                           <td><?php echo htmlentities($row->designation)?></td>
                           <td><a title="name" href="#" data-getueid="<?php echo $row->user_id;?>" id="name-emp-details" data-toggle="modal" data-target="#empAdmin_member_Model"><?php echo $leave_to ."/".$duration[0]->duration;?></a></td>
                           <td><?php echo date("d-m-Y", strtotime($row->created_at)); ?></td>
                           <td><?php echo htmlentities($enable)?></td>
                           <td>
                              <a title="Edit" href="<?php echo site_url()?>admin/member/updatedata/<?php echo $row->user_id;?>" data-getueid="<?php echo $row->user_id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_member_Model"><i class="fa fa-edit"></i></a>
                              <?php if($row->isActive=='0'){  ?>
                              <a href="javascript:void(0)" data-toggle="tooltip" title="Status disable" onclick="ActiveMember(<?php echo $row->user_id ?>,1)"><i style="padding-right:3px;color:green;font-size: 18px;" class="fa fa-user-times fa-2x" aria-hidden="true"></i></a>
                              <?php }else{ ?>
                              <a href="javascript:void(0)" data-toggle="tooltip" title="Status Enable" onclick="DeActiveMember(<?php echo $row->user_id ?>,0)"><i style="padding-right:3px;color:red;font-size: 18px;" class="fa fa-user-plus fa-2x" aria-hidden="true"></i></a>
                              <?php } ?>
                              <?php echo  anchor("admin/member/deleteadmin/{$row->user_id}",' ','class="fa fa-trash" onclick=" return ConfirmDialog();"')?>
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
      <div id="addAdmin_member_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
              <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                   echo form_open_multipart("admin/member/insert", $attrib); ?>
                  <div class="modal-header">
                     <h4 class="modal-title">Add member</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group" style="display: none;">
                        <label >company Name</label>
                        <!-- <input type="text" name="company_name" id="company_name" class="form-control" required> -->
                        <select id="company_name" name="company_name" class="form-control" >
                           <option value="">No Selected</option>
                           <?php foreach($company_name as $row):?>
                           <option value="<?php echo $row->id;?>"><?php echo $row->company_name;?></option>
                           <?php endforeach;?>
                        </select>
                     </div>
                    <div class="form-group">
                        <label>Choose your File</label>
                        <input type="file" name="image" id="image" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Member Name" required>
                     </div>
                     <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                        <span id="msg" style="color: red;"></span>
                     </div>
                     
                     <div class="form-group">
                        <label>Choice your Role Name </label>
                        <select id="role_id" name="role_id" class="form-control">
                          <option value="">Select User Roles</option>
                          <?php 
                          foreach ($roles as $user_role_row) { 
                            if($user_role_row->name =="Super Admin" || $user_role_row->name =="Company")
                            {
                              
                            }else {?>

                          <option value="<?php echo $user_role_row->role_id; ?>"><?php echo $user_role_row->name; ?></option>
                            <?php }
                            ?>
                          <?php } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" id="name" class="form-control" placeholder="Enter Designation" required>
                     </div>
                     <div class="form-group">
                        <label>Select Profile Color</label>
                        <input type="color" name="profilecolor" id="profilecolor" value="">
                     </div>
                     <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success add_member" id="add_member" name="add_member" value="Add member">
                     </div>
                     <?php echo form_close(); ?>
               

               </div>
            </div>
         </div>
         
      </div>
      <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <div id="editAdmin_member_Model" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                  echo form_open_multipart("admin/member/updatedata", $attrib); ?>
               
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Member</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="update_id" id="update_id" value="">
                  <div class="modal-body">
                    <div class="form-group">
                        <label>Choose your File</label>
                        <input type="file" name="image" id="image" onchange="readURL(this);" class="form-control" style="border: none; width: 230px;"> 
                        <div id="imagedisplay" style="margin-left: 362px;margin-top: -59px;">
                        </div>
                        <img id="blah" src="#" style="border: none; width: 230px; display: none;" />
                     </div>
                     <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" name="name" id="name_edit" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label> Email</label>
                        <input type="text" name="email" id="email_edit" class="form-control">
                     </div>
                     
                     <div class="form-group">
                        <label>Choice your Role Name </label>
                        <select id="role_id_edit" name="role_id" class="form-control">
                          <option value="">Select User Roles</option>
                          <?php 
                          foreach ($roles as $user_role_row) { ?>
                          <option value="<?php echo $user_role_row->role_id; ?>"><?php echo $user_role_row->name; ?></option>
                          <?php } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" id="designation_edit" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label>Select Profile Color</label>
                        <p id="cls_color" style="width: 50%; display: none;">Current Profile Color</p>
                        <input type="color" name="profilecolor" id="profile_color" value="">
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" name="edit_member" value="Update Member">
                  </div>
                   <?php echo form_close(); ?>
            </div>
         </div>
      </div>
      <div id="empAdmin_member_Model" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Member Leaves Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped print-table order-table">
                      <thead>
                          <tr>
                              <th>Member Name</th>
                              <th>Leave Types</th>
                              <th>Reason</th>
                              <th>Duration</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                          </tr>
                      </thead>
                      <tbody id="cls_html_list">
                      
                      </tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                 <input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
              </div>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>
   </body>
   <?php include APPPATH.'views/admin/includes/footer.php';?>
</html>
<script type="text/javascript">
  jQuery(document).on('click', '#update-emp-details', function(){
    var id = jQuery(this).data('getueid');
      $.ajax({
          type: "get",
          async: false,
          url: "<?= site_url('admin/member/edit') ?>/" + id,
          dataType: "json",
          data : {"id" : id},
          success: function (res) {
            console.log(res);
            var site_url = "<?php echo base_url(); ?>";
            var image = res.image ? res.image : 'default.png';
            $('#name_edit').val(res.name);
            $('#email_edit').val(res.email);
            $('#role_id_edit').val(res.role_id);
            $('#designation_edit').val(res.designation);
            $("#update_id").val(res.user_id);
            $("#profile_color").val(res.member_color); 
            $("#cls_color").css("background-color", res.member_color);
            document.getElementById("imagedisplay").innerHTML = "<img src='"+site_url+"image/"+image+"' width=\"100px\" height=\"auto\"/>"; 
          }
     });
  });
  jQuery(document).on('click', '#name-emp-details', function(){
    var id = jQuery(this).data('getueid');
      $.ajax({
          type: "get",
          async: false,
          url: "<?= site_url('admin/member/modal_view') ?>/" + id,
          dataType: "json",
          data : {"id" : id},
          success: function (res) {
              console.log(res);
              var i;
              var final_count = 0;
              var cls_html_list = "";
              for(i=0; i < res.length; i++)
              {
                  if(res[i].half_day == 0)
                  {
                      var duration_total = "0.5";
                  }
                  else
                  {
                      var date1 = res[i].startdate;
                      var date2 = res[i].enddate;
                      var days = daysdifference(date1, date2);
                      var duration_total = days + 1; 
                  }
                  if(duration_total == 1 ||duration_total == 0.5)
                  {
                    var day=" Day";
                  }
                  else
                  {
                    var day=" Days";
                  }
                  cls_html_list+= '<tr class="cls_row_model_list" id="row_'+final_count+'">';
                      cls_html_list+= '<td>';
                          cls_html_list+='<span> '+res[i].name+'</span>'; 
                      cls_html_list+= '</td>';
                      cls_html_list+= '<td>';
                          cls_html_list+='<span> '+res[i].leavetype+'</span>'; 
                      cls_html_list+= '</td>';
                      cls_html_list+= '<td class="number">';
                          cls_html_list+='<span>'+res[i].reason+'</span>'; 
                      cls_html_list+= '</td>';
                      cls_html_list+= '<td class="number">';
                          cls_html_list+='<span>'+duration_total+' '+day+'</span>'; 
                      cls_html_list+= '</td>';
                      cls_html_list+= '<td class="number">';
                          cls_html_list+='<span>'+res[i].startdate+'</span>'; 
                      cls_html_list+= '</td>';
                      cls_html_list+= '<td class="number">';
                          cls_html_list+='<span>'+res[i].enddate+'</span>'; 
                      cls_html_list+= '</td>';
                  cls_html_list+= '</tr>';
              }            
              $("#cls_html_list").html(cls_html_list);
          }
     });
  });

  function daysdifference(firstDate, secondDate){
      var startDay = new Date(firstDate);
      var endDay = new Date(secondDate);
     
      var millisBetween = startDay.getTime() - endDay.getTime();
      var days = millisBetween / (1000 * 3600 * 24);
     
      return Math.round(Math.abs(days));
  }
  function ActiveMember(id,status)
  {
    var x=confirm("Are you sure, you want to Disable the member!!")
    if (x) 
    {
      $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>admin/member/update_status",
           data: {'id' :id,'status' :status},
        success: function(data){
          if(data == "1")
          {
            $("#success_msg").addClass("alert alert-success");
            $("#success_msg").text("A Member Successfully Deactive!");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
          else
          {
            $("#success_msg").addClass("alert alert-danger");
            $("#success_msg").text("A Member Is not Deactive!");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    } 
    else
    {
        return false;
    }
  }
  function DeActiveMember(id,status)
  {
    var x=confirm("Are you sure, you want to Active the member!!")
    if (x) 
    {
      $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>admin/member/update_status",
           data: {'id' :id,'status' :status},
        success: function(data){
          if(data == "1")
          {
            $("#success_msg").addClass("alert alert-success");
            $("#success_msg").text("A Member Successfully Activated!");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
          else
          {
            $("#success_msg").addClass("alert alert-danger");
            $("#success_msg").text("Member Is Not Active!");
            setTimeout(function() {
                location.reload();
            }, 2000);
          }
        }
      });
    } 
    else
    {
        return false;
    }
  }
  $(document).on('change','#email',function(){
      var email = $("#email").val();
        jQuery.ajax({
        type:"post",
        url: "<?php echo base_url(); ?>admin/member/filename_exists",
        data:{ 'email':email},
        success: function(response) {
          console.log(response);
          if(response == "1")
          {
            $("#msg").text("Email is Already Exist!");
             $(".add_member").prop('disabled', true); 

          }
          else
          {
            $("#msg").text("");
            $(".add_member").prop('disabled', false);
          }
         }
      });
  });
  function readURL(input) 
  {
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
  function ConfirmDialog() 
  {
    var x=confirm("Are you sure you want to delete this Member?")
    if (x) {
      return true;
    } else {
      return false;
    }
  }
</script>