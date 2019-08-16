<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2><?php echo $product->short_name; ?> : Update attribute</h2>   
            <h5>Edit Attribute</h5>
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
                    Update Product Attributes
                </div>
                <div class="panel-body">
                    
                    <div class="row">
                    
                        <div class="col-md-12">
                            <div class="product_nav">
                                <ul class="nav nav-tabs">
                                    <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span>Basic Details</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-link"></span>Manufacturer</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-link"></span>Categories</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-picture"></span>Images</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-picture"></span>Inventory Tracking</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                    <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_attribute_area">
                                                
                        <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); $index = 0; ?>
                 
                        <div class="stock_group">
                            <h3>Update stock</h3>
                            <div class="row stocks">
                                <div class="col-md-3"> 
                                    <select name="attribute1" class="form-control stock_price" data-id="<?php echo $key1; ?>">
                                        <option value="">----Choose attribute 1----</option>
                                        <?php foreach ($attributes as $key => $attribute): ?>
                                            <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>" <?php echo ($attribute->paid == $product->attribute_id1) ? 'selected' : '' ?>><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute1'); ?>
                                </div>
                                <div class="col-md-3">
                                    <select name="attribute2" class="form-control attr" data-id="0">
                                        <option value="">----Choose attribute 2----</option>
                                        <?php foreach ($attributes as $key => $attribute): ?>
                                            <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>" <?php echo ($attribute->paid == $product->attribute_id2) ? 'selected' : '' ?>><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute2'); ?>
                                </div>
                                <div class="col-md-3">
                                    <select name="attribute3" class="form-control attr" data-id="0">
                                        <option value="">----Choose attribute 3----</option>
                                        <?php foreach ($attributes as $key => $attribute): ?>
                                            <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>" <?php echo ($attribute->paid == $product->attribute_id3) ? 'selected' : '' ?>><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute3'); ?>
                                </div>
                                <div class="col-md-3">
                                    &nbsp;
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row stocks">
                                <div class="col-md-3"> 
                                    <select name="attribute4" class="form-control attr" data-id="0">
                                        <option value="">----Choose attribute 4----</option>
                                        <?php foreach ($attributes as $key => $attribute): ?>
                                            <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>" <?php echo ($attribute->paid == $product->attribute_id4) ? 'selected' : '' ?>><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute4'); ?>
                                </div>
                                <div class="col-md-3">
                                    <select name="attribute5" class="form-control attr" data-id="0">
                                        <option value="">----Choose attribute 5----</option>
                                        <?php foreach ($attributes as $key => $attribute): ?>
                                            <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>" <?php echo ($attribute->paid == $product->attribute_id5) ? 'selected' : '' ?>><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute5'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row stocks">
                                <div class="col-md-3"> 
                                    <input type="text" class="form-control price<?php echo $key1; ?>" name="price_variation" placeholder="Price variation:" data-parsley-type="number" value="<?php echo $product->price_variation; ?>" required="">
                                    <?php echo form_error('price_variation'); ?>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control stock<?php echo $key1; ?>" name="total_stock" placeholder="Total stock available:" data-parsley-type="digits" value="<?php echo $product->quantity; ?>" required="">
                                    <?php echo form_error('total_stock'); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"> 
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <br/><br/>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_hidden($id); ?>
                                    <button type="submit" name="" class="btn btn-info btn-md">
                                        <span class="glyphicon glyphicon-share"></span>
                                        Update
                                    </button>
                                    <a href="<?php echo site_url('admin/products/stocks/'.$id); ?>" class="btn btn-primary btn-md">
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


