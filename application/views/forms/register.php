<div id="registration" class="form_div">
<?php
$form = array('id'=>'register_form', 'class'=>'register');
$business_name = array('name'=>'business_name', 'id'=>'business_name','class'=>'register required','maxlength'=>'30','size'=>'20','placeholder'=>'שם החברה','value'=>$business_name_f);
$business_id = array('name'=>'business_id', 'id'=>'business_id','class'=>'register required','maxlength'=>'20','size'=>'20','placeholder'=>'מספר עוסק','value'=>$business_id_f);
$address_st = array('name'=>'address_st', 'id'=>'address_st','class'=>'register required','maxlength'=>'60','size'=>'24','placeholder'=>'רחוב','value'=>$address_st_f);
$address_number = array('name'=>'address_number', 'id'=>'address_number','class'=>'register','maxlength'=>'6','size'=>'7','placeholder'=>'מספר בית','value'=>$address_number_f);
$address_city = array('name'=>'address_city', 'id'=>'address_city','class'=>'register required','maxlength'=>'30','size'=>'20','placeholder'=>'עיר','value'=>$address_city_f);
$address_mikud = array('name'=>'address_mikud', 'id'=>'address_mikud','class'=>'register','maxlength'=>'7','size'=>'10','placeholder'=>'מיקוד','value'=>$address_mikud_f);
$address_pob = array('name'=>'address_pob', 'id'=>'address_pob','class'=>'register','maxlength'=>'10','size'=>'10','placeholder'=>'ת.ד. (אם יש)','value'=>$address_pob_f);
$uname = array('name'=>'uname', 'id'=>'uname','class'=>'register required','maxlength'=>'30','size'=>'20','placeholder'=>'שם מלא','value'=>$uname_f);
$uid = array('name'=>'uid', 'id'=>'uid','class'=>'register required','maxlength'=>'9','size'=>'12','placeholder'=>'תעודת זהות','value'=>$business_name_f);
$reg_username = array('name'=>'reg_username', 'id'=>'reg_username','class'=>'register required','maxlength'=>'30','size'=>'12','placeholder'=>'שם משתמש','value'=>$uid_f);
$email = array('name'=>'email', 'id'=>'email','class'=>'register required','maxlength'=>'50','size'=>'28','placeholder'=>'כתובת אימייל','value'=>$email_f);
$reg_password = array('name'=>'reg_password', 'id'=>'reg_password','class'=>'register required','maxlength'=>'20','size'=>'13','placeholder'=>'סיסמא','value'=>$reg_password_f);
$reg_password2 = array('name'=>'reg_password2', 'id'=>'reg_password2','class'=>'register hide','maxlength'=>'20','size'=>'13','placeholder'=>'אימות סיסמא');
$upload = array('name'=>'upload_logo','id'=>'upload_logo','class'=>'register','size'=>'5'); 
$submit = array('id'=>'register_submit', 'class'=>'register','name'=>'register_submit','value'=>'הירשם');
echo form_open_multipart('action/register',$form);
echo form_input($business_name);
echo form_input($business_id);
echo form_fieldset('כתובת העסק',array('id'=>'address_info','class'=>'register'));
echo form_input($address_st);
echo form_input($address_number);
echo form_input($address_city);
echo form_input($address_mikud);
echo form_input($address_pob);
echo form_fieldset_close();
echo form_fieldset('פרטי מנהל העסק',array('id'=>'address_info','class'=>'register'));
echo form_input($uname);
echo form_input($uid);
echo form_input($reg_username);
echo form_input($email);
echo form_password($reg_password);
echo '</br>';
echo form_label('העלאת לוגו', 'upload_logo');
echo form_upload($upload);
echo form_fieldset_close();
echo form_submit($submit);
echo form_close();
?>
</div>