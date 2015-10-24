<?php

class ItemList {
    public $items;
    public $name;
    public function ItemList() {
        $this->name = $list_name;
        if(is_array($items)) $this->items = $items;
        else $this->items = array($items);
    }

    public function add($item) {
        array_push($this->items, $item);
    }
    public function get() {
        return $this->items;
    }
    public function show() {
        $list_div = array('id'=>$this->name.'_div','class'=>'list');
        $list = array('id'=>$this->name.'_list','class'=>'list');
        echo div_start($list_div);
        echo table($this->items,$list);
        echo div_end(); 
        
    }
}
?>
