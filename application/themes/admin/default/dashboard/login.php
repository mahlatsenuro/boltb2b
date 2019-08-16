<div class="row">
    <div class="col-sm-8 col-sm-offset-2 text">
        <h1><strong><?php echo $this->config->item('store_name'); ?></strong> Login</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 form-box">
        <div class="form-top">
            <div class="form-top-left">
                    <h3>Login to your online store:</h3>
            </div>
            <div class="form-top-right">
                    <!-- <i class="fa fa-lock"></i> -->
            </div>
        </div>
        <div class="form-bottom">
            <?php echo form_open('', array('class' => 'form-signin login-form', "id" => "loginform")); ?>
                <div class="form-group">
                    <label class="sr-only" for="form-username">Username</label>                        
                    <input type="text" name="identity" placeholder="Username..." class="form-username form-control" id="form-username">
                    <?php echo form_error('identity') ?>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-password">Password</label>
                    <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
                    <?php echo form_error('password') ?>
                </div>
                <div class="form-group"> 
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"') ?> Keep me logged in
                </div>
                <button type="submit" class="btn">Sign in!</button>
            <?php echo form_close(); ?>
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $.backstretch([
                "<?php echo loadAsset('/img/2.jpg') ?>"
                , "<?php echo loadAsset('/img/3.jpg') ?>"
                , "<?php echo loadAsset('/img/1.jpg') ?>"
               ], {duration: 3000, fade: 750});
        });
    </script>
    
</div>

    
    

