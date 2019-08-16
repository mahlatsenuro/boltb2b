<div id="page-inner">
    <?php echo form_open('', array('class' => '')); ?>
    
    <div class="row">
        <div class="col-md-6">
            <h2>Blogs</h2>   
            <h5><?php ucfirst($option); ?> blog!</h5>
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

                <a href="<?php echo site_url('admin/content/blogs'); ?>" class="btn btn-success btn-sm">
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
                    <?php ucfirst($option); ?> blog
                </div>
                <div class="panel-body">
                    
                    <div class="form-group">
                        <div class=""> 
                            <label>Title</label>
                            <?php echo form_input($title); ?>
                            <?php echo form_error("title"); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class=""> 
                            <label>Contents</label>
                            <textarea name="content" id="terms"><?php echo $content; ?></textarea>
                            <?php echo form_error('content') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'content' );
                                CKEDITOR.config.height = 500;
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class=""> 
                            <label>Status</label>
                            <input type="checkbox" name="status" value="1" <?php echo $status == 1 ? "checked" : "" ?> >
                            <?php echo form_error("status"); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>    
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
