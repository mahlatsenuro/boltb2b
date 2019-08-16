<section class="pt-3 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="account-box">
                    <h4 class="box-h4">Order 1172818 has been</h4>
                    <h3 class="box-h3">Accepted</h3>
                    <h4 class="box-date">10/27/19 10:45AM</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="manager-box">
                    <h4 class="box-h4">Your personal manager</h4>
                    <div class="row pt-2">
                        <div class="col-md-4">
                            <img class="img-responsive circle box-profile" src="<?php echo loadAsset('img/avatar-1.png') ?>">
                        </div>
                        <div class="col-md-8">
                            <h4 class="box-profile-name">Mohamed Salah</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="account-box">
                    <h4 class="box-h4">Any problem with your order?</h4>
                    <h3 class="box-h3 pt-3"><a href="#" class="pose-color">Claim</a></h3>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="flat-row main-shop shop-slidebar" data-filter-group>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar slidebar-shop">
                    <div class="accordion" id="category"></div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="product-content product-threecolumn product-slidebar clearfix">
                    <div class="wrap">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Shop At-Once</h3>
                                </div>
                                <div class="col-md-6 float-right">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6"><h4 class="sort-h4 float-right">Sort By:</h4></div>
                                            <div class="col-md-6">
                                                <select class="form-control" id="SortSelect">
                                                    <option value="available:asc">Quantities Available</option>
                                                    <option value="style:asc">Style</option>
                                                    <option value="name:asc">Name</option>
                                                    <option value="price:asc">Wholesale Price</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="status-container">
                                        <button class="filter-btn" data-filter=".available">AVAILABLE NOW</button>
                                        <button class="filter-btn" data-filter=".available_soon">AVAILABLE SOON</button>
                                        <button class="filter-btn" data-filter=".not_available">NOT AVAILABLE</button>
                                        <button class="filter-btn" data-filter="all">ALL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul id="shop" class="product style2 sd1 shop"></ul>
                </div>
                <div class="product-pagination text-center clearfix">
                    <ul class="flat-pagination">
                        <li class="prev">
                            <a href="#"><i class="fa fa-angle-left"></i></a>
                        </li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#" title="">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#shop").products();
            $("#category").categories();
        });
    </script>
</section>
