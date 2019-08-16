<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "category", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Attribute Group</h2>   
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
                    Attribute Group
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Group Name: ( <span style="color:red">If its a system generated group name, please don't change it!</span> )</label>
                            <input type="text" class="form-control" name="group_name" required="" value="<?php echo $group_name; ?>">
                            <?php echo form_error('group_name') ?>
                        </div>
                        <?php $attr_parts = fill_chunck($attributes, 4);  ?>
                        <label>Available attributes(Please check to add):</label>
                        <div class="row">
                            <?php foreach ($attr_parts as $attr_pars): ?>
                                <div class="col-md-4">
                                    <?php foreach ($attr_pars as $attr1): ?>
                                    <p><input type="checkbox" <?php echo in_array($attr1->id, $attribute_ids) ? 'checked' : ''; ?> name="members[]" value="<?php echo $attr1->id; ?>" />&nbsp;<a href="<?php echo site_url('admin/attributes/new_'.$attr1->type.'/'.$attr1->id); ?>" target="_blank"><?php echo $attr1->name; ?></a> &nbsp;&nbsp;&nbsp;<input class="form-control" type="number" name="sort[]" value="" placeholder="Sort" /></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php echo form_error('members'); ?>
                            <div class="clearfix"></div>
                        </div>
                            
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <?php echo form_close(); ?>
</div>
