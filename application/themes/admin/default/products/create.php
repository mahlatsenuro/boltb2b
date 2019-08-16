<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "product", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $head_title; ?> Product</h2>   
            <h5>Products available!</h5>
        </div>
        <div class="col-md-6">
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $head_title; ?> Product
                </div>
                <div class="panel-body">
                 
                    <div class="product_content_area">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product short name:</label>
                                    <?php echo form_input($shortname) ?>
                                    <?php echo form_error('shortname') ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success" value="Continue" />
                        </div>
                    </div>
                    
                </div>    
            </div>
            <div class="clearfix"></div>
        </div>
            <!--End Advanced Tables -->
    </div>

    <?php echo form_close(); ?>    
</div>
