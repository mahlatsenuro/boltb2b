<div id="page-inner">
    <?php echo form_open_multipart(''); ?>
    <div class="row">
        <div class="col-md-4">
            <h2>Settings Screen</h2>   
            <h5>Site settings</h5>
        </div>
        <div class="col-md-4 nav-area"></div>
        <div class="col-md-4">
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
    
    <?php require 'navs.php';?>
    <?php echo validation_errors(); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Store setup
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Name of your store</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="store_name" class="form-control" placeholder="Name of your store" value="<?php echo ($this->config->item('store_name')); ?>"/>
                            <?php echo form_error('store_name') ?>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Owners name</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="store_owner" class="form-control" placeholder="Owners name" required="" value="<?php echo ($this->config->item('store_owner')); ?>"/>
                            <?php echo form_error('store_owner') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Store email address</label> </div>
                        <div class="col-md-6">
                            <input autocomplete="off" type="text" name="store_email" class="form-control" placeholder="Store email address" data-parsley-type="email" required="" value="<?php echo ($this->config->item('store_email')); ?>"/>
                            <?php echo form_error('store_email') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Store password</label> </div>
                        <div class="col-md-6">
                            <input autocomplete="off" type="password" name="password" class="form-control" />
                            <?php echo form_error('password') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Store contact number</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="phone_number" class="form-control" placeholder="Store contact number"  required="" value="<?php echo ($this->config->item('phone_number')); ?>"/>
                            <?php echo form_error('phone_number') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Physical address</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="store_address" class="form-control" placeholder="Physical address" value="<?php echo ($this->config->item('store_address')); ?>"/>
                            <?php echo form_error('store_address') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Facebook URL</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="facebook_url" class="form-control" placeholder="Facebook url" value="<?php echo ($this->config->item('facebook_url')); ?>"/>
                            <?php echo form_error('facebook_url') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Twitter URL</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="twitter_url" class="form-control" placeholder="Twitter url" value="<?php echo ($this->config->item('twitter_url')); ?>"/>
                            <?php echo form_error('twitter_url') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Google+ URL</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="google_url" class="form-control" placeholder="Google url" value="<?php echo ($this->config->item('google_url')); ?>"/>
                            <?php echo form_error('google_url') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Add social icons</label> </div>
                        <div class="col-md-6">
                            <input type="hidden" name="social[]" value=""/>
                            <p><input type="checkbox" name="social[]" value="facebook" <?php echo $this->config->item('social')&&!empty($this->config->item('social'))&&in_array('facebook', json_decode($this->config->item('social'))) ? 'checked' : ''; ?>/>&nbsp;Facebook</p>
                            <p><input type="checkbox" name="social[]" value="twitter" <?php echo $this->config->item('social')&&!empty($this->config->item('social'))&&in_array('twitter', json_decode($this->config->item('social'))) ? 'checked' : ''; ?>/>&nbsp;Twitter</p>
                            <p><input type="checkbox" name="social[]" value="google" <?php echo $this->config->item('social')&&!empty($this->config->item('social'))&&in_array('google', json_decode($this->config->item('social'))) ? 'checked' : ''; ?>/>&nbsp;Google+</p>
                            
                            <?php echo form_error('social') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Merchant number</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="mygate_merchant_id" class="form-control" placeholder="Merchant number" required="" value="<?php echo ($this->config->item('mygate_merchant_id')); ?>"/>
                            Test : 722e564e-62d5-41fe-a1e5-cf1fb2c199a8
                            <?php echo form_error('mygate_merchant_id') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Merchant application id</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="mygate_application_id" class="form-control" placeholder="Merchant application id" required="" value="<?php echo ($this->config->item('mygate_application_id')); ?>"/>
                            Test : c433d13d-9f88-4781-8177-6b777aaa7875
                            <?php echo form_error('mygate_application_id') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Enable live transaction (Tick for live)</label> </div>
                        <div class="col-md-6">
                            <input value="1" type="checkbox" name="mygate_live_transaction" <?php echo ($this->config->item('mygate_live_transaction') == 1 ? 'checked' : '' ); ?>/>
                            <?php echo form_error('mygate_live_transaction') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>    
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Front end
                </div>
                <div class="panel-body">
                    
                     <div class="form-group">
                        <div class="col-md-4"> <label>Display style</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="grid_view_style" <?php echo ($this->config->item('grid_view_style') == 'list') ? 'checked' : ''; ?> value="list">List</label>
                            <label class="radio-inline"><input type="radio" name="grid_view_style" value="grid" <?php echo ($this->config->item('grid_view_style') == 'grid') ? 'checked' : ''; ?> >Grid</label>
                            <?php echo form_error('products_without_image') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Disable inventory tracking for all products</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="disable_inventory_tracking" <?php echo ($this->config->item('disable_inventory_tracking') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="disable_inventory_tracking" value="0" <?php echo ($this->config->item('disable_inventory_tracking') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('disable_inventory_tracking') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Display products without images</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="products_without_image" <?php echo ($this->config->item('products_without_image') == 'Yes') ? 'checked' : ''; ?> value="Yes">Yes</label>
                            <label class="radio-inline"><input type="radio" name="products_without_image" value="No" <?php echo ($this->config->item('products_without_image') == 'No') ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('products_without_image') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Show prices only if logged in:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="show_price" <?php echo ($this->config->item('show_price') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="show_price" value="0" <?php echo ($this->config->item('show_price') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('show_price') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Show product code:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="show_product_code" <?php echo ($this->config->item('show_product_code') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="show_product_code" value="0" <?php echo ($this->config->item('show_product_code') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('show_product_code') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>WhatsApp Chat Number:</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="whatsapp_no" class="form-control" placeholder="Eg: 734061803" value="<?php echo ($this->config->item('whatsapp_no')) ?>" >
                            <?php echo form_error('show_price') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>VAT %:</label> </div>
                        <div class="col-md-6">
                            <input type="number" min="0" name="vat_percentage" class="form-control" value="<?php echo ($this->config->item('vat_percentage')) ?>" >
                            <?php echo form_error('show_price') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Include VAT</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="show_vat" <?php echo ($this->config->item('show_vat') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="show_vat" value="0" <?php echo ($this->config->item('show_vat') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('show_vat') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Blogs active:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="blogs_active" <?php echo ($this->config->item('blogs_active') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="blogs_active" value="0" <?php echo ($this->config->item('blogs_active') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('show_price') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Show CUSTOMER REGISTRATION FORM:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="customer_registration" <?php echo ($this->config->item('customer_registration') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="customer_registration" value="0" <?php echo ($this->config->item('customer_registration') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('customer_registration') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Deactivate BUY NOW button if no stock</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="deactivate_buybutton" <?php echo ($this->config->item('deactivate_buybutton') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="deactivate_buybutton" value="0" <?php echo ($this->config->item('deactivate_buybutton') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('deactivate_buybutton') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Add to cart from product list( Don't activate if products have attributes)</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="add_cart_from_list" <?php echo ($this->config->item('add_cart_from_list') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="add_cart_from_list" value="0" <?php echo ($this->config->item('add_cart_from_list') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('add_cart_from_list') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Hide registration option:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="hide_registration" <?php echo ($this->config->item('hide_registration') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="hide_registration" value="0" <?php echo ($this->config->item('hide_registration') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('hide_registration') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Show product comment area:</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="radio" name="show_product_comment" <?php echo ($this->config->item('show_product_comment') == 1) ? 'checked' : ''; ?> value="1">Yes</label>
                            <label class="radio-inline"><input type="radio" name="show_product_comment" value="0" <?php echo ($this->config->item('show_product_comment') == 0) ? 'checked' : ''; ?> >No</label>
                            <?php echo form_error('show_product_comment') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Product comment area title:</label> </div>
                        <div class="col-md-6">
                                <input type="text" name="product_comment_area_title" class="form-control" value="<?php echo ($this->config->item('product_comment_area_title')) ?>" >
                            <?php echo form_error('product_comment_area_title') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <script type="text/javascript">
                        $(document).ready(function(){
                            
                            <?php  if($this->config->item('show_price') == 1): ?>
                                $(".show_price_area").hide();
                            <?php endif; ?>
                            
                            $("input[name=show_price]").click(function(){
                               var val = $(this).val();
                               if(val == 0){
                                   $(".show_price_area").show();
                               }
                               else{
                                   $(".show_price_area").hide();
                               }
                            });
                            
                        });
                    
                    </script>
                    
                    <div class="show_price_area" style="display:none;">
                        <div class="form-group">
                            <div class="col-md-4"> <label>Use website as catalogue only</label> </div>
                            <div class="col-md-6">
                                <input type="radio" name="use_catalogue" value="catalogue_only" value="1" checked="" <?php echo ($this->config->item('use_catalogue') == 1) ? 'checked' : ''; ?>>
                                <?php echo form_error('use_catalogue') ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-4"> <label>Use website as catalogue and request a quote</label> </div> 
                            <div class="col-md-6">
                                <input type="radio" name="use_catalogue" value="catalogue_and_request" value="0" <?php echo ($this->config->item('use_catalogue') == 0) ? 'checked' : ''; ?> >
                            </div>
                            <div class="clearfix"></div>  
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-md-4"> <label>Payment methods</label> </div>
                        <div class="col-md-6">
                            <label class="radio-inline"><input type="checkbox" name="payment_method[]" value="credit card" <?php echo $this->config->item('payment_method')&&!empty($this->config->item('payment_method'))&&in_array('credit card', json_decode($this->config->item('payment_method'))) ? 'checked' : ''; ?>>Credit card</label>
                            <label class="radio-inline"><input type="checkbox" name="payment_method[]" value="EFT" <?php echo $this->config->item('payment_method')&&!empty($this->config->item('payment_method'))&&in_array('EFT', json_decode($this->config->item('payment_method'))) ? 'checked' : ''; ?>>EFT</label>
                            <label class="radio-inline"><input type="checkbox" name="payment_method[]" value="On credit" <?php echo $this->config->item('payment_method')&&!empty($this->config->item('payment_method'))&&in_array('On credit', json_decode($this->config->item('payment_method'))) ? 'checked' : ''; ?>>On credit</label>
                            <?php echo form_error('payment_method[]') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Bank details for EFT</label> </div>
                        <div class="col-md-6">
                            <?php 
                            $eft_details  = array(
                                'name'        => 'eft_bank_details',
                                'id'          => 'eft_bank_details',
                                'value'       => $this->config->item('eft_bank_details'),
                                'rows'        => '5',
                                'cols'        => '10'
                            );
                            
                            ?>
                            <?php echo form_textarea( $eft_details ); ?>
                            <?php echo form_error('eft_bank_details') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'eft_bank_details' );
                            </script>
                            <?php echo form_error('eft_bank_details') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Display FAQ</label> </div>
                        <div class="col-md-6">
                            Yes <input value="1" type="radio" name="display_faq" <?php echo ($this->config->item('display_faq') == 1 ? 'checked' : '' ); ?>/>
                            No <input value="0" type="radio" name="display_faq" <?php echo ($this->config->item('display_faq') == 0 ? 'checked' : '' ); ?>/>
                            <?php echo form_error('mygate_live_transaction') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Analytics code</label> </div>
                        <div class="col-md-6">
                            <?php 
                            $footer_additions  = array(
                                'name'        => 'footer_additions',
                                'id'          => 'footer_additions',
                                'value'       => $this->config->item('footer_additions'),
                                'rows'        => '5',
                                'cols'        => '10'
                            );
                            
                            ?>
                            <?php echo form_textarea( $footer_additions ); ?>
                            <?php echo form_error('footer_additions') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'footer_additions' );
                            </script>
                            <?php echo form_error('footer_additions') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>    
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Images
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-2"> <label>Store logo(183X83)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[store_logo]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('store_logo')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('store_logo'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="link1" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link1'); ?>"/>
                            <?php echo form_error('link1') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Mobile Logo</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[mobile_logo]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('mobile_logo')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('mobile_logo'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('mobile_logo')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="1">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Banner 1 (1000 X 468)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[banner1]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('banner1')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('banner1'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('banner1')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="2">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link2" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link2'); ?>"/>
                            <?php echo form_error('link2') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                   <div class="form-group">
                        <div class="col-md-2"> <label>Banner 2 (1000 X 468)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[banner2]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('banner2')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('banner2'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('banner2')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="2">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link3" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link3'); ?>"/>
                            <?php echo form_error('link3') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Banner 3 (1000 X 468)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[banner3]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('banner3')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('banner3'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('banner3')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="3">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link4" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link4'); ?>"/>
                            <?php echo form_error('link4') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Banner 4 (1000 X 468)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[banner4]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('banner4')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('banner4'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('banner4')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="4">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link5" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link5'); ?>"/>
                            <?php echo form_error('link5"') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Banner 5 (1000 X 468)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[banner5]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('banner5')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('banner5'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-1">
                            <?php if($this->config->item('banner5')): ?>
                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="5">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            <?php endif; ?>    
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="link6" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link6'); ?>"/>
                            <?php echo form_error('link6') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Sub banner 1 (492 X 271)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[sub_banner1]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('sub_banner1')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('sub_banner1'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="link7" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link7'); ?>"/>
                            <?php echo form_error('link7') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Sub banner 2 (492 X 271)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[sub_banner2]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('sub_banner2')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('sub_banner2'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="link8" class="form-control" placeholder="URL Link" value="<?php echo $this->config->item('link8'); ?>"/>
                            <?php echo form_error('link8') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-2"> <label>Store Favicon(png)</label> </div>
                        <div class="col-md-2">
                            <span class="btn btn-info btn-file">
                                <span class="glyphicon glyphicon-upload">
                                    Browse---- <input type="file" name="images[fav_icon]">
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <?php if($this->config->item('fav_icon')): ?>
                                <img src="<?php echo loadAsset('img/'.$this->config->item('fav_icon'), 'common') ?>" class="img-responsive" />
                            <?php endif; ?>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    
                </div>    
            </div>
            <?php /*
            <div class="panel panel-default">
                <div class="panel-heading">
                    Legal Information
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-10"> 
                            <label>Terms and conditions</label>
                            <textarea name="terms" id="terms"><?php echo $this->config->item('terms'); ?></textarea>
                            <?php echo form_error('terms') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'terms' );
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-10"> 
                            <label>Returns policy</label>
                            <textarea name="policy" id="policy"><?php echo $this->config->item('policy'); ?></textarea>
                            <?php echo form_error('policy') ?>
                            <script>
                                // Replace the <textarea id="editor1"> with a CKEditor
                                // instance, using default configuration.
                                CKEDITOR.replace( 'policy' );
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </div> */ ?>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    SEO
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Meta title</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="meta_title" class="form-control" value="<?php echo $this->config->item('meta_title'); ?>"/>
                            <?php echo form_error('meta_title') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"> <label>Meta tag description</label> </div>
                        <div class="col-md-6">
                            <textarea name="meta_description" class="form-control"><?php echo $this->config->item('meta_description'); ?></textarea>
                            <?php echo form_error('meta_description') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                     <div class="form-group">
                        <div class="col-md-4"> <label>Meta keywords</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="keywords" class="form-control" value="<?php echo $this->config->item('keywords'); ?>">
                            <?php echo form_error('keywords') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Show subscription popup for customers</label> </div>
                        <div class="col-md-6">
                            Yes <input type="radio"  name="show_popup_customers" <?php echo $this->config->item('show_popup_customers') ? "checked" : ""; ?> value="1">
                            No  <input type="radio"  name="show_popup_customers" <?php echo $this->config->item('show_popup_customers') ? "" : "checked"; ?> value="0">
                            <?php echo form_error('show_popup_customers') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>    
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            POPUP
            <a target="_blank" class="btn btn-sm btn-success pull-right" href="<?php echo site_url(); ?>?type=admin">View popup on front end</a>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="popupArea hidden-xs">
                <div class="image_section">
                    <div class="overlay"></div>
                    <img src="<?php echo loadAsset('img/'.$this->config->item('image_file'), 'common'); ?>" class="img-responsive clothing-img" />
                    <div class="upload-btn-wrapper">
                        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                            <button class="btn">Upload Image</button>
                            <input type="file" name="images[image_file]" id="image_file" />
                        </form>
                    </div>

                </div>
                <div class="text-section"> 

                    <span class="close_btn">X</span> 

                    <div class="popup_logoarea text-center">
                        <img class="popup_logo" src="<?php echo loadAsset('img/'.$this->config->item('store_logo', 'common')) ?>" alt=""/>
                    </div>

                    <h2 class="subtitle text-data">
                        <a style="color: <?php echo $this->config->item('popup_title_color') ? $this->config->item('popup_title_color') : "#00A6FF"; ?>" href="#" id="popup_title" data-type="text" data-pk="1" data-url="<?php echo site_url('admin/settings/update_settings'); ?>" data-title="Enter title">
                            <?php echo $this->config->item('popup_title') ? $this->config->item('popup_title') : "Subscribe!"; ?>
                        </a>  
                        <input data-id="#popup_title" type="color" class="color_picker" name="popup_title_color" value="<?php echo $this->config->item('popup_title_color') ? $this->config->item('popup_title_color') : "#00A6FF"; ?>">
                        <div class="edit"><a href="javascript:void(0)"><i class="fa fa-pencil fa-lg"></i></a></div>
                    </h2>
                    <div class="text-data description_text">
                        <a class="description" style="color: <?php echo $this->config->item('popup_describe_color') ? $this->config->item('popup_describe_color') : "#ccc"; ?>" href="#" id="popup_describe" data-type="text" data-pk="1" data-url="<?php echo site_url('admin/settings/update_settings'); ?>" data-title="Enter text">
                            <?php echo $this->config->item('popup_describe') ? $this->config->item('popup_describe') : "Subscribe to our newsletter and get the best<br/> discounts sent directly to your inbox!"; ?>
                        </a>      
                        <input data-id="#popup_describe" type="color" class="color_picker" name="popup_describe_color" value="<?php echo $this->config->item('popup_describe_color') ? $this->config->item('popup_describe_color') : "#ccc"; ?>">
                        <div class="edit"><a href="javascript:void(0)"><i class="fa fa-pencil fa-lg"></i></a></div>
                    </div>

                    <div class="form-content text-data">
                        <input type="text" placeholder="Enter email" name="email" class="email"/> 
                        <button id="popup_btn_submit" class="btn btn-info" disabled="" style="background:<?php echo $this->config->item('popup_btn_color') ? $this->config->item('popup_btn_color') : "#5bc0de"; ?>; border:1px solid <?php echo $this->config->item('popup_btn_color') ? $this->config->item('popup_btn_color') : "#5bc0de"; ?>">SUBMIT</button> 
                        <input data-id="#popup_btn_submit" type="color" class="color_picker" name="popup_btn_color" value="<?php echo $this->config->item('popup_btn_color') ? $this->config->item('popup_btn_color') : "#5bc0de"; ?>">
                    </div>

                    <h2 class="footer_text text-data">
                        <a style="color: <?php echo $this->config->item('popup_footertext_color') ? $this->config->item('popup_footertext_color') : "#00A6FF"; ?>" href="#" id="popup_footertext" data-type="text" data-pk="1" data-url="<?php echo site_url('admin/settings/update_settings'); ?>" data-title="Enter text">
                            <?php echo $this->config->item('popup_footertext') ? $this->config->item('popup_footertext') : "Win Prizes Weekly Exclusively for YOUR COMPANY Subscribers!"; ?>
                        </a>  
                        <input data-id="#popup_footertext" type="color" class="color_picker" name="popup_footertext_color" value="<?php echo $this->config->item('popup_footertext_color') ? $this->config->item('popup_footertext_color') : "#00A6FF"; ?>">
                        <div class="edit"><a href="javascript:void(0)"><i class="fa fa-pencil fa-lg"></i></a></div>
                    </h2>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>    
    </div>
    
</div>
<script type="text/javascript">
    
        $(document).ready(function() {
            $('#popup_title, #popup_describe, #popup_footertext').editable({
                success: function(response, newValue) {
                    
                }
            });
            
            $("#image_file").change(function(){
                
                $("#uploadimage").submit();
            });
                
            $("#uploadimage").on('submit',(function(e){ 
                e.preventDefault();
                $(".clothing-img").after("<img class='loader' src='<?php echo loadAsset('img/loading.gif', 'common'); ?>'>");
                $.ajax({
                    url: "<?php echo site_url('admin/settings/image_handler'); ?>",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                success: function(data){
                    if('' != data){
                        $(".clothing-img").attr("src", data);
                        $('.loader').remove();
                    }
                    else{
                        $('.loader').replaceWith('<span class="error error_data">Error..</span>');
                        $(".error_data").delay(5000).hide('slow', function(){ $(".error_data").remove(); });
                    }
                },
                error: function(){
                    $('.loader').replaceWith('<span class="error error_data">Error..</span>');
                    $(".error_data").delay(5000).hide('slow', function(){ $(".error_data").remove(); });
                } 	        
                });
            }));
            
            
            $('.text-section input[type="color"]').change(function(){
               var info      = $(this);  
        
               var target_id = info.attr('data-id');
               var name      = info.attr('name');
               var color     = info.val();
               
               $(this).after('<img class="loader" src="<?php echo loadAsset('img/loading.gif', 'common'); ?>">');
               var postinfo = $.post( "<?php echo site_url('admin/settings/update_settings'); ?>", { name: name, value: color } );
               
               postinfo.done(function(){
                    $('.loader').remove();
                    
                    if(target_id != "#popup_btn_submit"){ alert(target_id);
                        $(target_id).css("color", color);
                    }
                    else{
                        $(target_id).css({background:color, border:"1px solid "+color});
                    }    
               });
               
               postinfo.fail(function(){
                   $('.loader').replaceWith('<span class="error error_data">Error..</span>');
                   $(".error_data").delay(5000).hide('slow', function(){ $(".error_data").remove(); });
               });
            });
            
        });
    
        $(document).ready( function() {
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });
            $('.btn-file :file').on('fileselect', function(event, numFiles, label) { 
                $(this).after('<span class="">'+label+'</span>')
            });
        });
        
        
</script>
<script>
    $(document).ready( function() {
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/settings/remove_banner/'); ?>/'+aID+'.html' );
        });
    });
</script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <div class="modal-body">
                <p>Deleting banner image will remove it from home bage banner slider.<br/><br/>Really want to remove image ?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
            </div>
        </div>

    </div>
</div>
</div>
