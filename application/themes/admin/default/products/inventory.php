<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Inventory Tracking</h2>   
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
                    Product inventory
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/inventory/'.$product_id); ?>"><span class="glyphicon glyphicon-picture"></span>Inventory Tracking</a></li>
                                        <li><a href="<?php echo site_url('admin/products/attributes/'.$product_id); ?>"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                        <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_content_area">
                        <p>Tracking method</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><input type="radio" name="inventory" value="1" required="" <?php echo $inventory == 1 ? 'checked' : '' ?> />&nbsp;&nbsp;Do not track inventory for this product.</p>
                                </div>
                                <div class="form-group">
                                    <p><input type="radio" name="inventory" value="2" required="" <?php echo $inventory == 2 ? 'checked' : '' ?>/>&nbsp;&nbsp;Track inventory for this product.</p>
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-4">
                                            <div class="invent_track" style="display: <?php echo $inventory == 2 ? 'block' : 'none' ?>;">
                                                <div class="form-group">
                                                    <label>Stock</label>
                                                    <input name="stock" type="number" class="form-control" value="<?php echo $stock; ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Min. stock</label>
                                                    <input name="stock_min" type="number" class="form-control" value="<?php echo $stock_min; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>    
                                </div>
                                <div class="form-group">
                                    <p><input type="radio" name="inventory" value="3" required="" <?php echo $inventory == 3 ? 'checked' : '' ?>/>&nbsp;&nbsp;Track inventory by its attributes.</p>
                                    <?php echo form_error('inventory'); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                    </div>    
                </div>    
            </div>
            </div>
            <!--End Advanced Tables -->
        </div>
        <script>
            $('input[type=radio]').click(function () { 
                var invent = $(this).val();
                if(invent == 2){
                    $('.invent_track').show();
                }
                else{
                    $('.invent_track').hide();
                }
            });
        </script>
    </div>
    <?php echo form_close(); ?>  
</div>
