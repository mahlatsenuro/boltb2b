<div id="page-inner">
<?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $head_title; ?> Category</h2>   
            <h5>Attributes that can be assigned to products!</h5>
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

                <a href="<?php echo site_url('admin/categories/'); ?>" class="btn btn-success btn-sm">
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
                    <?php echo $head_title; ?> Category
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                            <div class="form-group">
                                <label>Parent Category:</label>
                                <?php echo form_dropdown( "parent_category", $parent_category, $parent, 'class="form-control" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="number"' ) ?>
                                <?php echo form_error('parent_category') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Category Name:</label>
                                <?php echo form_input($name) ?>
                                <?php echo form_error('category_name') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Display Name:</label>
                                <?php echo form_input($display_name) ?>
                                <?php echo form_error('display_name') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Sort order:</label>
                                <?php echo form_input($sort) ?>
                                <?php echo form_error('sort') ?>
                            </div>
                            
                            <div class="form-group">
                                <label>Add to main menu:</label>
                                <?php echo form_checkbox($menu); ?>
                                <?php echo form_error('menu') ?>
                            </div>
                        
                            <div class="form-group">
                                <?php echo form_hidden($id) ?>
                                <?php echo form_hidden($old) ?>
                            </div>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <script type="text/javascript">
    
        $('#category').parsley();

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
