<div id="view_client" class="display_div">
<?php
if(empty($client) || $client->deleted!=0)  echo "<div class='empty_glass'>לקוח לא קיים</div>";
else {
    $form = array('id'=>'newclient_form', 'class'=>'new_client');
    $submit = array('id'=>'newclient_submit','name'=>'newclient_submit', 'class'=>'new_client','value'=>'עדכן פרטים');
    echo form_open("clients/update/$tab",$form);
    echo "<ul id='client_card_upper_menu'>";
    echo anchor("clients/new_client","<li>לקוח חדש</li>");
    echo anchor("clients/view","<li>רשימת לקוחות</li>");
    echo "</ul>";
    echo '<p style="float:right">תאריך פתיחת כרטיס: '.$client->date_created.'</p>';
    echo br();
    $contact_details = "";
    if($client->contact_name!=='') $contact_details = " - (".$client->contact_name;
    if($client->contact_mobile!=='') $contact_details .= " : ".$client->contact_mobile;
    elseif($client->contact_phone!=='') $contact_details .= " : ".$client->contact_phone;
    if($client->contact_name!=='') $contact_details .= ")";
    echo '<legend class="new_client">כרטיס לקוח '.$client->client_id.' | '.
            anchor("clients/view?cid=$client->client_id&tab=details",'<span class="customer_name under-line">'.
                    $client->name.$contact_details."</span>");
    echo form_submit($submit);
    echo "<ul id='client_card_nav'>";
    echo anchor("clients/view?cid=$client->client_id&tab=contacts","<li>אנשי קשר</li>");
    echo anchor('',"<li>רכישות/הזמנות</li>");
    echo anchor('',"<li>עוד משהו</li>");
    echo "</ul>";
    echo '</legend>';
    
    echo form_hidden('db_id', $client->db_id);
    echo form_hidden('the_id', $client->client_id);
    echo "<div style='width:83%;display:inline-block'>";
    $this->load->view("display/client/$tab");
    echo "</div>"
?>
    
    <div id='leftpanel_clientcard'>
        <ul id="leftpanel_clientcard_list">
            <?php
                echo anchor('','<li>הצעת מחיר</li>');
                echo anchor('','<li>הזמנה</li>');
                echo anchor("docs/invoice?cid=$client->client_id",'<li>חשבונית מס</li>');
                echo anchor('','<li>חשבונית מס קבלה</li>');
                echo anchor('','<li>קבלה</li>');
                echo anchor('','<li>חשבונית זיכוי</li>');
                echo anchor('','<li>תעודת משלוח</li>');
                echo anchor('','<li>חשבון עסקה</li>');
            ?>
        </ul>
    </div>
    
<?php
    echo form_close();
}
    
?>
</div>