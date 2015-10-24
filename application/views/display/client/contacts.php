<?php
    if($client->contact_name==='' && $client->contact_phone==='' && $client->contact_mobile==='' && $client->contact_email==='') {
        echo '<p style="font-size:1.2em;font-weight:bold;color:#333;text-align:center;">אין אנשי קשר ללקוח זה</p>';
    }
    else {
        if($client->contact_name==='') {
            $client->contact_name = 'ללא שם';
        }
        $contact_name = array('id'=>'contact_name','name'=>'contact_name', 'class'=>'add_contact','size'=>'16','maxlength'=>'16');
        $contact_phone = array('id'=>'contact_phone','name'=>'contact_phone', 'class'=>'add_contact','size'=>'16','maxlength'=>'14');
        $contact_mobile = array('id'=>'contact_mobile','name'=>'contact_mobile', 'class'=>'add_contact','size'=>'16','maxlength'=>'14');
        $contact_fax = array('id'=>'contact_fax','name'=>'contact_fax', 'class'=>'add_contact','size'=>'16','maxlength'=>'14');
        $contact_email = array('id'=>'contact_email','name'=>'contact_email', 'class'=>'add_contact','size'=>'30','maxlength'=>'45');
        $addcontact_submit = array('id'=>'addcontact','name'=>'addcontact');
        echo "<div id='add_contact'>הוסף איש קשר</div>";
        echo "<div id='add_contact_form' class='hide'>";
        echo br();
        echo form_label('שם מלא',$contact_name);
        echo form_input($contact_name);
        echo form_label('טלפון',$contact_phone);
        echo form_input($contact_phone);
        echo form_label('טלפון נייד',$contact_mobile);
        echo form_input($contact_mobile);
        echo form_label('פקס',$contact_fax);
        echo form_input($contact_fax);echo br();
        echo form_label('דוא"ל',$contact_email);
        echo form_input($contact_email);
        echo form_submit($addcontact_submit,'הוסף');
        echo "</div>";
        echo "<table id='client_contacts'>";
        echo "<thead><th></th><th>שם</th><th>טלפון</th><th>טלפון נייד</th><th>פקס</th><th id='contact_email'>כתובת אימייל</th><th>תפקיד</th></thead>";
        echo "<tr><td></td><td>$client->contact_name</td><td>$client->contact_phone</td><td>$client->contact_mobile</td><td>$client->contact_fax</td>".
                "<td>$client->contact_email</td><td></td></tr>";
        if(!empty($contacts)) {
            foreach($contacts as $contact) {
                 echo "<tr><td>".anchor("clients/delete_contact/$contact->db_id/$contact->client_id",'מחק')."</td><td>$contact->name</td><td>$contact->phone</td><td>$contact->mobile</td>".
                 "<td>$contact->fax</td><td>$contact->email</td><td></td></tr>";
            }
        }
        echo "</table>";
    }
?>