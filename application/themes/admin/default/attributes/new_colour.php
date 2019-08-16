<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Option Name and Type</h2>   
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <button type="submit" name="submitForm" class="btn btn-info btn-sm" value="formSave">
                    <span class="glyphicon glyphicon-share"></span>
                    Save
                </button>

                <button type="submit" name="submitForm" class="btn btn-info btn-sm " value="formSaveClose">
                    <span class="glyphicon glyphicon-share"></span>
                    Save and Close
                </button>

                <a href="<?php echo site_url('admin/attributes/'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-reply"></i>
                    Back
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>      
    <hr />
    
    <br/>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Attributs
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Attribute Name:</label>
                            <input type="text" class="form-control" name="attribute_name" required="" value="<?php echo isset($attribs[0]->aname) ? $attribs[0]->aname : ''; ?>">
                            <?php echo form_error('attribute_name') ?>
                        </div>
                        
                        <?php if(!isset($id) || empty($id)):
                            $attributes = array('Red', 'Blue', 'Green');
                            $hex        = array('#ff0000', '#00ffff', '#40ff00');
                            $sorts      = array( 1, 2, 3);
                            else:
                                foreach ($attribs as $attr):
                                   $attributes[] = $attr->name; 
                                   $hex[]        = $attr->hex;
                                   $sorts[]      = $attr->sort;
                                   $ids[]        = $attr->id;
                                endforeach;
                            endif; ?>
                        <?php foreach ($attributes as $sort => $attribute): ?>
                            <div class="row attribute-row" style="padding: 3px 0;">
                                <div class="col-sm-4">
                                    <?php if(isset($ids[$sort])):?>
                                        <input type="hidden" class="form-control" name="ids[]" value="<?php echo $ids[$sort]; ?>" required="">
                                    <?php endif; ?>
                                        
                                    <input type="text" class="form-control" name="attr_options[]" value="<?php echo $attribute; ?>" required="">
                                </div>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control sort" name="sort[]" value="<?php echo $sorts[$sort]; ?>" min="1" />
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control hex" name="hex[]" value="<?php echo $hex[$sort] ?>" style="background: <?php echo $hex[$sort] ?>" placeholder="#000" required="" />
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-sm btn-danger remove">Remove</button>
                                    <button class="btn btn-sm btn-default add_new">Add new</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php echo form_error('attr_options') ?>
                        <?php endforeach; ?>
                            
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <?php echo form_close(); ?>
    
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery(document).on('click', '.add_new', function(e){
                e.preventDefault();
                var htm  = '<div class="row attribute-row" style="padding: 3px 0;">'
                                +'<div class="col-sm-4">'
                                    +'<input type="text" class="form-control" name="attr_options[]" required="">'
                                +'</div>'
                                +'<div class="col-sm-2">'
                                    +'<input type="number" class="form-control" name="sort[]" min="1" />'
                                +'</div>'
                                +'<div class="col-sm-2">'
                                    +'<input type="text" class="form-control hex" name="hex[]" value="" placeholder="#000" required="" />'
                                +'</div>'
                                +'<div class="col-sm-4">'
                                    +'<button class="btn btn-sm btn-danger remove">Remove</button>&nbsp;'
                                    +'<button class="btn btn-sm btn-default add_new">Add new</button>'
                                +'</div>'
                                +'<div class="clearfix"></div>'
                            +'</div>';
                jQuery( ".attribute-row" ).last().after(htm); 
            });
            
            jQuery(document).on('click', '.remove', function(e){
               e.preventDefault();
               jQuery(this).closest('.attribute-row').remove();
            });
            
            jQuery(document).on('blur', '.hex', function(){
               var col = jQuery(this).val();
               jQuery(this).css('background', col);
            });
        });
    </script>
    
</div>
