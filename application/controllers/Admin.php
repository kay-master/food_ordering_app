<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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

    public function admin_orders_view()
    {
        $context = [
            'title' => 'Admin Orders'
        ];
        $this->load->view('admin/admin_orders', $context);
    }

    public function get_admin_orders(){
        $type = strtolower(trim($this->input->get('option')));
        $sort = strtolower(trim($this->input->get('sort')));

        $sort_order = 'DESC';
        if($sort == 'old'){
            $sort_order = 'ASC';
        }

        $order_result = [];
        $orders = $this->db->query("SELECT * FROM orders ORDER BY date_created $sort_order");
        if($orders->num_rows() != 0){
            foreach($orders->result() as $order){
                $menu = $this->getMenu((int)$order->menu_id, $type);
                if(empty($menu)) continue;

                $order_result[] = [
                    'id' => $order->id,
                    'user' => $this->getUser((int)$order->user_id),
                    'menu' => $menu,
                    'date_ordered' => date_time_format($order->date_created, true, true, true)
                ];
            }
        }

        echo json_encode($order_result);
    }

    private function getUser($id){
        $user = $this->User_model->data_select('users', ['id' => $id]);
        $data = [];
        if(sizeof($user) != 0){
            foreach($user as $this_user){
                $data = [
                    'id' => $id,
                    'name' => $this_user->first_name .' '.$this_user->last_name
                ];
            }
        }
        return $data;
    }

    private function getMenu($id, $type = ''){
        $menu = $this->User_model->data_select('menu', ['id' => $id]);
        $data = [];
        if(sizeof($menu) != 0){
            foreach($menu as $this_menu){
                $add = false;
                if($type == ''){
                    $add = true;
                }else if(strtolower(trim($this_menu->menu_type)) == $type){
                    $add = true;
                }

                if(!$add) continue;

                $data = [
                    'id' => $id,
                    'name' => $this_menu->title,
                    'price' => $this_menu->price,
                    'type' => $this_menu->menu_type
                ];
            }
        }
        return $data;
    }

    public function remove_admin_orders(){
        $order = (int) $this->input->post('order');
        $remove_order = $this->User_model->data_delete('orders', ['id'=> $order]);
        $result = ['success' => false];
        if($remove_order){
            $result['success'] = true;
        }
        echo json_encode($result);
    }

    public function create_menu_view()
    {
        $context = [
			'title' => 'Create Menu',
			'action' => 'create'
        ];
        $this->load->view('admin/create_menu', $context);
	}

	public function edit_menu_view()
    {
		$menu_id = (int)$this->uri->segment(3);
		$input_data = [];
		if($menu_id != 0){
			$menu_details = $this->User_model->data_select('menu', ['id' => $menu_id]);
			foreach($menu_details as $menu_detail){
				$input_data = [
					'id' => $menu_id,
					'title' => $menu_detail->title,
					'menu_type' => $menu_detail->menu_type,
					'description' => $menu_detail->description,
					'price' => $menu_detail->price,
					'day' => $menu_detail->day_of_menu
				];
			}
		}
        $context = [
			'title' => 'Edit Menu',
			'data' => $input_data,
			'action' => 'edit'
        ];
        $this->load->view('admin/create_menu', $context);
	}

	public function add_user_view(){
		$menu_id = (int)$this->uri->segment(3);
		$input_data = [];
		if($menu_id != 0){
			$menu_details = $this->User_model->data_select('menu', ['id' => $menu_id]);
			foreach($menu_details as $menu_detail){
				$input_data = [
					'id' => $menu_id,
					'title' => $menu_detail->title,
					'menu_type' => $menu_detail->menu_type,
					'price' => $menu_detail->price,
					'day' => $menu_detail->day_of_menu
				];
			}
		}
		$context = [
			'title' => 'Add User To Menu',
			'data' => $input_data
        ];
        $this->load->view('admin/add_user_menu', $context);
	}

    public function menu_view()
    {

        $week = ['monday' => [], 'tuesday' => [], 'wednesday' => [], 'thursday' => [], 'friday' => []];
        $weekFunc = function ($data) {
            return [
                'id' => $data->id,
                'title' => $data->title,
                'image' => $data->image,
                'menu_type' => $data->menu_type,
                'price' => $data->price,
            ];
        };

        $menu = $this->db->query("SELECT * FROM menu");
        foreach ($menu->result() as $info) {
            $week[strtolower(trim($info->day_of_menu))][] = $weekFunc($info);
        }

        $context = [
            'title' => 'Weekly Menu',
            'userType' => 'admin',
            'data' => $week,
            'dataCount' => $menu->num_rows(),
        ];
        $this->load->view('menu', $context);
    }

    public function admin_billing_view()
    {
        $context = [
            'title' => 'Billing',
        ];
        $this->load->view('admin/admin_billing', $context);
    }

    public function get_admin_bills(){
        $order_by = strtolower(trim($this->input->get('order_by')));
        $sort = strtolower(trim($this->input->get('sort')));

        $sort_order = 'DESC';
        if($sort == 'old'){
            $sort_order = 'ASC';
        }

        $billing_result = [];
        $billing = $this->db->query("SELECT * FROM billing ORDER BY date_created $sort_order");
        if($billing->num_rows() != 0){
            foreach($billing->result() as $bill){
                $billing_result[] = [
                    'id' => $bill->id,
                    'item' => $bill->item,
                    'price' => $bill->price,
                    'date_billed' => date_time_format($bill->date_created, true, true, true)
                ];
            }
        }

        echo json_encode($billing_result);
    }

    public function admin_settings_view()
    {
        $data = [];
        $settings = $this->db->query("SELECT * FROM settings");
        if($settings->num_rows() != 0){
            foreach($settings->result() as $setting){
                $data = (array) json_decode($setting->data);
            }
        }
        $context = [
            'title' => 'Settings',
            'data' => $data
        ];
        $this->load->view('admin/admin_settings', $context);
    }
}
