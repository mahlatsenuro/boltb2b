<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "manu", 'data-parsley-validate' => '')); $index = 0; ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Emails</h2>   
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

                <a href="<?php echo site_url('admin/dashboard/'); ?>" class="btn btn-success btn-sm">
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
            <div class="product_nav">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?php echo site_url('admin/abandoncart'); ?>">Abandoned cart</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo site_url('admin/abandoncart/email'); ?>">Email</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Abandon cart
                </div> 
                <div class="panel-body">
                    
                    <div class="row">
                        <div class="col-md-1">
                            <button class="send_mail btn btn-success">Send email</button>
                        </div>
                        <div class="col-md-9">
                            <span class="alert alert-info message" style="display: none;"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Email template:</label>
                                <textarea name="abandoned_email"><?php echo $this->config->item('abandoned_email'); ?></textarea>
                                <script>
                                    // Replace the <textarea id="editor1"> with a CKEditor
                                    // instance, using default configuration.
                                    CKEDITOR.replace( 'abandoned_email' );
                                </script>
                            </div>    
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                </div>
            </div>
            
            <script type="text/javascript">
                $(document).ready(function(){
                   $('.send_mail').on('click', function(e){
                       e.preventDefault();
                       $('.message').text('Please wait..').show();
                       $.post('<?php echo site_url('admin/abandoncart/send_email') ?>').done(function(){ $('.message').text('Email sent!'); }).always(function(){ $('.message').delay(2000).fadeOut(); });
                   });
                });
            </script>
            <!--End Advanced Tables -->
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
