<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

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

    public function create_menu()
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
        if(!$results['success']){
            echo json_encode($results);
            return;
        }

        $menu_name = $this->db->escape_str(trim($this->input->post('menu_name')));
        $day_of_menu = $this->db->escape_str(trim($this->input->post('day_of_menu')));
        $menu_type = $this->db->escape_str(trim($this->input->post('menu_type')));
        $price = get_settings('price');
        $description = $this->db->escape_str(trim($this->input->post('description')));

        $result = array('success' => false);
        $query = $this->User_model->data_submit('menu', [
            'title' => $menu_name,
            'day_of_menu' => $day_of_menu,
            'menu_type' => $menu_type,
            'description' => $description,
            'price' => $price
        ]);
        if ($query) {
            $result['success'] = true;
            $results['msg'] = '';
        }
        echo json_encode($result);
    }

    public function edit_menu()
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
        if(!$results['success']){
            echo json_encode($results);
            return;
        }

        $menu_id = (int) trim($this->input->post('menu_id'));
        $menu_name = $this->db->escape_str(trim($this->input->post('menu_name')));
        $day_of_menu = $this->db->escape_str(trim($this->input->post('day_of_menu')));
        $menu_type = $this->db->escape_str(trim($this->input->post('menu_type')));
        $price = $this->db->escape_str(trim($this->input->post('price')));
        $description = $this->db->escape_str(trim($this->input->post('description')));

        $result = array('success' => false);
        $query = $this->User_model->update_entry('menu', [
            'title' => $menu_name,
            'day_of_menu' => $day_of_menu,
            'menu_type' => $menu_type,
            'description' => $description,
            'price' => $price
        ], ['id' => $menu_id]);
        if ($query) {
            $result['success'] = true;
            $results['msg'] = '';
        }
        echo json_encode($result);
    }

    public function add_user_menu()
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
        if(!$results['success']){
            echo json_encode($results);
            return;
        }

        $users = (!is_null($this->input->post('users'))) ? (array) $this->input->post('users') : [];
        $user = (!is_null($this->input->post('user'))) ? (int) $this->input->post('user') : 0;
        $menu_id = (!is_null($this->input->post('menu_id'))) ? (int) $this->input->post('menu_id') : 0;

        if(!empty($users) && $user == 0){
            foreach($users as $adduser){
                $query = $this->User_model->data_submit('orders', [
                    'user_id' => $adduser,
                    'menu_id' => $menu_id
                ]);
                if($query){
                    add_bill([
                        'user_id' => $adduser,
                        'menu_id' => $menu_id
                    ]);
                }
            }
        }elseif(empty($users) && $user != 0){
            $query = $this->User_model->data_submit('orders', [
                'user_id' => $user,
                'menu_id' => $menu_id
            ]);
            if($query){
                add_bill([
                    'user_id' => $user,
                    'menu_id' => $menu_id
                ]);
            }
        }else{
            $results['success'] = false;
            $results['msg'] = '';
        }

        echo json_encode($results);
    }

    public function find_users()
    {
        $_results['users'] = [];

        $q = $this->input->get('search');
        $menu_id = (!is_null($this->input->get('menu_id'))) ? (int) $this->input->get('menu_id') : 0;
        if(is_null($q)){
            echo json_encode($_results);
            return;
        }

        $each_words = explode(' ', $q);
        $x = 0;
        $construct = "";
        if ($this->input->get('type') === 'private') {
            foreach ($each_words as $each_word) {
                $x++;
                if ($x == 1) {
                    $construct .= "concat(first_name, ' ', last_name) LIKE '%" . $this->db->escape_like_str(trim($each_word)) . "%' ESCAPE '!'";
                } else {
                    $construct .= "AND concat(first_name, ' ', last_name) LIKE '%" . $this->db->escape_like_str(trim($each_word)) . "%' ESCAPE '!'";
                }
            }
        }

        $all = $this->db->query("SELECT concat(first_name, ' ', last_name) AS name, id FROM users WHERE $construct");

        $checkOrders = function($user, $menu){

            $check = $this->User_model->data_select('orders', [
                'user_id' => $user,
                'menu_id' => $menu
            ]);

            if(sizeof($check) == 0){
                return false;
            }

            return true;

        };

        if ($all->num_rows() !== 0) {
            foreach ($all->result() as $user) {
                $_results['users'][] = (object) array(
                    'id' => $user->id,
                    'text' => $user->name,
                    'name' => $user->name,
                    'on_order' => $checkOrders($user->id, $menu_id)
                );
            }
        }
        echo json_encode($_results);
    }

}