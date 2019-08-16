<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Orders</h2>   
            <h5>Orders with system!</h5>
        </div>
        <div class="col-md-1">
           
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Orders
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Reference</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Method</th>
                                    <th>Paid</th>
                                    <th>Delivered</th>
                                    <th>Date</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody> 
                                
                                <?php foreach ($orders as $key => $order): ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( $key+1 ); ?></td>   
                                        <td><?php echo "ORD-".$order->id; ?></td>   
                                        <td><?php echo $order->order_reference; ?></td>   
                                        <td><?php echo $order->first_name.' '.$order->last_name; ?></td>
                                        <td><?php echo $order->email; ?></td>
                                        <th><?php echo $order->payment_method; ?></th>
                                        <th><?php echo $order->paid == 1 ? '<i style="color:green" class="fa fa-check" aria-hidden="true"></i>' : '<i style="color:red" class="fa fa-times" aria-hidden="true"></i>'; ?></th>
                                        <td><?php echo $order->order_placed == 1 ? '<i style="color:green" class="fa fa-check" aria-hidden="true"></i>' : '<i style="color:red" class="fa fa-times" aria-hidden="true"></i>'; ?></td>
                                        <td><?php echo Date('jS, F Y', strtotime($order->date)); ?></td>
                                        <th>
                                            <a class="btn btn-info" href="<?php echo site_url('admin/orders/details/'.$order->id); ?>" >View details</a>
                                            <a class="btn btn-danger delete" href="<?php echo site_url('admin/orders/remove/'.$order->id); ?>" >Delete</a>
                                        </th>
                                    </tr>
                                <?php endforeach; ?>
                                
                                
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
            $('#dataTables-example').dataTable(); 
        });
        $(document).on("click", ".delete", function (e) {
            e.preventDefault();
            var href = $(this).attr("href");
            var con = confirm("Really want to remove order ?");
            if(con == true){
                location.href = href;
            }
            return;
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
                    <p>Deleting an attribute will cause removal of this attribute from all the existing products.<br/><br/>Really want to delete attribute ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
