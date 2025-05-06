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
    <title>Leaves Types</title>
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
            <li class="breadcrumb-item active">Leaves Types</li>
          </ol>
          <h1><b style="margin-left: 18px;">Leaves Types</h1></b><hr>
          <div class="">
            <a href="#addAdmin_Leaves_Model" class="btn btn-success" style="margin-left: 20px;" data-toggle="modal">
              <i class="fa fa-plus-square"></i> <span >Add Leaves</span>
            </a>
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
                      <th>Leave Types</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  </tbody>
                    <?php
                    if(count($userdetails)) :
                    $cnt=1; 
                    foreach ($userdetails as $row) :
                    ?> 
                    <tr>
                      <td><?php echo htmlentities($cnt);?></td>
                      <td><?php echo htmlentities($row->leavetype)?></td>
                      <td>
                        <a title="Edit" href="<?php echo site_url()?>admin/leave_type/updatedata/<?php echo $row->id;?>" data-getueid="<?php echo $row->id;?>" id="update-emp-details" data-toggle="modal" data-target="#editAdmin_Leaves_Model"><i class="fa fa-edit"></i></a> |
                        <a href="<?php echo base_url() ?>admin/leave_type/deleteadmin/<?php echo $row->id; ?>" class="fa fa-trash" onclick="return ConfirmDialog();"></a></tr>
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
                </table>
              </div>
            </div>
    <div id="addAdmin_Leaves_Model" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" id="insert-form" name="insert" enctype="multipart/form-data" action="<?php echo site_url('admin/leave_type/insert'); ?>">
            <div class="modal-header">
              <h4 class="modal-title">Add Leaves</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="form-group" style="padding-left: 10px;padding-right: 10px;">
                <label>Leave Types</label>
                <input type="text" name="leavetype" id="leavetype" class="form-control" placeholder="Enter Leaves Types" required>
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="submit" class="btn btn-success" value="Add Leaves">
            </div>
          </form>
        </div>
      </div>
    </div>
      <!-- /.content-wrapper -->
  </div>
    <!-- /#wrapper -->
    <div id="editAdmin_Leaves_Model" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" enctype="multipart/form-data" action="<?php echo site_url()?>admin/leave_type/updatedata">
            <div class="modal-header">
              <h4 class="modal-title">Edit Member</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <input type="hidden" name="update_id" id="update_id" value="">
              <div class="form-group" style="padding-left: 10px;padding-right: 10px;">
                <label>Leave Types</label>
                <input type="text" name="leavetype" id="leavetype_edit" class="form-control" required>
              </div>
              <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="submit" class="btn btn-success" value="Update Leave Type">
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
  var x=confirm("Kindly remove the leave type from the leave policy first?")
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
      url: "<?= site_url('admin/leave_type/edit') ?>/" + id,
      dataType: "json",
      data : {"id" : id},
      success: function (res) {      
        $('#leavetype_edit').val(res.leavetype);
        $("#update_id").val(res.id); 
      }
  });
});
</script>