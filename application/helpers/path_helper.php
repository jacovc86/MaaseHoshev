<?php
function get_path($filename,$type) {
	return APPPATH."/".$type."/".$filename."/";
}
function template_path($template_name) {
	return APPPATH."views/templates/".$template_name."/";
}
?>