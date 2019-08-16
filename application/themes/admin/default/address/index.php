<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2><?php echo $head_title; ?> Address</h2>   
            <h5>Address from where the parcel service collect the products from!</h5>
        </div>

        <div class="clearfix"></div>
    </div>       
    <hr />
    <?php require APPPATH.'views/admin/settings/navs.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $head_title; ?> Address
                </div>
                <div class="panel-body">
                    <div class="col-md-8">
                         <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
                            
                            <div class="form-group">
                                <label>Full Name:</label>
                                <?php echo form_input($full_name) ?>
                                <?php echo form_error('full_name') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Company Name:</label>
                                <?php echo form_input($company_name) ?>
                                <?php echo form_error('company_name') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Street:</label>
                                <?php echo form_input($street) ?>
                                <?php echo form_error('street') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Town:</label>
                                <?php echo form_dropdown('town', $towns, isset($address->town_id) ? $address->town_id : $this->input->post('town'), 'class="form-control" id="town" required="" autocomplete="off"'); ?>
                                <?php echo form_error('town') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Suburb:</label>
                                <?php echo form_dropdown('suburb', $suburbs, $this->input->post('suburb'), 'class="form-control" id="suburb" required'); ?>
                                <?php echo form_error('suburb') ?>
                            </div>
                            
                            <div class="form-group">
                                <label>Location type:</label>
                                <?php echo form_dropdown('type', $types, isset($address->location_type) ? $address->location_type : $this->input->post('type'), 'class="form-control" id="" required autocomplete="off"'); ?>
                                <?php echo form_error('type') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Zip code:</label>
                                <?php echo form_input($zip_code); ?>
                                <?php echo form_error('zip_code') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Email:</label>
                                <?php echo form_input($email); ?>
                                <?php echo form_error('email') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Phone:</label>
                                <?php echo form_input($phone); ?>
                                <?php echo form_error('phone') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Cell No:</label>
                                <?php echo form_input($cellphone); ?>
                                <?php echo form_error('cellphone') ?>
                            </div>
                        
                            <div class="form-group">
                                <label>Free delivery above amount(In R):</label>
                                <?php echo form_input($free_delivery_above); ?>
                                <?php echo form_error('free_delivery_above') ?>
                            </div>
                            
                            <div class="form-group">
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
        $(document).ready(function(){
            
            <?php if(isset($address->town_id) || $this->input->post('town')): ?>
                   $('#suburb').html('<option value="">Please wait..</option>'); 
                   
                   var id  = <?php echo isset($address->town_id) ? $address->town_id : $this->input->post('town') ?>;
                   var sub = <?php echo isset($address->suburb_id) ? $address->suburb_id : $this->input->post('suburb') ?>;
                   
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
</div>
