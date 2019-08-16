<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "stock", 'data-parsley-validate' => '')); $index = 0; ?>
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
                        <?php echo validation_errors('<div class="error">', '</div>'); ?>     <div class="stock_group">
                                <div class="row stocks">
                                    <div class="col-md-3"> 
                                        <select name="attribute1" class="form-control stock_price" data-id="0">
                                            <option value="">----Choose attribute 1----</option>
                                            <?php foreach ($attributes as $key => $attribute): ?>
                                                <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>"><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('attribute1'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="attribute2" class="form-control attr" data-id="0">
                                            <option value="">----Choose attribute 2----</option>
                                            <?php foreach ($attributes as $key => $attribute): ?>
                                                <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>"><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('attribute2'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="attribute3" class="form-control attr" data-id="0">
                                            <option value="">----Choose attribute 3----</option>
                                            <?php foreach ($attributes as $key => $attribute): ?>
                                                <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>"><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('attribute3'); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row stocks">
                                    <div class="col-md-3"> 
                                        <select name="attribute4" class="form-control attr" data-id="0">
                                            <option value="">----Choose attribute 4----</option>
                                            <?php foreach ($attributes as $key => $attribute): ?>
                                                <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>"><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('attribute4'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="attribute5" class="form-control attr" data-id="0">
                                            <option value="">----Choose attribute 5----</option>
                                            <?php foreach ($attributes as $key => $attribute): ?>
                                                <option value="<?php echo $attribute->paid; ?>" data-aid="<?php echo $attribute->at_id; ?>"><?php echo $attribute->at_name.' : '.$attribute->value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('attribute5'); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row stocks">
                                    <div class="col-md-3"> 
                                        <input type="text" class="form-control price0" name="price_variation" placeholder="Price variation:" data-parsley-type="number" >
                                        <?php echo form_error('price_variation'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control stock0" name="total_stock" placeholder="Total stock available:" data-parsley-type="digits">
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
                        

                        <div class="stock_group">
                            <h3>Existing Stock Price!</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Attribute1</th>
                                            <th>Attribute2</th>
                                            <th>Attribute3</th>
                                            <th>Attribute4</th>
                                            <th>Attribute5</th>
                                            <th>Stock</th>
                                            <th>Price Variation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php if($all && count($all) > 0): ?>
                                            <?php foreach ($all as $key1 => $attr ):  ?>
                                                <tr class="<?php ($key1%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                                    <td><?php echo ( $key1+1 ); ?></td>    
                                                    <td>
                                                        <?php 
                                                            foreach ($attributes as $at)
                                                            {
                                                                if ($at->paid == $attr->attribute_id1)
                                                                {
                                                                    echo $at->at_name.' : '.$at->value; break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            foreach ($attributes as $at)
                                                            {
                                                                if ($at->paid == $attr->attribute_id2)
                                                                {
                                                                    echo $at->at_name.' : '.$at->value; break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            foreach ($attributes as $at)
                                                            {
                                                                if ($at->paid == $attr->attribute_id3)
                                                                {
                                                                    echo $at->at_name.' : '.$at->value; break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            foreach ($attributes as $at)
                                                            {
                                                                if ($at->paid == $attr->attribute_id4)
                                                                {
                                                                    echo $at->at_name.' : '.$at->value; break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            foreach ($attributes as $at)
                                                            {
                                                                if ($at->paid == $attr->attribute_id5)
                                                                {
                                                                    echo $at->at_name.' : '.$at->value; break;
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $attr->quantity;?></td>
                                                    <td><?php echo $attr->price_variation;?></td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="<?php echo site_url('admin/products/edit_stock/'.$product->id.'/'.$attr->spaid); ?>">
                                                            <i class="fa fa-edit "></i> 
                                                            Edit
                                                        </a>
                                                        <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $attr->spaid; ?>">
                                                            <i class="fa fa-times"></i>
                                                            Delete
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>    
                </div>    
            </div>
            </div>
            <script type="text/javascript">
                    $(document).ready( function() {
                        $('#dataTables-example').dataTable(); 
                    });
                    
            </script>
        </div>
    </div>
    <script>
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/products/delete_stock/'.$id); ?>/'+aID+'.html' );
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
                    <p>Deleting a stock price will remove it from the products stock section.<br/><br/>Really want to continue ?</p>
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
