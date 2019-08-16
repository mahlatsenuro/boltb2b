<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="<?php echo $subs == 'micomp' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/point_sale'); ?>">Micomp</a>
            </li>
            <li class="<?php echo $subs == 'shop' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/shop_keeper'); ?>">Shopkeeper</a>
            </li>
            <li class="<?php echo $subs == 'csv' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/csv'); ?>">IQ Retail</a>
            </li>
            <li class="<?php echo $subs == 'posibolt' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('admin/settings/posibolt'); ?>">Posibolt</a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <br/><br/>
</div>

