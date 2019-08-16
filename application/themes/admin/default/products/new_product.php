<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "product", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $head_title; ?> Product</h2>   
            <h5>Products available!</h5>
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
                    <?php echo $head_title; ?> Product
                </div>
                <div class="panel-body">
                    
                    <div class="row">
                    
                        <div class="col-md-12">
                            <div class="product_nav">
                                <ul class="nav nav-tabs">
                                    <li class="active">
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

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Product long name:</label>
                                        <?php echo form_input($longname) ?>
                                        <?php echo form_error('longname') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>SKU:</label>
                                        <?php echo form_input($sku) ?>
                                        <?php echo form_error('sku') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Product model:</label>
                                        <?php echo form_input($model) ?>
                                        <?php echo form_error('model') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Product description:</label>
                                        <?php echo form_textarea( $description ); ?>
                                        <?php echo form_error('description') ?>
                                        <script>
                                            // Replace the <textarea id="editor1"> with a CKEditor
                                            // instance, using default configuration.
                                            CKEDITOR.replace( 'description' );
                                        </script>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" id="checkbox1" value="1" name="featured" <?php echo $featured == 1 ? 'checked' : '' ?>>
                                            <label for="checkbox1">
                                                Featured <small>(If check this, product will display on home page. Only latest six.)</small>
                                            </label>
                                            <?php echo form_error('featured') ?>
                                        </div>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Status</label>
                                    <div class="form-group">
                                        <input type="radio" id="" value="1" style="margin-right: 4px" name="status" <?php echo $status == 1 ? 'checked' : '' ?>>Published&nbsp;&nbsp;
                                        <input type="radio" id="" value="0" style="margin-right: 4px" name="status" <?php echo $status == 0 ? 'checked' : '' ?>>Unpublished
                                        <?php echo form_error('status') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Price</label>
                                    <div class="form-group">
                                        <?php echo form_input( $price ); ?>
                                        <?php echo form_error('price') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Strike out price:</label>
                                        <?php echo form_input( $strike_price ); ?>
                                        <?php echo form_error('strike_price') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Strike out price active</label>
                                    <div class="form-group">
                                        <input type="radio" id="" value="1" style="margin-right: 4px" name="strike_status" <?php echo $strike_status == 1 ? 'checked' : '' ?>>Yes&nbsp;&nbsp;
                                        <input type="radio" id="" value="0" style="margin-right: 4px" name="strike_status" <?php echo $strike_status == 0 ? 'checked' : '' ?>>No
                                        <?php echo form_error('status') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product weight(Kg):</label>
                                        <?php echo form_input( $weight ); ?>
                                        <?php echo form_error('weight') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product height(cm):</label>
                                        <?php echo form_input( $height ); ?>
                                        <?php echo form_error('height') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product length(cm):</label>
                                        <?php echo form_input( $length ); ?>
                                        <?php echo form_error('length') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product width(cm):</label>
                                        <?php echo form_input( $width ); ?>
                                        <?php echo form_error('width') ?>
                                    </div>    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Parcel type(Only for MDS Collivery):</label>
                                        <?php echo form_dropdown( 'envelop', $parcel_types, $envelop, 'autocomplete = "off"  class="form-control"' ); ?>
                                        <?php echo form_error('envelop') ?>
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
    </div>
    
    <div class="row"><br/>
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">Search Engine Optimization</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Page Title:</label>
                                    <input type="text" name="page_title" class="form-control" value="<?php echo $product->page_title; ?>" placeholder="Page title" />
                                    <?php echo form_error('page_title') ?>
                                </div>    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Meta keywords:</label>
                                    <input type="text" name="meta_keywords" class="form-control" value="<?php echo $product->meta_keys; ?>" placeholder="Meta keywords" />
                                    <?php echo form_error('meta_keywords') ?>
                                </div>    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Meta description:</label>
                                    <input type="text" name="meta_description" class="form-control" value="<?php echo $product->meta_description; ?>" placeholder="Meta description" />
                                    <?php echo form_error('meta_description') ?>
                                </div>    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product URL:</label>
                                    <input type="text" name="product_url" class="form-control" value="<?php echo  '/'.$product->sku.'/'  ?>" placeholder="Product_url"/>
                                    <?php echo form_error('product_url') ?>
                                </div>    
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    <script type="text/javascript">
    
            window.Parsley.addAsyncValidator('validateCategory', function (xhr) {
            console.log(xhr.responseText); // jQuery Object[ input[name="q"] ]

            if (xhr.responseText == 0){
                return false;
            }
            else{
                return true;
            }
                
        }, '<?php echo site_url('admin/categories/exists/{value}');?>', { "type": "POST", "dataType": "json", "data": $('#category').serialize() } );

    </script>
    <?php echo form_close(); ?>    
</div>
