<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Reports</h2>   
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="<?php echo site_url("admin/reports"); ?>" >Reports</a> / <a href="<?php echo site_url("admin/reports/view/".$request); ?>" >Order Status - Monthly</a>
                </div> 
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php $this->posreportico->create_report($request, 'PREPARE'); ?>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
   
</div>
