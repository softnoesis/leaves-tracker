<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css"/>
      <!-- Bootstrap core CSS-->
      <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
      <!-- Custom fonts for this template-->
      <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
      <!-- Page level plugin CSS-->
      <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
      <!-- Custom styles for this template-->
      <?php echo link_tag('assests/css/sb-admin.css'); ?>
      <link rel="shortcut icon" href="<?php echo base_url ("image/favicon.ico")?>"/>
      <title>Calendar</title>
      <meta name="robots" content="noindex, nofollow">


   </head>
   <body id="page-top">
      <?php include APPPATH.'views/admin/includes/header.php';?>
      <div id="wrapper">
      <!-- Sidebar -->
      <?php include APPPATH.'views/admin/includes/sidebar.php';?>
      <div id="content-wrapper">
      <div class="container-fluid">
         <div id="calendar">
         </div>
      </div>
      <div id="calendar">
      </div>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
   </body>
   <script type="text/javascript">
      $(document).ready(function(){
            var calendar = $('#calendar').fullCalendar({
              editable:true,
              header:{
                  left:'prev,next today',
                  center:'title',
                  right:'month,agendaWeek,agendaDay',
              },
            
              eventRender: function (eventObj, $el) {
               // console.log($("h2").val());
                  console.log(eventObj);
                  $el.popover({
                      title: eventObj.title,
                      content : '<p>Start Date : ' + eventObj.start.format('ddd MMM Do YYYY') + '</p><p> End Date : ' + eventObj.end.format('ddd MMM Do YYYY') + '</p><p> Reason : ' + eventObj.reason + '</p><p> Total Leave : '+eventObj.total_leaves+'</p>',
                      trigger: 'hover',
                      placement: 'top',
                      container: 'body',
                      html : true
                      
                  });
                              

              },
             
              events:"<?php echo base_url(); ?>admin/Fullcalendar/load",
              selectable:true,
              selectHelper:true,
              displayEventTime: false,
          });
      });
   </script>
</html>