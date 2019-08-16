<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "attribute", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Styles</h2>   
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
    <?php require 'navs.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Styles
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Google fonts</label> </div>
                        <div class="col-md-6">
                            <input type="text" name="google_fonts" class="form-control" placeholder="Google fonts(comma separated)" value="<?php echo ($this->config->item('google_fonts')); ?>"/>
                            <?php echo form_error('google_fonts') ?>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Body text colour</label> </div>
                        <div class="col-md-6">
                            
                            <div class="form-inline">
                                <input type="color" data-id="body_text_colour" name="" class="" value="<?php echo ($this->config->item('body_text_colour')); ?>"/>
                                <input type="text" name="body_text_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('body_text_colour')); ?>"/>
                            </div>
                            <?php echo form_error('body_text_colour') ?>
                        
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Buy Now" button text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="buy_now_button_colour" value="<?php echo ($this->config->item('buy_now_button_colour')); ?>"/>
                                <input type="text" name="buy_now_button_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('buy_now_button_colour')); ?>"/>
                            </div>
                            <?php echo form_error('buy_now_button_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Buy Now" button hover text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="buy_now_button_hover_colour" value="<?php echo ($this->config->item('buy_now_button_hover_colour')); ?>"/>
                                <input type="text" name="buy_now_button_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('buy_now_button_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('buy_now_button_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Buy Now" button background</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="buy_now_button_bgcolour" value="<?php echo ($this->config->item('buy_now_button_bgcolour')); ?>"/>
                                <input type="text" name="buy_now_button_bgcolour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('buy_now_button_bgcolour')); ?>"/>
                            </div>
                            <?php echo form_error('buy_now_button_bgcolour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Buy Now" button hover background</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="buy_now_button_hover_bgcolour" value="<?php echo ($this->config->item('buy_now_button_hover_bgcolour')); ?>"/>
                                <input type="text" name="buy_now_button_hover_bgcolour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('buy_now_button_hover_bgcolour')); ?>"/>
                            </div>
                            <?php echo form_error('buy_now_button_hover_bgcolour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Add to Cart" button text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="add_cart_button_colour" value="<?php echo ($this->config->item('add_cart_button_colour')); ?>"/>
                                <input type="text" name="add_cart_button_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('add_cart_button_colour')); ?>"/>
                            </div>
                            <?php echo form_error('add_cart_button_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Add to Cart" button hover text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="add_cart_button_hover_colour" value="<?php echo ($this->config->item('add_cart_button_hover_colour')); ?>"/>
                                <input type="text" name="add_cart_button_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('add_cart_button_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('add_cart_button_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Add to Cart" button background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="add_cart_button_bgcolour" value="<?php echo ($this->config->item('add_cart_button_bgcolour')); ?>"/>
                                <input type="text" name="add_cart_button_bgcolour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('add_cart_button_bgcolour')); ?>"/>
                            </div>
                            <?php echo form_error('add_cart_button_bgcolour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>"Add to Cart" button hover background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="add_cart_button_hover_bgcolour" value="<?php echo ($this->config->item('add_cart_button_hover_bgcolour')); ?>"/>
                                <input type="text" name="add_cart_button_hover_bgcolour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('add_cart_button_hover_bgcolour')); ?>"/>
                            </div>
                            <?php echo form_error('add_cart_button_hover_bgcolour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Attribute Blocks border colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="attributes_border_colour" value="<?php echo ($this->config->item('attributes_border_colour')); ?>"/>
                                <input type="text" name="attributes_border_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('attributes_border_colour')); ?>"/>
                            </div>
                            <?php echo form_error('attributes_border_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Attribute Blocks active colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="attributes_active_colour" value="<?php echo ($this->config->item('attributes_active_colour')); ?>"/>
                                <input type="text" name="attributes_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('attributes_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('attributes_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Product title text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="product_title_colour" value="<?php echo ($this->config->item('product_title_colour')); ?>"/>
                                <input type="text" name="product_title_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('product_title_colour')); ?>"/>
                            </div>
                            <?php echo form_error('product_title_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Header Styles
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>h1</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h1" value="<?php echo ($this->config->item('h1')); ?>"/>
                            <?php echo form_error('h1') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>h2</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h2" value="<?php echo ($this->config->item('h2')); ?>"/>
                            <?php echo form_error('h2') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>h3</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h3" value="<?php echo ($this->config->item('h3')); ?>"/>
                            <?php echo form_error('h3') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>h4</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h4" value="<?php echo ($this->config->item('h4')); ?>"/>
                            <?php echo form_error('h4') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>h5</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h5" value="<?php echo ($this->config->item('h5')); ?>"/>
                            <?php echo form_error('h5') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>h6</label> </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="h6" value="<?php echo ($this->config->item('h6')); ?>"/>
                            <?php echo form_error('h6') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Main menu
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Main menu text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="main_menu_colour" value="<?php echo ($this->config->item('main_menu_colour')); ?>"/>
                                <input type="text" name="main_menu_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('main_menu_colour')); ?>"/>
                            </div>
                            <?php echo form_error('main_menu_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu hover text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="menu_hover_colour" value="<?php echo ($this->config->item('menu_hover_colour')); ?>"/>
                                <input type="text" name="menu_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('menu_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('menu_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu active text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="menu_active_colour" value="<?php echo ($this->config->item('menu_active_colour')); ?>"/>
                                <input type="text" name="menu_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('menu_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('menu_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu font size</label> </div>
                        <div class="col-md-6">
                            <input type="number" name="menu_font_size" class="form-control" value="<?php echo ($this->config->item('menu_font_size')); ?>"/>
                            <?php echo form_error('menu_font_size') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="menu_background_colour" value="<?php echo ($this->config->item('menu_background_colour')); ?>"/>
                                <input type="text" name="menu_background_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('menu_background_colour')); ?>"/>
                            </div>
                            <?php echo form_error('menu_background_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background active colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="menu_background_active_colour" value="<?php echo ($this->config->item('menu_background_active_colour')); ?>"/>
                                <input type="text" name="menu_background_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('menu_background_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('menu_background_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background hover colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="menu_background_hover_colour" value="<?php echo ($this->config->item('menu_background_hover_colour')); ?>"/>
                                <input type="text" name="menu_background_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('menu_background_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('menu_background_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Underline</label> </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="menu_underline" value="1" <?php echo ($this->config->item('menu_underline')&&$this->config->item('menu_underline')==1 ? "checked" : ""); ?>/>
                            <?php echo form_error('menu_underline') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sub menu
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Sub menu text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_menu_colour" value="<?php echo ($this->config->item('sub_menu_colour')); ?>"/>
                                <input type="text" name="sub_menu_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_menu_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_menu_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu hover text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_hover_colour" value="<?php echo ($this->config->item('sub_hover_colour')); ?>"/>
                                <input type="text" name="sub_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu active text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_active_colour" value="<?php echo ($this->config->item('sub_active_colour')); ?>"/>
                                <input type="text" name="sub_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu font size</label> </div>
                        <div class="col-md-6">
                            <input type="number" name="sub_font_size" class="form-control" value="<?php echo ($this->config->item('sub_font_size')); ?>"/>
                            <?php echo form_error('sub_font_size') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_background_colour" value="<?php echo ($this->config->item('sub_background_colour')); ?>"/>
                                <input type="text" name="sub_background_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_background_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_background_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background active colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_background_active_colour" value="<?php echo ($this->config->item('sub_background_active_colour')); ?>"/>
                                <input type="text" name="sub_background_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_background_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_background_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background hover colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="sub_background_hover_colour" value="<?php echo ($this->config->item('sub_background_hover_colour')); ?>"/>
                                <input type="text" name="sub_background_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('sub_background_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('sub_background_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Underline</label> </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="sub_underline" value="1" <?php echo ($this->config->item('sub_underline')&&$this->config->item('sub_underline')==1 ? "checked" : ""); ?>/>
                            <?php echo form_error('sub_underline') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Left menu
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_menu_colour" value="<?php echo ($this->config->item('our_menu_colour')); ?>"/>
                                <input type="text" name="our_menu_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_menu_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_menu_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu hover text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_hover_colour" value="<?php echo ($this->config->item('our_hover_colour')); ?>"/>
                                <input type="text" name="our_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu active text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_active_colour" value="<?php echo ($this->config->item('our_active_colour')); ?>"/>
                                <input type="text" name="our_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu font size</label> </div>
                        <div class="col-md-6">
                            <input type="number" name="our_font_size" class="form-control" value="<?php echo ($this->config->item('our_font_size')); ?>"/>
                            <?php echo form_error('our_font_size') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_background_colour" value="<?php echo ($this->config->item('our_background_colour')); ?>"/>
                                <input type="text" name="our_background_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_background_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_background_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background active colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_background_active_colour" value="<?php echo ($this->config->item('our_background_active_colour')); ?>"/>
                                <input type="text" name="our_background_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_background_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_background_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background hover colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="our_background_hover_colour" value="<?php echo ($this->config->item('our_background_hover_colour')); ?>"/>
                                <input type="text" name="our_background_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('our_background_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('our_background_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Underline</label> </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="our_underline" value="1" <?php echo ($this->config->item('our_underline')&&$this->config->item('our_underline')==1 ? "checked" : ""); ?>/>
                            <?php echo form_error('our_underline') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Left sub menu
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_menu_colour" value="<?php echo ($this->config->item('oursub_menu_colour')); ?>"/>
                                <input type="text" name="oursub_menu_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_menu_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_menu_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu hover text color</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_hover_colour" value="<?php echo ($this->config->item('oursub_hover_colour')); ?>"/>
                                <input type="text" name="oursub_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu active text colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_active_colour" value="<?php echo ($this->config->item('oursub_active_colour')); ?>"/>
                                <input type="text" name="oursub_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu font size</label> </div>
                        <div class="col-md-6">
                            <input type="number" name="oursub_font_size" class="form-control" value="<?php echo ($this->config->item('oursub_font_size')); ?>"/>
                            <?php echo form_error('oursub_font_size') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_background_colour" value="<?php echo ($this->config->item('oursub_background_colour')); ?>"/>
                                <input type="text" name="oursub_background_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_background_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_background_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background active colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_background_active_colour" value="<?php echo ($this->config->item('oursub_background_active_colour')); ?>"/>
                                <input type="text" name="oursub_background_active_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_background_active_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_background_active_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Menu background hover colour</label> </div>
                        <div class="col-md-6">
                            <div class="form-inline">
                                <input type="color" data-id="oursub_background_hover_colour" value="<?php echo ($this->config->item('oursub_background_hover_colour')); ?>"/>
                                <input type="text" name="oursub_background_hover_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('oursub_background_hover_colour')); ?>"/>
                            </div>
                            <?php echo form_error('oursub_background_hover_colour') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Underline</label> </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="oursub_underline" value="1" <?php echo ($this->config->item('oursub_underline')&&$this->config->item('oursub_underline')==1 ? "checked" : ""); ?>/>
                            <?php echo form_error('oursub_underline') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
        
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Home Sections
                </div>
                <div class="panel-body">
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Left section</label> </div>
                        <div class="col-md-4">
                            <input type="text" name="left_section_title" placeholder="Left title" class="form-control" value="<?php echo ($this->config->item('left_section_title')); ?>"/>
                            <?php echo form_error('left_section_title') ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="left_section_link" placeholder="Left link" class="form-control" value="<?php echo ($this->config->item('left_section_link')); ?>"/>
                            <?php echo form_error('left_section_link') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Left section title text colour</label> </div>
                        <div class="col-md-4">
                            <div class="form-inline">
                                <input type="color" data-id="left_section_title_colour" value="<?php echo ($this->config->item('left_section_title_colour')); ?>"/>
                                <input type="text" name="left_section_title_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('left_section_title_colour')); ?>"/>
                            </div>
                            <?php echo form_error('left_section_title_colour') ?>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Right section</label> </div>
                        <div class="col-md-4">
                            <input type="text" name="right_section_title" placeholder="Right title" class="form-control" value="<?php echo ($this->config->item('right_section_title')); ?>"/>
                            <?php echo form_error('right_section_title') ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="right_section_link" placeholder="Right link" class="form-control" value="<?php echo ($this->config->item('right_section_link')); ?>"/>
                            <?php echo form_error('right_section_link') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Right section title text colour</label> </div>
                        <div class="col-md-4">
                            <div class="form-inline">
                                <input type="color" data-id="right_section_title_colour" value="<?php echo ($this->config->item('right_section_title_colour')); ?>"/>
                                <input type="text" name="right_section_title_colour" class="form-control" style="margin-top: -5px;" value="<?php echo ($this->config->item('right_section_title_colour')); ?>"/>
                            </div>
                            <?php echo form_error('right_section_title_colour') ?>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Left text section</label> </div>
                        <div class="col-md-4">
                            <input type="text" name="left_textsection_title" placeholder="Left text" class="form-control" value="<?php echo ($this->config->item('left_textsection_title')); ?>"/>
                            <?php echo form_error('left_textsection_title') ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="left_textsection_link" placeholder="Leftt text link" class="form-control" value="<?php echo ($this->config->item('left_textsection_link')); ?>"/>
                            <?php echo form_error('left_textsection_link') ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-md-4"> <label>Right text section</label> </div>
                        <div class="col-md-4">
                            <input type="text" name="right_textsection_title" placeholder="Right text" class="form-control" value="<?php echo ($this->config->item('right_textsection_title')); ?>"/>
                            <?php echo form_error('right_textsection_title') ?>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="right_textsection_link" placeholder="Right text link" class="form-control" value="<?php echo ($this->config->item('right_textsection_link')); ?>"/>
                            <?php echo form_error('right_textsection_link') ?>
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
    
    <?php echo form_close(); ?>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

