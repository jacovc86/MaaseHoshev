<?php
    
    $name = array('id'=>'client_name','name'=>'client_name','class'=>'new_client','size'=>'40','maxlength'=>'40','value'=>$client->name);
    $id = array('id'=>'client_id','name'=>'client_id','class'=>'new_client','size'=>'16','maxlength'=>'9','value'=>$client->id);
    $street = array('id'=>'client_street','name'=>'client_street', 'class'=>'new_client','size'=>'16','maxlength'=>'30','value'=>$client->street);
    $st_number = array('id'=>'st_number','name'=>'st_number', 'class'=>'new_client','size'=>'2','maxlength'=>'4','value'=>$client->st_number);
    $city = array('id'=>'city','name'=>'city', 'class'=>'new_client','size'=>'13','maxlength'=>'15','value'=>$client->city);
    $mikud = array('id'=>'mikud','name'=>'mikud', 'class'=>'new_client','size'=>'8','maxlength'=>'7','value'=>$client->mikud);
    $pob = array('id'=>'pob','name'=>'pob', 'class'=>'new_client','size'=>'2','maxlength'=>'30','value'=>$client->pob);
    $contact_name = array('id'=>'contact_name','name'=>'contact_name', 'class'=>'new_client','size'=>'16','maxlength'=>'16','value'=>$client->contact_name);
    $contact_phone = array('id'=>'contact_phone','name'=>'contact_phone', 'class'=>'new_client','size'=>'16','maxlength'=>'14','value'=>$client->contact_phone);
    $contact_mobile = array('id'=>'contact_mobile','name'=>'contact_mobile', 'class'=>'new_client','size'=>'16','maxlength'=>'14','value'=>$client->contact_mobile);
    $contact_fax = array('id'=>'contact_fax','name'=>'contact_fax', 'class'=>'new_client','size'=>'16','maxlength'=>'14','value'=>$client->contact_fax);
    $contact_email = array('id'=>'contact_email','name'=>'contact_email', 'class'=>'new_client','size'=>'40','maxlength'=>'45','value'=>$client->contact_email);
    $notes = array('id'=>'notes','name'=>'notes', 'class'=>'new_client','cols'=>'35','rows'=>'10','value'=>$client->notes);
    
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


?>