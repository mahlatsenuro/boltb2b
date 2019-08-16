<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img src="<?php echo loadAsset( 'img/'.$this->config->item('store_logo'), true ); ?>" class="user-image img-responsive"/>
            </li>		
            <li>
                <a  href="<?php echo site_url('admin/home'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'home') ? 'active-menu' : ''; ?>"><i class="fa fa-dashboard fa-3x" ></i> Dashboard</a>
            </li>
            <li>
                <a  href="<?php echo site_url('admin/orders/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'orders') ? 'active-menu' : ''; ?>"><i class="fa fa-list-ul fa-3x"></i>Orders</a>
            </li>
            <li>
                <a  href="<?php echo site_url('admin/attributes/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'attributes') ? 'active-menu' : ''; ?>"><i class="fa fa-list-ul fa-3x"></i>Attributes</a>
            </li>
            <li>
                <a  href="<?php echo site_url('admin/manufacturer/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'manufacturer') ? 'active-menu' : ''; ?>" ><i class="fa fa-wrench fa-3x"></i>Manufactures</a>
            </li>
            <li>
                <a  href="<?php echo site_url('admin/categories/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'categories') ? 'active-menu' : ''; ?>" ><i class="fa fa-qrcode fa-3x"></i>Categories</a>
            </li>
            <li  >
                <a  href="<?php echo site_url('admin/users/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'users') ? 'active-menu' : ''; ?>"><i class="fa fa-user fa-3x"></i>Users</a>
            </li>	
            <li  >
                <a  href="<?php echo site_url('admin/products/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'products') ? 'active-menu' : ''; ?>" ><i class="fa fa-table fa-3x"></i>Products</a>
            </li>
            <li  >
                <a  href="<?php echo site_url('admin/abandoncart/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'abandoncart') ? 'active-menu' : ''; ?>" ><i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i>Abandoned cart</a>
            </li>
            <li  >
                <a  href="javascript:void(0)" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'content') ? 'active-menu' : ''; ?>" ><i class="fa fa-table fa-3x"></i>Content</a>
                <ul class="sub-menu <?php echo ( strtolower( $this->uri->segment(2) ) == 'content') ? 'in' : ''; ?>" style="width:100%">
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'blogs' || strtolower( $this->uri->segment(3) ) == 'new_blog') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/blogs'); ?>">Blogs</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'terms') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/terms'); ?>">Terms and Conditions</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'privacy') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/privacy'); ?>">Privacy Policy</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'delivery') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/delivery'); ?>">Delivery Policy</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'returns') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/returns'); ?>">Returns</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'whoweare') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/whoweare'); ?>">Who we are</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'faq') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/content/faq'); ?>">FAQ</a>
                    </li>
                </ul>
            </li>
            <!--<li  >
                <a  href="<?php //echo site_url('admin/reports/'); ?>" class="<?php //echo ( strtolower( $this->uri->segment(2) ) == 'reports') ? 'active-menu' : ''; ?>" ><i class="glyphicon glyphicon-share fa-3x"></i>Reports</a>
            </li> -->
            <li  >
                <a  href="<?php echo site_url('admin/csv/'); ?>" class="<?php echo ( strtolower( $this->uri->segment(2) ) == 'csv') ? 'active-menu' : ''; ?>" ><i class="glyphicon glyphicon-share fa-3x"></i>CSV Import Export</a>
            </li>	

            <li  >
                <a  href="javascript:void(0);" ><i class="fa fa-cog fa-3x" aria-hidden="true"></i> Settings </a>
                <ul class="sub-menu <?php echo ( strtolower( $this->uri->segment(2) ) == 'settings') ? 'in' : ''; ?>" style="width:100%">
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == '' && $this->uri->segment(2) == 'settings') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/settings'); ?>">Basic settings</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'point_sale') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/settings/point_sale'); ?>">Point of sale</a>
                    </li>
                    <li class="<?php echo ( strtolower( $this->uri->segment(3) ) == 'coupon_code') ? 'active-menu' : ''; ?>">
                        <a href="<?php echo site_url('admin/settings/coupon_code'); ?>">Coupon code</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>  