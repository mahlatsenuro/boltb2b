<div id="page-inner">
    <?php echo form_open_multipart('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Upload CSV</h2>   
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <button type="submit" name="submitForm" class="btn btn-info btn-sm" value="formSave">
                    <span class="glyphicon glyphicon-share"></span>
                    Save
                </button>

                <button type="submit" name="submitForm" class="btn btn-info btn-sm " value="formSaveClose"> 
                    <span class="glyphicon glyphicon-share"></span>
                    Save and Close
                </button>

                <a href="<?php echo site_url('admin/'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-reply"></i>
                    Back
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>  
    
    <div class="row">
        <div class="col-sm-12">
            <?php if ($error = $this->session->flashdata('pro_error')): ?>
            <div class="container"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><h5><?php echo $error ?></h5></div></div>
            <?php endif ?>

            <?php if ($success = $this->session->flashdata('pro_success')): ?>
            <div class="container"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><h5><?php echo $success ?></h5></div></div>
            <?php endif ?>
        </div>
        <div class="clearfix"></div>
    </div>
    
    
    <hr />
    
    <div class="row">
        <div class="col-md-6">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Upload CSV
                </div>
                <div class="panel-body">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="file" name="csv" />
                                <?php echo form_error('csv') ?>
                            </div>
                            <br/>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <button name="submitForm" value="formSave" type="submit" class="btn btn-success">Upload</button>
                            </div>
                            <br/>
                        </div> 
                        <div class="clearfix"></div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
        <div class="col-md-6">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Download CSV
                </div>
                <div class="panel-body">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <a href="<?php echo site_url('admin/csv/download'); ?>" class="btn btn-success">Download</a>
                            </div>
                            <br/>
                        </div> 
                        <div class="clearfix"></div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
        <div class="clearfix"></div>
    </div>
</div>