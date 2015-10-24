<?php
 $client_data = array(
            'name'=>'אבא',
            'id'=>'אמא',
            'street'=>'ילד',
            'st_number'=>'ילדה',
            'city'=>'אח',
            'mikud'=>'אחות',
            'pob'=>',סבא',
            'contact_name'=>'סבתא',
            'contact_phone'=>'דוד',
            'contact_mobile'=>'דודה',
        );
		$xml = simplexml_load_file('data.xml');
		print_r($xml);
?>