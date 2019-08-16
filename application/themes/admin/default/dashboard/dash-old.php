    <div class="row">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Dashboard</h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active"></li>
                </ol>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row"><br/><br/>
        <div class="col-lg-3 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading dark-blue">
                        <i class="fa fa-users fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content dark-blue">
                    <div class="circle-tile-description text-faded">
                        Total Revenue
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo price($total_revenue); ?>
                    </div>
                    <a href="#" class="circle-tile-footer"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading green">
                        <i class="fa fa-money fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content green">
                    <div class="circle-tile-description text-faded">
                        Products Sold
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo $products_sold; ?>
                    </div>
                    <a href="#" class="circle-tile-footer"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading orange">
                        <i class="fa fa-bell fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content orange">
                    <div class="circle-tile-description text-faded">
                        Pending Delivery
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo $products_todeliver; ?>
                    </div>
                    <a href="#" class="circle-tile-footer"></a>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading purple">
                        <i class="fa fa-comments fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content purple">
                    <div class="circle-tile-description text-faded">
                        Registered Users
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo $total_customers; ?>
                    </div>
                    <a href="#" class="circle-tile-footer"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="portlet portlet-blue">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Customer - Revenue chart <?php echo Date('Y'); ?></h4>
                    </div>
                    <div class="portlet-widgets">
                        <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion" href="#barChart"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="barChart" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-chart-area"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <!-- /.col-lg-12 -->

        <!-- Bar Chart Example -->
        <div class="col-lg-6">
            <div class="portlet portlet-blue">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Customer - Abandoned chart <?php echo Date('Y'); ?></h4>
                    </div>
                    <div class="portlet-widgets">
                        <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion" href="#barChart"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="barChart" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div id="morris-chart-abandond"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-6 -->

        <!-- Donut Chart Example -->
        <div class="col-lg-6">
            <div class="portlet portlet-orange">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Products log <?php echo Date('Y'); ?></h4>
                    </div>
                    <div class="portlet-widgets">
                        <a href="javascript:;"><i class="fa fa-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion" href="#donutChart"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="donutChart" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="portlet-body">
                            <div id="morris-chart-donut"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-6 -->
        <script type="text/javascript" src="<?php echo base_url('assets/js/morris.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/morris-demo-data.js'); ?>"></script>
        <script type="text/javascript">
            $( function() {
                $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
              } );
        </script>
    </div>
