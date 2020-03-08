<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

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

	public function menu(){
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
            'userType' => 'user',
            'data' => $week,
            'dataCount' => $menu->num_rows(),
        ];
		$this->load->view('menu', $context);
	}

	public function order_view()
	{
		$result = [];
		$orders = $this->User_model->data_select('orders', ['user_id' => $_SESSION['User_ID'], 'order_status' => 'pending']);
		if(sizeof($orders) != 0){
			foreach($orders as $order){
				$getMenu = $this->User_model->data_select('menu', ['id' => (int) $order->menu_id]);
				if(sizeof($getMenu) == 0) continue;

				$description = '';
				$price = '';
				$title = '';
				foreach($getMenu as $gM){
					$description = $gM->description;
					$price = $gM->price;
					$title = $gM->title;
				}

				$result = [
					'order_id' => $order->id,
					'description' => $description,
					'price' => $price,
					'title' => $title,
					'date_ordered' => date_time_format($order->date_created)
				];
			}
		}
		$context = [
			'title' => 'Current Order',
			'data' => $result
		];
		$this->load->view('user/order', $context);
	}

	public function order_history_view(){
		$result = [];
		$user_id = $_SESSION['User_ID'];
		$orders = $this->db->query("SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY date_created DESC");
		if($orders->num_rows() != 0){
			foreach($orders->result() as $order){
				$getMenu = $this->User_model->data_select('menu', ['id' => (int) $order->menu_id]);
				if(sizeof($getMenu) == 0) continue;

				$price = '';
				$title = '';
				foreach($getMenu as $gM){
					$price = $gM->price;
					$title = $gM->title;
				}

				$result[] = [
					'order_id' => $order->id,
					'price' => $price,
					'title' => $title,
					'date_ordered' => date_time_format($order->date_created)
				];
			}
		}
		$context = [
			'title' => 'Order History',
			'data' => $result
		];
		$this->load->view('user/order_history', $context);
	}

    public function billing_view(){

		$billing_result = [];
		$user_id = $_SESSION["User_ID"];
        $billing = $this->db->query("SELECT * FROM billing WHERE user_id = '$user_id' ORDER BY date_created DESC");
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

		$context = [
			'title' => 'Billing',
			'data' => $billing_result
		];
		$this->load->view('user/billing', $context);
	}

}
