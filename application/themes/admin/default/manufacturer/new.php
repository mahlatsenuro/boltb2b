<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2><?php echo $head_title; ?> Manufacturer</h2>   
            <h5>Manufactures that can be assigned to products!</h5>
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/manufacturer/'); ?>" class="btn btn-success btn-sm new">
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
                    <?php echo $head_title; ?> Manufacturer
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                         <?php echo form_open('', array('class' => 'form-new', "id" => "manu", 'data-parsley-validate' => '')); ?>
                            <div class="form-group">
                                <label>Manufacturer Name:</label>
                                <?php echo form_input($name) ?>
                                <?php echo form_error('name') ?>
                            </div>
                            <div class="form-group">
                                <label>Manufacturer Details:</label>
                                <?php echo form_input($details); ?>
                                <?php echo form_error('details') ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_hidden($id) ?>
                                <?php echo form_hidden($old) ?>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-floppy-o"></i>
                                    <?php echo $head_title ?>
                                </button>
                            </div>
                        <?php echo form_close(); ?>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <script type="text/javascript">
    
        $('#attribute').parsley();

        window.Parsley.addAsyncValidator('validateManufacturer', function (xhr) {
            console.log(xhr.responseText); // jQuery Object[ input[name="q"] ]

            if (xhr.responseText == 0){
                return false;
            }
            else{
                return true;
            }
                
        }, '<?php echo site_url('admin/manufacturer/exists/{value}');?>', { "type": "POST", "dataType": "json", "data": $('#manu').serialize() } );


    </script>
</div>
