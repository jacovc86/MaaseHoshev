<?php

function p($string,$attr = array()) {
    echo "<p ";
    foreach($attr as $a=>$b) {
        echo "$a = \"$b\" ";
    }
    echo ">$string</p>";
}
function h($hnum,$string,$attr = array()) {
    echo "<h".$hnum." ";
    foreach($attr as $a=>$b) {
        echo "$a = \"$b\" ";
    }
    echo ">$string</h".$hnum.">";
}
function div_start($attr) {
    echo "<div ";
    foreach($attr as $a=>$b) {
        echo "$a = \"$b\" ";
    }
    echo ">"; 
}
function div_end() {
    echo "</div>";
}
function li($type,$items,$attr = array()) {
    if($type !== 'ul' && $type!=='ol')
        throw new Exception ("Wrong list type: $type");
    echo "<$type ";
    foreach($attr as $a=>$b) {
        echo "$a = \"$b\" ";
    }
    echo ">";
    foreach($items as $item) {
        echo $item;
    }
}
function table($rows,$attr = array(),$titles = '') {
    if(!is_array($rows)) {
        throw new Exception("Table must be an array");
    }
    else if(!is_array($rows[0])) {
        if(is_object($rows[0])) {
            foreach($rows as $row)
                $row = (array)$row;
        }
        else {
            echo li('ul',$rows,$attr);
            return;
        }
    }
    echo "<table ";
    foreach($attr as $a=>$b) {
        echo "$a = \"$b\" ";
    }
    echo ">";
    if(!empty($titles)) {  
        echo "<thead>";
        foreach($titles as $title) {
            echo "<th>$title</th>";
        }
        echo "</thead>";
    }
    foreach($rows as $row) {
        echo "<tr>";
        foreach($row as $field) {
            echo "<td>$field</td>";
        }
        echo "</tr>";
    }
    echo "</table>"; 
}

?> 
