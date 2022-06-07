<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerInformationInformation extends Controller {
    private $error = [];
    const BRAND_HISTORY_LAYOUT = 20;
    const SIZE_GUIDE_LAYOUT = 21;
    const CERTIFICATE_LAYOUT = 22;
    const DELIVERY_LAYOUT = 23;
    const SUBSCRIBE_LAYOUT = 24;
	public function index() {
	    $data['date'] = date('Y-m-d', strtotime("-6 months"));
	    $data['date_modified'] = date('Y-m-d', strtotime("-1 months"));
        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }
        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		$layout_id = $this->model_catalog_information->getInformationLayoutId($information_id);
		$data['text_account'] = '';
		$data['text_policy'] = '';
		$data['country_id'] = '';
        $data['zone_id'] = '';
        $data['street'] = '';
        $data['house'] = '';
        $data['building'] = '';
        $data['flat'] = '';
        $data['email'] = '';
        $data['telephone'] = '';
        $data['name'] = '';
        $data['countries'] = [];
        $data['auth'] = 0;
		if ((int)$layout_id === self::SUBSCRIBE_LAYOUT) {
            if ($this->customer->isLogged()) {
                $this->response->redirect($this->url->link('account/account', '', true));
            }
		    $data['text_policy'] = sprintf($this->language->get('text_policy'), $this->url->link('information/information', 'information_id=3', true), $this->url->link('information/information', 'information_id=7', true));
		    $data['text_account'] = sprintf($this->language->get('text_account'), '/login');
            $this->load->model('localisation/country');
            $data['countries'] = $this->model_localisation_country->getCountries();
            if ($this->customer->isLogged()) {
                $data['auth'] = 1;
                $this->load->model('account/customer');
                $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
                if ($customer_info) {
                    $data['country_id'] = $customer_info['country_id'];
                    $data['zone_id'] = $customer_info['zone_id'];
                    $data['street'] = $customer_info['street'];
                    $data['house'] = $customer_info['house'];
                    $data['building'] = $customer_info['building'];
                    $data['flat'] = $customer_info['flat'];
                    $data['email'] = $customer_info['email'];
                    $data['telephone'] = $customer_info['telephone'];
                    $data['name'] = $customer_info['firstname'] . ($customer_info['lastname'] ? ' ' . $customer_info['lastname'] : '');
                }
            }
        }

		if ((int)$layout_id === self::CERTIFICATE_LAYOUT) {
		    $this->load->model('catalog/product');
            $this->load->model('tool/image');
		    $product = $this->model_catalog_product->getProduct($this->__get_certificate_product_id__());

		    if ($product) {
                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], 550, 343);
                } else {
                    $image = '';
                }

                $title = explode('[span]', $product['name'], 2);
                if (isset($title[0]) && isset($title[1])) {
                    $new_title = '<span>'. $title[0] .'</span>' . $title[1];
                } else {
                    $new_title = '';
                }

                $data['product'] = [
                    'product_id' => $product['product_id'],
                    'image' => $image,
                    'description' => html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8'),
                    'title' => html_entity_decode($new_title, ENT_QUOTES, 'UTF-8')
                ];
            }
        }

		$data['text_certificate_contact_instruction'] = sprintf($this->language->get('text_certificate_contact_instruction'), $this->url->link('information/contact'));

		$data['electronic_certificate'] = $this->language->get('text_electronic_certificate');
		$data['paper_certificate'] = $this->language->get('text_paper_certificate');
		$data['add_to_cart'] = $this->language->get('text_add_to_cart');
		$data['text_mail'] = $this->language->get('text_mail');
		$data['text_currency'] = sprintf($this->language->get('text_currency'), $this->session->data['currency']);
		$data['certificate_empty'] = $this->language->get('text_certificate_empty');

		if ($information_info) {
			
			if ($information_info['meta_title']) {
				$this->document->setTitle($information_info['meta_title']);
			} else {
				$this->document->setTitle($information_info['title']);
			}
			
			if ($information_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}
			
			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}
			
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');

            $data['text_back_button'] = sprintf($this->language->get('text_back_button'), (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/');

            $data['column_left'] = $this->load->controller('common/column_left');

            if ($layout_id === self::SIZE_GUIDE_LAYOUT) {
                $data['column_left'] = html_entity_decode(strip_tags(str_replace([' ', '&nbsp;'], '', $data['column_left'])), ENT_QUOTES, 'UTF-8');
            }

			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/' . $this->getInformationLayout($layout_id), $data));
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function getStates()
    {
        $this->load->model('localisation/zone');
        $data['zones'] = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
        if (array_key_exists('zone_id', $this->request->get)) {
            $data['zone_id'] = $this->request->get['zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        $this->response->setOutput($this->load->view('account/zones', $data));
    }

    public function submitHandlerSubscribe()
    {
        $from_account = false;
        if ( array_key_exists('route_action', $this->request->get) ) {
            $from_account = true;
        }
        $validation = $this->validation($this->request->get['language'], $this->request->post, $from_account);

        if (!empty($validation)) {
            $json = [
                'success' => false,
                'errors' => $validation
            ];
        } else {

            $language = new language($this->request->get['language']);
            $language->load($this->request->get['language']);
            $language->load('account/register');
            $this->load->model('account/customer');

            $data = $this->request->post;
            $phone = isset($data['phone']) ? $data['phone'] : $this->customer->getTelephone();
            $password = $this->randomString();
            $filter_data = [
                'customer_group_id'     => isset($data['newsletter']) ? '2' : '1',
                'language_id'           => $this->request->get['language_id'],
                'firstname'             => isset($data['name']) ? $data['name'] : $this->customer->getFirstName(),
                'lastname'              => '',
                'email'                 => isset($data['email']) ? $data['email'] : $this->customer->getEmail(),
                'social_nick'           => null,
                'telephone'             => str_replace($this->__get_deprecated_symbols__(), '', $phone),
                'password'              => $password,
                'newsletter'            => isset($data['newsletter']) ? '1' : '0'
            ];

            if (isset($data['country_id'])) {
                $filter_data += [
                    'country' => $data['country_id'],
                ];
            }

            if (isset($data['zone_id'])) {
                $filter_data += [
                    'city' => $data['zone_id'],
                ];
            }

            if (isset($data['street'])) {
                $filter_data += [
                    'street' => $data['street'],
                ];
            }

            if (isset($data['house'])) {
                $filter_data += [
                    'house' => $data['house'],
                ];
            }

            if (isset($data['building'])) {
                $filter_data += [
                    'building' => $data['building'],
                ];
            }

            if (isset($data['flat'])) {
                $filter_data += [
                    'flat' => $data['flat'],
                ];
            }
            $bepay_customer_id = null;

            if ($this->customer->isLogged()) {
                $_bepay_customer_id = $this->model_account_customer->getBePayedCustomerId($this->customer->getId());
                if (!empty($_bepay_customer_id)) {
                    if ($_bepay_customer_id['pay_status'] === 'canceled' || $_bepay_customer_id['pay_status'] === 'failed') {
                        $bepay_customer_id = $_bepay_customer_id['id'];
                    } else if ($_bepay_customer_id['pay_status'] === 'successful') {
                        print_r(json_encode(['success' => false, 'error_subscribe' => $language->get('error_subscribe')]));exit;
                    }
                }
            }
            $sub_data = [
                'first_name' => isset($this->request->post['name']) ? $this->request->post['name'] : $this->customer->getFirstName(),
                'phone' => isset($this->request->post['phone']) ? $this->request->post['phone'] : $this->customer->getTelephone(),
                'email' => isset($this->request->post['email']) ? $this->request->post['email'] : $this->customer->getEmail(),
                'ip' => $this->request->server['REMOTE_ADDR'],
                'auth_data' => self::AUTH_DATA
            ];
            if ($bepay_customer_id) {
                $id = $bepay_customer_id;
            } else {
                $res = json_decode($this->curlHandler('https://api.bepaid.by/customers', [], 'POST', $sub_data), true);
                $id = $res['id'];
            }

            $subscribe = json_decode($this->curlHandler('https://api.bepaid.by/subscriptions', [], 'POST', [
                'customer' => [
                    'id' => $id
                ],
                'plan' => [
                    'id' => 'pln_3f9e9658a89c8d7f'
                ],
                'return_url' => $this->url->link('account/account'),
                'language' => 'ru',
                'auth_data' => self::AUTH_DATA
            ]), true);

            if (!$this->customer->isLogged()) {
                $customer_id = $this->model_account_customer->addCustomer($filter_data);
            } else {
                $customer_id = $this->customer->getId();
            }

            if ($customer_id) {
                if (!$from_account) {
                    $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

                    $this->customer->login($filter_data['email'], $filter_data['password']);

                    unset($this->session->data['guest']);
                }

                $this->model_account_customer->saveInfo([
                    'customer_id' => $customer_id,
                    'bepayed_customer_id' => $id ? $id : '',
                    'bepayed_sbs_id' => isset($subscribe['id']) ? $subscribe['id'] : '',
                    'user_data' => (array_key_exists('requests', $this->request->post) && $this->request->post['requests']) ? serialize(['requests' => $this->request->post['requests']]) : ''
                ]);
                if (!$this->customer->isLogged() && !$from_account) {
                    $this->load->language('mail/register');
                    $data['login'] = $this->url->link('account/login', '', true);
                    $data['login_data'] = $this->request->post['phone'] . ' | ' . $this->request->post['email'];
                    $data['store'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
                    $data['text_welcome'] = sprintf($this->language->get('text_welcome'), $data['store']);
                    $data['title'] = '';
                    $data['text_password'] = sprintf($this->language->get('text_password'), $password);

                    $mail = new Mail($this->config->get('config_mail_engine'));
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                    $mail->setTo('support@lovelace.by');
                    $mail->setFrom($this->request->post['email']);
                    $mail->setReplyTo($this->request->post['email']);
                    $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name'] . ' (' . $this->request->post['email'] . ')'), ENT_QUOTES, 'UTF-8'));
                    $mail->setHtml($this->load->view('mail/register', $data));
                    $mail->send();
                }

                $json = [
                    'success' => true,
                    'redirect' => 'https://api.bepaid.by/plans/pln_3f9e9658a89c8d7f/pay?return_url=' . $this->url->link('account/account')
                ];
            } else {
                $json = ['success' => false, 'critical_error' => $language->get('critical_error')];
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->addHeader('X-Robots-Tag: noindex');

		$this->response->setOutput($output);
	}

	private function getInformationLayout($layout_id)
    {
        switch ((int)$layout_id) {
            case self::BRAND_HISTORY_LAYOUT:
                $template = 'brand_history';
                break;
            case self::SIZE_GUIDE_LAYOUT:
                $template = 'size_guide';
                break;
            case self::CERTIFICATE_LAYOUT:
                $template = 'certificate';
                break;
            case self::DELIVERY_LAYOUT:
                $template = 'delivery';
                break;
            case self::SUBSCRIBE_LAYOUT:
                $template = 'subscribe';
                break;
            default:
                $template = 'information';
        }

        return $template;
    }

    protected function validation($language_code, $data = [], $from_account = false)
    {
        $language = new language($language_code);
        $language->load($language_code);
        $language->load('account/register');

        if (!$from_account) {
            if ((utf8_strlen(trim($data['name'])) < 1) || (utf8_strlen(trim($data['name'])) > 32)) {
                $this->error['name'] = $language->get('error_firstname');
            }

            if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){9,14}(\s*)?$/', $data['phone'])) {
                $this->error['phone'] = $language->get('error_telephone');
            } else if ($this->check_phone($data['phone'])) {
                $this->error['phone'] = $language->get('error_phone_exists');
            }

            if ((utf8_strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error['email'] = $language->get('error_email');
            } else if ($this->check_email($data['email'])) {
                $this->error['email'] = $language->get('error_email_exists');
            }

            if ((int)$data['country_id'] === 0) {
                $this->error['country_id'] = sprintf($language->get('error_custom_field'), $language->get('entry_country')) . ( $language_code === 'ru-ru' ? 'а' : '' );
            }

            if ((int)$data['zone_id'] === 0) {
                $this->error['zone_id'] = sprintf($language->get('error_custom_field'), $language->get('entry_city'));
            }

            if ((utf8_strlen($data['street']) <= 0)) {
                $this->error['street'] = sprintf($language->get('error_custom_field'), $language->get('entry_address'));
            }

            if ((utf8_strlen($data['house']) <= 0)) {
                $this->error['house'] = sprintf($language->get('error_custom_field'), $language->get('entry_house'));
            }

            if (!array_key_exists('agree', $data)) {
                $this->error['agree'] = sprintf($language->get('error_agree'), 'Политикой конфедециальности');
            }

            if (!$this->customer->isLogged() && !array_key_exists('create', $data)) {
                $this->error['create'] = $language->get('error_create');
            }

            if (!$this->customer->isLogged() && !array_key_exists('charge', $data)) {
                $this->error['charge'] = $language->get('error_charge');
            }
        } else {

            if (!array_key_exists('agree', $data)) {
                $this->error['agree'] = sprintf($language->get('error_agree'), 'Политикой конфиденциальности');
            }

            if (!array_key_exists('charge', $data)) {
                $this->error['charge'] = $language->get('error_charge');
            }
        }


        return $this->error;
    }

    private function check_phone($phone) {
        $this->load->model('account/customer');
        return $this->model_account_customer->getCustomerByPhone($phone);
    }

    private function check_email($email) {
        $this->load->model('account/customer');
        return $this->model_account_customer->getCustomerByEmail($email);
    }

    private function randomString() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
