<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setRobots('noindex,follow');

		$this->load->model('account/customer');

        $token = array_key_exists('token', $this->request->get) ? $this->request->get['token'] : '';
        if ($token) {
            $data['issetToken'] = true;
        } else {
            $data['issetToken'] = false;
        }
        $data['token'] = $token;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_forgotten'),
			'href' => $this->url->link('account/forgotten', '', true)
		);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('account/forgotten', '', true);

		$data['back'] = $this->url->link('account/login', '', true);

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/forgotten', $data));
	}

	public function reset() {
        $this->load->language('account/forgotten');
        $this->load->model('account/customer');
        $post = $this->request->post;
        $json = [];

        if (mb_strlen($post['password']) === 0) {
            $json['success'] = false;
            $json['errors']['password'] = $this->language->get('error_password_empty');
        } else if (mb_strlen($post['password']) < 5) {
            $json['success'] = false;
	        $json['errors']['password'] = $this->language->get('error_password');
        } else if ($post['password'] !== $post['password_confirmation']) {
            $json['success'] = false;
            $json['errors']['password'] = $this->language->get('error_password_confirmation');
        } else {
            $customer = $this->model_account_customer->getCustomerByTokenId( $this->request->post['token'] );
            if ($customer) {
                $this->model_account_customer->editPasswordAndResetToken($customer['email'], $post['password']);
                $this->model_account_customer->deleteLoginAttempts($customer['email']);
                $this->customer->login($customer['email'], $post['password']);
                unset($this->session->data['guest']);
                $json['success'] = true;
                $json['text'] = $this->language->get('text_password_success');
                $json['button_text'] = $this->language->get('text_go_to_account');
                $json['redirect_link'] = $this->url->link('account/account');
                $json['redirect'] = $this->url->link('account/account');
            } else {
                $json['success'] = false;
                $json['errors']['password'] = $this->language->get('error_customer');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	protected function validate() {
		if (!isset($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		}
		
		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['status']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		return !$this->error;
	}

	public function validation($email = null)
    {
        $this->load->model('account/customer');
        if (!$email) {
            $this->error['warning'] = 'error_email';
        } else if (!$this->model_account_customer->getTotalCustomersByEmail($email)) {
            $this->error['warning'] = 'error_email';
        }

        $customer_info = $this->model_account_customer->getCustomerByEmail($email);

        if ($customer_info && !$customer_info['status']) {
            $this->error['warning'] = 'error_approved';
        }
        return $this->error;
    }

	public function forgotten()
    {
        $json = [];

        $language = new language($this->request->post['language_code']);
        $language->load($this->request->post['language_code']);
        $language->load('account/forgotten');

        $validation = $this->validation($this->request->post['email']);

        if (!empty($validation)) {
            $json['error'] = $language->get($validation['warning']);
        } else {

            $this->load->model('account/customer');

            $this->customer->logout();
            $this->cart->clear();

            unset($this->session->data['order_id']);
            unset($this->session->data['payment_address']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['shipping_address']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['comment']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);

            $token = token(40);

            $this->model_account_customer->editCode($this->request->post['email'], $token);

            $json['success'] = $language->get('text_success');

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
