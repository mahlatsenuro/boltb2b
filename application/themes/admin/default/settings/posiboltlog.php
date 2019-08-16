<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-inline')); ?>
    <div class="row">
        <div class="col-md-9">
            <h2>Posibolt Logs</h2>   
            <h5>All requests made to posibolt server</h5>
        </div>
        <div class="col-md-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                
            </div>
            
        </div>
        <div class="clearfix"></div>
    </div>       
    <hr />
    
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Categories
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    <th>Post Data</th>
                                    <th>Response</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($logs as $key => $log): 
                                    
                                    $request_data  = json_decode($log->request_data);
                                    $response_data = json_decode($log->response_data);
                                    
                                    ?>
                                    <tr class="<?php ($key%2 == 0) ? 'odd' : 'even'; ?> gradeX">
                                        <td><?php echo ( $key+1 ); ?></td>
                                        <td><?php echo $log->request_url; ?></td>
                                        <td><?php echo $log->request_method; ?></td>
                                        <td>
                                            <ul>
                                            <?php foreach ($request_data as $req_key => $req_data): ?>
                                            <li><?php echo $req_key." : ".$req_data; ?></li>
                                            <?php endforeach;?>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                            <?php foreach ($response_data as $res_key => $res_data): ?>
                                            <li><?php echo $res_key." : ".$res_data; ?></li>
                                            <?php endforeach;?>
                                            </ul>
                                        </td>
                                        <td><?php echo formatDate( $log->date ); ?></td>
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
    <?php echo form_close(); ?>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable(); 
            
//            $("input[type=checkbox]").click(function(){
//                var total = $("input:checkbox:checked").length;
//                if(total > 0){
//                    //$(".searchform").show();
//                }
//                else{
//                   // $(".searchform").hide();
//                }
//            });
            
            
        });
        $(document).on("click", ".delete", function () {
            var aID = $(this).data('id');
            $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/categories/delete/'); ?>/'+aID+'.html' );
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
                    <p>Deleting an category will cause removal of this category and its sub categories from all the existing products.<br/><br/>Really want to delete category ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
