<div id="page-inner">
    <style type="text/css">
            .cc-selector input{
            margin:0;padding:0;
            -webkit-appearance:none;
               -moz-appearance:none;
                    appearance:none;
        }
        .cc-selector-2 input{
            position:absolute;
            z-index:999;
        }
        .visa{background-image:url(http://i.imgur.com/lXzJ1eB.png);}
        .mastercard{background-image:url(http://i.imgur.com/SJbRQF7.png);}

        .visa{background-image:url(<?php echo base_url('assets/images/colllogo1.jpg'); ?>);}
        .mastercard{background-image:url(<?php echo base_url('assets/images/courierguylogo1.jpg') ?>);}

        .cc-selector-2 input:active +.drinkcard-cc, .cc-selector input:active +.drinkcard-cc{opacity: .9;}
        .cc-selector-2 input:checked +.drinkcard-cc, .cc-selector input:checked +.drinkcard-cc{
            -webkit-filter: none;
               -moz-filter: none;
                    filter: none;
        }
        .cc-selector-2 {padding: 20px 0;}
        .drinkcard-cc{
            cursor:pointer;
            background-size:contain;
            background-repeat:no-repeat;
            display:inline-block;
            width:166px;height:111px;
            -webkit-transition: all 100ms ease-in;
               -moz-transition: all 100ms ease-in;
                    transition: all 100ms ease-in;
            -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
               -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
                    filter: brightness(1.8) grayscale(1) opacity(.7);
        }
        .drinkcard-cc:hover{
            -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
               -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
                    filter: brightness(1.2) grayscale(.5) opacity(.9);
        }

        /* Extras */
        a:visited{color:#888}
        a{color:#444;text-decoration:none;}
        p{margin-bottom:.3em;}
        
        .cc-selector-2 input{ margin: 5px 0 0 12px; }
        .cc-selector-2 label{ margin-left: 7px; }
        span.cc{ color:#6d84b4 }
            
    </style>
    <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2><?php echo $head_title; ?> Delivery details</h2>   
            <h5>Please fill all informations below to help pos system!</h5>
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
    <?php require 'navs.php'; ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            Delivery details
        </div>
        <div class="panel-body">
            <div class="col-md-8">

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Free delivery:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="radio" name="free_delivery" value="1" <?php echo $this->config->item('free_delivery') == 1 ? 'checked' : '' ?> >
                            <?php echo form_error('free_delivery') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Flat rate:</label>
                        </div>
                        <div class="col-sm-1">
                            <input type="radio" name="free_delivery" value="flat" <?php echo $this->config->item('free_delivery') == 'flat' ? 'checked' : '' ?> >
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="flat_rate_delivery" class="form-control" placeholder="Flat rate" value="<?php echo $this->config->item('flat_rate_delivery'); ?>">
                            <?php echo form_error('flat_rate_delivery') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="form-group bottom-line">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Use courier prices:</label>
                        </div>
                        <div class="col-sm-1">
                            <input type="radio" name="free_delivery" value="courier" <?php echo $this->config->item('free_delivery') == 'courier' ? 'checked' : '' ?> >
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Free above:</label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" name="free_delivery_above" value="1" <?php echo $this->config->item('free_delivery_above') == '1' ? 'checked' : '' ?> >
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="free_rate_above" class="form-control" placeholder="Free after" value="<?php echo $this->config->item('free_rate_above'); ?>">
                            <?php echo form_error('free_rate_above') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <hr/>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Use my own courier</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="radio" name="courier_service"  value="self_courier" <?php echo $this->config->item('courier_service') == 'self_courier'  ? 'checked' : ''; ?> >
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <br/><br/>
                        <div class="col-sm-5">
                            <label>Select your courier</label>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="cc-selector-2">
                        <br/><br/>
                        <input type="radio" name="courier_service"  value="collivery_delivery" <?php echo $this->config->item('courier_service') == 'collivery_delivery'  ? 'checked' : ''; ?> >
                        <label for="courier_service" class="drinkcard-cc visa" for="visa2"></label>

                        <input type="radio" name="courier_service"  value="courierguy_delivery" <?php echo $this->config->item('courier_service') == 'courierguy_delivery'  ? 'checked' : ''; ?> >
                        <label for="courier_service" class="drinkcard-cc mastercard"for="mastercard2"></label>
                    </div>
                    <?php echo form_error('courier_service') ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', 'input[name=courier_service]', function(){ 
                //$(this).closest('form').append('<input type="hidden" name="service" value="1" />');
                //$(this).closest('form').submit();
                var opt = $(this).val();
                $('.couriers_area').hide();
                $('#'+opt).show();
            });
        });
    </script>
</div>

<div id="courierguy_delivery" class="couriers_area" style="display :<?php echo $this->config->item('courier_service') == 'courierguy_delivery'  ? 'block' : 'none'; ?>">
   
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Courier guy ID(Email):</label>
                <?php echo form_input($delivery_courierguy_email) ?>
                <?php echo form_error('delivery_courierguy_id') ?>
            </div>
            <div class="form-group">
                <label>Courier guy password:</label>
                <?php echo form_input($delivery_courierguy_password) ?>
                <?php echo form_error('delivery_courierguy_password') ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Courier Guy Address
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                        
                        <div class="form-group">
                            <label>Full Name:</label>
                            <?php echo form_input($delivery_courierguy_full_name) ?>
                            <?php echo form_error('delivery_courierguy_full_name') ?>
                        </div>
                        <div class="form-group">
                            <label>Company Name:</label>
                            <?php echo form_input($delivery_courierguy_company_name) ?>
                            <?php echo form_error('delivery_courierguy_company_name') ?>
                        </div>

                        <div class="form-group">
                            <label>Street:</label>
                            <?php echo form_input($delivery_courierguy_address_1) ?>
                            <?php echo form_error('delivery_courierguy_address1') ?>
                        </div>
                        <div class="form-group">
                            <label>City:</label>
                            <?php echo form_input($delivery_courierguy_address_2) ?>
                            <?php echo form_error('delivery_courierguy_address2') ?>
                        </div>
                        <div class="form-group">
                            <label>Suburb:</label>
                            <?php echo form_input($delivery_courierguy_address_3) ?>
                            <?php echo form_error('delivery_courierguy_address3') ?>
                        </div>

                        <div class="form-group">
                            <label>Area code:</label>
                            <?php echo form_input($delivery_courierguy_zip_code); ?>
                            <?php echo form_error('delivery_courierguy_zip_code') ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone:</label>
                            <?php echo form_input($delivery_courierguy_phone); ?>
                            <?php echo form_error('delivery_courierguy_phone') ?>
                        </div>
                        <div class="form-group">
                            <label>Cell No:</label>
                            <?php echo form_input($delivery_courierguy_cellphone); ?>
                            <?php echo form_error('delivery_courierguy_cellphone') ?>
                        </div>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
</div>
<div id="collivery_delivery" style="display:<?php echo $this->config->item('courier_service') == 'collivery_delivery'  ? 'block' : 'none'; ?>" class="couriers_area">
   
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Collivery ID(Email):</label>
                <?php echo form_input($collivery_email) ?>
                <?php echo form_error('delivery_collivery_id') ?>
            </div>
            <div class="form-group">
                <label>Collivery password:</label>
                <?php echo form_input($collivery_password) ?>
                <?php echo form_error('delivery_collivery_password') ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    MDS Collivery Address
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <?php echo form_input($full_name) ?>
                            <?php echo form_error('delivery_collivery_full_name') ?>
                        </div>
                        <div class="form-group">
                            <label>Company Name:</label>
                            <?php echo form_input($company_name) ?>
                            <?php echo form_error('delivery_collivery_company_name') ?>
                        </div>
                        <div class="form-group">
                            <label>Street:</label>
                            <?php echo form_input($street) ?>
                            <?php echo form_error('delivery_collivery_street') ?>
                        </div>
                        <div class="form-group">
                            <label>Town:</label>
                            
                            <select name="delivery_collivery_town" class="form-control" id="town"  autocomplete="off">
                                <option value="">--SELECT--</option>
                                <?php foreach ($towns as $town_id => $town_name): ?>
                                    <option value="<?php echo $town_id?>" <?php echo $this->config->item('delivery_collivery_town') == $town_id ? 'selected' : ''?>  ><?php echo $town_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('delivery_collivery_town') ?>
                        </div>
                        <div class="form-group">
                            <label>Suburb:</label>
                            <select name="delivery_collivery_suburb" class="form-control" id="suburb"  autocomplete="off">
                                <option value="">--SELECT--</option>
                                <?php foreach ($suburbs as $suburbs_id => $suburbs_name): ?>
                                    <option value="<?php echo $suburbs_id?>" <?php echo $this->config->item('delivery_collivery_suburb') == $suburbs_id ? 'selected' : ''?>  ><?php echo $suburbs_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('delivery_collivery_suburb') ?>
                        </div>
                        <div class="form-group">
                            <label>Location type:</label>
                            <?php echo form_dropdown('delivery_collivery_type', $types, $this->config->item('delivery_collivery_type') ? $this->config->item('delivery_collivery_type') : $this->input->post('delivery_collivery_type'), 'class="form-control" id="" required autocomplete="off"'); ?>
                            <?php echo form_error('delivery_collivery_type') ?>
                        </div>
                        <div class="form-group">
                            <label>Zip code:</label>
                            <?php echo form_input($zip_code); ?>
                            <?php echo form_error('delivery_collivery_zip_code') ?>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <?php echo form_input($email); ?>
                            <?php echo form_error('delivery_collivery_email') ?>
                        </div>
                        <div class="form-group">
                            <label>Phone:</label>
                            <?php echo form_input($phone); ?>
                            <?php echo form_error('delivery_collivery_phone') ?>
                        </div>
                        <div class="form-group">
                            <label>Cell No:</label>
                            <?php echo form_input($cellphone); ?>
                            <?php echo form_error('delivery_collivery_cellphone') ?>
                        </div>
                    </div>    
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php if(isset($address->town_id) || $this->input->post('town')): ?>
                   $('#suburb').html('<option value="">Please wait..</option>'); 
                   var id  = <?php echo $this->config->item('delivery_collivery_town') ? $this->config->item('delivery_collivery_town') : $this->input->post('delivery_collivery_town') ?>;
                   var sub = <?php echo $this->config->item('delivery_collivery_suburb') ? $this->config->item('delivery_collivery_suburb') : $this->input->post('delivery_collivery_suburb') ?>;
                   
                   var request = $.ajax({
                          url: "<?php echo base_url('admin/address/get_suburb'); ?>/"+id+"/"+sub,
                          method: "GET",
                          dataType: "html"
                    });

                    request.done(function( result ) {
                         $('#suburb').html(result);
                    });

                    request.fail(function( jqXHR, textStatus ) {
                          alert( "Request failed: " + textStatus );
                    });
                    
            <?php endif; ?>
            
            $('#town').on('change', function(){
                var id = $(this).val();
                $('#suburb').html('<option value="">Please wait..</option>');
                if ( id != ''){
                    var request = $.ajax({
                          url: "<?php echo base_url('admin/address/get_suburb'); ?>/"+id,
                          method: "GET",
                          dataType: "html"
                    });
                    request.done(function( result ) {
                         $('#suburb').html(result);
                    });
                    request.fail(function( jqXHR, textStatus ) {
                          alert( "Request failed: " + textStatus );
                    });

                }
                else{
                  $('#suburb').html('<option value="">Please select a town..</option>');
                }
            });
           
        });
    </script>
    <?php echo form_close(); ?>
</div>
