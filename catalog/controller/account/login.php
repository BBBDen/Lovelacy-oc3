<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');
		$this->load->model('account/api');

		// Login override for admin users
		if (!empty($this->request->get['token'])) {
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

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->response->redirect($this->url->link('account/account', '', true));
			}
		}

		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/login');

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

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('account/login', '', true)
		);

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        $api_info = $this->model_account_api->getApi($this->config->get('config_api_sms_id'));

        if ($api_info) {
            $session = new Session($this->config->get('session_engine'), $this->registry);

            $session->start();

            $this->model_account_api->deleteApiSessionBySessionId($session->getId());

            $this->model_account_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);

            $session->data['api_id'] = $api_info['api_id'];

            $data['api_token'] = $session->getId();
        } else {
            $data['api_token'] = '';
        }

		$data['login_way'] = $this->config->get('config_login_way');

		$data['text_title'] = $this->language->get('text_title');
		$data['text_back_button'] = sprintf($this->language->get('text_back_button'), (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/');

		$data['action'] = $this->url->link('account/login', '', true);
		$data['action_auth'] = $this->url->link('account/login/authorization', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);

		// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/login', $data));
	}

	protected function validate($email = null, $phone = null, $password = null) {
	    if (isset($this->request->post['email'])) {
	        $email = $this->request->post['email'];
        }

        if (isset($this->request->post['phone'])) {
            $phone = str_replace($this->__get_deprecated_symbols__(), '', $this->request->post['phone']);
        }

        $config_login_way = $this->config->get('config_login_way');

	    if (isset($this->request->post['password'])) {
	        $password = $this->request->post['password'];
        }
        $this->load->model('account/customer');
        // Check how many login attempts have been made.
        if ($config_login_way && $config_login_way === 'phone') {

            $login_info = $this->model_account_customer->getLoginAttemptsByPhone($phone);
        } else {

            $login_info = $this->model_account_customer->getLoginAttempts($email);
        }

        if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->error['warning'] = $this->language->get('error_attempts');
        }

        // Check if customer has been approved.
        if ($config_login_way && $config_login_way === 'phone') {
            $customer_info = $this->model_account_customer->getCustomerByPhone($phone);
        } else {
            $customer_info = $this->model_account_customer->getCustomerByEmail($email);
        }

        if ($customer_info && !$customer_info['status']) {
            $this->error['warning'] = $this->language->get('error_approved');
        }

        if (!$this->error) {
            if (!$this->customer->login($email, $password, $phone)) {

                if ($config_login_way && $config_login_way === 'phone') {
                    $this->error['warning'] = $this->language->get('error_login2');
                    $this->model_account_customer->addLoginAttemptPhone($phone);
                } else {
                    $this->error['warning'] = $this->language->get('error_login');
                    $this->model_account_customer->addLoginAttempt($email);
                }
            } else {
                if ($config_login_way && $config_login_way === 'phone') {
                    $this->model_account_customer->deleteLoginAttemptsPhone($phone);
                } else {
                    $this->model_account_customer->deleteLoginAttempts($email);
                }

            }
        }

        return !$this->error;
	}

	public function authorization()
    {
        $json = [];

        $language = new Language($this->session->data['language']);
        $language->load($this->session->data['language']);
        $language->load('account/login');
        $email = (isset($this->request->post['email']) ? $this->request->post['email'] : null);
        $phone = (isset($this->request->post['phone']) ? $this->request->post['phone'] : null);
        if (!$this->validate($email, $phone, $this->request->post['password'])) {
            $json['errors'] = $language->get($this->error['warning']);
        } else {

            unset($this->session->data['guest']);

            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }
            $this->load->model('catalog/product');
            $certificates = $this->model_catalog_product->getCertificates();

            if ($certificates) {
                foreach ($certificates as $certificate) {
                    $this->model_catalog_product->updateCertificate($certificate['certificate_id']);
                }
            }

            // Wishlist
            if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
                $this->load->model('account/wishlist');

                foreach ($this->session->data['wishlist'] as $key => $product_id) {
                    $this->model_account_wishlist->addWishlist($product_id);

                    unset($this->session->data['wishlist'][$key]);
                }
            }

            if (isset($this->request->post['redirect']) && $this->request->post['redirect'] != $this->url->link('account/logout', '', true) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
                $redirect = str_replace('&amp;', '&', $this->request->post['redirect']);
            } else {
                $redirect = $this->url->link('account/account', '', true);
            }

            $json['redirect'] = $redirect;

        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
