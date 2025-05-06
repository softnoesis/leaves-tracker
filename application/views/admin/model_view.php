<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped print-table order-table">
                    <thead>
                        <tr>
                            <th>Member Name</th>
                            <th>Leave Types</th>
                            <th>Reason</th>
                            <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($user_leaves as $key => $value) {?>
                        <tr>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->leavetype; ?></td>
                            <td><?php echo $value->reason; ?></td>        
                            <td><?php echo $value->startdate; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>