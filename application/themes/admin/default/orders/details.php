<div id="page-inner">
    <?php echo form_open('', array('class' => 'form-new', "id" => "product", 'data-parsley-validate' => '')); ?>
    <div class="row">
        <div class="col-md-6">
            <h2>Order details</h2>   
            <h5>View details for this order</h5><br/>
            <br/>
        </div>
        <div class="col-md-6">
            <div class="pull-right nav-area">
                <button type="submit" name="submitForm" class="btn btn-info btn-sm" value="formSave">
                    <span class="glyphicon glyphicon-share"></span>
                    Save
                </button>

                <button type="submit" name="submitForm" class="btn btn-info btn-sm " value="formSaveClose">
                    <span class="glyphicon glyphicon-share"></span>
                    Save and Close
                </button>
                <a href="<?php echo site_url('admin/orders/'); ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-reply"></i>
                    Back
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div> 
    
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $this->config->item('store_name'); ?> order #ord-<?php echo $orders[0]->oid; ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Order</p> 
                        </div>
                        <div class="col-sm-4">
                            <p><strong>#ord-<?php echo $orders[0]->oid; ?></strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Order reference</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong><?php echo $orders[0]->order_reference; ?></strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Order time</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong><?php echo Date('d-m-Y H:i:s', strtotime($orders[0]->date)); ?></strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Order status</p>
                        </div>
                        <div class="col-sm-4">
                            <p>
                                <strong>Checkout: <span class="success">Completed</span></strong><br/>
                                <strong>Order placed: <span class="<?php echo $orders[0]->order_placed == 1 ? 'success' : 'error' ?>"><?php echo $orders[0]->order_placed == 1 ? 'Completed' : 'Pending' ?></span></strong><br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Buyer Information
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Customer</p> 
                        </div>
                        <div class="col-sm-4">
                            <p><strong><?php echo $orders[0]->first_name.' '.$orders[0]->last_name; ?></strong><br/>
                                <strong><?php echo !empty($orders[0]->email) ? 'Email: '.$orders[0]->email.'' : ''?></strong><br/> 
                                <strong><?php echo !empty($orders[0]->phone) ? 'Phone: '.$orders[0]->phone.'' : ''?></strong><br/> 
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Shipping address</p> 
                        </div>
                        <div class="col-sm-4">
                            <p><strong><?php echo str_replace('||', '<br/>', $orders[0]->shipping_address) ?></strong><br/>
                            </p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Order comments</p> 
                        </div>
                        <div class="col-sm-4">
                            <p><strong><?php echo $orders[0]->ocomment ?></strong><br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payment Information 
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Payment method</p>
                            </div>
                            <div class="col-sm-4">
                                <p><strong><?php echo $orders[0]->payment_method; ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Total amount</p>
                            </div>
                            <div class="col-sm-4">
                                <p><strong>R<?php echo formatNumber($orders[0]->oprice); ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Order status</p>
                            </div>
                            <div class="col-sm-4">
                                <select name="status" class="form-control">
                                    <option value="0" <?php echo $orders[0]->order_placed == 0 ? 'selected' : '' ;?> >Pending</option>
                                    <option value="1" <?php echo $orders[0]->order_placed == 1 ? 'selected' : '' ;?>>Completed</option>
                                </select>
                                <?php echo form_error('status'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>EFT Transaction id</p>
                            </div>
                            <div class="col-sm-4">
                                <p>
                                    <input type="text" class="form-control" name="transaction_id" value="<?php echo $orders[0]->transaction_id; ?>"
                                    <?php echo form_error('transaction_id'); ?>       
                                </p>
                            </div>
                        </div>
                        
                    </div>
                 </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Shipping details
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Shipping charge</p>
                            </div>
                            <div class="col-sm-4">
                                <p><strong>R<?php echo formatNumber($orders[0]->pos_shipping_price); ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Shipped by</p>
                            </div>
                            <div class="col-sm-4">
                                <p><strong><?php echo $orders[0]->courier; ?></strong></p>
                            </div>
                        </div>
                    </div>

                 </div>
            </div>
            <div class="clearfix"></div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Transaction items
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Options</th>
                                <th>Product comment</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?php echo $order->product_name; ?></strong></td>
                                <td><strong><?php echo $order->quantity; ?></strong></td>
                                <td><strong><?php echo formatNumber($order->odprice); ?></strong></td>
                                <?php 
                                    $variations = array();
                                    if(isset($order->options) && !empty($order->options)){ 
                                        $options     = json_decode($order->options, TRUE);                                        
                                        $option_data = array_filter($options, 'strlen');
                                        foreach ($option_data as $key => $ops){
                                            if($key == 'stock_id' || $key == 'envelop' || $key == 'weight' || $key == 'height' || $key == 'width' || $key == 'length'){
                                                continue;
                                            }
                                            $variations[]  .= $key.' : '.$ops;
                                        }
                                    }
                                ?>
                                <td><?php echo count($variations) > 0 ? '('.implode(', ', $variations).')' : ''; ?></td>
                                <td><?php echo $order->odcomment; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
             <div class="panel panel-default">
                <div class="panel-heading">
                    Coupon
                </div>
                 <div class="panel-body">
                    <?php $coupon = $orders[0]->coupon; $coupon_data = json_decode($coupon, TRUE); 
                    
                    if(is_array($coupon_data) && count($coupon_data) > 0 ){
                        echo '<p>Coupon Type: <strong>'.$coupon_data['coupon_type'].'</strong></p>';
                        echo '<p>Coupon Amount: <strong>'.$coupon_data['coupon_amount'].'</strong></p>';
                    }
                    else{
                        echo '<p>No coupons used!</p>';
                    }
                    ?>
                    <p></p>
                </div>
             </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>