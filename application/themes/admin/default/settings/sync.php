<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Sync Products</h2>   
            <h5>Address from where the parcel service collect the products from!</h5>
        </div>
        <div class="col-md-6"></div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <?php require APPPATH.'views/admin/settings/navs.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sync Products
                </div>
                <div class="panel-body">
                    <div class="sync-area">
                        <a href="<?php echo site_url('/data_mapper/'); ?>" target="_blank" class="btn btn-success btn-lg" id="sync">Sync now</a>
                        <br/><br/>
                        <div class="sync-notification" style="display: none">
                            <img src="<?php echo base_url('assets/images/ellipsis.gif'); ?>">
                            <span class="alert alert-success sync-message">Processing..</span>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <script>
    $(document).ready( function() {
        $("#sync").click(function(event){
            event.preventDefault();
            var link = $(this).attr("href");
            
            $(".sync-notification img").show("fast");
            $(".sync-notification span").removeClass('alert-danger').text("Processing..");
            $(".sync-notification").show("slow");
             
             
            var jqxhr = $.get( link, function() { 
            })
            .done(function() {
              $(".sync-notification span").text("Sync completed!");
            })
            .fail(function() {
              $(".sync-notification span").addClass('alert-danger').text("Sync failed!");
            })
            .always(function() {
              $(".sync-notification img").hide("slow");
            });
        });
    });
</script>
    <?php echo form_close(); ?>
</div>
