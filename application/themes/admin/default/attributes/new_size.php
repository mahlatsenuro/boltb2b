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
                            <label>Attribute Name(How it display for customer):</label>
                            <input type="text" class="form-control" name="attribute_name" required="" value="<?php echo $attribute_name; ?>">
                            <?php echo form_error('attribute_name') ?>
                        </div>
                        
                        <div class="form-group">
                            <label>System Attribute Name(How it display in admin):</label>
                            <input type="text" class="form-control" name="system_name" required="" value="<?php echo $system_name; ?>">
                            <?php echo form_error('system_name') ?>
                        </div>
                        
                        <?php if(!isset($id) || empty($id)): 
                            $attributes = isset($options)   ? $options   : array( 'Small', 'Medium', 'Large');
                            $sorts      = isset($sort)      ? $sort      : array( 1, 2, 3);
                            $ids        = isset($ids)       ? $ids : array();                            
                        endif; ?>
                        <?php foreach ($attributes as $sort => $attribute): ?>
                            <div class="row attribute-row" style="padding: 3px 0;">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="attr_options[]" value="<?php echo $attribute; ?>" required="">
                                    <?php echo form_error('attr_options') ?>
                                </div>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control sort" name="sort[]" value="<?php echo $sorts[$sort]; ?>" min="1" required="" />
                                    <?php echo form_error('sort') ?>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-sm btn-danger remove">Remove</button>
                                    <button class="btn btn-sm btn-default add_new">Add new</button>
                                </div>
                                <?php if(isset($ids[$sort]) && !empty($ids[$sort])): ?>
                                    <input type="hidden" name="ids[]" value="<?php echo $ids[$sort] ?>" />
                                    <?php echo form_error('ids[]') ?>
                                <?php endif; ?>
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
                                    +'<input type="number" class="form-control" name="sort[]" min="1" required/>'
                                +'</div>'
                                +'<div class="col-sm-6">'
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
        });
    </script>
    
</div>
