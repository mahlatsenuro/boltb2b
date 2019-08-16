<section class="flat-row main-shop shop-slidebar" data-filter-group>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="search" id='search' class="search-query form-control" placeholder="Search by name of category" />
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button">
                                <span class="fa fa-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-10">
                <div class="product-content product-threecolumn product-slidebar clearfix">
                    <div class="wrap">
                        <div class="row">
                            <div class="col-md-12 prod-assets">
                              <form action="<?php echo base_url() ?>catalog/insert" method="POST">
                                <table class="table table-bordered" id="prod-asset-tbl">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th>Product Name</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody id="table-details">
                                      <?php foreach($categories as $product){ ?>
                                        <tr>
                                          <td>
                                            <h4><?php echo $product->name; ?></h4>
                                            <input type="hidden" name="product_title[]" value="<?php echo $product->name; ?>">
                                          </td>
                                          <td><button type="submit" class="btn btn-outline-success float-right">Generate Assets</button></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#shop").products();
            $("#category").categories();
        });
    </script>
    <script type='text/javascript'>
        $(document).ready(function(){
            $('#search').keyup(function(){
                var search = $(this).val();
                $('table tbody tr').hide();
                var len = $('table tbody tr:not(.notfound) td:contains("'+search+'")').length;

                if(len > 0){
                    $('table tbody tr:not(.notfound) td:contains("'+search+'")').each(function(){
                        $(this).closest('tr').show();
                    });
                }else{
                    $('.notfound').show();
                }
            });
        });

        $.expr[":"].contains = $.expr.createPseudo(function(arg) {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
    </script>

    <script type='text/javascript'>
        $(document).ready(function() {
            $('#all').click(function() {
                var isChecked = $(this).prop("checked");
                $('#prod-asset-tbl tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
            });

            $('#prod-asset-tbl tr:has(td)').find('input[type="checkbox"]').click(function() {
                var isChecked = $(this).prop("checked");
                var isHeaderChecked = $("#all").prop("checked");
                if (isChecked == false && isHeaderChecked)
                    $("#all").prop('checked', isChecked);
                else {
                    $('#prod-asset-tbl tr:has(td)').find('input[type="checkbox"]').each(function() {
                        if ($(this).prop("checked") == false)
                            isChecked = false;
                    });
                    console.log(isChecked);
                    $("#all").prop('checked', isChecked);
                }
            });
        });
    </script>
</section>
