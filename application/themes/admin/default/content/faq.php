<div id="page-inner">
    <?php echo form_open('', array('class' => '')); ?>
    
    <div class="row">
        <div class="col-md-6">
            <h2>Contents</h2>   
            <h5>FAQ!</h5>
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    FAQ
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class=""> 
                            <label>FAQ</label>
                            <textarea name="faq" id="terms"><?php echo $this->config->item('faq'); ?></textarea>
                            <?php echo form_error('faq') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'faq' );
                                CKEDITOR.config.height = 500;
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>    
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
