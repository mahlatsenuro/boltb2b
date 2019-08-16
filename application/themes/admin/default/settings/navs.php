<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="<?php echo $current == 'basic' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings'); ?>">Basic Settings</a>
            </li>
            <li class="<?php echo $current == 'images' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/product_images'); ?>">Product image upload</a>
            </li>
            <li class="<?php echo $current == 'address' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/address'); ?>">Delivery</a>
            </li>
            <li class="<?php echo $current == 'style' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/style'); ?>">Styling</a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <br/><br/>
</div>