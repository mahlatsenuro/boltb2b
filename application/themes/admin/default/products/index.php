<div id="page-inner">
    <div class="row">
        <div class="col-md-11">
            <h2>Products</h2>   
            <h5>Products available in our system!</h5>
        </div>
        <div class="col-md-1">
            <a href="<?php echo site_url('admin/products/create/'); ?>" class="btn btn-success btn-sm new">
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
                    Products
                </div> 
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sku</th>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Created</th>
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
            //$('#dataTables-example').dataTable( {"ajax": "<?php //echo site_url('admin/products/load_products');?>"}); 


            $(document).on("click", ".delete", function () {
                var aID = $(this).data('id');
                $(".modal-footer #continue").attr( 'href', '<?php echo base_url('admin/products/delete/'); ?>/'+aID+'.html' );
                // As pointed out in comments, 
                // it is superfluous to have to manually call the modal.
                // $('#addBookDialog').modal('show');
            });
        });
        
        $(function() {
	//wait till the page is fully loaded before loading table
	//dataTableSearch() is optional.  It is a jQuery plugin that looks for input fields in the thead to bind to the table searching
	var table = $("#dataTables-example").dataTable({
            processing: true,
            serverSide: true,
            displayStart: <?php echo $this->session->userdata('datatable_start') && is_numeric($this->session->userdata('datatable_start')) ? $this->session->userdata('datatable_start')  : 0; ?>,
            oSearch: {"sSearch": "<?php echo $this->session->userdata('datatable_search') ? $this->session->userdata('datatable_search') : ""; ?>"},
            ajax: {
                "url": "<?php echo site_url('admin/products/load_products');?>",
                "type": "POST"
            },
            columns: [
                   
                    { data: "p.short_name" },
                    { data: "p.sku" },
                    { data: "i.image" },
                    { data: "p.code" },
                    { data: "p.status" },
                    { data: "p.date" },
                    { data: "p.id" },
            ],
	}).dataTableSearch(500);
    
});

/**
 * Zepernick jQuery plugins 
 */
/*
 * Zepernick JS Commons library
 */
var $z = (function($z) {
	
	//empty object to assign custom functions / properties to
	$z.fn = {};
	
	//set a timeout delay that clears itself if it fires in succession before the timeout
	//is reached.  Useful when 
	$z.delay = (function(){
	  var timer = 0;
	  return function(ms, callback){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	})();
	
	
	//handles the security for ajax calls
	$z.ajax = function(jQueryOpts) {
		//store the success function specified on the call
		var userSuccess = jQueryOpts.hasOwnProperty("success") === false ?
			function(){}  :
				jQueryOpts.success;
			
		//replace the success function
		jQueryOpts.success = function(data, status, xhr) {
			//TODO check the header to make sure we did not get denied access or were not 
			//logged in
			
			userSuccess(data, status, xhr);
		};		
		
		
		
		return jQuery.ajax(jQueryOpts);
	};
	
	$z.select2Init = function(element, callback) {
		var val = element.val().split("|");
		if (val.length === 2) {
			callback({
				id: val[0],
	        	text: val[1]
	       });
		}
		
		
	};
	
	$z.setToggle = function(eles) {
		$z._toggleEles = eles;
	};
	
	$z.toggle = function() {
		if($z._toggleEles !== undefined) {
			$z._toggleEles.slideToggle(300, "swing");
		}
	};
	
	
	return $z;
	
})(window.$z || {});

(function($) {
	
	$.fn.dataTableSearch = function(delay) {
		//console.log("data table search plugin...");
		
		var dt = this;
		
		this.find("thead input").on( 'keyup', function (event) {
		 	
		 	
		 	getInput = function() {
		 		return $(event.target);
		 	};
		 	
		 	$z.delay(delay, function() {
		 		var td = getInput().closest("td");
		 		var index = td.index();
		 		//console.log("index is " + index);
		 		dt.DataTable()
			        .columns(index)
			        .search(getInput().val())
			        .draw();
		 	});
		 	
		    
		});
		
		
		return this;
		
	};
	
	
	function delay(){
	  var timer = 0;
	  return function(ms, callback){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	};
	
})(jQuery);
        
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
                    <p>Deleting a product will cause removal of all data related with that product from the system<br/><br/>Really want to delete product ?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" id="continue">Continue</a>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                </div>
            </div>

        </div>
    </div>
</div>
