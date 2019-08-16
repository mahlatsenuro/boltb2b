<div id="page-inner">
<?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Create user</h2>   
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

                <a href="<?php echo site_url('admin/users/'); ?>" class="btn btn-success btn-sm">
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
                    Create user
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                            <div class="form-group">
                                <label>First Name:</label>
                                <?php echo form_input($first_name) ?>
                                <?php echo form_error('first_name') ?>
                            </div>
                            
                            <div class="form-group">
                                <label>Last Name:</label>
                                <?php echo form_input($last_name) ?>
                                <?php echo form_error('last_name') ?>
                            </div>
                            <div class="form-group">
                                <label>E-Mail:</label>
                                <?php echo form_input($email) ?>
                                <?php echo form_error('email') ?>
                            </div>
                            <div class="form-group">
                                <label>Company:</label>
                                <?php echo form_input($company) ?>
                                <?php echo form_error('company') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Phone:</label>
                                <?php echo form_input($phone) ?>
                                <?php echo form_error('phone') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Password: (if changing password):</label>
                                <?php echo form_input($password) ?>
                                <?php echo form_error('password') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Confirm Password: (if changing password)</label>
                                <?php echo form_input($password_confirm) ?>
                                <?php echo form_error('password_confirm') ?>
                            </div>
                        
                        <?php echo form_close(); ?>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
     <?php echo form_close(); ?>
</div>
