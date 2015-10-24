<?php
echo "<table id='user_list'><thead><th>".$this->lang->line('settings_users_name')."</th>"
        ."<th>".$this->lang->line('settings_users_username')."</th>"
        ."<th>".$this->lang->line('settings_users_role')."</th>"
        ."<th>".$this->lang->line('settings_users_level')."</th></thead>";
foreach($all_users as $user) {
    echo "<tr><td>$user->name</td><td>$user->username</td><td>$user->role</td><td>$user->level</td></tr>";
}
echo div_start(array('id'=>'add_user_button','class'=>'green small_button','onclick'=>"$('#add_user_div').show()"));
echo $this->lang->line('settings_users_add_user');
echo div_end();
echo div_start(array('id'=>'add_user_div','class'=>'div_form hide'));
$add_user_form = array('id'=>'adduser_form','class'=>'small_form');;
echo form_open('settings/add_user',$add_user_form);
echo form_hidden('post_security',$this->config->item('post_security'));
echo form_label($this->lang->line('settings_users_name'), 'name');
echo form_input(array('id'=>'name','name'=>'name','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_id'), 'name');
echo form_input(array('id'=>'user_id','name'=>'user_id','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_username'), 'name');
echo form_input(array('id'=>'username','name'=>'username','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_email'), 'name');
echo form_input(array('id'=>'email','name'=>'email','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_password'), 'name');
echo form_input(array('id'=>'password','name'=>'password','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_role'), 'name');
echo form_input(array('id'=>'role','name'=>'role','class'=>'small_form'));
echo form_label($this->lang->line('settings_users_level'), 'name');
echo form_input(array('id'=>'level','name'=>'level','class'=>'small_form'));
echo form_submit(array('id'=>'adduser_submit'),$this->lang->line('add'));
echo form_close(); 
echo div_end();
?>
