<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2><?php echo $head_title; ?> Coupon</h2>   
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/settings/coupon_code'); ?>" class="btn btn-success btn-sm new">
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
                    <?php echo $head_title; ?> Coupon
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
                            <div class="form-group">
                                <label>Coupon code:</label>
                                <?php echo form_input($code) ?>
                                <?php echo form_error('code') ?>
                            </div>
                            <div class="form-group">
                                <label>Start date:</label>
                                <?php echo form_input($start_date) ?>
                                <?php echo form_error('start_date') ?>
                            </div>
                            <div class="form-group">
                                <label>End date:</label>
                                <?php echo form_input($end_date) ?>
                                <?php echo form_error('end_date') ?>
                            </div>
                            <div class="form-group">
                                <label>Limit:</label>
                                <?php echo form_input($limit) ?>
                                <?php echo form_error('limit') ?>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label>Offer:</label>
                                        <?php echo form_input($offer) ?>
                                        <?php echo form_error('offer') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Offer type:</label>
                                        <select name="offer_type" class="form-control">
                                            <option value="percentage">Percentage</option>
                                            <option value="currency">Currency</option>
                                        </select>
                                        <?php echo form_error('offer_type') ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo form_hidden($id) ?>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-floppy-o"></i>
                                    <?php echo $head_title ?>
                                </button>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    
    <script type="text/javascript">
        $(function() {
            $( "#start_date, #end_date" ).datepicker({ dateFormat: 'yy-mm-dd'});
        });
    </script>
</div>
