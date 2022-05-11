<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutCheckout extends Controller {
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}


		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setRobots('noindex,follow');

		if (!isset($this->session->data['shipping_address']['firstname']) &&
            !isset($this->session->data['shipping_address']['telephone']) &&
            !isset($this->session->data['shipping_address']['country_id']) &&
            !isset($this->session->data['shipping_address']['zone_id']) &&
            !isset($this->session->data['shipping_address']['city']) &&
            !isset($this->session->data['shipping_address']['street']) &&
            !isset($this->session->data['shipping_address']['house']) &&
            !isset($this->session->data['shipping_address']['phone'])) {
		    unset($this->session->data['shipping_methods']);
		    unset($this->session->data['shipping_method']);
        }

		// Required by klarna
		if ($this->config->get('payment_klarna_account') || $this->config->get('payment_klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

        $this->document->addScript('catalog/view/javascript/bootstrap/js/bootstrap.min.js');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['text_checkout_option'] = sprintf($this->language->get('text_checkout_option'), 1);
		$data['text_checkout_account'] = sprintf($this->language->get('text_checkout_account'), 2);
		$data['text_checkout_payment_address'] = sprintf($this->language->get('text_checkout_payment_address'), 2);
		$data['text_checkout_shipping_address'] = sprintf($this->language->get('text_checkout_shipping_address'), 3);
		$data['text_checkout_shipping_method'] = sprintf($this->language->get('text_checkout_shipping_method'), 4);
		
		if ($this->cart->hasShipping()) {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 5);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 6);
		} else {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 3);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 4);	
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

        $data['payment_social_nick'] =  '';

        if ($this->customer->isLogged()) {
            $this->load->model('account/customer');
            $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
            $data['payment_social_nick'] =  $customer_info['social_nick'] ? $customer_info['social_nick'] : '';
            $this->session->data['payment_address']['firstname'] = $this->customer->getFirstName();
            $this->session->data['payment_address']['lastname'] = $this->customer->getLastName();
            $this->session->data['payment_address']['email'] = $this->customer->getEmail();
            $this->session->data['payment_address']['phone'] = $this->customer->getTelephone();
            $this->session->data['payment_address']['company'] = '';
            $this->session->data['payment_address']['address_2'] = '';
            $this->session->data['payment_address']['country_id'] = $this->__get_countries_id__()['belarus'];
            $this->session->data['payment_address']['zone_id'] = $this->__get_cities_id__()['minsk'];
            $this->session->data['payment_address']['iso_code_2'] = 'BY';
            $this->session->data['payment_address']['iso_code_3'] = 'BLR';
            $this->session->data['payment_address']['zone_code'] = 'HM';
            $this->session->data['payment_address']['address_1'] = $customer_info['country'] .
                (!empty($customer_info['city']) ? ', ' . $customer_info['city'] . ', ' : '') .
                (!empty($customer_info['street']) ? $customer_info['street'] . ', ' : '') .
                (!empty($customer_info['house']) ? $customer_info['house'] : '') .
                (!empty($customer_info['building']) ? '/' . $customer_info['building'] : '') .
                (!empty($customer_info['flat']) ? '/' . $customer_info['flat'] : '');
            $this->session->data['payment_address']['country'] = $customer_info['country'];
            $this->session->data['payment_address']['city'] = $customer_info['city'];
            $this->session->data['payment_address']['zone'] = $customer_info['city'];
            $this->session->data['payment_address']['street'] = $customer_info['street'];
            $this->session->data['payment_address']['house'] = $customer_info['house'];
            $this->session->data['payment_address']['building'] = $customer_info['building'];
            $this->session->data['payment_address']['flat'] = $customer_info['flat'];

            $this->session->data['shipping_address']['firstname'] = $this->customer->getFirstName();
            $this->session->data['shipping_address']['lastname'] = $this->customer->getLastName();
            $this->session->data['shipping_address']['email'] = $this->customer->getEmail();
            $this->session->data['shipping_address']['phone'] = $this->customer->getTelephone();
            $this->session->data['shipping_address']['company'] = '';
            $this->session->data['shipping_address']['address_2'] = '';
            $this->session->data['shipping_address']['country_id'] = $this->__get_countries_id__()['belarus'];
            $this->session->data['shipping_address']['zone_id'] = $this->__get_cities_id__()['minsk'];
            $this->session->data['shipping_address']['iso_code_2'] = 'BY';
            $this->session->data['shipping_address']['iso_code_3'] = 'BLR';
            $this->session->data['shipping_address']['zone_code'] = 'HM';
            $this->session->data['shipping_address']['address_1'] = $customer_info['country'] .
                (!empty($customer_info['city']) ? ', ' . $customer_info['city'] . ', ' : '') .
                (!empty($customer_info['street']) ? $customer_info['street'] . ', ' : '') .
                (!empty($customer_info['house']) ? $customer_info['house'] : '') .
                (!empty($customer_info['building']) ? '/' . $customer_info['building'] : '') .
                (!empty($customer_info['flat']) ? '/' . $customer_info['flat'] : '');
            $this->session->data['shipping_address']['country'] = $customer_info['country'];
            $this->session->data['shipping_address']['city'] = $customer_info['city'];
            $this->session->data['shipping_address']['zone'] = $customer_info['city'];
            $this->session->data['shipping_address']['street'] = $customer_info['street'];
            $this->session->data['shipping_address']['house'] = $customer_info['house'];
            $this->session->data['shipping_address']['building'] = $customer_info['building'];
            $this->session->data['shipping_address']['flat'] = $customer_info['flat'];

        }

        $data['error_street'] = sprintf($this->language->get('error_custom_field'), $this->language->get('text_street'));
        $data['error_house'] = sprintf($this->language->get('error_custom_field'), $this->language->get('text_house'));


        $data['payment_name'] = isset($this->session->data['payment_address']['firstname']) ? $this->session->data['payment_address']['firstname'] : '';
        $data['payment_birthday'] = isset($this->session->data['payment_address']['birthday']) ? $this->session->data['payment_address']['birthday'] : '';
        $data['payment_phone'] = isset($this->session->data['payment_address']['phone']) ? $this->session->data['payment_address']['phone'] : '';
        $data['payment_email'] = isset($this->session->data['payment_address']['email']) ? $this->session->data['payment_address']['email'] : '';
        $data['payment_country'] = isset($this->session->data['payment_address']['country']) ? $this->session->data['payment_address']['country'] : '';
        $data['payment_city'] =  '';
        $data['payment_street'] = isset($this->session->data['payment_address']['street']) ? $this->session->data['payment_address']['street'] : '';
        $data['payment_house'] = isset($this->session->data['payment_address']['house']) ? $this->session->data['payment_address']['house'] : '';
        $data['payment_building'] = isset($this->session->data['payment_address']['building']) ? $this->session->data['payment_address']['building'] : '';
        $data['payment_flat'] = isset($this->session->data['payment_address']['flat']) ? $this->session->data['payment_address']['flat'] : '';
        $data['payment_zone'] = isset($this->session->data['payment_address']['zone']) ?
            $this->session->data['payment_address']['zone'] :
            (isset($this->session->data['shipping_address']['zone']) ? $this->session->data['shipping_address']['zone'] : '');

        $data['payment_zone_id'] = isset($this->session->data['payment_address']['zone_id']) ?
            $this->session->data['payment_address']['zone_id'] :
            (isset($this->session->data['shipping_address']['zone_id']) ? $this->session->data['shipping_address']['zone_id'] : '');

        $data['shipping_required'] = $this->cart->hasShipping();

        if (isset($this->session->data['shipping_address']['country_id'])) {

            $data['country_id'] = $this->session->data['shipping_address']['country_id'];
        } else if (isset($this->session->data['payment_address']['country_id'])) {

            $data['country_id'] = $this->session->data['payment_address']['country_id'];
        } else {

            $data['country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->session->data['shipping_address']['zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
        } else {
            $data['zone_id'] = '';
        }
        $free_shepping_currency_format = $this->currency->format(0.00, $this->session->data['currency']);
        $data['zone_misnk_id'] = $this->__get_cities_id__()['minsk'];
        $data['zone_moscow_id'] = $this->__get_cities_id__()['moscow'];
        $data['country_belarus_id'] = $this->__get_countries_id__()['belarus'];
        $data['country_russia_id'] = $this->__get_countries_id__()['russia'];
        $data['free_shipping_minsk_text'] = 'Доставка курьером по Минску – ' . $free_shepping_currency_format;
        $data['free_shipping_other_text'] = 'Доставка почтой РБ – ' . $free_shepping_currency_format;
        $data['free_shipping_russia_text'] = 'Бесплатная доставка по России почтой – ' . $free_shepping_currency_format;
        $data['login_way'] = $this->config->get('config_login_way');

        $this->load->model('localisation/country');
        $this->load->model('localisation/zone');
        $data['countries'] = $this->model_localisation_country->getCountries();
        $data['zones'] = [];

        if ($data['country_id']) {
            $data['zones'] = $this->model_localisation_zone->getZonesByCountryId($data['country_id']);
        }

        $this->load->model('setting/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get('total_' . $result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['totals'] = array();

        foreach ($totals as $total) {
            if (isset($this->session->data['promo']['certificate_price'])) {
                $price_with_promo = ($this->session->data['promo']['certificate_price'] >= $total['value']) ?
                    0 :
                    ((float)$total['value'] - (float)$this->session->data['promo']['certificate_price']);
                $total_value = ((float)$total['value'] - (float)$this->session->data['promo']['certificate_price']);
                $total_value_html = $this->currency->format($price_with_promo, $this->session->data['currency']);
            } else {
                $total_value = $total['value'];
                $total_value_html = $this->currency->format($total['value'], $this->session->data['currency']);
            }
            $data['totals'][] = array(
                'title' => $total['title'],
                'total_value' => $total_value,
                'text'  => $total_value_html
            );
        }

        $data['show_address_and_payment'] = !(isset($this->request->get['promo']));

        if (!$data['show_address_and_payment']) {

            $this->load->controller('extension/payment/' . $this->__get_bank_transfer_payment__());
            $this->load->controller('checkout/confirm');
            $data['promo'] = $this->request->get['promo'];
            $data['promo_payment'] = $this->load->view('extension/payment/' . $this->__get_bank_transfer_payment__(), $data);
        }
//        debug($this->session->data, true);

        $data['cart_link'] = $this->url->link('checkout/cart', '', true);
        $data['show_form'] = $this->customer->isLogged() ? 'n' : 'y';
        $data['promo_payment_method'] = $this->__get_bank_transfer_payment__();
        $data['minsk_city'] = $this->__get_cities_id__()['minsk'];
        $data['moscow_city'] = $this->__get_cities_id__()['moscow'];

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/checkout', $data));
	}

	public function updateShipping()
    {
        $json = [];
        $language_code = isset($this->request->post['language']) ? $this->request->post['language'] : 'ru-ru';
        $language = new Language($language_code);
        $language->load($language_code);
        $language->load('checkout/checkout');

        if (isset($this->request->post['shipping_method'])) {
            $shipping_address = isset($this->session->data['shipping_address']) ? $this->session->data['shipping_address'] : ['country_id' => '20','zone_id' => '339'];
            $shipping_method = explode('.', $this->request->post['shipping_method']);
            $shipping_method = array_shift($shipping_method);
            if ($shipping_method === 'postal_euro' && isset($this->session->data['payment_method']) && $this->session->data['payment_method']['code'] === 'cod') {
                unset($this->session->data['payment_method']);
            }
            $this->load->model('extension/shipping/' . $shipping_method);
            $quote = $this->{'model_extension_shipping_' . $shipping_method}->getQuote($shipping_address);

            $this->session->data['shipping_method'] = $quote['quote'][$shipping_method];

            $this->load->model('setting/extension');

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            $total_data = array(
                'totals' => &$totals,
                'taxes'  => &$taxes,
                'total'  => &$total
            );

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $sort_order = array();

                $results = $this->model_setting_extension->getExtensions('total');


                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {

                        $this->load->model('extension/total/' . $result['code']);

                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = array();

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }


                array_multisort($sort_order, SORT_ASC, $totals);
            }

            $data['totals'] = array();

            foreach ($totals as $total) {

                if (isset($this->session->data['promo']['certificate_price'])) {
                    $price_with_promo = ($this->session->data['promo']['certificate_price'] >= $total['value']) ?
                        0 :
                        ((float)$total['value'] - (float)$this->session->data['promo']['certificate_price']);
                    $total_value = ((float)$total['value'] - (float)$this->session->data['promo']['certificate_price']);
                    $total_value_html = $this->currency->format($price_with_promo, $this->session->data['currency']);
                } else {
                    $total_value = $total['value'];
                    $total_value_html = $this->currency->format($total['value'], $this->session->data['currency']);
                }
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'total_value' => $total_value,
                    'text'  => $total_value_html
                );

//                $data['totals'][] = array(
//                    'title' => $total['title'],
//                    'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
//                );
            }


            $json = $data;
            $json['shipping_method'] = $shipping_method;
        } else {
            $json['error'] = $language->get('error_shipping');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	public function setData()
    {
        $language = new language($this->request->get['language']);
        $language->load($this->request->get['language']);
        $language->load('checkout/checkout');
        $address = '';


        if (!$this->customer->isLogged()) {
            $this->session->data['guest']['customer_group_id'] = '1';

            if ($this->request->get['name'] === 'name') {
                $this->session->data['guest']['firstname'] = $this->request->get['value'];
                $this->session->data['guest']['lastname'] = '';
            }
            if ($this->request->get['name'] === 'email') {
                $this->session->data['guest']['email'] = $this->request->get['value'];
            }

            if ($this->request->get['name'] === 'phone') {
                $this->session->data['guest']['telephone'] = $this->request->get['value'];
            }
        }
        $this->session->data['payment_address']['city'] = 'Минск';
        $this->session->data['payment_address']['zone_code'] = '';

        $this->session->data['shipping_address']['city'] = $this->request->get['value'];
        $this->session->data['shipping_address']['zone_code'] = 'HM';
        if ($this->request->get['name'] === 'name') {

            $this->session->data['payment_address']['lastname'] = '';
            $this->session->data['payment_address']['firstname'] = $this->request->get['value'];
            $this->session->data['payment_address']['company'] = '';
            $this->session->data['payment_address']['address_2'] = '';

            $this->session->data['shipping_address']['lastname'] = '';
            $this->session->data['shipping_address']['firstname'] = $this->request->get['value'];
            $this->session->data['shipping_address']['company'] = '';
            $this->session->data['shipping_address']['address_2'] = '';

        } else if ($this->request->get['name'] === 'city') {
            $this->session->data['payment_address']['city'] = $this->request->get['value'];
            $this->session->data['payment_address']['zone_code'] = 'HM';

            $this->session->data['shipping_address']['city'] = $this->request->get['value'];
            $this->session->data['shipping_address']['zone_code'] = 'HM';
        } else {
            $this->session->data['payment_address'][$this->request->get['name']] = $this->request->get['value'];
            $this->session->data['shipping_address'][$this->request->get['name']] = $this->request->get['value'];
        }

        if (in_array($this->request->get['name'], ['street', 'house', 'building', 'flat'])) {
            $address .= ' ' . $this->request->get['value'] . ' ';
        }

        $this->session->data['payment_address']['address_1'] = $address;
        $this->session->data['shipping_address']['address_1'] = $address;

        if (isset($this->request->get['country_data'])) {
            $this->session->data['payment_address']['address_format'] = $this->request->get['country_data']['address_format'];
            $this->session->data['payment_address']['country_id'] = $this->request->get['country_data']['country_id'];
            $this->session->data['payment_address']['iso_code_2'] = $this->request->get['country_data']['iso_code_2'];
            $this->session->data['payment_address']['iso_code_3'] = $this->request->get['country_data']['iso_code_3'];
            $this->session->data['payment_address']['country'] = $this->request->get['country_data']['name'];

            $this->session->data['shipping_address']['address_format'] = $this->request->get['country_data']['address_format'];
            $this->session->data['shipping_address']['country_id'] = $this->request->get['country_data']['country_id'];
            $this->session->data['shipping_address']['iso_code_2'] = $this->request->get['country_data']['iso_code_2'];
            $this->session->data['shipping_address']['iso_code_3'] = $this->request->get['country_data']['iso_code_3'];
            $this->session->data['shipping_address']['country'] = $this->request->get['country_data']['name'];
            $this->rmSession(['zone_id', 'zone', 'zone_code']);

        }

        if (isset($this->request->get['zone_data'])) {
            $this->session->data['payment_address']['zone_id'] = $this->request->get['zone_data']['zone_id'];
            $this->session->data['payment_address']['zone'] = $this->request->get['zone_data']['zone'];

            if (((int)$this->request->get['zone_data']['zone_id'] === (int)$this->__get_cities_id__()['minsk']) ||(
                (int)$this->request->get['zone_data']['zone_id'] === (int)$this->__get_cities_id__()['moscow'] )) {
                $this->session->data['payment_address']['city'] = $this->request->get['zone_data']['zone'];
            }

            $this->session->data['shipping_address']['zone_id'] = $this->request->get['zone_data']['zone_id'];
            $this->session->data['shipping_address']['zone'] = $this->request->get['zone_data']['zone'];

            if (!isset($this->session->data['shipping_address']['city'])) {
                $this->session->data['shipping_address']['city'] = $this->request->get['zone_data']['zone'];
            }
            if (((int)$this->request->get['zone_data']['zone_id'] === (int)$this->__get_cities_id__()['minsk']) ||(
                    (int)$this->request->get['zone_data']['zone_id'] === (int)$this->__get_cities_id__()['moscow'] )) {
                $this->rmSession();
            } else {
                $this->rmSession(['city']);
            }

        }

        $data['check'] = (isset($this->session->data['payment_address']['firstname']) && !empty($this->session->data['payment_address']['firstname'])) &&
            (isset($this->session->data['payment_address']['phone']) && !empty($this->session->data['payment_address']['phone'])) &&
            (isset($this->session->data['payment_address']['email']) && !empty($this->session->data['payment_address']['email'])) &&
            (isset($this->session->data['payment_address']['city']) && !empty($this->session->data['payment_address']['city'])) &&
            (isset($this->session->data['payment_address']['street']) && !empty($this->session->data['payment_address']['street'])) &&
            (isset($this->session->data['payment_address']['house']) && !empty($this->session->data['payment_address']['house']));

        if ($this->request->get['name'] === 'email') {
            if (!filter_var($this->request->get['value'], FILTER_VALIDATE_EMAIL)) {
                $data['check'] = false;
                $data['error_email'] = $language->get('error_email');
            }
        }



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
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

        $this->session->data['payment_address']['address_format']   = $country_info['address_format'];
        $this->session->data['payment_address']['country_id']       = $country_info['country_id'];
        $this->session->data['payment_address']['iso_code_2']       = $country_info['iso_code_2'];
        $this->session->data['payment_address']['iso_code_3']       = $country_info['iso_code_3'];
        $this->session->data['payment_address']['country']          = $country_info['name'];

        $this->session->data['shipping_address']['address_format']  = $country_info['address_format'];
        $this->session->data['shipping_address']['country_id']      = $country_info['country_id'];
        $this->session->data['shipping_address']['iso_code_2']      = $country_info['iso_code_2'];
        $this->session->data['shipping_address']['iso_code_3']      = $country_info['iso_code_3'];
        $this->session->data['shipping_address']['country']         = $country_info['name'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    private function rmSession($sessions = [])
    {
        if (isset($this->session->data['payment_address']['address_1'])) {
            unset($this->session->data['payment_address']['address_1']);
        }

        if (isset($this->session->data['payment_address']['address_2'])) {
            unset($this->session->data['payment_address']['address_2']);
        }

        if (isset($this->session->data['payment_address']['street'])) {
            unset($this->session->data['payment_address']['street']);
        }

        if (isset($this->session->data['payment_address']['house'])) {
            unset($this->session->data['payment_address']['house']);
        }

        if (isset($this->session->data['payment_address']['building'])) {
            unset($this->session->data['payment_address']['building']);
        }

        if (isset($this->session->data['payment_address']['flat'])) {
            unset($this->session->data['payment_address']['flat']);
        }

        if (isset($this->session->data['shipping_address']['address_1'])) {
            unset($this->session->data['shipping_address']['address_1']);
        }

        if (isset($this->session->data['shipping_address']['address_2'])) {
            unset($this->session->data['shipping_address']['address_2']);
        }

        if (isset($this->session->data['shipping_address']['street'])) {
            unset($this->session->data['shipping_address']['street']);
        }

        if (isset($this->session->data['shipping_address']['house'])) {
            unset($this->session->data['shipping_address']['house']);
        }

        if (isset($this->session->data['shipping_address']['building'])) {
            unset($this->session->data['shipping_address']['building']);
        }

        if (isset($this->session->data['shipping_address']['flat'])) {
            unset($this->session->data['shipping_address']['flat']);
        }

        if (!empty($sessions)) {
            foreach ($sessions as $session) {
                if (isset($this->session->data['payment_address'][$session])) {
                    unset($this->session->data['payment_address'][$session]);
                }

                if (isset($this->session->data['shipping_address'][$session])) {
                    unset($this->session->data['shipping_address'][$session]);
                }
            }
        }
    }
}
