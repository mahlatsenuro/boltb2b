<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Blogs</h2>   
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/content/new_blog/'); ?>" class="btn btn-success btn-sm new">
                <i class="fa fa-sign-out"></i>
                Create New
            </a>
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    <?php echo form_open('', array('class' => 'form-inline')); ?>
        
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Blogs
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                            <?php if(is_array($blogs) && count($blogs) > 0): ?>   
                                <?php foreach ($blogs as $key => $blog): ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( $key+1 ); ?></td>
                                        <td><?php echo $blog->title; ?></td>
                                        <td>
                                            <span class="label label-<?php echo ($blog->status == 1 ? "success" : "danger"); ?>"><?php echo ($blog->status == 1 ? "Active" : "Inactive"); ?></span>
                                        </td>
                                        <td><?php echo formatDate( $blog->date ); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info btn-sm" href="<?php echo site_url('admin/content/new_blog/'.$blog->id); ?>">
                                                    <i class="fa fa-edit "></i> 
                                                    Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $blog->id; ?>">
                                                    <i class="fa fa-times"></i>
                                                    Delete
                                                </a>
                                                <a class="btn <?php echo ($blog->status == 1 ? "btn-warning" : "btn-success"); ?> btn-sm" href="<?php echo site_url("admin/content/status/".($blog->status == 1 ? "deactivate" : "activate")."/".$blog->id); ?>">
                                                    <i class="fa fa-times"></i>
                                                    <?php echo $blog->status == 1 ? "Deactivate" : "Activate"; ?>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?> 
                                <tr class="gradeX">
                                    <td colspan="5">No blogs available</td>
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
    <?php echo form_close(); ?>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();   
        });
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/content/status/delete/'); ?>/'+aID+'.html' );
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
                    <p>Deleting a blog will cause removal of this blog from the site for ever.<br/><br/>Really want to delete blog ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
