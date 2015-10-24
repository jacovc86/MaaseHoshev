<div id="view_client" class="form_div">
<?php
echo "<ul id='client_card_upper_menu'>";
echo anchor("clients/view","<li>רשימת לקוחות</li>");
echo "</ul>";
echo br();
$form = array('id'=>'newclient_form', 'class'=>'new_client');

$name = array('id'=>'client_name','name'=>'client_name','class'=>'new_client required','size'=>'50','maxlength'=>'40');
$id = array('id'=>'client_id','name'=>'client_id','class'=>'new_client','size'=>'16','maxlength'=>'9');
$street = array('id'=>'client_street','name'=>'client_street', 'class'=>'new_client','size'=>'16','maxlength'=>'30');
$st_number = array('id'=>'st_number','name'=>'st_number', 'class'=>'new_client','size'=>'2','maxlength'=>'4');
$city = array('id'=>'city','name'=>'city', 'class'=>'new_client','size'=>'13','maxlength'=>'15');
$mikud = array('id'=>'mikud','name'=>'mikud', 'class'=>'new_client','size'=>'8','maxlength'=>'7');
$pob = array('id'=>'pob','name'=>'pob', 'class'=>'new_client','size'=>'2','maxlength'=>'30');
$contact_name = array('id'=>'contact_name','name'=>'contact_name', 'class'=>'new_client','size'=>'16','maxlength'=>'16');
$contact_phone = array('id'=>'contact_phone','name'=>'contact_phone', 'class'=>'new_client','size'=>'16','maxlength'=>'14');
$contact_mobile = array('id'=>'contact_mobile','name'=>'contact_mobile', 'class'=>'new_client','size'=>'16','maxlength'=>'14');
$contact_fax = array('id'=>'contact_fax','name'=>'contact_fax', 'class'=>'new_client','size'=>'16','maxlength'=>'14');
$contact_email = array('id'=>'contact_email','name'=>'contact_email', 'class'=>'new_client','size'=>'46','maxlength'=>'45');
$notes = array('id'=>'notes','name'=>'notes', 'class'=>'new_client','cols'=>'46','rows'=>'10');
$submit = array('id'=>'newclient_submit','name'=>'newclient_submit', 'class'=>'new_client','value'=>'הוסף לקוח');
echo form_open('clients/save',$form);
echo '<legend class="new_client">לקוח חדש';
echo form_submit($submit);
echo '</legend>';

echo '<ul class="new_client">';
echo '<li id="client_name">';
echo form_label('שם הלקוח',$name);
echo form_input($name);
echo br();
echo form_label('ת.ז. או ח.פ.',$id);
echo form_input($id);
echo '</li><li id="client_address">';
echo '<legend class="inline">כתובת</legend>';
echo form_label('רחוב',$street);
echo form_input($street);
echo form_label('מספר בית',$st_number);
echo form_input($st_number);echo br();
echo form_label('עיר',$city);
echo form_input($city);
echo form_label('מיקוד',$mikud);
echo form_input($mikud);
echo form_label('ת"ד',$pob);
echo form_input($pob);
echo '</li></ul>';
echo '<ul class="new_client">';
echo '<li id="contact_details">';
echo '<legend class="inline">איש קשר</legend>';
echo form_label('שם מלא',$contact_name);
echo form_input($contact_name);
echo form_label('טלפון',$contact_phone);
echo form_input($contact_phone);
echo '</br>';
echo form_label('טלפון נייד',$contact_mobile);
echo form_input($contact_mobile);
echo form_label('פקס',$contact_fax);
echo form_input($contact_fax);
echo '</br>';
echo form_label('דוא"ל',$contact_email);
echo form_input($contact_email);
echo '</li><li id="client_additional_info">';
echo '<legend class="inline">הערות נוספות</legend>';
echo form_textarea($notes);
echo '</li></ul>';
echo form_close();
?>
</div>