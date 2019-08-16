<div id="page-inner">
    <?php $stock_data = array(); ?>
    <?php foreach ($stocks  as $key => $stock): 
        if(isset($stock_data[$stock->spaid])){
            $stock_data[$stock->spaid]['name'] .= '<br/><span>'.$stock->aname.' : '.$stock->aoname.'</span>'; 
            continue;
        }
        $stock_data[$stock->spaid]['name']      = '<span>'.$stock->aname.' : '.$stock->aoname.'</span>';
        $stock_data[$stock->spaid]['stock']     = $stock->quantity;
        $stock_data[$stock->spaid]['min_stock'] = $stock->min_quantity;
        $stock_data[$stock->spaid]['price']     = $stock->price_variation;
        
    endforeach; $attr_names = array(); ?>
    <div class="row">
        <div class="col-md-8">
            <h2>Product Attributes</h2>   
        </div>
        <div class="clearfix"></div>
    </div>   
    <a data-toggle="modal" data-target="#myModal2" class="btn btn-success btn-sm new">
        <i class="fa fa-sign-out"></i>
        Create New
    </a>
    <hr />
    <?php echo form_open('', array('class' => 'form-inline')); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="attributes">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Attribute</th>
                                    <th>Price variation</th>
                                    <th>Stock</th>
                                    <th>Minimum stock</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php $ind = 0; foreach ($stock_data  as $key => $stock): $stock = (object)$stock; ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( ++$ind ); ?></td>
                                        <td>
                                            <?php echo $stock->name; ?> 
                                        </td>
                                        <td><?php echo $stock->price; ?></td>
                                        <td><?php echo $stock->stock; ?></td>
                                        <td><?php echo $stock->min_stock; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm edit" href="#" data-id="<?php echo $key ?>">
                                                <i class="fa fa-edit "></i> 
                                                Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $key; ?>">
                                                <i class="fa fa-times"></i>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <?php echo form_close(); ?>
    <script>
        $(document).ready(function () {
            $('#attributes').dataTable(); 
            
            $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/products/delete_stock/'.$product_id.'/'); ?>/'+aID+'.html' );
        });
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
                    <p>Really want to delete stock ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
    
    <div id="myModal2" class="modal fade" role="dialog">
        <?php echo form_open('', array()); ?>
        <div class="modal-dialog">

          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create a SKU</h4>
                </div>
                <div class="modal-body">
                    
                    <span class="alert alert-warning msg_box" style="display:none">Please wait..</span>
                    
                    <div class="form-group">
                        <label>Price variation</label>
                        <input type="text" class="form-control" value="0" name="price_variation" />
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" class="form-control"  name="sku" required=""/>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="text" class="form-control" value="0" name="stock" />
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label>Low stock level</label>
                        <input type="text" class="form-control" value="0" name="low_stock" />
                    </div>
                    <?php $previous = ''; ?>
                    <div class="attribute_list">
                    <?php foreach($attributes as $attribute): 
                        if($attribute->aid != $previous){ ?>
                            <input type="hidden" name="attr_names[]" value="<?php echo clean($attribute->aname); ?>" />
                            <?php $attr_names[] = clean($attribute->aname); ?>
                        <?php
                            echo '<div class="clearfix"></div><h3>'.$attribute->aname.'</h3>';
                        }
                        echo '<div class="col-md-6"><p><input checked="checked" type="radio" name="'.clean($attribute->aname).'" value="'.$attribute->aoid.'"> '.$attribute->aoname.'</p></div>';
                        $previous = $attribute->aid;
                    endforeach; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_attribute" />
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                    <input type="hidden" name="stock_id" value="" />
                    <button  class="btn btn-danger btn-sm" type="submit" id="saveAttribute">Save</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.msg_box').show();
                var stock_id = $(this).attr('data-id'); 
                $.post( '<?php echo site_url('admin/products/get_stocks'); ?>', {stock_id : stock_id, product_id : <?php echo $product_id ?> })
                .done(function( data ) { 
                    var info = jQuery.parseJSON(data);
                    if(info.success == 1){
                        $('input[name=price_variation]').val(info.data.price_variation);
                        $('input[name=stock]').val(info.data.quantity);
                        $('input[name=low_stock]').val(info.data.min_quantity);
                        $('input[name=stock_id]').val(info.data.id);
                        $('input[name=sku]').val(info.data.sku);
                        <?php $ind = 1; $aids =array(); foreach ($attr_names as $attribute): ?>
                            $("input[name=<?php echo $attribute; ?>][value="+info.data.attribute_id<?php echo $ind; ?>+"]").prop('checked', true);
                        <?php ++$ind; endforeach; ?>
                    }
                })
                .always(function(){
                    $('.msg_box').hide();
                });
                $('#myModal2').modal('show');
            });
            $(document).on('click', '#saveAttribute', function(e){
                e.preventDefault();
                var data = $(this).closest('form').serialize();
                $.post( '<?php echo site_url('admin/products/stock_price_update'); ?>', data) 
                .done(function( data ) {
                  
                })
                .fail(function(){
                    
                })
                .always(function(){ location.href='<?php echo site_url("/admin/products/attributes/".$product_id); ?>'; });
            });
        });
    </script>
</div>
