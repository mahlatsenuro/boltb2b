<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Upload image zip file here!</h2>   
            <h5>Upload image zip files here. That will be added automatically to the system.</h5>
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
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    POS Images
                </div>
                <div class="panel-body">   
                    <div class="product_attribute_area">
                        <?php echo form_open_multipart('', array('class' => 'form-new', "id" => "settings", 'data-parsley-validate' => '')); $index = 0; ?>

                        
                        <div class="stock_group offerblock">
                            <div class="row stocks">
                                <div class="form-group">
                                    <span class="btn btn-info btn-file">
                                        <span class="glyphicon glyphicon-upload">
                                            Browse---- <input type="file" name="images">
                                        </span>
                                    </span>
                                </div>    
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                     
                        <div class="row">
                            <br/><br/>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="" class="btn btn-info btn-md">
                                        <span class="glyphicon glyphicon-share"></span>
                                        Upload
                                    </button>
                                    <a href="<?php echo site_url('admin/'); ?>" class="btn btn-primary btn-md">
                                        <i class="fa fa-reply"></i>
                                        Back
                                    </a>
                                </div>    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <?php echo form_close(); ?>    
                    </div>    
                </div>    
            </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd'});
        });
    </script>
</div>
