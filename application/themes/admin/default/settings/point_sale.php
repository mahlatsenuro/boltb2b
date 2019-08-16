<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Front End</h2>   
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

                <a href="<?php echo site_url('admin/'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-reply"></i>
                    Back
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <?php require 'sub_navs.php'; ?>
    
    <div class="row">
        <div class="form-group">
            <div class="col-md-4"> <label>Import from Micomp</label> </div>
            <div class="col-md-6">
                <input type="checkbox" name="posecom_posoption"  <?php echo $this->config->item('posecom_posoption') == 'micomp' ? 'checked' : '' ?> value="micomp" />
                <?php echo form_error('posecom_posoption') ?>
            </div>
            <div class="clearfix"></div>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sync Products
                </div>
                <div class="panel-body">
                    <div class="sync-area">
                        <a href="<?php echo $this->config->item('posecom_posoption') == 'micomp' ? site_url('/data_mapper/') : site_url('/'.$this->config->item('posecom_posoption').'/'); ?>" target="_blank" class="btn btn-success btn-lg sync" id="sync">Sync now</a>
                        <br/><br/>
                        <br/>
                        <?php if( $this->config->item('posecom_posoption') == 'micomp'): ?>
                        <?php require 'sync_timings.php'; endif; ?>
                        
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <?php if($this->config->item('posecom_posoption') == 'micomp'): ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sync Users
                </div>
                <div class="panel-body">
                    <div class="sync-area">
                        <?php if($this->config->item('posecom_posoption') == 'micomp'): ?>
                            <a href="<?php echo $this->config->item('posecom_posoption') == 'micomp' ? site_url('/data_mapper/sync_users') : site_url('/'.$this->config->item('posecom_posoption').'/'); ?>" target="_blank" class="btn btn-success btn-lg sync" id="sync">Sync Users</a>
                        <?php endif; ?>
                        <br/><br/>
                        
                        <br/>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    MICOMP
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>NoIP allocated URL</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="micomp_host_address" value="<?php echo $this->config->item('micomp_host_address') ?>" />
                            <?php echo form_error('micomp_host_address') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Database name</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="micomp_database" value="<?php echo $this->config->item('micomp_database') ?>" />
                            <?php echo form_error('micomp_database') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Username</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="micomp_username" value="<?php echo $this->config->item('micomp_username') ?>" />
                            <?php echo form_error('micomp_username') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Password</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="password" name="micomp_password" value="<?php echo $this->config->item('micomp_password') ?>" />
                            <?php echo form_error('micomp_password') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu level 1</label> </div>
                        <div class="col-md-6">
                            <select name="micomp_menu_level1" class="form-control">
                                <option value="">--SELECT--</option>
                                <option value="category" <?php echo $this->config->item('micomp_menu_level1') == 'category' ? 'selected' : '' ?>>Category</option>
                                <option value="dept" <?php echo $this->config->item('micomp_menu_level1') == 'dept' ? 'selected' : '' ?>>Department</option>
                                <option value="type" <?php echo $this->config->item('micomp_menu_level1') == 'type' ? 'selected' : '' ?>>Type</option>
                            </select>
                            <?php echo form_error('micomp_menu_level1') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu level 2</label> </div>
                        <div class="col-md-6">
                            <select name="micomp_menu_level2" class="form-control">
                                <option value="">--SELECT--</option>
                                <option value="category" <?php echo $this->config->item('micomp_menu_level2') == 'category' ? 'selected' : '' ?>>Category</option>
                                <option value="dept" <?php echo $this->config->item('micomp_menu_level2') == 'dept' ? 'selected' : '' ?>>Department</option>
                                <option value="type" <?php echo $this->config->item('micomp_menu_level2') == 'type' ? 'selected' : '' ?>>Type</option>
                            </select>
                            <?php echo form_error('micomp_menu_level2') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu level 3</label> </div>
                        <div class="col-md-6">
                            <select name="micomp_menu_level3" class="form-control">
                                <option value="">--SELECT--</option>
                                <option value="category" <?php echo $this->config->item('micomp_menu_level3') == 'category' ? 'selected' : '' ?>>Category</option>
                                <option value="dept" <?php echo $this->config->item('micomp_menu_level3') == 'dept' ? 'selected' : '' ?>>Department</option>
                                <option value="type" <?php echo $this->config->item('micomp_menu_level3') == 'type' ? 'selected' : '' ?>>Type</option>
                            </select>
                            <?php echo form_error('micomp_menu_level3') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
           $("input[type=color]").change(function(){
               var name = $(this).attr('data-id');
               $("input[name="+name+"]").val($(this).val());
           }) ;
        });
    </script>
    <script>
        $(document).ready( function() {
            $(".sync").click(function(event){
                event.preventDefault();
                var link = $(this).attr("href");
                var th   = $(this);  
                var img  = $(".sync-notification img");
                var span = $(".sync-notification span");
                var not  = $(".sync-notification");
                img.show("fast");
                span.removeClass('alert-danger').text("Processing..");
                not.show("slow");


                var jqxhr = $.get( link, function() { 
                })
                .done(function() {
                  $(".sync-notification span").text("Sync completed!");
                })
                .fail(function() {
                  $(".sync-notification span").addClass('alert-danger').text("Sync failed!");
                })
                .always(function() {
                  $(".sync-notification img").hide("slow");
                });
            });
        });
    </script>
    <?php echo form_close(); ?>
</div>
<div class="sync-notification" style="display: none; position: fixed; top: 40%; left: 50%; z-index: 9999;">
    <img src="<?php echo base_url('assets/images/ellipsis.gif'); ?>">
    <span class="alert alert-success sync-message">Processing..</span>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

