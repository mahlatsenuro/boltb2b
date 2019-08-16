<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Users</h2>   
            <h5>Users registered with us!</h5>
        </div>
        <div class="col-md-1">
            &nbsp;
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />

    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo site_url('admin/users/create_user') ?>" class="pull-right btn btn-sm btn-success">Create User</a>
        </div>
        <div class="clearfix"></div>
        <br/>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Users
                </div> 
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Active</th>
                                    <th>Role</th>
                                    <th>Orders</th>
                                    <th>Last Login</th>
                                    <th>Registered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                                
                                <?php foreach ($users as $key => $user): ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( $key+1 ); ?></td>    
                                        <td><?php echo $user->first_name; ?></td>
                                        <td><?php echo $user->last_name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td>
                                            <?php echo $user->active == 1 ? '<i class="fa fa-thumbs-o-up fa-6 t_disp"></i>' : '<i class="fa fa-thumbs-o-down fa-6 t_disp"></i>'; ?>
                                        </td>
                                        <th><?php echo $user->role; ?></th>
                                        <th><?php echo $user->order_count; ?></th>
                                        <th><?php echo formatDate($user->last_login, true); ?></th>
                                        <th><?php echo formatDate($user->created_on, true); ?></th>
                                        
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?php echo site_url('admin/users/edit_user/'.$user->uid); ?>">
                                                <i class="fa fa-edit "></i> 
                                                Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo $user->uid; ?>">
                                                <i class="fa fa-times"></i>
                                                Delete
                                            </a>
                                        </td>
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
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/users/delete/'); ?>/'+aID+'.html' );
            // As pointed out in comments, 
            // it is superfluous to have to manually call the modal.
            // $('#addBookDialog').modal('show');
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
                    <p>Deleting a user will cause removal of all data related with that user<br/><br/>Really want to delete user ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
