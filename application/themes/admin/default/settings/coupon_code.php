<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Coupon codes</h2>   
            <h5>Coupon code offers!</h5>
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/settings/new_coupon/'); ?>" class="btn btn-success btn-sm new">
                <i class="fa fa-sign-out"></i>
                Create New
            </a>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />

    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Coupons
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Offer</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(is_array($coupons) && count($coupons)>0): ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#dataTables-example').dataTable(); 
                                    });
                                    $(document).on("click", ".delete", function () {
                                        var aID = $(this).data('id');
                                        $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/settings/delete_coupon/'); ?>/'+aID+'.html' );
                                        // As pointed out in comments, 
                                        // it is superfluous to have to manually call the modal.
                                        // $('#addBookDialog').modal('show');
                                    });
                                </script>
                                <?php foreach ($coupons as $key => $coupon): ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( $key+1 ); ?></td>    
                                        <td>
                                            <span class="label <?php echo $coupon->status == 1 ? 'label-success' : 'label-danger' ?>">
                                                <?php echo $coupon->code; ?>
                                            </span>
                                        </td>
                                        <td><?php echo pos_date( $coupon->start_date ); ?></td>
                                        <td><?php echo pos_date( $coupon->end_date ); ?></td>
                                        <td><?php echo $coupon->offer_type == 'currency' ? 'R ' : ''.$coupon->offer.($coupon->offer_type == 'percentage' ? '%' : ''); ?></td>
                                        <td>
                                            <?php if($coupon->status == 1): ?>
                                            <div class="btn-group">
                                                <div title="Published" href="<?php echo site_url('admin/settings/coupon_deactivate/'.$coupon->id) ?>" class="btn btn-micro active success"><span class="glyphicon glyphicon-ok"></span></div>															
                                            </div>
                                            <?php else: ?>
                                                <div class="btn-group">
                                                    <div title="Unpublished" href="<?php echo site_url('admin/settings/coupon_activate/'.$coupon->id) ?>" class="btn btn-micro active remove"><span class="glyphicon glyphicon-remove"></span></div>															
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?php echo site_url('admin/settings/new_coupon/'.$coupon->id); ?>">
                                                <i class="fa fa-edit "></i> 
                                                Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $coupon->id; ?>">
                                                <i class="fa fa-times"></i>
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7">No coupons available!</td>
                                    </tr>
                                <?php endif; ?>    
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
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
                    <p>Really want to remove coupon code ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
