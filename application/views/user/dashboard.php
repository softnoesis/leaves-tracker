<!DOCTYPE html>
<html lang="en">
   <head>
      <meta name="robots" content="noindex, nofollow">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>User dashboard</title>

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
                  <li class="breadcrumb-item active">Dashboard</li>
               </ol>
                <?php if($this->session->flashdata('massage')) {?>
                  <div class="alert alert-success" role="alert">
                    <?php echo $this->session->flashdata('massage');?>
                  </div>
                <?php  }?>
                <?php
                  $userid = $this->session->userdata('uid');
                  $this->db->select('company_id');
                  $this->db->from('member');
                  $this->db->where('user_id',$userid);
                  $company_id = $this->db->get()->row();

                  $this->db->select('sum(duration) as duration');
                  $this->db->from('leaves_policy');
                  $this->db->where('company_id',$company_id->company_id);
                  $this->db->where('year',date("Y"));
                  $duration = $this->db->get()->result();

                  $this->db->select('sum(duration) as total_leaves');
                  $this->db->from('leaves');
                  $this->db->where('leave_status',1);
                  $this->db->where('user_id',$userid);
                  $this->db->where('created_at >=',date( 'Y' ) . '-01-01');
                  $teken_leaves = $this->db->get()->result();
                 
                 ?>
                 <!-- <?php
                 if($teken_leaves[0]->total_leaves >= 13) {?>
                  <div class="alert alert-success" role="alert">
                    <?php echo "Bus karle abhi bohot leaves le li hai tune kam par bhi dhyan de de.";?>
                  </div>
                <?php  }?> -->
                 <div class="row">
                 <div class="col-md-12">
                   <div class="col-md-9">
                    <div class="clsleaveavailsection">
                      <label style="color:DodgerBlue;">Available day off for the year data <?php echo date("Y");?></label><br>
                      <button type="button" class="btn btn-secondary"style="background-color:MediumSeaGreen;"><?php echo $duration[0]->duration - $teken_leaves[0]->total_leaves ; ?> Remain</button>
                      <button type="button" class="btn btn-secondary"style="background-color:Tomato;" ><?php echo $teken_leaves[0]->total_leaves ? $teken_leaves[0]->total_leaves : "0"; ?> Taken</button>
                      <button type="button" class="btn btn-secondary" style="background-color:Orange;"><?php echo $duration[0]->duration; ?> Total</button>
                    </div>
                    
                  </div>
                 </div>
               </div>
               <?php if ($this->session->flashdata('success')) { ?>
               <p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
            </div>
            <?php }?>
             <div class="tab-content card pt-5" id="myTabContentMD">
               <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
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
                  <!-- <li class="nav-item">
                     <a class="nav-link" id="History-tab-md" data-toggle="tab" href="#History-md" role="tab" aria-controls="History-md"
                        aria-selected="false">History Leaves</a>  
                  </li> -->
               </ul>
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
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($pending)) :
                             //echo "<pre>";print_r($pending);echo "</pre>";exit();
                           $cnt=1; 
                           foreach ($pending as $row_pendingleaves) :
                            if($row_pendingleaves->leave_status == 0)
                            {
                               $status = "Pending";
                            }
                            else if($row_pendingleaves->leave_status == 1)
                            {
                               $status = "Approved";
                            }
                            else
                            {
                               $status = "Reject";
                            }
                            if($row_pendingleaves->half_day == 0)
                            {
                                $duration_total = "0.5 day";
                            }
                            else
                            {
                               $date1 =$row_pendingleaves->startdate;
                               $date2 =$row_pendingleaves->enddate;
                           
                               $diff = abs(strtotime($date2) - strtotime($date1));
                           
                               $years = floor($diff / (365*60*60*24));
                               $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                               $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                               $duration_total = $days + 1; 
                               if($duration_total == "1")
                               {
                                  $days = "day";
                               }
                               else
                               {
                                  $days = "days";
                               }
                            }                      
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities(date("Y-m-d", strtotime($row_pendingleaves->created_at)))?></td>
                           <td><?php echo htmlentities($row_pendingleaves->name)?></td>
                           <td><?php echo htmlentities($row_pendingleaves->leave_type_name)?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_pendingleaves->startdate)).', '.date('l', strtotime($row_pendingleaves->startdate)))?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_pendingleaves->enddate)).', '.date('l', strtotime($row_pendingleaves->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total." ".$days)?></td>
                           <td><?php echo htmlentities($row_pendingleaves->reason)?></td>
                           <td><?php echo htmlentities($status)?></td>
                          
                              
                              <!-- <a class = "label label-success"><i class="fa fa-check"></i></a>  
                                 <a title="reject"><i class="fa fa-window-close" aria-hidden="true"></i></a> -->
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
                  <table class="table table-bordered" id="todayleaves" width="100%" cellspacing="0">
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
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($todays)) :
                           $cnt=1; 
                           foreach ($todays as $row_todayleaves) :
                             if($row_todayleaves->leave_status == 0){
                               $status = "Pending";
                             }
                             else if($row_todayleaves->leave_status == 1){
                               $status = "Approved";
                             }
                             else{
                               $status = "Reject";
                             }
                           
                            if($row_todayleaves->half_day == 0)
                            {
                                $duration_total = "0.5";
                            }
                            else
                            {

                              $date1 =$row_todayleaves->startdate;
                              $date2 =$row_todayleaves->enddate;
                           
                              $diff = abs(strtotime($date2) - strtotime($date1));
                           
                              $years = floor($diff / (365*60*60*24));
                              $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                              $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                              $duration_total = $days + 1;
                              if($duration_total == "1")
                               {
                                  $days = "day";
                               }
                               else
                               {
                                  $days = "days";
                               }
                            }
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities(date("Y-m-d", strtotime($row_todayleaves->created_at)))?></td>
                           <td><?php echo htmlentities($row_todayleaves->name)?></td>
                           <td><?php echo htmlentities($row_todayleaves->leave_type_name)?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_todayleaves->startdate)).', '.date('l', strtotime($row_todayleaves->startdate)))?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_todayleaves->enddate)).', '.date('l', strtotime($row_todayleaves->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total." ".$days)?></td>
                           <td><?php echo htmlentities($row_todayleaves->reason)?></td>
                           <td><?php echo htmlentities($status)?></td>
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
               <!-- Approved Leaves -->               
               <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                  <table class="table table-bordered" id="approval" width="100%" cellspacing="0">
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
                           <th>Approved By</th>
                           <th>Status</th>
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
                           <th>Approved By</th>
                           <th>Status</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           //echo "<pre>";print_r($upcoming);echo "</pre>";
                             if(count($upcoming)) :
                             $cnt=1; 
                             foreach ($upcoming as $row_upcomingleaves) :
                              
                               if($row_upcomingleaves->leave_status == 0){
                                 $status = "Pending";
                               }
                               else if($row_upcomingleaves->leave_status == 1){
                                 $status = "Approved";
                               }
                               else{
                                 $status = "Reject";
                               }
                               if($row_upcomingleaves->half_day == 0)
                                {
                                $duration_total = "0.5";
                                }
                                else
                                  {
                              $date1 =$row_upcomingleaves->startdate;
                              $date2 =$row_upcomingleaves->enddate;
                           
                               $diff = abs(strtotime($date2) - strtotime($date1));
                           
                               $years = floor($diff / (365*60*60*24));
                               $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                               $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                               $duration_total = $days + 1;
                               if($duration_total == "1")
                               {
                                  $days = "day";
                               }
                               else
                               {
                                  $days = "days";
                               }
                             }
                             ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities(date("Y-m-d", strtotime($row_upcomingleaves->created_at)))?></td>
                           <td><?php echo htmlentities($row_upcomingleaves->name)?></td>
                           <td><?php echo htmlentities($row_upcomingleaves->leave_type_name)?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_upcomingleaves->startdate)).', '.date('l', strtotime($row_upcomingleaves->startdate)))?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_upcomingleaves->enddate)).', '.date('l', strtotime($row_upcomingleaves->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total." ".$days)?></td>
                           <td><?php echo htmlentities($row_upcomingleaves->reason)?></td>
                           <td><?php echo htmlentities($row_upcomingleaves->approved_name)?></td>
                           <td><?php echo htmlentities($status)?></td>
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
                  <table class="table table-bordered" id="reject" width="100%" cellspacing="0">
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
                           <th>Rejected By</th>
                           <th>Status</th>
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
                           <th>Rejected By</th>
                           <th>Status</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                           if(count($reject)) :
                           $cnt=1; 
                           foreach ($reject as $row_rejectleaves) :
                            

                             if($row_rejectleaves->leave_status == 0){
                               $status = "Pending";
                             }
                             else if($row_rejectleaves->leave_status == 1){
                               $status = "Approved";
                             }
                             else{
                               $status = "Reject";
                             }
                             if($row_rejectleaves->half_day == 0)
                                {
                                $duration_total = "0.5";
                                }
                                else
                                  {
                           
                              $date1 =$row_rejectleaves->startdate;
                               $date2 =$row_rejectleaves->enddate;
                           
                           
                               $diff = abs(strtotime($date2) - strtotime($date1));
                           
                               $years = floor($diff / (365*60*60*24));
                               $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                               $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                               $duration_total = $days + 1;
                               if($duration_total == "1")
                               {
                                  $days = "day";
                               }
                               else
                               {
                                  $days = "days";
                               }
                             }
                           ?>  
                        <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities(date("Y-m-d", strtotime($row_rejectleaves->created_at)))?></td>
                           <td><?php echo htmlentities($row_rejectleaves->name)?></td>
                           <td><?php echo htmlentities($row_rejectleaves->leave_type_name)?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_rejectleaves->startdate)).', '.date('l', strtotime($row_rejectleaves->startdate)))?></td>
                           <td><?php echo htmlentities(date('M j, Y', strtotime($row_rejectleaves->enddate)).', '.date('l', strtotime($row_rejectleaves->enddate)))?></td>
                           <td><?php echo htmlentities($duration_total." ".$days)?></td>
                           <td><?php echo htmlentities($row_rejectleaves->reason)?></td>
                           <td><?php echo htmlentities($row_rejectleaves->approved_name)?></td>
                           <td><?php echo htmlentities($status)?></td>
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
         <?php include APPPATH.'views/user/includes/footer.php';?>
      </div>
      <!-- /.content-wrapper -->
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
      <!-- Core plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
      <!-- Page level plugin JavaScript-->
      <script src="<?php echo base_url('assests/vendor/chart.js/Chart.min.js'); ?>"></script>

      <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
      <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
      <!-- Custom scripts for all pages-->
      <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
      <script src="<?php echo base_url('assests/js/demo/datatables-demo.js'); ?>"></script>
      <script src="<?php echo base_url('assests/js/demo/chart-area-demo.js'); ?>"></script>
   </body>
</html>

<script type="text/javascript">

    $('#todayleaves').DataTable();
    $('#approval').DataTable();
    $('#reject').DataTable();
    $('#history').DataTable();

</script>

