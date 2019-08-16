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
            <div class="col-md-3"> <label>Import from Posibolt</label> </div>
            <div class="col-md-4">
                <input type="checkbox" name="posecom_posoption"  <?php echo $this->config->item('posecom_posoption') == 'posibolt' ? 'checked' : '' ?> value="posibolt" />
                <?php echo form_error('posecom_posoption') ?>
            </div>
            <div class="col-md-3">
                <a href="<?php echo site_url('admin/settings/posi_describe'); ?>" class="btn btn-sm btn-warning">View Data</a>
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
                        <a href="<?php echo $this->config->item('posecom_posoption') == 'micomp' ? site_url('/data_mapper/') : site_url('/'.$this->config->item('posecom_posoption').'/'); ?>" target="_blank" class="btn btn-success btn-lg" id="sync">Sync now</a>
                        <a href="<?php echo site_url('admin/settings/posibolt_log'); ?>" class="btn btn-lg btn-warning">View Log</a>
                        <br/><br/>
                        <div class="sync-notification" style="display: none">
                            <img src="<?php echo base_url('assets/images/ellipsis.gif'); ?>">
                            <span class="alert alert-success sync-message">Processing..</span>
                        </div>
                        <br/>
                        
                        <?php if( $this->config->item('posecom_posoption') == 'posibolt'): ?>
                        <?php require APPPATH.'views/admin/settings/sync_timings.php'; endif; ?>
                        
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Posibolt
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Posibolt domain url</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_url" required="" value="<?php echo $this->config->item('posibolt_url') ?>" />
                            <?php echo form_error('posibolt_url') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Auth Username</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_auth_username" required="" value="<?php echo $this->config->item('posibolt_auth_username') ?>" />
                            <?php echo form_error('posibolt_auth_username') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Auth Password</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_auth_password" required="" value="<?php echo $this->config->item('posibolt_auth_password') ?>" />
                            <?php echo form_error('posibolt_auth_password') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Posibolt Username</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_username" required="" value="<?php echo $this->config->item('posibolt_username') ?>" />
                            <?php echo form_error('posibolt_username') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Posibolt Password</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_password" required="" value="<?php echo $this->config->item('posibolt_password') ?>" />
                            <?php echo form_error('posibolt_password') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Terminal</label> </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="posibolt_terminal" required="" value="<?php echo $this->config->item('posibolt_terminal') ?>" />
                            <?php echo form_error('posibolt_terminal') ?>
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
            $("#sync").click(function(event){
                event.preventDefault();
                var link = $(this).attr("href");

                $(".sync-notification img").show("fast");
                $(".sync-notification span").removeClass('alert-danger').text("Processing..");
                $(".sync-notification").show("slow");


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
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

