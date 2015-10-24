<div id="top-profile">
    <img src="<?php echo $current_user['company']->logo; ?>" 
         title="<?php echo $current_user['company']->business_name; ?>" 
         rel="<?php echo $current_user['company']->business_name; ?>"
         id="logo_img"/>
    <p style="float:right"><span style="color:#d91"><?php echo $this->lang->line('user').': '; ?> </span><?php echo $current_user['user']->name; ?></p>
    
</div>
<div id="session_time">
    <div id="session_text" title=<?php echo $this->lang->line('can_change_session_time_suggestion'); ?> >
        <?php echo $this->lang->line('session_time_left').": "; ?> <p style='display:inline' id='session_clock'></p>
    </div>
    <div id="session_bar_red" class="session_bar" style="background:red"></div>
    <div id="session_bar_green" class="session_bar" style="background:greenyellow;width:20em"></div>
</div>