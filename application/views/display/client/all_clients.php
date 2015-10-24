<div id="inner_nav" class="all_clients">
    <?php echo form_open('clients/view',array('id'=>'allclients_form')); ?>
    <ul id='all_clients_upper_menu'>
        <li>
            <?php echo anchor('clients/new_client','לקוח חדש'); ?>
        </li>
        <li>
            <?php 
                echo "<span style='color:#fff'>מציג: </span>";
                if($limit=='') $limit = '30';
                echo form_input(array('name'=>'clients_limit','value'=>$limit));
            ?>
        </li>
        <li>
            <?php echo anchor('clients/view?l=all','הצג הכל'); ?>
        </li>
       
    </ul>
    <?php echo form_close(); ?>
</div>
<div id="clients" class="display_div">
<?php
if(empty($clients)) echo "<div class='empty_glass'>אין לך לקוחות עדיין</div>";
else {
    $order_sign = $c=='desc'?'&and;':'&or;';
echo "<table id='all_clients'>";
echo "<thead>";
echo "<th>".anchor('clients/view?c='.($c=='desc'?'asc':'desc'),"מס' לקוח".$order_sign,array('style'=>'color:#fff'))."</th>";
echo "<th>שם</th><th>ת.ז.</th><th>טלפון/נייד</th><th>תאריך פתיחה</th><th>יתרה</th><th>פעולות</th></thead>";
foreach($clients as $client) {
    $client_phone = '';
    if($client->contact_mobile!=='') $client_phone = $client->contact_mobile;
    elseif($client->contact_phone!=='') $client_phone = $client->contact_phone;
    echo "<tr style='cursor:pointer' class='client_row' onclick=\"window.location.href='/clients/view?cid=$client->client_id'\">";
    echo "<td style='width:1em'>".$client->client_id."</td>";
    echo "<td style='width:18em;text-align:right'>$client->name</td>";
    echo "<td style='width:7em'>".$client->id."</td>";
    echo "<td style='width:9em'>".$client_phone."</td>";
    echo "<td style='width:9em'>".$client->date_created."</td>";
    echo "<td style='width:1em'>בפיתוח</td>";
    echo "<td style='width:1em'>".
            anchor("clients/delete/$client->client_id",'מחק');
            "</td>";
    echo "</tr>";
}
echo "</table>";
}
?>
</div>