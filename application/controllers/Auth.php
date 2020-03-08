<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
		parent::__construct();
    }

    private function session_check()
    {
        if (isset($_SESSION['Admin_ID'])) {
            redirect('admin/orders');
        } elseif (isset($_SESSION['User_ID'])) {
            redirect('order');
        }
    }

    public function login_view()
    {
		$this->session_check();
        $context = [
            'title' => 'Login',
        ];
        $this->load->view('auth/login', $context);
    }

    public function signup_view()
    {
		$this->session_check();
        $context = [
            'title' => 'Sign Up',
        ];
        $this->load->view('auth/signup', $context);
	}

	function _validation($email) {
        $query = $this->Auth_model->email_validation($email);
        if ($query['user'] === 'none') {
            return 'none';
        } else {
            return 'exist';
        }
    }

    /**
     * Creating User account
     */

    public function create_account()
    {
        if ($this->input->post() == null || isset($_SESSION['User_ID'])) {
			echo json_encode(array('success' => false, 'msg' => 'empty'));
            return;
        }

        $token = $this->input->post('csrf_token');
        if (!csrf_token_is_valid($token)) {
            echo json_encode(array('success' => false, 'msg' => 't_error'));
            return;
        }
        $new_token = create_csrf_token();
        $email = $this->db->escape_str(strtolower(trim($this->input->post('email'))));
        $first_name = $this->db->escape_str(ucwords(strtolower(trim($this->input->post('first_name')))));
        $last_name = $this->db->escape_str(ucwords(strtolower(trim($this->input->post('last_name')))));
        $validate = $this->_validation($email);
        $result = array('success' => false);
        if ($validate === 'none') {
            $query = $this->Auth_model->create_user(array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
            ), 'users');
            if ($query) {
				$result['msg'] = 'registered';
				$result['success'] = true;
            }
        } elseif ($validate === 'exist') {
            $result['msg'] = 'exist';
            $result['token'] = $new_token;
        }
        echo json_encode($result);
	}

	public function user_login() { //checking credentials
        if($this->input->post() == null || isset($_SESSION['User_ID'])) {
			echo json_encode(array('success' => false, 'msg' => 'empty'));
            return;
		}

        $token = $this->input->post('csrf_token');
        if(!csrf_token_is_valid($token)){
            echo json_encode(array('success' => false, 'msg' => 't_error'));
            return;
        }

        // if the users credentials is validated. continue
		$email = $this->db->escape_str(strtolower($this->input->post('email')));
		$query2 = $this->db->query("SELECT * FROM users WHERE email = '$email' ");
		$good_to_go = false;
		foreach ($query2->result_array() as $row) {
			$pw = $this->input->post('password');
			if(password_verify($pw, $row['password'])){
				$good_to_go = true;
				$this->session->set_userdata([
					'loggedIn' => true,
					'User_ID' => (int) $row['id'],
					'first_name' => $row['first_name']
				]);
			}
		}

		$results = array('success' => true);
		if(!$good_to_go){
			$results['success'] = false;
			$results['msg'] = 'incorrect';
		}

        echo json_encode($results);
	}

	public function signout(){
        $admin = (isset($_SESSION['Admin_ID'])) ? true : false;
		session_unset();
        $this->session->sess_destroy();

        if($admin){
            redirect('admin/login', 'refresh');
        }else{
            redirect('login', 'refresh');
        }
	}

}
