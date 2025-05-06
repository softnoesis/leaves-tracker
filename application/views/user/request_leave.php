<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
  <title>Request Leave</title>
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
<style>
{
  box-sizing: border-box;
}
label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}
input[type=submit]:hover {
  background-color: #45a049;
}
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
.col-25 {
  width: 20%;
  margin-top: 6px;
}
.col-75 {
  width: 80%;
  margin-top: 6px;
}
.labe1{
  margin-left: 15px;
}
/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
<body id="page-top">
   <?php include APPPATH.'views/user/includes/header.php';?>
    <div id="wrapper">
      <!-- Sidebar -->
      <?php include APPPATH.'views/user/includes/sidebar.php';?>
      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('user/Dashboard'); ?>">User</a>
            </li>
            <li class="breadcrumb-item active">Leave Request</li>
          </ol>
          <!-- Page Content -->
          <hr>
          <!---- Success Message ---->
          <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success" role="alert">
              <?php echo $this->session->flashdata('success');?>
            </div>
          <?php }?>
          <h2><b>LEAVE REQUEST </h2></b>
          <div class="container">
            <form action="<?php echo base_url('user/Requestleave/request_leave'); ?>" method="Post">
              <div class="row">
                <div class="col-25">
                  <label for="Request" class="labe1">Leave Types:</label>
                </div>
                <div class="col-75">
                  <select id="leave_type" name="leave_type" class="form-control" required="required">
                    <option value="">No Selected</option>
                    <?php foreach($leaves_type as $row):?>
                    <option value="<?php echo $row->id;?>"><?php echo $row->leavetype;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="row" id="halfday">
                <div class="col-25">
                  <label for="fname" class="labe1">Duration:</label>
                </div>
                <div class="col-75">
                  <input type="radio" id="half_day" name="half_day" value="0" onchange="myFunction()">
                  <label for="male">Half Day</label>
                  <input type="radio" id="full_day" name="half_day" value="1" checked="checked" onchange="fullFunction()">
                  <label for="male">Full Day</label>
                </div>
              </div>
              <div class="row" id="clockpicker" style="display: none;">
                <div class="col-25">
                </div>
                <div class="col-75">
                  <label for="time"class="labe1">Start Time</label>
                  <input type="text" id="start_time" name="start_time">
                  <label for="time"class="labe1" style="margin-left: 10px;">End Time</label>
                  <input type="text" id="end_time" name="end_time">  
                </div>
              </div>
              <div class="row" id="start_date_hide">
                <div class="col-25" id="datetimepicker">
                  <label for="fname" class="labe1">Start Date:</label>
                </div>
                <div class="col-75">
                  <input type="text" id="startdate" name="startdate" class="form-control" required="required">
                </div>
              </div>
              <div class="row" id="end_date_hide"> 
                <div class="col-25">
                  <label for="lname"class="labe1">End Date:</label> 
                </div> 
                <div class="col-75">
                  <input type="text" id="enddate" name="enddate" class="form-control" > 
                </div> 
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="subject" class="labe1">Reason:</label>
                </div>
                <div class="col-75">
                  <textarea id="Reason" name="reason" class="form-control" required="required" placeholder="Write your Reason..." style="height:100px;"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75">
                  <input type="submit" value="Submit Request">
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
     <?php include APPPATH.'views/user/includes/footer.php';?>
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
    <script src="https://cdn.jsdelivr.net/gh/djibe/clockpicker@6d385d49ed6cc7f58a0b23db3477f236e4c1cd3e/dist/bootstrap4-clockpicker.min.js"></script>
  </body>
</html>
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
        startDate: '-30d',
        daysOfWeekDisabled: [0],
        format: 'dd-mm-yyyy', 
    }).on('changeDate', function(ev){
      // Format the selected date and display it in #sDate1
      let selectedDate = $('#startdate').datepicker('getFormattedDate');
      $('#sDate1').text(selectedDate);
      $('#enddate').datepicker('hide');
    });
    $('#enddate').datepicker({
        startDate: '-30d',
        daysOfWeekDisabled: [0],
        format: 'dd-mm-yyyy', 
    }).on('changeDate', function(ev){
      // Format the selected date and display it in #sDate1
      let selectedDate = $('#enddate').datepicker('getFormattedDate');
      $('#sDate1').text(selectedDate);
      $('#startdate').datepicker('hide');
    });
})
function myFunction()
{
    var half_day= $('#half_day').val();
    var full_day= $('#full_day').val();
    if (half_day == "0") 
    {
        $('#clockpicker').show();
        $('#end_date_hide').hide();
        $("#start_time").attr('required',true);
        $("#end_time").attr('required',true);
    }
    else 
    {
        $('#end_date_hide').show();
        $('#clockpicker').hide(); 
        $("#start_time").removeAttr('required');
        $("#end_time").removeAttr('required');
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
      $("#start_time").removeAttr('required');
      $("#end_time").removeAttr('required'); 
    }
    else
    {
      $('#clockpicker').show();
      $('#end_date_hide').hide();
      $("#start_time").attr('required',true);
      $("#end_time").attr('required',true);
    }
}
</script>