<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->session_check();
    }

    private function session_check()
    {
        if (!isset($_SESSION['Admin_ID'])) {
            redirect('admin/login');
        }
    }

    public function save(){
        $results = ['success' => true];
        if ($this->input->post() == null) {
            $results['success'] = false;
            $results['msg'] = 'empty';
        }

        $token = $this->input->post('csrf_token');
        if (!csrf_token_is_valid($token)) {
            $results['success'] = false;
            $results['msg'] = 't_error';
        }

        $results['token'] = create_csrf_token();
        if(!$results['success']){
            echo json_encode($results);
            return;
        }

        $start_time = (!is_null($this->input->post('start_time'))) ? $this->input->post('start_time') : '';
        $closing_time = (!is_null($this->input->post('closing_time'))) ? $this->input->post('closing_time') : '';
        $price = (!is_null($this->input->post('price'))) ? $this->input->post('price') : 50;

        $setting_id = 0;

        $check_settings = $this->db->query("SELECT * FROM settings");
        if($check_settings->num_rows() != 0){
            foreach($check_settings->result() as $check_setting){
                $setting_id = (int) $check_setting->id;
            }
        }

        if($start_time == ''){
            $closing_time = '';
        }else if($closing_time == ''){
            $start_time = '';
        }

        $data = [
            'data' => json_encode([
                'price' => $price,
                'time' => [
                    'start' => $start_time,
                    'closing' => $closing_time
                ]
            ])
        ];

        if($setting_id == 0){
            $query = $this->User_model->data_submit('settings', $data);
        }else{
            $query = $this->User_model->data_update('settings', $data, ['id' => $setting_id]);
        }

        $results = ['success' => false];
        if($query){
            $results['success'] = true;
        }

        echo json_encode($results);
    }

}