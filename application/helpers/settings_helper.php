<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if(!function_exists('get_settings')){

	/**
     * Get specified setting from data object
     * @return value
     */
	function get_settings($setting_name) {
		$CI = & get_instance();
        $CI->load->database();
        $settings = $CI->db->query("SELECT * FROM settings");
        $data = [];
        if($settings->num_rows() !=  0){
            foreach($settings->result() as $setting){
                $data = (array) json_decode($setting->data);
            }
        }

        if(!isset($data[$setting_name])){
            return '';
        }

        return $data[$setting_name];
	}
}