<style>
    .sync-control{margin: 0 2px; max-width: 100%;}
</style>
<div class="sync_timings">
    <h2>Schedule your sync</h2>
    <span class="error">Last sync: <?php echo $this->config->item('last_sync_time'); ?></span><br/>
    <span class="error">Now: <?php echo Date('Y-m-d H:i:s') ?></span>
    <div class="clearfix"></div>
    <br/><br/>
    <div class="col-sm-1">
        <div class="form-group">
            <label>Daily</label>
        </div>
        <div class="form-group">
            <label>Twice Daily</label>
        </div>
        <div class="form-group">
            <label>Weekly</label>
        </div>
        <div class="form-group">
            <label>Monthly</label>
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <input type="radio" name="schedule" value="0" <?php echo $this->config->item('schedule') == 0 ? 'checked' : '' ?> />
        </div>
        <div class="form-group">
            <input type="radio" name="schedule" value="1" <?php echo $this->config->item('schedule') == 1 ? 'checked' : '' ?> />
        </div>
        <div class="form-group">
            <input type="radio" name="schedule" value="2" <?php echo $this->config->item('schedule') == 2 ? 'checked' : '' ?> />
        </div>
        <div class="form-group">
            <input type="radio" name="schedule" value="3" <?php echo $this->config->item('schedule') == 3 ? 'checked' : '' ?> />
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <input type="number" name="schedule_day[0]" style="visibility:hidden" class="sync-control " min="1" max="7" value="<?php echo $this->config->item('schedule_day') ?>" />
        </div>
        <div class="form-group">
            <input type="number" name="schedule_day[1]" style="visibility:hidden" class="sync-control " min="1" max="7" value="<?php echo $this->config->item('schedule_day') ?>" />
        </div>
        <div class="form-group">
            <select name="schedule_day[2]" class="sync-control">
                <option value="2" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 2 ? "selected" : "" ?> >Monday</option> 
                <option value="3" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 3 ? "selected" : "" ?> >Tuesday</option>                            
                <option value="4" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 4 ? "selected" : "" ?> >Wednesday</option>
                <option value="5" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 5 ? "selected" : "" ?> >Thursday</option>
                <option value="6" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 6 ? "selected" : "" ?> >Friday</option>
                <option value="7" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 7 ? "selected" : "" ?> >Saturday</option>
                <option value="1" <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_day') == 1 ? "selected" : "" ?> >Sunday</option>
            </select>
        </div>
        <div class="form-group">
            <select name="schedule_day[3]" class="sync-control">
                <option value="2" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 2 ? "selected" : "" ?> >Monday</option> 
                <option value="3" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 3 ? "selected" : "" ?> >Tuesday</option>                            
                <option value="4" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 4 ? "selected" : "" ?> >Wednesday</option>
                <option value="5" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 5 ? "selected" : "" ?> >Thursday</option>
                <option value="6" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 6 ? "selected" : "" ?> >Friday</option>
                <option value="7" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 7 ? "selected" : "" ?> >Saturday</option>
                <option value="1" <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_day') == 1 ? "selected" : "" ?> >Sunday</option>
            </select>
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <select name="schedule_hour[0]" class="sync-control" style="float: left">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 0 && $this->config->item('schedule_hour') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min[0]" class="sync-control">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 0 && $this->config->item('schedule_min') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <select name="schedule_hour[1]" class="sync-control" style="float: left">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 1 && $this->config->item('schedule_hour') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min[1]" class="sync-control">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 1 && $this->config->item('schedule_min') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group"  style="padding-top:6px;">
            <select name="schedule_hour[2]" class="sync-control" style="float: left">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_hour') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min[2]" class="sync-control">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_min') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <select name="schedule_hour[3]" class="sync-control" style="float: left">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_hour') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min[3]" class="sync-control">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_min') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
    </div>
    
    <div class="col-sm-1">
        <div class="form-group">
            <select name="schedule_hour2[0]" class="sync-control" style="float: left; visibility:hidden;">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 0 && $this->config->item('schedule_hour2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min2[0]" class="sync-control" style="visibility:hidden;">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 0 && $this->config->item('schedule_min2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <select name="schedule_hour2[1]" class="sync-control" style="float: left;">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 1 && $this->config->item('schedule_hour2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min2[1]" class="sync-control">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 1 && $this->config->item('schedule_min2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <select name="schedule_hour2[2]" class="sync-control" style="float: left;visibility:hidden;">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_hour2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min2[2]" class="sync-control" style="visibility:hidden;">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 2 && $this->config->item('schedule_min2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <select name="schedule_hour2[3]" class="sync-control" style="float: left;visibility:hidden;">
                <?php for($i=0; $i<=23; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_hour2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <select name="schedule_min2[3]" class="sync-control" style="visibility:hidden;">
                <?php for($i=0; $i<=59; $i++): ?>
                <option <?php echo $this->config->item('schedule') == 3 && $this->config->item('schedule_min2') == $i ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i<10 ? "0".$i : $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix"></div>
        </div>
    </div>
    
    
</div>