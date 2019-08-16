<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Bulk pricing</h2>   
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <?php echo form_error('product_id'); ?>
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
                    Bulk Pricing
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_content_area">
                        <div class="form-group"> 
                            <ul class="list-inline">
                                <li>Purchases between</li>
                                <li><input name="from[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[0]->quantity_from) ? $discounts[0]->quantity_from : ""; ?>" /></li>
                                <li>and</li>
                                <li><input name="to[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[0]->quantity_to) ? $discounts[0]->quantity_to : ""; ?>" /></li>
                                <li>of this product will receive a</li>
                                <li>
                                    <select name="type[]" class="form-control" tag-id=".tag-container1">
                                        <option value="1" <?php echo isset($discounts[0]->type) && $discounts[0]->type ==1 ? "selected='selected'" : ""; ?>>Price Discount</option>
                                        <option value="2" <?php echo isset($discounts[0]->type) && $discounts[0]->type ==2 ? "selected='selected'" : ""; ?>>Percentage Discount</option>
                                        <option value="3" <?php echo isset($discounts[0]->type) && $discounts[0]->type ==3 ? "selected='selected'" : ""; ?>>Fixed Price</option>
                                    </select>
                                </li>
                                <li>of</li>
                                <li><input name="discount[]" type="text"  class="form-control" value="<?php echo isset($discounts[0]->discount) ? $discounts[0]->discount : "1"; ?>"/></li>
                                <li>
                                    <span class="tag-container1">
                                    <?php
                                        $text = ""; 
                                        if(isset($discounts[0]->type) && $discounts[0]->type == 1)
                                            $text = "Rand off each individual item.";
                                        else if(isset($discounts[0]->type) && $discounts[0]->type==2)
                                            $text = "% off each individual item.";
                                        else if(isset($discounts[0]->type) && $discounts[0]->type == 3)
                                            $text = "Fixed price per item.";
                                        echo $text;
                                    ?>
                                    </span> 
                                    </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group"> 
                            <ul class="list-inline">
                                <li>Purchases between</li>
                                <li><input name="from[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[1]->quantity_from) ? $discounts[1]->quantity_from : ""; ?>" /></li>
                                <li>and</li>
                                <li><input name="to[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[1]->quantity_to) ? $discounts[1]->quantity_to : ""; ?>" /></li>
                                <li>of this product will receive a</li>
                                <li>
                                    <select name="type[]" class="form-control" tag-id=".tag-container2">
                                        <option value="1" <?php echo isset($discounts[1]->type) && $discounts[1]->type ==1 ? "selected='selected'" : ""; ?>>Price Discount</option>
                                        <option value="2" <?php echo isset($discounts[1]->type) && $discounts[1]->type ==2 ? "selected='selected'" : ""; ?>>Percentage Discount</option>
                                        <option value="3" <?php echo isset($discounts[1]->type) && $discounts[1]->type ==3 ? "selected='selected'" : ""; ?>>Fixed Price</option>
                                    </select>
                                </li>
                                <li>of</li>
                                <li><input name="discount[]" type="text"  class="form-control" value="<?php echo isset($discounts[1]->discount) ? $discounts[1]->discount : "1"; ?>"/></li>
                                <li>
                                     <span class="tag-container2">
                                    <?php
                                        $text = ""; 
                                        if(isset($discounts[1]->type) && $discounts[1]->type == 1)
                                            $text = "Rand off each individual item.";
                                        else if(isset($discounts[1]->type) && $discounts[1]->type==2)
                                            $text = "% off each individual item.";
                                        else if(isset($discounts[1]->type) && $discounts[1]->type == 3)
                                            $text = "Fixed Rand price per item.";
                                        echo $text;
                                    ?>
                                    </span> 
                                </li>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group"> 
                            <ul class="list-inline" >
                                <li>Purchases between</li>
                                <li><input name="from[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[2]->quantity_from) ? $discounts[2]->quantity_from : ""; ?>" /></li>
                                <li>and</li>
                                <li><input name="to[]" type="number" min="0" class="form-control" value="<?php echo isset($discounts[2]->quantity_to) ? $discounts[2]->quantity_to : ""; ?>" /></li>
                                <li>of this product will receive a</li>
                                <li>
                                    <select name="type[]" class="form-control" tag-id=".tag-container3">
                                        <option value="1" <?php echo isset($discounts[2]->type) && $discounts[2]->type ==1 ? "selected='selected'" : ""; ?>>Price Discount</option>
                                        <option value="2" <?php echo isset($discounts[2]->type) && $discounts[2]->type ==2 ? "selected='selected'" : ""; ?>>Percentage Discount</option>
                                        <option value="3" <?php echo isset($discounts[2]->type) && $discounts[2]->type ==3 ? "selected='selected'" : ""; ?>>Fixed Price</option>
                                    </select>
                                </li>
                                <li>of</li>
                                <li><input name="discount[]" type="text"  class="form-control" value="<?php echo isset($discounts[2]->discount) ? $discounts[2]->discount : "1"; ?>"/></li>
                                <li>
                                    <span class="tag-container3">
                                    <?php
                                        $text = ""; 
                                        if(isset($discounts[2]->type) && $discounts[2]->type == 1)
                                            $text = "Rand off each individual item.";
                                        else if(isset($discounts[2]->type) && $discounts[2]->type==2)
                                            $text = "% off each individual item.";
                                        else if(isset($discounts[2]->type) && $discounts[2]->type == 3)
                                            $text = "Fixed Rand price per item.";
                                        echo $text;
                                    ?>
                                    </span> 
                                   </li>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div class="clearfix"></div> 
                    </div>    
                </div>    
            </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
           jQuery("ul li select").on("change", function(e){ 
                e.preventDefault();
                var id   = jQuery(this).val();
                var text = ""; 
                if(id == 1)
                    text = "Rand off each individual item.";
                else if(id==2)
                    text = "% off each individual item.";
                else if(id==3)
                    text = "Fixed Rand price per item.";
                    
                jQuery(jQuery(this).attr('tag-id')).html(text);
           });
        });
    </script>
    <?php echo form_close(); ?>  
</div>
