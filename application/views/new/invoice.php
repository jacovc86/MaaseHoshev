<div id="new_invoice" class="new_doc">
<?php
if($cid=='') {
    $form = array('id'=>'choseclient_form', 'class'=>'new_doc','autocomplete'=>'off');
    $client_input = array('name'=>'chose_client', 'id'=>'chose_client','maxlength'=>'30','size'=>'30','placeholder'=>'לקוח');
    $submit = array('id'=>'chose_client','name'=>'chose_client', 'class'=>'chose_client focus','value'=>'המשך');
    echo form_open('docs/invoice/chose',$form);
    echo "<legend class='new_doc'>";
    echo "<h1>הנפקת חשבונית מס</h1>";
    echo form_input($client_input);
    echo form_input(array('style'=>'display:none','name'=>'chosen','id'=>'chosen'));
    echo form_submit($submit);
    echo br();
    echo h(2,'',array('id'=>'selected_client'));
    echo "</legend>"; 
    echo p("ניתן לחפש על פי שם הלקוח, שם איש הקשר או מס' הח.פ/ת.ז. של הלקוח",array('class'=>'suggestion'));
    echo "<div id='clients_list_div'>";
    echo "<table id='client_list' class='clients'>"; 
        echo "<thead><th>מס' לקוח</th><th>שם</th><th>ת.ז.</th><th>איש קשר</th><th>טלפון/נייד</th><th>תאריך פתיחה</th></thead>";
        foreach($clients as $client) {
            $client_phone = '';
            if($client->contact_mobile) $client_phone = $client->contact_mobile;
            elseif($client->contact_phone) $client_phone = $client->contact_phone;
            echo "<tr onclick=\"window.location.href='/docs/invoice?cid=$client->client_id'\">";
            echo "<td style='width:1em'>$client->client_id</td>";
            echo "<td style='width:18em;text-align:right'>$client->name</td>";
            echo "<td style='width:7em'>$client->id</td>";
            echo "<td style='width:7em'>$client->contact_name</td>";
            echo "<td style='width:9em'>$client_phone</td>";
            echo "<td style='width:9em'>$client->date_created</td>";
            echo "</tr>"; 
            echo "</a>";
        }
    echo "</table>";
    echo "</div>";
    echo form_close(); 
    
}
else {
    $form = array('id'=>'invoice_form','class'=>'new_doc');
    echo form_open('docs/save/invoice',$form);
    
    echo "<legend class='new_doc'>";
    echo "<h1>הנפקת חשבונית מס</h1>";
    echo "<span style='font-size:1.3em'>";
    echo anchor("clients/view?cid=$client->client_id","<p style='font-weight:bold'>$client->name</p>");
    if($client->id) echo "<p>ת.ז. או ח.פ. $client->id</p>";echo "</span>";
    echo anchor('docs/invoice',"<span style='float:left;font-weight:bold;border:1px #ccc dashed;letter-spacing:1.2px;box-shadow:2px 2px 2px #888;font-size:1.2em;color:#345422'>לקוח אחר<span>");
    echo "<hr style='border:1px #ccc solid'>";
    if($client->city) echo "<p>כתובת: $client->street $client->st_number, $client->city $client->mikud</p>";
    echo br();
    $has_some_contact = ($client->contact_phone || $client->contact_mobile || $client->contact_fax || $client->contact_email);
    if($has_some_contact) {
        $phone = '';
        if($client->contact_mobile) $phone = 'נייד: '.$client->contact_mobile;
        elseif($client->contact_phone) $phone = 'טלפון: '.$client->contact_phone;
        elseif($client->contact_fax) $phone = 'פקס: '.$client->contact_fax;
        echo "<p style='text-decoration:underline;color:#B31B58'>פרטי התקשרות:</p>";
        echo "<p>";
        echo "<span style='font-weight:bold'>$client->contact_name&nbsp;</span>";
        if($phone) echo $phone;
        if($client->contact_email) echo " כתובת אימייל: $client->contact_email&nbsp;";
        echo "</p>";
    }
    echo "</legend>";
    $product_name = array('id'=>'product_name','name'=>'product_name','class'=>'new_doc','size'=>'50');
    $product_info = $setting->product_info;
    echo "<div id='inner_invoice'>";
    echo form_label('שם הפריט','product_name');
    echo form_input($product_name);
    echo "</div>";
    echo form_close();
}
?>
</div>