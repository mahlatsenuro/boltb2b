<div id="page-inner">
    
    <?php echo form_open_multipart('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $product->short_name; ?> : Images</h2>   
            <h5>Choose images for product</h5>
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <?php echo form_hidden($id); ?>
                
                <a target="_blank" href="<?php echo site_url('products/single/'.$product->sku); ?>" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-send"></span>
                    View Product
                </a>
                
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
                    Product images
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/images/'.$product_id); ?>"><span class="glyphicon glyphicon-picture"></span>Images</a></li>
                                        <li><a href="<?php echo site_url('admin/products/inventory/'.$product_id); ?>"><span class="glyphicon glyphicon-picture"></span>Inventory Tracking</a></li>
                                        <li><a href="<?php echo site_url('admin/products/attributes/'.$product_id); ?>"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                        <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_image_area">
                        
                        <?php echo form_error('images[]'); ?>
                        <div class="row">
                            <div class="col-md-3">
                                <span>Featured image :</span>
                                
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($product->image_id) ? $product->image_id : 0; ?>]" <?php echo !isset($product->image_id) ? 'required=""' : '' ?>>
                                    </span>
                                </span>                               
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($product->image) ?  '<img width="300" src="'.getProductImage($product->image).'" class="resize">' : ''; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($product->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($product->image_id) ? $product->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$product->image_id]) && $attribute_images[$product->image_id] == $attribute->attribute_id ? "selected" : "" ?>  value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <br/><br/>
                            <div class="col-md-12">
                                <span>Other images</span>
                            </div>
                        </div>
                         
                        <div class="row">
                            <div class="col-md-3">
                                <span>Image1 :</span>
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($products[1]->image_id) ? $products[1]->image_id : 1; ?>]">
                                    </span>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($products[1]->image) ?  '<img width="300" src="'.getProductImage($products[1]->image).'" class="resize">' : ''; ?>
                                <?php if(isset($products[1]->image_id)): ?>
                                    <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $products[1]->image_id; ?>">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($products[1]->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($products[1]->image_id) ? $products[1]->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$products[1]->image_id]) && $attribute_images[$products[1]->image_id] == $attribute->attribute_id ? "selected" : "" ?> value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <span>Image2 :</span>
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($products[2]->image_id) ? $products[2]->image_id : 2; ?>]">
                                    </span>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($products[2]->image) ?  '<img width="300" src="'.getProductImage($products[2]->image).'" class="resize">' : ''; ?>
                                <?php if(isset($products[2]->image_id)): ?>
                                    <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $products[2]->image_id; ?>">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($products[2]->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($products[2]->image_id) ? $products[2]->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$products[2]->image_id]) && $attribute_images[$products[2]->image_id] == $attribute->attribute_id ? "selected" : "" ?> value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                                
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <span>Image3 :</span>
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($products[3]->image_id) ? $products[3]->image_id : 3; ?>]">
                                    </span>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($products[3]->image) ?  '<img width="300" src="'.getProductImage($products[3]->image).'" class="resize">' : ''; ?>
                                <?php if(isset($products[3]->image_id)): ?>
                                    <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $products[3]->image_id; ?>">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($products[3]->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($products[3]->image_id) ? $products[3]->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$products[3]->image_id]) && $attribute_images[$products[3]->image_id] == $attribute->attribute_id ? "selected" : "" ?> value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>                          
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <span>Image4 :</span>
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($products[4]->image_id) ? $products[4]->image_id : 4; ?>]">
                                    </span>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($products[4]->image) ?  '<img width="300" src="'.getProductImage($products[4]->image).'" class="resize" >' : ''; ?>
                                <?php if(isset($products[4]->image_id)): ?>
                                    <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $products[4]->image_id; ?>">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($products[4]->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($products[4]->image_id) ? $products[4]->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$products[4]->image_id]) && $attribute_images[$products[4]->image_id] == $attribute->attribute_id ? "selected" : "" ?> value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <span>Image5:</span>
                            </div>
                            <div class="col-md-3">
                                <span class="btn btn-info btn-file">
                                    <span class="glyphicon glyphicon-upload">
                                        Browse---- <input type="file" name="images[<?php echo isset($products[5]->image_id) ? $products[5]->image_id : 5; ?>]">
                                    </span>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <?php echo isset($products[5]->image) ?  '<img width="300" src="'.getProductImage($products[5]->image).'" class="resize" >' : ''; ?>
                                <?php if(isset($products[5]->image_id)): ?>
                                    <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $products[5]->image_id; ?>">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(isset($products[5]->image_id)): ?>
                                    <div class="form-group">
                                        <span>Assign to attribute:</span>
                                        <select name="attribute[<?php echo isset($products[5]->image_id) ? $products[5]->image_id : NULL; ?>]" class="form-control">
                                            <option value="">--NONE--</option>
                                            <?php foreach ($attributes as $attribute): ?>
                                            <option <?php echo isset($attribute_images[$products[5]->image_id]) && $attribute_images[$products[5]->image_id] == $attribute->attribute_id ? "selected" : "" ?> value="<?php echo $attribute->attribute_id; ?>"><?php echo $attribute->option_name." (".$attribute->aname.")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>                           
                            <div class="clearfix"></div>
                        </div>
                        
                        
                    </div>    
                </div>    
            </div>
            </div>
            <script type="text/javascript">
                    $(document).on('change', '.btn-file :file', function() {
                        var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                        input.trigger('fileselect', [numFiles, label]);
                    });
                    
                    $(document).ready( function() {
                        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
                            $(this).after('<span class="">'+label+'</span>')
                        });
                    });
            </script>
        </div>
    </div>
    <script>
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/products/delete_image/'.$id); ?>/'+aID+'.html' );
            // As pointed out in comments, 
            // it is superfluous to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });
    </script>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete</h4>
                </div>
                <div class="modal-body">
                    <p>Deleting product image will remove it from product details slider area.<br/><br/>Really want to remove image ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
    <?php echo form_close(); ?>    
</div>
