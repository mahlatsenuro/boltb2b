<div id="site-header-wrap">
    <div id="top-bar">
        <div id="top-bar-inner" class="container-fluid container-width-94">
            <div class="top-bar-inner-wrap ">
                <div class="top-bar-nav">
                    <div class="inner">
                        <span class="account">
                            <i class="fa fa-download"></i>
                            <a href="<?php echo site_url('home/productsAssets'); ?>">Download Catalog</a>
                        </span>
                        <span class="account"><i class="fa fa-user"></i><a href="#">Contact Us</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header id="header" class="header clearfix">
        <div class="container-fluid clearfix container-width-93" id="site-header-inner">
            <div id="logo" class="logo float-left">
                <a href="/" title="logo">
                    <img src="<?php echo loadAsset('img/wholesalerlogo.png') ?>" class="logo" alt="logo">
                </a>
            </div>
            <div class="mobile-button"><span></span></div>
            <ul class="menu-extra">
                <li class="box-search">
                    <a class="icon_search header-search-icon" href="#"></a>
                    <form role="search" method="get" class="header-search-form" action="#">
                        <input type="text" value="" name="s" class="header-search-field" placeholder="Search...">
                        <button type="submit" class="header-search-submit" title="Search">Search</button>
                    </form>
                </li>
                <li class="box-login">
                    <a class="icon_login" href="#"></a>
                </li>
                <li class="box-cart nav-top-cart-wrapper">
                    <a class="icon_cart nav-cart-trigger active" href="#"><span>3</span></a>
                    <div class="nav-shop-cart">
                        <div class="widget_shopping_cart_content">
                            <div class="woocommerce-min-cart-wrap">
                                <ul class="woocommerce-mini-cart cart_list product_list_widget ">
                                    <li class="woocommerce-mini-cart-item mini_cart_item">
                                        <span>No Items in Shopping Cart</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="nav-wrap new-menu">
                <nav id="mainnav" class="mainnav">
                    <ul class="menu">
                        <li>
                          <a href="index.html">HOME</a>
                        </li>

                        <li>
                          <a href="landing.html">LANDING</a>
                        </li>

                        <li>
                            <a href="shop.html">SHOP</a>
                        </li>
                    </ul>
                </nav>
            </div
        </div>
    </header>
</div>