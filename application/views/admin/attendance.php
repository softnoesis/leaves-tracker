<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
    <title>Attendance</title>
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
        <?php include APPPATH.'views/admin/includes/sidebar.php';?>
      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a>
            </li>
            <li class="breadcrumb-item active">Attendance</li>
          </ol>
          <h1><b style="margin-left: 18px;">Attendance</h1></b>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="company_id" id="company_id" value="<?php echo $company->id; ?>">
              <h4 style="text-align: center;"><?php echo $company->company_name; ?></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h4 style="text-align: center;">Monthly Summary Report</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" id="cls_month_show">
              <h4 style="text-align: center;"><?php echo date('d F Y', strtotime(date('Y-m')." -1 month")) ." To ". date('t F Y', strtotime(date('Y-m')." -1 month"))?></h4>
            </div>
          </div>
          <div class="form-group">
            <a href="#upload_csv_file" class="btn btn-success" style="margin-left: 20px;" data-toggle="modal">
              <i class="fa fa-plus-square"></i> <span >Add Attendance</span>
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
              <!---- Success Message ---->
              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                      <select name="month_year_drop" id="month_year_drop" class="form-control">
                        <?php foreach ($getyear as $key => $getyear_row) { 
                          $last_month = date('Y-m', strtotime(date('Y-m')." -1 month"));
                          ?>
                          <option value="<?php echo $getyear_row->month_year; ?>"<?php if($getyear_row->month_year == $last_month) echo "selected"; ?>><?php echo date('F Y',strtotime($getyear_row->month_year)); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
              </div>
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>P</th>
                    <th>A</th>
                    <th>H</th>
                    <th>HP</th>
                    <th>WO</th>
                    <th>WOP</th>
                    <th>PL</th>
                    <th>CL</th>
                    <th>SL</th>
                    <th>Total OT</th>
                    <th>T Duration</th>
                    <th>Early By</th>
                    <th>Late By</th>
                    <th>Total Leaves</th>
                    <th>Total Present</th>
                    <th>Pay Days</th>
                </thead>
                <tbody>
                  <?php
                     if(count($attendance)) {
                     $cnt=1; 
                     $present_day = 0;
                     $absent_day = 0;
                     $h_day = 0;
                     $hp_day = 0;
                     $wo_day = 0;
                     $wop_day = 0;
                     $pl_day = 0;
                     $cl_day = 0;
                     $sl_day = 0;
                     $total_ot = 0;
                     $total_leave = 0;
                     $total_present = 0;
                     $pay_days = 0;
                     foreach ($attendance as $row_attendance) {?>
                      <tr>
                        <td><?php echo $row_attendance->employee_code ?></td>
                        <td><?php echo $row_attendance->employee_name ?></td>
                        <td><?php echo $row_attendance->p ?></td>
                        <td><?php echo $row_attendance->a ?></td>
                        <td><?php echo $row_attendance->h ?></td>
                        <td><?php echo $row_attendance->h_p ?></td>
                        <td><?php echo $row_attendance->w_o ?></td>
                        <td><?php echo $row_attendance->w_o_p ?></td>
                        <td><?php echo $row_attendance->p_l ?></td>
                        <td><?php echo $row_attendance->c_l ?></td>
                        <td><?php echo $row_attendance->s_l ?></td>
                        <td><?php echo $row_attendance->total_ot ?></td>
                        <td><?php echo $row_attendance->t_duration ?></td>
                        <td><?php echo $row_attendance->early_by ?></td>
                        <td><?php echo $row_attendance->late_by ?></td>
                        <td><?php echo $row_attendance->total_leave ?></td>
                        <td><?php echo $row_attendance->total_present ?></td>
                        <td><?php echo $row_attendance->pay_days ?></td>
                      </tr>
                      <?php 
                        $present_day = $row_attendance->p + $present_day;
                        $absent_day = $row_attendance->a + $absent_day;
                        $h_day = $row_attendance->h + $h_day;
                        $hp_day = $row_attendance->h_p + $hp_day;
                        $wo_day = $row_attendance->w_o + $wo_day;
                        $wop_day = $row_attendance->w_o_p + $wop_day;
                        $pl_day = $row_attendance->p_l + $pl_day;
                        $cl_day = $row_attendance->c_l + $cl_day;
                        $sl_day = $row_attendance->s_l + $sl_day;
                        $total_ot = $row_attendance->total_ot + $total_ot;
                        $total_leave = $row_attendance->total_leave + $total_leave;
                        $total_present = $row_attendance->total_present + $total_present;
                        $pay_days = $row_attendance->pay_days + $pay_days;
                      ?>
                     <?php } ?>
                   <?php }else{ ?>
                    <tr>
                      <td colspan="13">No records Found!</td>
                    </tr>
                  <?php }?>
                </tbody>
                <tfoot>
                  <tr style="background-color: aliceblue;">
                    <th colspan="2"><?php echo "Total"; ?></th>
                    <td><?php echo $present_day; ?></td>
                    <td><?php echo $absent_day; ?></td>
                    <td><?php echo $h_day; ?></td>
                    <td><?php echo $hp_day; ?></td>
                    <td><?php echo $wo_day; ?></td>
                    <td><?php echo $wop_day; ?></td>
                    <td><?php echo $pl_day; ?></td>
                    <td><?php echo $cl_day; ?></td>
                    <td><?php echo $sl_day; ?></td>
                    <td><?php echo $total_ot; ?></td>
                    <td><?php echo "0"; ?></td>
                    <td><?php echo "0"; ?></td>
                    <td><?php echo "0"; ?></td>
                    <td><?php echo $total_leave; ?></td>
                    <td><?php echo $total_present; ?></td>
                    <td><?php echo $pay_days; ?></td>
                  </tr>
                </tfoot>
              </table>    
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="upload_csv_file" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
             <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("admin/attendance/upload_attendance", $attrib); ?>
                <div class="modal-header">
                   <h4 class="modal-title">Attendance Sheet Upload </h4>
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <input type="hidden" name="leave_id" id="leave_id" value="">
                <div class="modal-body">
                   <div class="form-group">
                      <label>Month / Year</label>
                      <input type="month" name="month_year" required="required" placeholder="yyyy-mm" id="month_year" class="form-control">
                   </div>
                   <div class="form-group">
                     <label>Upload CSV</label>
                     <input type="file" name="upload_csv" id="upload_csv" class="form-control">
                   </div>
                   <div class="form-group">
                     <label>Total Duration</label>
                     <input type="text" name="total_duration" required="required" id="total_duration" class="form-control">
                   </div>
                </div>
                <div class="modal-footer">
                   <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                   <input type="submit" class="btn btn-success" name="importSubmit" value="Submit">
                </div>
                <?php echo form_close(); ?>
          </div>
      </div>
  </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
  </body>
  <?php include APPPATH.'views/admin/includes/footer.php';?>
</html>
<script type="text/javascript">
  $(document).on('change','#month_year_drop',function(){
      var month_name = $("#month_year_drop").val();
      var company_id = $("#company_id").val();
        jQuery.ajax({
        type:"post",
        url: "<?php echo base_url(); ?>admin/attendance/getAttendanceData",
        data:{ 'month_name':month_name,'company_id':company_id},
        success: function(response) {
          response = $.parseJSON(response);
          var final_count = 0; var cls_html_foot = ""; var cls_html_list = ""; var present_day = 0; var absent_day = 0; var h_day = 0; var hp_day = 0; var wo_day = 0; var wop_day = 0; var pl_day = 0; var cl_day = 0; var sl_day = 0; var total_ot = 0; var total_leave = 0; var total_present = 0; var pay_days = 0;
          for (var i = 0; i < response.length; i++) 
          {
            cls_html_list+= '<tr class="" id="row_'+final_count+'">';
                cls_html_list+= '<td>'+response[i].employee_code+'</td>';
                cls_html_list+= '<td>'+response[i].employee_name+'</td>';
                cls_html_list+= '<td>'+response[i].p+'</td>';
                cls_html_list+= '<td>'+response[i].a+'</td>';
                cls_html_list+= '<td>'+response[i].h+'</td>';
                cls_html_list+= '<td>'+response[i].h_p+'</td>';
                cls_html_list+= '<td>'+response[i].w_o+'</td>';
                cls_html_list+= '<td>'+response[i].w_o_p+'</td>';
                cls_html_list+= '<td>'+response[i].p_l+'</td>';
                cls_html_list+= '<td>'+response[i].c_l+'</td>';
                cls_html_list+= '<td>'+response[i].s_l+'</td>';
                cls_html_list+= '<td>'+response[i].total_ot+'</td>';
                cls_html_list+= '<td>'+response[i].t_duration+'</td>';
                cls_html_list+= '<td>'+response[i].early_by+'</td>';
                cls_html_list+= '<td>'+response[i].late_by+'</td>';
                cls_html_list+= '<td>'+response[i].total_leave+'</td>';
                cls_html_list+= '<td>'+response[i].total_present+'</td>';
                cls_html_list+= '<td>'+response[i].pay_days+'</td>';
            cls_html_list+= '</tr>';

            present_day += parseInt(response[i].p);
            absent_day += parseInt(response[i].a);
            h_day += parseInt(response[i].h);
            hp_day += parseInt(response[i].h_p);
            wo_day += parseInt(response[i].w_o);
            wop_day += parseInt(response[i].w_o_p);
            pl_day += parseInt(response[i].p_l);
            cl_day += parseInt(response[i].c_l);
            sl_day += parseInt(response[i].s_l);
            total_ot += parseInt(response[i].total_ot);
            total_leave += parseInt(response[i].total_leave);
            total_present += parseInt(response[i].total_present);
            pay_days += parseInt(response[i].pay_days);
          }

          cls_html_foot+= '<tr style="background-color: aliceblue;" class="" id="row_'+final_count+'">';
              cls_html_foot+= '<td colspan="2">Total</td>';
              cls_html_foot+= '<td>'+present_day+'</td>';
              cls_html_foot+= '<td>'+absent_day+'</td>';
              cls_html_foot+= '<td>'+h_day+'</td>';
              cls_html_foot+= '<td>'+hp_day+'</td>';
              cls_html_foot+= '<td>'+wo_day+'</td>';
              cls_html_foot+= '<td>'+wop_day+'</td>';
              cls_html_foot+= '<td>'+pl_day+'</td>';
              cls_html_foot+= '<td>'+cl_day+'</td>';
              cls_html_foot+= '<td>'+sl_day+'</td>';
              cls_html_foot+= '<td>'+total_ot+'</td>';
              cls_html_foot+= '<td>0</td>';
              cls_html_foot+= '<td>0</td>';
              cls_html_foot+= '<td>0</td>';
              cls_html_foot+= '<td>'+total_leave+'</td>';
              cls_html_foot+= '<td>'+total_present+'</td>';
              cls_html_foot+= '<td>'+pay_days+'</td>';
          cls_html_foot+= '</tr>';

          var cls_html_date = new Date(month_name);
          $("#dataTable tbody").html(cls_html_list);
          $("#dataTable tfoot").html(cls_html_foot);
          //$("#cls_month_show h4").html(cls_html_date);
        }
      });
  });
</script>
