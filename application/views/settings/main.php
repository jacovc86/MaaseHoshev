<?php
$settings_wrapper = array('id'=>'settings_wrapper'); 
$settings_container = array('id'=>'settings_container');

if($this->the_user->level<3) {
    $menu = array(
        $this->lang->line('system') => array('id'=>'system_tab','name'=>'system','class'=>'settings_tab','onclick'=>"window.location.href='/settings?tab=system'"),
        $this->lang->line('users') => array('id'=>'users_tab','name'=>'users','class'=>'settings_tab','onclick'=>"window.location.href='/settings?tab=users'"),
        $this->lang->line('products') => array('id'=>'products_tab','name'=>'products','class'=>'settings_tab','onclick'=>"window.location.href='/settings?tab=products'"),
        $this->lang->line('clients') => array('id'=>'clients_tab','name'=>'clients','class'=>'settings_tab','onclick'=>"window.location.href='/settings?tab=clients'")
    );
}
else {
    $menu = array(
        $this->lang->line('system') => array('id'=>'system_tab','name'=>'system','class'=>'settings_tab','onclick'=>"window.location.href='/settings?tab=system'")
    );
}

echo div_start($settings_wrapper);
foreach($menu as $item=>$attr) {
    echo div_start($attr);
    echo $item;
    echo div_end();
}


echo div_start($settings_container);

switch($tab) {
    case 'system':
    default:
        $this->load->view('settings/system');
        break;
    case 'users':
        $this->load->view('settings/users');
        break;
    case 'products':
        $this->load->view('settings/products');
        break;
    case 'clients':
        $this->load->view('settings/clients');
        break;
}

echo div_end(); //Container
echo div_end(); //Wrapper
?>
