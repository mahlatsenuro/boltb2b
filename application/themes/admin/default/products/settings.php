<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "settings", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $product->short_name; ?> : Price variation and stocks</h2>   
            <h5>Price variation and stocks</h5>
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <?php echo form_hidden($id); ?>

                <button type="submit" name="submitForm" class="btn btn-info btn-sm" value="formSave">
                    <span class="glyphicon glyphicon-share"></span>
                    Save
                </button>

                <button type="submit" name="submitForm" class="btn btn-info btn-sm " value="formSaveClose">
                    <span class="glyphicon glyphicon-share"></span>
                    Save and Close
                </button>

                <a href="<?php echo site_url('admin/products/'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-reply"></i>
                    Back
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr /> 
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Price variation and stocks
                </div>
                <div class="panel-body">
                    
                    <div class="row">
                    
                        <div class="col-md-12">
                            <div class="product_nav">
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a href="<?php echo site_url('admin/products/new_product/'.$product_id); ?>"><span class="glyphicon glyphicon-list-alt"></span>Basic Details</a>
                                    </li>
                                    <?php if(isset($product_id) && is_numeric($product_id)): ?>
                                        <li><a href="<?php echo site_url('admin/products/manufacture/'.$product_id); ?>"><span class="glyphicon glyphicon-link"></span>Manufacturer</a></li>
                                        <li><a href="<?php echo site_url('admin/products/categories/'.$product_id); ?>"><span class="glyphicon glyphicon-link"></span>Categories</a></li>
                                        <li><a href="<?php echo site_url('admin/products/images/'.$product_id); ?>"><span class="glyphicon glyphicon-picture"></span>Images</a></li>
                                        <li><a href="<?php echo site_url('admin/products/inventory/'.$product_id); ?>"><span class="glyphicon glyphicon-picture"></span>Inventory Tracking</a></li>
                                        <li><a href="<?php echo site_url('admin/products/attributes/'.$product_id); ?>"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                        <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_attribute_area">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    Enable Offer (You must check this to save offer values): 
                                    <?php echo form_checkbox($offer); ?>
                                    <?php echo form_error('offer'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stock_group offerblock">
                            <div class="row stocks">
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <?php echo form_input($offer_value); ?>
                                        <?php form_error('offer_value'); ?>
                                    </div>    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_input($offer_from); ?>
                                        <?php echo form_error('offer_from'); ?>
                                    </div>    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_input($offer_to); ?>
                                        <?php echo form_error('offer_to'); ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                     
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                   Show new product (You must check this to save new settings): 
                                    <?php echo form_checkbox($new); ?>
                                    <?php echo form_error('new'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stock_group offerblock">
                            <div class="row stocks">
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <?php echo form_input($new_from); ?>
                                        <?php echo form_error('new_from'); ?>
                                    </div>    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_input($new_to); ?>
                                        <?php echo form_error('new_to'); ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                        
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
    <?php echo form_close(); ?>   
</div>
