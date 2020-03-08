<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if(!function_exists('add_bill')){

	/**
     *
     * @return value
     */
	function add_bill($data) {
		$CI = & get_instance();
        $CI->load->database();
        $CI->load->model('User_model');

        $menu_name = 'Unknown Item';
        $menu_price = get_settings('price');
        $getMenu = $CI->User_model->data_select("menu", ['id'=> $data['menu_id']]);
        if(sizeof($getMenu) != 0 ){
            foreach($getMenu as $getM){
                $menu_price = $getM->price;
                $menu_name = $getM->title;
            }
        }

        $billing = $CI->User_model->data_submit("billing", [
            'user_id' => $data['user_id'],
            'item' => $menu_name,
            'price' => $menu_price
        ]);

        if($billing){
            return true;
        }
        return false;
	}
}