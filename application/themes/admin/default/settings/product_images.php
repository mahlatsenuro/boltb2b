<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Products Images</h2>   
            <h5>Site settings</h5>
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/products/'); ?>" class="btn btn-success btn-sm new">
                <i class="fa fa-reply"></i>
                Back
            </a>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    
    <?php require 'navs.php';?>
    
    <div class="row">
        <?php echo form_open_multipart(''); ?>
        
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Store setup
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-2"> <label>Product Images</label> </div>
                        <div class="col-md-3">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images">
                                </span>
                            </span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-success" value="Submit" />
                        <input type="hidden" name="checker" value="1">
                        <?php echo form_error('checker'); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
                   
</div>
