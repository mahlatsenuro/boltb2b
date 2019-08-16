<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $product->short_name; ?> : Categories</h2>   
            <h5>Choose categories for product</h5>
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
                    Product categories
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/categories/'.$product_id); ?>"><span class="glyphicon glyphicon-link"></span>Categories</a></li>
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
                                    
                                    <label>Select categories to which you would like to assign this product:</label>
                                   
                                    <?php echo buildCategory(0, $categories, $existing_categories); ?>  
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
            $('input[type=checkbox]').click(function () {
                $(this).parent().find('li input[type=checkbox]').prop('checked', $(this).is(':checked'));
                var sibs = false;
                $(this).closest('ul').children('li').each(function () {
                    if($('input[type=checkbox]', this).is(':checked')) sibs=true;
                })
                $(this).parents('ul').prev().prop('checked', sibs);
            });
        </script>
    </div>
    <?php echo form_close(); ?>  
</div>
