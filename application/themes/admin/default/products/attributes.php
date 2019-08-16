<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Attributes</h2>   
            <h5>Choose attributes for product</h5>
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
                    Product Attributes
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
                                        <li class="active"><a href="<?php echo site_url('admin/products/attributes/'.$product_id); ?>"><span class="glyphicon glyphicon-random"></span>Attributes</a></li>
                                        <li><a href="<?php echo site_url('admin/products/bulk/'.$product_id); ?>"><span class="glyphicon glyphicon-folder-open"></span>Bulk Pricing</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>    
                    <div class="product_attribute_area">
                       
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">Attributes</a></li>
                                <?php if($inventory == 3) :?>
                                    <li><a href="<?php echo site_url('admin/products/sku/'.$product_id); ?>">Stock</a></li>
                                <?php endif; ?>
                            </ul>
                            <div id="tabs-1">
                                <h3>Attribute groups</h3>
                                <div class="row attribute">
                                    <select name="attribute_group" class="form-control attr" data-id="" >
                                        <option value="0">----Choose attribute----</option>
                                        <?php foreach ($groups as $key => $group): ?>
                                            <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('attribute_group'); ?>
                                    <br/><br/>
                                </div>
                                <div class="row">
                                    <br/>
                                    <div class="attribute_message" style="display:none"><span class="alert alert-success">Please wait..</span></div>
                                    <br/>
                                    <div id="attribute_section"></div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <input type="hidden" name="product_id" value="<?php echo $id; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>    
                </div>    
            </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            <?php if($existing_group > 0): ?>
                $('select[name=attribute_group]').val(<?php echo $existing_group; ?>);
                $('.attribute_message').show();
                var data = $('select[name=attribute_group]').closest('form').serialize(); 
                $.post( '<?php echo site_url('admin/products/group_attributes'); ?>', data)
                .done(function( data ) {
                  $('#attribute_section').html(data);
                })
                .fail(function(){
                    
                })
                .always(function(){$('.attribute_message').hide();});
            <?php endif; ?>
            $( function() {
                $( "#tabs" ).tabs({
                    beforeLoad: function( event, ui ) {
                        ui.jqXHR.fail(function() {
                          ui.panel.html(
                            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                            "If this wouldn't be a demo." );
                        });
                    }
                });
            });
            $('select[name=attribute_group]').on('change', function(e){
                e.preventDefault();
                $('.attribute_message').show();
                if($(this).val() == 0){
                    $('#attribute_section').html('');
                    $('.attribute_message').hide();
                    return false;
                }
                var data = $(this).closest('form').serialize(); 
                $.post( '<?php echo site_url('admin/products/group_attributes'); ?>', data)
                .done(function( data ) {
                  $('#attribute_section').html(data);
                })
                .fail(function(){
                    
                })
                .always(function(){$('.attribute_message').hide();});
            });
            
            $(document).on("click", ".delete", function () {
                var aID = $(this).data('id');
                $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/products/delete_attribute/'.$id); ?>/'+aID+'.html' );      
            });
            $('#dataTables-example').dataTable(); 
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
                    <p>Deleting product attribute will fully remove it from this product.<br/><br/>Really want to remove attribute ?</p>
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
