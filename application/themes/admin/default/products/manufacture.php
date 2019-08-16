<div id="page-inner">
    <?php $product = $products[0]; ?>
    <?php echo form_open('', array('class' => 'form-new', "id" => "manu", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $product->short_name; ?> : Manufacture</h2>   
            <h5>Choose manufacture for product</h5>
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
                    Product manufactures
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/manufacture/'.$product_id); ?>"><span class="glyphicon glyphicon-link"></span>Manufacturer</a></li>
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
                    <div class="product_content_area">
                        <div class="row admin_categories">
                            <div class="col-md-6">
                                
                                <label>Select manufacture for the product:</label>
                                    <select name="manu" class="form-control" required="">
                                        <option value="">--SELECT--</option>
                                        <?php foreach ($manufactures as $key => $manu): ?>
                                            <option value="<?php echo $manu->id; ?>" <?php echo  ($product->manufacturer_id == $manu->id) ? 'selected' : '' ?>><?php echo $manu->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>   
                                    <?php echo form_error('manu'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>    
                </div>    
            </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <?php echo form_close(); ?> 
</div>
