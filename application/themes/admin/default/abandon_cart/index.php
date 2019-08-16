<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Abandon carts</h2>   
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <div class="row">     
        <div class="col-md-12">
            <div class="product_nav">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo site_url('admin/abandoncart'); ?>">Abandoned cart</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/abandoncart/email'); ?>">Email</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row"><br><br>
        <div class="col-lg-3 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading dark-blue">
                        <i class="fa fa-users fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content dark-blue">
                    <div class="circle-tile-description text-faded">
                        Abandoned Revenue
                    </div>
                    <div class="circle-tile-number text-faded">
                        <span class="main-price"><?php echo formatNumber($abandon_revenue); ?></span>                    </div>
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
                        Abandoned Carts
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo $abandond_carts; ?>                    
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
                        Total sales
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo $sold_products; ?>                    
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
                        Total customers
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
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Abandon cart
                </div> 
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Revenue</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                             
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(document).on("click", ".delete", function () { 
                var aID = $(this).data('id');
                $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/abandoncart/delete/'); ?>/'+aID+'.html' ); 
            });
        });
        
        $(function() {
             $("#dataTables-example").dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "<?php echo site_url('admin/abandoncart/load_cart');?>",
                    "type": "POST"
                },
                "pageLength": 50,
                "columnDefs": [
                    { "orderable": false, "targets": [-2 , -3]}
                ]
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
                    <p>Really want to delete abandon cart item ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
