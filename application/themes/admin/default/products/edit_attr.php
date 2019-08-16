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
                                    <li class="active"><a href="#"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                    <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_attribute_area">
                                                
                        <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); $index = 0; ?>
                 
                        <div class="row attribute">
                            <div class="col-md-3"> 
                                <select name="attribute" class="form-control attr" data-id="0" required="">
                                    <?php foreach ($attributes as $key => $attribute): ?>
                                        <option value="<?php echo $attribute->at_id; ?>" <?php echo ($product->at_id == $attribute->at_id) ? 'selected' : ''; ?>><?php echo $attribute->at_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="req0" value="<?php echo $product->value; ?>" name="value" placeholder="Attribute value:"  required=""/>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="req1" value="<?php echo $product->sort; ?>" name="sort" placeholder="Sort:"/>
                            </div>
                            <div class="clearfix"></div>
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
                                    <a href="<?php echo site_url('admin/products/attributes/'.$id); ?>" class="btn btn-primary btn-md">
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


