<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->session_check();
    }

    private function session_check()
    {
        if (!isset($_SESSION['User_ID'])) {
            redirect('login');
        }
    }

    public function order_menu()
    {
        $results = ['success' => true];
        if ($this->input->post() == null) {
            $results['success'] = false;
            $results['msg'] = 'empty';
        }

        $user = $_SESSION['User_ID'];
        $menu_id = (!is_null($this->input->post('menu_id'))) ? (int) $this->input->post('menu_id') : 0;

        $query = $this->User_model->data_submit('orders', [
            'user_id' => $user,
            'menu_id' => $menu_id,
        ]);
        if ($query) {
            add_bill([
                'user_id' => $user,
                'menu_id' => $menu_id,
            ]);
        } else {
            $results['success'] = false;
            $results['msg'] = '';
        }

        echo json_encode($results);
    }

    public function cancel_order()
    {
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
        if (!$results['success']) {
            echo json_encode($results);
            return;
        }

        $reason = trim($this->input->post('cancel-reason'));
        $order = (int) $this->input->post('order');

        $updateOrder = $this->User_model->data_update('orders', ['order_status' => 'canceled', 'cancel_reason' => $reason], ['id' => $order]);
        if ($updateOrder) {
            $results['success'] = true;
            $results['msg'] = '';
        } else {
            $results['success'] = false;
            $results['msg'] = '';
        }

        echo json_encode($results);
    }
}
