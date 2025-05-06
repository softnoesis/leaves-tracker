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

    <title>Admin -member</title>
<!-- Bootstrap core CSS-->
<?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
<!-- Custom fonts for this template-->
<?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
<!-- Page level plugin CSS-->
<?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
<!-- Custom styles for this template-->
<?php echo link_tag('assests/css/sb-admin.css'); ?>

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
            <li class="breadcrumb-item active" >Leave Policy</li>
          </ol>

          

             <h1><b style="margin-left: 16px;">Leave Policy</h1>
                </b>
                <hr>
                <div class="">
                  <a href="#Admin_LeavesPolicy_Model" class="btn btn-success" style="margin-left: 20px;" data-toggle="modal"><i class="fa fa-plus-square"></i> 
                    <span>Add Leave policy</span></a><br><br>
                </div>
                <div class="col-md-3">
              
              <!-- <select id="year" name="year" class="form-control"> -->
    
              </select>
            </div>


            <div class="card-body">
              <div class="table-responsive">
                        <!---- Success Message ---->
                        <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>                           
                        </div>
                        <?php }?>
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Year</th>
                      <th>Leave Types</th>
                      <th>Duration</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    //echo "<pre>";print_r($userdetails);echo "</pre>";exit();
                    if(count($userdetails)) :
                    $cnt=1; 
                    foreach ($userdetails as $row) :

                    ?>                  <!-- <?php echo "<pre>";print_r($row);echo "</pre>"; ?> -->
                    <tr>
                      <td><?php echo htmlentities($cnt);?></td>
                      <td><?php echo htmlentities($row->year)?></td>
                      <td><?php echo htmlentities($row->leavetyps_name)?></td>
                      <td><?php echo htmlentities($row->duration)?></td>
                      
                          <td><a title="Edit" href="<?php echo site_url()?>admin/leavespolicy/updatedata/<?php echo $row->id;?>" data-getueid="<?php echo $row->id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_LeavesPolicy_Model"><i class="fa fa-edit"></i></a> |
                      <a href="<?php echo base_url() ?>admin/leavespolicy/deleteadmin/<?php echo $row->id; ?>" class="fa fa-trash" onclick=" return ConfirmDialog();"></a> </td>

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
        <div id="Admin_LeavesPolicy_Model" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" id="insert-form" name="insert" enctype="multipart/form-data" action="<?php echo site_url('admin/leavespolicy/insert'); ?>">
            <div class="modal-header">
              <h4 class="modal-title">Add Leave Policy</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
              <label>Choice your year</label>
              <select id="leave_year" name="year" class="form-control">
              </select>
            </div>
              <div class="form-group">
              <label>Choice your Leave Type </label>
              <select id="leavetyps" name="leavetyps" class="form-control">
                <option value="">Select Leave Type</option>
                <?php foreach($leaves_type as $row):?>
                <option value="<?php echo $row->id;?>"><?php echo $row->leavetype;?></option>
                  <?php endforeach;?>
              </select>
            </div>
              <div class="form-group">
                <label>Duration</label>
                <input type="text" name="duration" id="duration" placeholder="Enter Duration" class="form-control" required>
              </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="submit" class="btn btn-success" value="Add Leave policy">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
      <!-- /.content-wrapper -->
</div>
    <!-- /#wrapper -->
<div id="editAdmin_LeavesPolicy_Model" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" enctype="multipart/form-data" action="<?php echo site_url()?>admin/leavespolicy/updatedata">
            <div class="modal-header">
              <h4 class="modal-title">Edit Leave policy</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <input type="hidden" name="update_id" id="update_id" value="">
            <div class="modal-body">
              <div class="form-group">
              <label>Choice your year</label>
              <select id="leave_year_edit" name="year" class="form-control" disabled="disable">
              </select>
            </div>
              <div class="form-group">
              <label>Choice your Leave Type </label>
              <select id="leavetyps_edit" name="leavetyps" class="form-control">
               <option value="">No Selected</option>
          <?php foreach($leaves_type as $row):?>
          <option value="<?php echo $row->id;?>"><?php echo $row->leavetype;?></option>
          <?php endforeach;?>
              </select>
            </div>
              <div class="form-group">
                <label>Duration</label>
                <input type="text" name="duration" id="duration_edit" class="form-control" required>
              </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="submit" class="btn btn-success" value="Edit Leave policy">
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
  <?php include APPPATH.'views/admin/includes/footer.php';?>
</html>
<script type="text/javascript">
function ConfirmDialog() {
  var x=confirm("Are you sure you want to delete this leavespolicy?")
  if (x) {
    return true;
  } else {
    return false;
  }
}  
jQuery(document).on('click', '#update-emp-details', function(){
  var id = jQuery(this).data('getueid');  
  $.ajax({
      type: "get",
      async: false,
      url: "<?= site_url('admin/leavespolicy/edit') ?>/" + id,
      dataType: "json",
      data : {"id" : id},
      success: function (res) {
        console.log(res);
        $('#year_edit').val(res.year);
        $('#leavetyps_edit').val(res.leavetyps);
        $('#duration_edit').val(res.duration);
        $("#update_id").val(res.id); 
           
      }
  });      
});

var year = 2021;
var till = 2030;
var options = "";
for(var y=year; y<=till; y++){
  options += "<option>"+ y +"</option>";
}
document.getElementById("leave_year").innerHTML = options;
document.getElementById("leave_year_edit").innerHTML = options;
</script>