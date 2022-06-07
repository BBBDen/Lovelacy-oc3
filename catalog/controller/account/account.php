<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountAccount extends Controller {
    const SUBSCRIBER_CUSTOMER_GROUP_ID = 2;
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}
        $data['status'] = '';
        if (array_key_exists('token', $this->request->get)) {
            $this->load->model('account/customer');
            if (array_key_exists('status', $this->request->get) && $this->request->get['status'] === 'successful') {
                $this->document->addScript('/catalog/view/javascript/lovelace/bepay.js');
            }
            $result = json_decode($this->curlHandler('https://checkout.bepaid.by/ctp/api/checkouts/' . $this->request->get['token'], [], 'GET', ['auth_data' => self::AUTH_DATA]), true);
            $this->model_account_customer->updateCustomerSubscribeInfo($this->customer->getId(), $result['checkout']['status']);
            $data['status'] = $result['checkout']['status'];
        }
        $data['subscribe_link'] = $this->url->link('information/information', 'information_id=14');

		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setRobots('noindex,follow');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 
		
		$data['edit'] = $this->url->link('account/edit', '', true);
		$data['password'] = $this->url->link('account/password', '', true);
		$data['address'] = $this->url->link('account/address', '', true);
        $data['text_back_button'] = sprintf($this->language->get('text_back_button'), (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/');
		
		$data['credit_cards'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/extension/credit_card/*.php');
		
		foreach ($files as $file) {
			$code = basename($file, '.php');
			
			if ($this->config->get('payment_' . $code . '_status') && $this->config->get('payment_' . $code . '_card')) {
				$this->load->language('extension/credit_card/' . $code, 'extension');

				$data['credit_cards'][] = array(
					'name' => $this->language->get('extension')->get('heading_title'),
					'href' => $this->url->link('extension/credit_card/' . $code, '', true)
				);
			}
		}

        $this->load->model('localisation/country');
        $data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
        $data['customer_status'] = '';
        $data['text_policy'] = sprintf($this->language->get('text_policy'), $this->url->link('information/information', 'information_id=3', true), $this->url->link('information/information', 'information_id=7', true));
        $data['user_pay_status'] = '';

        if ( $customer_info ) {
            $data['customer_id'] = $customer_info['customer_id'];
            $_user_data_ = $this->model_account_customer->getCustomerInfo($customer_info['customer_id']);

//            if ($_user_data_) {
//                $data['user_pay_status'] = $_user_data_['pay_status'];
//                if ($data['user_pay_status'] == 'successful') {
//                    $curl = curl_init();
//
//                    curl_setopt_array($curl, array(
//                        CURLOPT_URL => 'https://lovelaceby.retailcrm.ru/api/v5/customers/'.$customer_info['customer_id'].'/edit?by=externalId&apiKey=qPiqTmCrdsGldH5K9U5DUWVj3t4mKPDH&site=lovelaceby',
//                        CURLOPT_RETURNTRANSFER => true,
//                        CURLOPT_ENCODING => '',
//                        CURLOPT_MAXREDIRS => 10,
//                        CURLOPT_TIMEOUT => 0,
//                        CURLOPT_FOLLOWLOCATION => true,
//                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                        CURLOPT_CUSTOMREQUEST => 'POST',
//                        CURLOPT_POSTFIELDS => array('customer' => '  {
//                        "customFields":{
//                        "subscribe":true}}
//                         '),
//                    ));
//
//                    $response = curl_exec($curl);
//
//                    curl_close($curl);
//
//                }
//                $data['customer_status'] = $_user_data_['pay_status'];
//                $user_data = isset($_user_data_['user_data']) ? unserialize($_user_data_['user_data']) : [];
//                $data['chest'] = isset($user_data['chest']) ? $user_data['chest'] : '';
//                $data['under_chest'] = isset($user_data['under_chest']) ? $user_data['under_chest'] : '';
//                $data['hips'] = isset($user_data['hips']) ? $user_data['hips'] : '';
//                $data['chockers'] = isset($user_data['chockers']) ? $user_data['chockers'] : '';
//                $data['streps'] = isset($user_data['streps']) ? $user_data['streps'] : '';
//                $data['material'] = isset($user_data['material']) ? $user_data['material'] : '';
//                $data['color'] = isset($user_data['color']) ? $user_data['color'] : '';
//                $data['notToAdd'] = isset($user_data['notToAdd']) ? $user_data['notToAdd'] : '';
//                $data['requests'] = isset($user_data['requests']) ? $user_data['requests'] : '';
//                $data['braSize'] = isset($user_data['braSize']) ? $user_data['braSize'] : '';
//                $data['braSizeOur'] = isset($user_data['braSizeOur']) ? $user_data['braSizeOur'] : '';
//            }
        } else {
            $data['customer_id'] = 0;
            $data['chest'] = '';
            $data['under_chest'] = '';
            $data['hips'] = '';
            $data['chockers'] = '';
            $data['streps'] = '';
            $data['material'] = '';
            $data['color'] = '';
            $data['notToAdd'] = '';
            $data['requests'] = '';
            $data['braSize'] = '';
            $data['braSizeOur'] = '';
        }

        $data['name'] = $customer_info['firstname'];
        $data['email'] = $customer_info['email'];
        $data['phone'] = $customer_info['telephone'];
        $data['newsletter_checkbox'] = (int)$customer_info['newsletter'] ? 'checked' : '';
        $data['birthday'] = date('d.m.Y', strtotime($customer_info['birthday']));
        $data['country'] = $customer_info['country'];
        $data['country_id'] = $customer_info['country_id'];
        $data['city'] = $customer_info['city'];
        $data['zone_id'] = $customer_info['zone_id'];
        $data['street'] = $customer_info['street'];
        $data['house'] = $customer_info['house'];
        $data['building'] = $customer_info['building'];
        $data['flat'] = $customer_info['flat'];
        $data['social_nick'] = $customer_info['social_nick'] ? $customer_info['social_nick'] : '';

		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		
		if ($this->config->get('total_reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', true);
		} else {
			$data['reward'] = '';
		}		
		
		$data['return'] = $this->url->link('account/return', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['recurring'] = $this->url->link('account/recurring', '', true);
		
		$this->load->model('account/customer');
		
		$affiliate_info = $this->model_account_customer->getAffiliate($this->customer->getId());
		
		if (!$affiliate_info) {	
			$data['affiliate'] = $this->url->link('account/affiliate/add', '', true);
		} else {
			$data['affiliate'] = $this->url->link('account/affiliate/edit', '', true);
		}
		
		if ($affiliate_info) {		
			$data['tracking'] = $this->url->link('account/tracking', '', true);
		} else {
			$data['tracking'] = '';
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view('account/account', $data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function subscribe()
    {
        $this->load->language('account/account');
        $this->load->model('account/customer');
        $json = [];
        if (isset($this->request->post['subscriber'])) {
            $subscriber = $this->request->post['subscriber'];
            $data = [
                'customer_group_id' => self::SUBSCRIBER_CUSTOMER_GROUP_ID,
                'language_id' => $this->request->post['language'],
                'firstname' => 'subscriber',
                'lastname' => 'subscriber',
                'email' => $subscriber,
                'telephone' => '',
                'newsletter' => '1',
                'password' => 'subscriber'
            ];

            if (!preg_match('/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/', $subscriber)) {
                $json['error'] = $this->language->get('text_error_email');
            } else if ($this->model_account_customer->checkSubscriber($data)) {
                $json['error'] = $this->language->get('text_subscriber_error_exist');
            }

            if (!$json) {
                $result = $this->model_account_customer->addCustomer($data);

                if ($result) {
                    $json['success'] = true;
                    $json['answer'] = $this->language->get('text_subscriber_success');

                }
            }
        } else {
            $json['error'] = $this->language->get('text_error_email_empty');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function editPersonal()
    {
        $json = [];

        $language = new language($this->request->post['language']);
        $language->load($this->request->post['language']);
        $language->load('account/account');
        $language->load('account/register');

        if ((utf8_strlen(trim($this->request->post['name'])) < 1) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
            $json['errors']['name'] = $language->get('error_firstname');
        }

        if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $json['errors']['email'] = $language->get('error_email');
        }

        if ((utf8_strlen(trim($this->request->post['social_nick'])) < 1) || (utf8_strlen(trim($this->request->post['social_nick'])) > 32)) {
            $json['errors']['social_nick'] = $language->get('error_social_nick');
        }

        if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32)) {
            $json['errors']['phone'] = $language->get('error_telephone');
        }

        if (empty($json)) {
            $this->load->model('account/customer');

            $data = $this->request->post;
            $params = [
                'customer_group_id' => (isset($data['newsletter']) && $data['newsletter'] === 'on') ? '2' : '1',
                'firstname' => $data['name'],
                'lastname' => '',
                'email' => $data['email'],
                'social_nick' => $data['social_nick'],
                'telephone' => str_replace($this->__get_deprecated_symbols__(), '', $data['phone']),
                'birthday' => $data['birthday'],
                'newsletter' => (isset($data['newsletter']) && $data['newsletter'] === 'on') ? '1' : '0'
            ];

            $this->model_account_customer->editCustomer($this->customer->getId(), $params);
            $json['success'] = $language->get('success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function editAddress()
    {
        $json = [];

        $language = new language($this->request->post['language']);
        $language->load($this->request->post['language']);
        $language->load('account/account');
        $language->load('account/register');

        if ((utf8_strlen(trim($this->request->post['country'])) <= 0)) {
            $json['errors']['country'] = $language->get('error_country');
        }

        if ((utf8_strlen(trim($this->request->post['city'])) <= 0)) {
            $json['errors']['city'] = $language->get('error_city');
        }

        if ((utf8_strlen(trim($this->request->post['street'])) < 2) || (utf8_strlen(trim($this->request->post['street'])) > 255)) {
            $json['errors']['street'] = sprintf($language->get('error_custom_field'), $language->get('entry_street'));
        }

        if ((utf8_strlen(trim($this->request->post['house'])) < 1) || (utf8_strlen(trim($this->request->post['house'])) > 255)) {
            $json['errors']['house'] = sprintf($language->get('error_custom_field'), $language->get('entry_house'));
        }

        if (empty($json)) {
            $this->load->model('account/customer');

            $data = $this->request->post;

            $params = [
                'country' => $data['country'],
                'city' => $data['city'],
                'street' => $data['street'],
                'house' => (isset($data['house']) && $data['house']) ? $data['house'] : '',
                'building' => (isset($data['building']) && $data['building']) ? $data['building'] : '',
                'flat' => (isset($data['flat']) && $data['flat']) ? $data['flat'] : '',
            ];

            $this->model_account_customer->editAddress($this->customer->getId(), $params);
            $json['success'] = $language->get('success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function editPassword()
    {
        $json = [];

        $language = new language($this->request->post['language']);
        $language->load($this->request->post['language']);
        $language->load('account/account');
        $language->load('account/register');

        if ((utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
            $json['errors']['password'] = $language->get('error_password');
        }

        if ($this->request->post['confirm'] !== $this->request->post['password']) {
            $json['errors']['confirm'] = $language->get('error_confirm');
        }

        if (empty($json)) {
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($this->customer->getId());

            $this->model_account_customer->editPassword($customer['email'], $this->request->post['password']);

            $json['success'] = $language->get('success');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function userInfo()
    {
        $language = new language($this->request->get['language']);
        $language->load($this->request->get['language']);
        $language->load('account/account');

        $this->load->model('account/customer');
        $validation_errors = $this->validateUserInfo($this->request->post);
        if (!empty($validation_errors)) {
            $errors_array = [];
            foreach ($validation_errors as $error_key => $validation_error) {
                $errors_array[$error_key] = $language->get($validation_error);
            }
            $answer = $errors_array;
            $success = false;
        } else {
            $params = [
                'customer_id' => $this->request->get['customer_id'],
                'user_data' => serialize($this->request->post)
            ];
            $this->model_account_customer->saveInfo($params);
            $answer = $language->get('text_answer');
            $success = true;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode(['success' => $success, 'answer' => $answer, 'redirect' => $this->url->link('account/account')]));
    }

    public function validateUserInfo($post) {
        $errors = [];
        if (mb_strlen($post['chest']) === 0) {
            $errors['chest'] = 'chest_text_error';
        }

        if (mb_strlen($post['under_chest']) === 0) {
            $errors['under_chest'] = 'under_chest_text_error';
        }

        if (mb_strlen($post['hips']) === 0) {
            $errors['hips'] = 'hips_text_error';
        }

        if (mb_strlen($post['braSize']) === 0) {
            $errors['braSize'] = 'bra_size_text_error';
        }

        if (!array_key_exists('chockers', $post)) {
            $errors['chockers'] = 'chockers_text_error';
        }

        if (!array_key_exists('streps', $post)) {
            $errors['streps'] = 'streps_text_error';
        }
        if (!array_key_exists('material', $post)) {
            $errors['material'] = 'material_text_error';
        }

        if (!array_key_exists('color', $post)) {
            $errors['color'] = 'color_text_error';
        }

        if (mb_strlen($post['notToAdd']) === 0) {
            $errors['notToAdd'] = 'not_to_add_text_error';
        }
        if (mb_strlen($post['requests']) === 0) {
            $errors['requests'] = 'requests_text_error';
        }
        return $errors;
    }

    public function unSubscribe()
    {
        $json = [];
        $language = new language($this->request->get['language']);
        $language->load($this->request->get['language']);
        $language->load('account/account');

        $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomerSubscribeId($this->request->get['customer_id']);
        if ($customer_info) {
            $sbs_info = json_decode($this->curlHandler('https://api.bepaid.by/subscriptions/' . $customer_info['bepayed_sbs_id'], [], 'GET', [
                'auth_data' => self::AUTH_DATA
            ]), true);
            if (array_key_exists('message', $sbs_info)) {
                $json = [
                    'success' => false,
                    'answer' => $language->get('text_not_subscribe')
                ];
            } else {
                $unsbs = json_decode($this->curlHandler("https://api.bepaid.by/subscriptions/{$customer_info['bepayed_sbs_id']}/cancel", [], 'POST', [
                    'auth_data' => self::AUTH_DATA,
                    'cancel_reason' => "Customer's request"
                ]), true);
                $this->model_account_customer->updateCustomerSubscribeInfo($this->request->get['customer_id'], $unsbs['state'] ? $unsbs['state'] : 'canceled');
                $json = ['success' => true];
//                $curl = curl_init();
//                curl_setopt_array($curl, array(
//                    CURLOPT_URL => 'https://lovelaceby.retailcrm.ru/api/v5/customers/'.$customer_info['customer_id'].'/edit?by=externalId&apiKey=qPiqTmCrdsGldH5K9U5DUWVj3t4mKPDH&site=lovelaceby',
//                    CURLOPT_RETURNTRANSFER => true,
//                    CURLOPT_ENCODING => '',
//                    CURLOPT_MAXREDIRS => 10,
//                    CURLOPT_TIMEOUT => 0,
//                    CURLOPT_FOLLOWLOCATION => true,
//                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                    CURLOPT_CUSTOMREQUEST => 'POST',
//                    CURLOPT_POSTFIELDS => array('customer' => '  {
//                        "customFields":{
//                        "subscribe":false}}
//                         '),
//                ));
//                $response = curl_exec($curl);
//                curl_close($curl);
            }
        } else {
            $json = [
                'success' => false,
                'answer' => $language->get('text_not_subscribe')
            ];
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode(['success' => true, 'answer' => $json]));
    }
}
