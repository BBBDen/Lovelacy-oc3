<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutCart extends Controller {
	public function index() {
//	    unset($this->session->data['promo_products']);
//        debug($this->session->data);
		$this->load->language('checkout/cart');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setRobots('noindex,follow');
        $this->document->addScript('catalog/view/javascript/bootstrap/js/bootstrap.min.js');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);

		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit', '', true);

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');
			$this->load->model('catalog/product');

			$data['products'] = array();

			$products = $this->cart->getProducts();
            $data['promo_notification'] = '';
            $promo_is_enabled = (int)$this->config->get('config_promo');
            if ( $promo_is_enabled ) {
                $data['promo_notification'] = '<a href="'.$this->url->link('information/information', 'information_id=9').'">Акция</a> "2 по цене 1": купи один комплект, второй получи в подарок!';
            }

			$count_products = count($products);
			$isset_certificate = false;
			$certificate_key = '';
            $data['categories'] = [];
            $data['product_ids'] = [];
			foreach ($products as $product) {
			    if ( (int)$product['product_id'] === $this->__get_certificate_product_id__() ) {
			        $isset_certificate = true;
			        $certificate_key = $product['option']['certificate_key'];
                    $__certificate__ = $this->model_catalog_product->getProductCertificatePrice($product['option']['certificate_key']);
                } else {
                    $__certificate__ = false;
                }
                $product_total = 0;

			    $categories = $this->model_catalog_product->getCategories($product['product_id']);
                foreach ($categories as $category) {
                    $data['categories'][$category['category_id']] = $category['category_id'];
			    }

                $data['product_ids'][] = $product['product_id'];

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();
				$__option_data__ = [];
                if ((int)$product['product_id'] !== $this->__get_certificate_product_id__()) {

                    foreach ($product['option'] as $option) {

                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                $value = $upload_info['name'];
                            } else {
                                $value = '';
                            }
                        }

                        $__option_data__[] = array(
                            'name'  => $option['name'],
                            'option_id' => $option['option_id'],
                            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                        );
                    }
                }
                $val = '';
                foreach ($__option_data__ as $option_datum) {
                    if ((int)$option_datum['option_id'] === $this->__get_option_size_id__()) {
                        $val .= $option_datum['value'] . ', ';
                    } else {
                        $val = $option_datum['value'];
                    }
                }
                foreach ($__option_data__ as $v) {
                    $option_data[$v['option_id']] = [
                        'name'  => $v['name'],
                        'value' => trim($val, ', ')
                    ];
                }


                // Display prices
                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
                    $price = $this->currency->format($unit_price, $this->session->data['currency']);
                    $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);

                } else {
                    $price = false;
                    $total = false;
                }

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year')
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

                $result_color = $this->model_catalog_product->getProductColorFilter($product['product_id']);

				if ($result_color) {
				    $name = $this->model_tool_image->resize($result_color['image'], 25, 25);
                } else {
				    $name = '';
                }

                if (isset($product['special']) && !is_null($product['special']) && (float)$product['special'] >= 0) {
                    $special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ((int)$product['product_id'] === $this->__get_certificate_product_id__()) {
                    $product_name = $this->language->get('certificate_text');
                    $product_certificate = true;
                } else {
                    $product_name = $product['name'];
                    $product_certificate = false;
                }

				$data['products'][] = array(
					'cart_id'           => $product['cart_id'],
					'product_id'        => $product['product_id'],
					'thumb'             => $image,
					'name'              => $product_name,
					'model'             => $product['model'],
					'option'            => $option_data,
					'recurring'         => $recurring,
					'quantity'          => $product['quantity'],
					'stock'             => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'            => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'             => $price,
					'special'           => $special,
					'total'             => $total,
					'color'             => $name,
					'promo'             => $product['promo'],
                    'certificate'       =>$product_certificate,
					'certificate_key'   => ($__certificate__ ? $__certificate__['certificate_id'] : ''),
					'href'              => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);

			}
			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

            $this->load->model('catalog/product');

			$result = $this->model_catalog_product->getCharityProduct();
            $data['charity_product'] = [];
			if ($result) {

                if ($result['image']) {
                    $__image = $this->model_tool_image->resize($result['image'], 459, 685);
                } else {
                    $__image = '';
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $unit_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));

                    $price = $this->currency->format($unit_price, $this->session->data['currency']);
                } else {
                    $price = false;
                }

                $data['product_variations'] = [];

                $results_product_variations = $this->model_catalog_product->getProductVariations($result['product_id']);

                if ($results_product_variations) {
                    foreach ($results_product_variations as $result_product_variations) {
                        $data['product_variations'][] = [
                            'image' => $this->model_tool_image->resize($result_product_variations['image'], 44, 44),
                            'href' => $this->url->link('product/product', 'product_id=' . $result_product_variations['product_id']),
                            'product_id' => $result_product_variations['product_id'],
                            'name' => $result_product_variations['name']
                        ];
                    }
                }

                $result_color = $this->model_catalog_product->getProductColorFilter($result['product_id']);

                if ($result_color) {
                    $data['product_variations'][] = [
                        'image' => $this->model_tool_image->resize($result_color['image'], 44, 44),
                        'href' => '',
                        'product_id' => $result['product_id'],
                        'name' => $result_color['name']
                    ];
                }

                $result_images = $this->model_catalog_product->getProductImages($result['product_id']);
                $images = [];
                foreach ($result_images as $image) {
                    $images[] = array(
                        'popup' => $this->model_tool_image->resize($image['image'], 459, 685),
                        'thumb' => $this->model_tool_image->resize($result['image'], 95, 142)
                    );
                }

                $data['charity_product'] = [
                    'product_id'=> $result['product_id'],
                    'thumb'     => $__image,
                    'name'      => $result['name'],
                    'model'     => $result['model'],
                    'quantity'  => $result['quantity'],
                    'price'     => $price,
                    'images'    => $images,
                    'href'      => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                ];
            }

			// Totals
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

			$data['continue'] = $this->url->link('common/home');

            if ((int)$count_products === 1 && $isset_certificate) {
                $url = 'promo=' . $certificate_key;
            } else {
                $url = '';
            }

			$data['checkout'] = $this->url->link('checkout/checkout', $url, true);

			$this->load->model('setting/extension');

			$data['modules'] = array();
			
			$files = glob(DIR_APPLICATION . '/controller/extension/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$result = $this->load->controller('extension/total/' . basename($file, '.php'));
					
					if ($result) {
						$data['modules'][] = $result;
					}
				}
			}

			if ( array_key_exists('promo_gift', $this->session->data) && $this->session->data['promo_gift'] ) {
			    $data['promo_gift'] = $this->session->data['promo_gift'];
            }

            $data['main_category'] =  $this->url->link('product/category', 'path=' . $this->__get_main_category_id__());
			$data['text_back'] = $this->language->get('text_vack');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('checkout/cart', $data));
		} else {
			$data['text_error'] = $this->language->get('text_empty');
			
			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);
			unset($this->session->data['promo_gift']);
			unset($this->session->data['promo_products']);
			if (isset($this->session->data['payment_address'])) {
                unset($this->session->data['payment_address']);
            }
			if (isset($this->session->data['shipping_address'])) {
                unset($this->session->data['shipping_address']);
            }
			if (isset($this->session->data['shipping_method'])) {
                unset($this->session->data['shipping_method']);
            }

			if (isset($this->session->data['payment_method'])) {
                unset($this->session->data['payment_method']);
            }

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['text_back_button'] = sprintf($this->language->get('text_back_button'), (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'));
			$data['text_empty'] = sprintf($this->language->get('text_empty'), $this->url->link('product/category', 'path=' . $this->__get_main_category_id__()));

			$this->response->setOutput($this->load->view('checkout/cart_empty', $data));
		}
	}

    public function getVariation()
    {
        if ($this->request->get['language']) {
            $language = new Language($this->request->get['language']);
            $language->load($this->request->get['language']);
            $language->load('catalog/product');

            if (isset($this->request->get['product_id'])) {
                $this->load->model('catalog/product');
                $this->load->model('tool/image');

                $result = $this->model_catalog_product->getProduct($this->request->get['product_id']);

                $data['product'] = [];

                if ($result) {

                    if ($result['image']) {
                        $__image = $this->model_tool_image->resize($result['image'], 459, 685);
                    } else {
                        $__image = '';
                    }

                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $unit_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));

                        $price = $this->currency->format($unit_price, $this->session->data['currency']);
                    } else {
                        $price = false;
                    }

                    if (!is_null($result['special']) && (float)$result['special'] >= 0) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    } else {
                        $special = false;
                    }

                    $data['product_variations'] = [];

                    $results_product_variations = $this->model_catalog_product->getProductVariations($result['product_id']);

                    if ($results_product_variations) {
                        foreach ($results_product_variations as $result_product_variations) {
                            $data['product_variations'][] = [
                                'image' => $this->model_tool_image->resize($result_product_variations['image'], 44, 44),
                                'href' => $this->url->link('product/product', 'product_id=' . $result_product_variations['product_id']),
                                'product_id' => $result_product_variations['product_id'],
                                'name' => $result_product_variations['name']
                            ];
                        }
                    }

                    $result_color = $this->model_catalog_product->getProductColorFilter($result['product_id']);

                    if ($result_color) {
                        $data['product_variations'][] = [
                            'image' => $this->model_tool_image->resize($result_color['image'], 44, 44),
                            'href' => '',
                            'product_id' => $result['product_id'],
                            'name' => $result_color['name']
                        ];
                    }

                    $result_images = $this->model_catalog_product->getProductImages($result['product_id']);
                    $images = [];
                    foreach ($result_images as $image) {
                        $images[] = array(
                            'popup' => $this->model_tool_image->resize($image['image'], 459, 685),
                            'thumb' => $this->model_tool_image->resize($result['image'], 95, 142)
                        );
                    }

                    $data['product'] = [
                        'product_id'=> $result['product_id'],
                        'thumb'     => $__image,
                        'name'      => $result['name'],
                        'model'     => $result['model'],
                        'quantity'  => $result['quantity'],
                        'price'     => $price,
                        'special'   => $special,
                        'images'    => $images,
                        'href'      => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                    ];
                }

                $this->response->setOutput($this->load->view('product/charity', $data));
            }
        }
    }

	public function add() {
	    $json = [];
        $this->load->model('catalog/product');
		if (isset($this->request->post['type']) && $this->request->post['type'] === 'certificate') {
		    $language = new Language($this->request->post['language']);
            $language->load($this->request->post['language']);
            $language->load('product/product');

		    if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                $json['errors']['email'] = $language->get('error_email');
            }

		    if ((utf8_strlen($this->request->post['denomination']) <= 0)) {
                $json['errors']['denomination'] = $language->get('error_denomination');
            }

		    if (!$json) {
                $bytes = bin2hex(random_bytes(10));
                $options = [
                    'certificate_key' => $bytes
                ];

                $data = [
                    'customer_id' => ($this->customer->isLogged() ? $this->customer->getId() : 0),
                    'session_id' => $this->session->getId(),
                    'current_currency' => $this->request->post['current_currency'],
                    'currency_value' => $this->currency->getValue($this->session->data['currency']),
                    'price' => str_replace(',', '.', preg_replace('#[^0-9\.]#', '', $this->request->post['denomination'])),
                    'email' => $this->request->post['email'],
                    'certificate_type' => (isset($this->request->post['certificate']) ? $this->request->post['certificate'] : 'electronic'),
                    'certificate_key' => $bytes,
                ];

                $this->session->data['certificate_code'] = $bytes;

                $this->cart->add($this->request->post['product_id'], '1', $options, '0');

	    // remarketing all in one
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$categories = $this->model_catalog_product->getRemarketingCategories($product_info['product_id']);
			$json['remarketing'] = [];
			$json['remarketing']['google_product_id'] = $this->config->get('remarketing_google_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['google_identifier'] = $this->config->get('remarketing_google_identifier');;
			$json['remarketing']['facebook_product_id'] = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['mytarget_product_id'] = $this->config->get('remarketing_mytarget_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['product_id'] = $product_info['product_id'];
			$json['remarketing']['retailrocket_status'] = $this->config->get('remarketing_retailrocket_status');
			$json['remarketing']['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
			$json['remarketing']['vk_product_id'] = $this->config->get('remarketing_vk_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['vk_identifier'] = $this->config->get('remarketing_vk_identifier');
			$json['remarketing']['google_ads_identifier'] = $this->config->get('remarketing_google_ads_identifier');
			$json['remarketing']['google_ads_identifier_cart'] = $this->config->get('remarketing_google_ads_identifier_cart');
			$json['remarketing']['ecommerce_product_id'] = $this->config->get('remarketing_ecommerce_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['ecommerce_ga4_product_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json['remarketing']['ecommerce_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
			$json['remarketing']['ecommerce_analytics_id'] = $this->config->get('remarketing_ecommerce_analytics_id');
			$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
			$json['remarketing']['google_status'] = $this->config->get('remarketing_google_status');
			$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
			$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
			$json['remarketing']['vk_status'] = $this->config->get('remarketing_vk_status');
			$json['remarketing']['quantity'] = $quantity;
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$json['remarketing']['price'] = $this->currency->format($current_price, $this->session->data['currency'], '', false);
			$json['remarketing']['google_price'] = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
			$json['remarketing']['google_conversion_price'] = $this->currency->format($current_price * $this->config->get('remarketing_google_ads_ratio'), $this->config->get('remarketing_google_currency'), '', false);
			$json['remarketing']['facebook_price'] = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
			$json['remarketing']['ecommerce_price'] = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
			$json['remarketing']['brand'] = addslashes($product_info['manufacturer']);
			$json['remarketing']['name'] = addslashes($product_info['name']);
			$json['remarketing']['category'] = addslashes($categories);
			$json['remarketing']['currency'] = $this->session->data['currency'];
			$json['remarketing']['google_currency'] = $this->config->get('remarketing_google_currency');
			$json['remarketing']['facebook_currency'] = $this->config->get('remarketing_facebook_currency');
			$json['remarketing']['ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
			$json['remarketing']['google_remarketing_event'] = [
				'send_to' => $this->config->get('remarketing_google_identifier'),
				'value'   => $json['remarketing']['google_price'],
				'items'   => [[
					'id' => $json['remarketing']['google_product_id'],
					'google_business_vertical' => 'retail'
				]],
			];
			$json['remarketing']['google_ads_event'] = [
				'send_to' => $this->config->get('remarketing_google_ads_identifier_cart'),
				'value'   => $json['remarketing']['google_conversion_price'],
				'currency'   => $this->config->get('remarketing_google_currency')
			];
			$json['remarketing']['facebook_pixel_event'] = [
				'content_name' => $json['remarketing']['name'],
				'content_ids' => [$json['remarketing']['facebook_product_id']],
				'content_type' => 'product',
				'content_category' => $json['remarketing']['category'],
				'value'   => $json['remarketing']['facebook_price'],
				'currency'   => $this->config->get('remarketing_facebook_currency')
			];
			$json['remarketing']['tiktok_event'] = [
				'content_name' => $json['remarketing']['name'],
				'content_id' => $json['remarketing']['product_id'],
				'content_type' => 'product',
				'content_category' => $json['remarketing']['category'],
				'value'   => $json['remarketing']['price'],
				'currency'   => $json['remarketing']['currency']
			];
			$ecommerce_product = [
				'name' => $json['remarketing']['name'],
				'id' => [$json['remarketing']['ecommerce_product_id']],
				'price' => $json['remarketing']['ecommerce_price'],
				'quantity' => $json['remarketing']['quantity']
			];
			if (!empty($json['remarketing']['brand'])) $ecommerce_product['brand'] = $json['remarketing']['brand'];
			if (!empty($json['remarketing']['category'])) $ecommerce_product['category'] = $json['remarketing']['category'];
			$json['remarketing']['ecommerce_product'] = $ecommerce_product;
			
			$json['remarketing']['google_gtag_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
				'value'   => $json['remarketing']['ecommerce_price'] * $json['remarketing']['quantity'],
				'currency'   => $json['remarketing']['ecommerce_currency'],
				'items' => [$json['remarketing']['ecommerce_product']]
			];
			
			$ecommerce_ga4_product = [
				'item_name' => $json['remarketing']['name'],
				'index' => 1,
				'price' => $json['remarketing']['ecommerce_price'],
				'quantity' => $json['remarketing']['quantity']
			];
			if (!empty($json['remarketing']['brand'])) $ecommerce_ga4_product['item_brand'] = $json['remarketing']['brand'];
			if (!empty($json['remarketing']['category'])) $ecommerce_ga4_product['item_category'] = $json['remarketing']['category'];
			$json['remarketing']['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $json['remarketing']['ecommerce_currency'],
				'value' => $json['remarketing']['ecommerce_price'] * $json['remarketing']['quantity'],
				'items' => [$ecommerce_ga4_product]
			];
			
			$fb_time = time();
			$json['remarketing']['time'] = $fb_time;
			//options todo			
			
			if ($this->config->get('remarketing_ecommerce_measurement_status')) {
			if (!empty($this->session->data['uuid'])) {
				$uuid = $this->session->data['uuid'];	
				$ecommerce_data = [
					'ec'    => 'Enhanced Ecommerce',
					'ea'    => 'Adding a Product to a Shopping Cart',
					'ni'    => 1,
					'cu'    => $this->config->get('remarketing_ecommerce_currency'),
					'pa'    => 'add',
					'pr1nm' => $product_info['name'],
					'pr1id' => ($this->config->get('remarketing_ecommerce_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
					'pr1pr' => $json['remarketing']['ecommerce_price'],
					'pr1qt' => $quantity
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_data['pr1br'] = $json['remarketing']['brand'];
				if (!empty($categories)) $ecommerce_data['pr1ca'] = $categories;
		
				$this->model_tool_remarketing->sendEcommerce($ecommerce_data);
			}
			}
			
			if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
				if (!empty($this->session->data['uuid'])) {
				$uuid = $this->session->data['uuid'];		
				$item = [
					// Google refuses id 'item_id' => ($this->config->get('remarketing_ecommerce_ga4_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
					'item_name' => $product_info['name'],
					'affiliation' => $this->config->get('config_name'),
					'price' => $json['remarketing']['ecommerce_price'],
					'currency' => $this->config->get('remarketing_ecommerce_currency'),
					'quantity' => 1,
				];
				if(!empty($json['remarketing']['brand'])) $item['item_brand'] = addslashes($json['remarketing']['brand']);
				if(!empty($categories)) $item['item_category'] = $item['item_list_name'] = addslashes($categories);

				$ecommerce_data = [
					'client_id' => $uuid,
					'events' => [[
						'name' => 'add_to_cart',
						'params' => [
							'currency' => $this->config->get('remarketing_ecommerce_currency'),
							'items' => [$item], 
							'value' => $json['remarketing']['ecommerce_price']
						]],
					],
				];
				
				$this->model_tool_remarketing->sendEcommerceGa4($ecommerce_data);
				}
			}
			
			if ($this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'AddToCart';
				$facebook_data['custom_data'] = [
					'value' => $json['remarketing']['facebook_price'],
					'currency' => $this->config->get('remarketing_facebook_currency'),
					'content_ids' => [
						$json['remarketing']['facebook_product_id']
					],
					'content_name'     => addslashes($product_info['name']),
					'content_category' => $categories,
					'content_type'     => 'product',
					'opt_out'          => false
				];
				$facebook_data['time'] = $fb_time;
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
			
			if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged() && isset($this->session->data['esputnik_email'])) {
				$event = new stdClass();
				$event->eventTypeKey = 'cartUpdated'; 
				$event->keyValue = $this->session->data['esputnik_email'];
				$event->params = [];
				if (isset($this->session->data['esputnik_telephone'])) {
					$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
				}
				$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
				
				$event->params[] = ['name' => 'currencyCode', 'value' => $this->session->data['currency']];
				
				if ($this->customer->isLogged()) {
					$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->isLogged()];

					if ($this->customer->getFirstName()) {
						$event->params[] = ['name' => 'firstName', 'value' => $this->customer->getFirstName()];
					}
					if ($this->customer->getLastName()) {
						$event->params[] = ['name' => 'lastName', 'value' => $this->customer->getLastName()];
					}
				}
				$items = [];
				
				$this->load->model('tool/image');
				$products = $this->cart->getProducts();
				foreach ($products as $product) {
					$items[] = [
						'productId' => $product['product_id'],
						'name'      => $product['name'],
						'quantity'  => $product['quantity'],
						'price'     => $product['price']
					];
				}
				if (!isset($this->session->data['esputnik_uniq'])) {
					$this->session->data['esputnik_uniq'] = uniqid();
				}
				$event->params[] = ['name' => 'recycleStateId', 'value' => $this->session->data['esputnik_uniq']];
				$event->params[] = ['name' => 'products', 'value' => json_encode($items)];
				
				$this->model_tool_remarketing->sendEsputnik($event);
			}
		}
	  
                $this->model_catalog_product->addCertificate($data);

                $json['success'] = $language->get('certificate_success');
            }

        } else {

            $this->load->language('checkout/cart');

            if (isset($this->request->post['product_id'])) {
                $product_id = (int)$this->request->post['product_id'];
            } else {
                $product_id = 0;
            }

            $product_info = $this->model_catalog_product->getProduct($product_id);
            if ( array_key_exists('complect', $product_info) && (int)$product_info['complect'] === 1 ) {
//                print_r(json_encode($this->request->post));exit;
//                $results = $this->model_catalog_product->getProductComplect($product_info['product_id']);
            }

            if ($product_info) {
                if (isset($this->request->post['quantity'])) {
                    $quantity = (int)$this->request->post['quantity'];
                } else {
                    $quantity = 1;
                }

                if (isset($this->request->post['option'])) {
                    $option = array_filter($this->request->post['option']);
                } else {
                    $option = array();
                }

                $product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

                foreach ($product_options as $product_option) {
                    if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                        $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                    }
                }

                if (isset($this->request->post['recurring_id'])) {
                    $recurring_id = $this->request->post['recurring_id'];
                } else {
                    $recurring_id = 0;
                }

                $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

                if ($recurrings) {
                    $recurring_ids = array();

                    foreach ($recurrings as $recurring) {
                        $recurring_ids[] = $recurring['recurring_id'];
                    }

                    if (!in_array($recurring_id, $recurring_ids)) {
                        $json['error']['recurring'] = $this->language->get('error_recurring_required');
                    }
                }

                if (!$json) {
                    $this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);

	    // remarketing all in one
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$categories = $this->model_catalog_product->getRemarketingCategories($product_info['product_id']);
			$json['remarketing'] = [];
			$json['remarketing']['google_product_id'] = $this->config->get('remarketing_google_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['google_identifier'] = $this->config->get('remarketing_google_identifier');;
			$json['remarketing']['facebook_product_id'] = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['mytarget_product_id'] = $this->config->get('remarketing_mytarget_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['product_id'] = $product_info['product_id'];
			$json['remarketing']['retailrocket_status'] = $this->config->get('remarketing_retailrocket_status');
			$json['remarketing']['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
			$json['remarketing']['vk_product_id'] = $this->config->get('remarketing_vk_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['vk_identifier'] = $this->config->get('remarketing_vk_identifier');
			$json['remarketing']['google_ads_identifier'] = $this->config->get('remarketing_google_ads_identifier');
			$json['remarketing']['google_ads_identifier_cart'] = $this->config->get('remarketing_google_ads_identifier_cart');
			$json['remarketing']['ecommerce_product_id'] = $this->config->get('remarketing_ecommerce_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['ecommerce_ga4_product_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json['remarketing']['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json['remarketing']['ecommerce_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
			$json['remarketing']['ecommerce_analytics_id'] = $this->config->get('remarketing_ecommerce_analytics_id');
			$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
			$json['remarketing']['google_status'] = $this->config->get('remarketing_google_status');
			$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
			$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
			$json['remarketing']['vk_status'] = $this->config->get('remarketing_vk_status');
			$json['remarketing']['quantity'] = $quantity;
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$json['remarketing']['price'] = $this->currency->format($current_price, $this->session->data['currency'], '', false);
			$json['remarketing']['google_price'] = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
			$json['remarketing']['google_conversion_price'] = $this->currency->format($current_price * $this->config->get('remarketing_google_ads_ratio'), $this->config->get('remarketing_google_currency'), '', false);
			$json['remarketing']['facebook_price'] = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
			$json['remarketing']['ecommerce_price'] = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
			$json['remarketing']['brand'] = addslashes($product_info['manufacturer']);
			$json['remarketing']['name'] = addslashes($product_info['name']);
			$json['remarketing']['category'] = addslashes($categories);
			$json['remarketing']['currency'] = $this->session->data['currency'];
			$json['remarketing']['google_currency'] = $this->config->get('remarketing_google_currency');
			$json['remarketing']['facebook_currency'] = $this->config->get('remarketing_facebook_currency');
			$json['remarketing']['ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
			$json['remarketing']['google_remarketing_event'] = [
				'send_to' => $this->config->get('remarketing_google_identifier'),
				'value'   => $json['remarketing']['google_price'],
				'items'   => [[
					'id' => $json['remarketing']['google_product_id'],
					'google_business_vertical' => 'retail'
				]],
			];
			$json['remarketing']['google_ads_event'] = [
				'send_to' => $this->config->get('remarketing_google_ads_identifier_cart'),
				'value'   => $json['remarketing']['google_conversion_price'],
				'currency'   => $this->config->get('remarketing_google_currency')
			];
			$json['remarketing']['facebook_pixel_event'] = [
				'content_name' => $json['remarketing']['name'],
				'content_ids' => [$json['remarketing']['facebook_product_id']],
				'content_type' => 'product',
				'content_category' => $json['remarketing']['category'],
				'value'   => $json['remarketing']['facebook_price'],
				'currency'   => $this->config->get('remarketing_facebook_currency')
			];
			$json['remarketing']['tiktok_event'] = [
				'content_name' => $json['remarketing']['name'],
				'content_id' => $json['remarketing']['product_id'],
				'content_type' => 'product',
				'content_category' => $json['remarketing']['category'],
				'value'   => $json['remarketing']['price'],
				'currency'   => $json['remarketing']['currency']
			];
			$ecommerce_product = [
				'name' => $json['remarketing']['name'],
				'id' => [$json['remarketing']['ecommerce_product_id']],
				'price' => $json['remarketing']['ecommerce_price'],
				'quantity' => $json['remarketing']['quantity']
			];
			if (!empty($json['remarketing']['brand'])) $ecommerce_product['brand'] = $json['remarketing']['brand'];
			if (!empty($json['remarketing']['category'])) $ecommerce_product['category'] = $json['remarketing']['category'];
			$json['remarketing']['ecommerce_product'] = $ecommerce_product;
			
			$json['remarketing']['google_gtag_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
				'value'   => $json['remarketing']['ecommerce_price'] * $json['remarketing']['quantity'],
				'currency'   => $json['remarketing']['ecommerce_currency'],
				'items' => [$json['remarketing']['ecommerce_product']]
			];
			
			$ecommerce_ga4_product = [
				'item_name' => $json['remarketing']['name'],
				'index' => 1,
				'price' => $json['remarketing']['ecommerce_price'],
				'quantity' => $json['remarketing']['quantity']
			];
			if (!empty($json['remarketing']['brand'])) $ecommerce_ga4_product['item_brand'] = $json['remarketing']['brand'];
			if (!empty($json['remarketing']['category'])) $ecommerce_ga4_product['item_category'] = $json['remarketing']['category'];
			$json['remarketing']['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $json['remarketing']['ecommerce_currency'],
				'value' => $json['remarketing']['ecommerce_price'] * $json['remarketing']['quantity'],
				'items' => [$ecommerce_ga4_product]
			];
			
			$fb_time = time();
			$json['remarketing']['time'] = $fb_time;
			//options todo			
			
			if ($this->config->get('remarketing_ecommerce_measurement_status')) {
			if (!empty($this->session->data['uuid'])) {
				$uuid = $this->session->data['uuid'];	
				$ecommerce_data = [
					'ec'    => 'Enhanced Ecommerce',
					'ea'    => 'Adding a Product to a Shopping Cart',
					'ni'    => 1,
					'cu'    => $this->config->get('remarketing_ecommerce_currency'),
					'pa'    => 'add',
					'pr1nm' => $product_info['name'],
					'pr1id' => ($this->config->get('remarketing_ecommerce_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
					'pr1pr' => $json['remarketing']['ecommerce_price'],
					'pr1qt' => $quantity
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_data['pr1br'] = $json['remarketing']['brand'];
				if (!empty($categories)) $ecommerce_data['pr1ca'] = $categories;
		
				$this->model_tool_remarketing->sendEcommerce($ecommerce_data);
			}
			}
			
			if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
				if (!empty($this->session->data['uuid'])) {
				$uuid = $this->session->data['uuid'];		
				$item = [
					// Google refuses id 'item_id' => ($this->config->get('remarketing_ecommerce_ga4_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
					'item_name' => $product_info['name'],
					'affiliation' => $this->config->get('config_name'),
					'price' => $json['remarketing']['ecommerce_price'],
					'currency' => $this->config->get('remarketing_ecommerce_currency'),
					'quantity' => 1,
				];
				if(!empty($json['remarketing']['brand'])) $item['item_brand'] = addslashes($json['remarketing']['brand']);
				if(!empty($categories)) $item['item_category'] = $item['item_list_name'] = addslashes($categories);

				$ecommerce_data = [
					'client_id' => $uuid,
					'events' => [[
						'name' => 'add_to_cart',
						'params' => [
							'currency' => $this->config->get('remarketing_ecommerce_currency'),
							'items' => [$item], 
							'value' => $json['remarketing']['ecommerce_price']
						]],
					],
				];
				
				$this->model_tool_remarketing->sendEcommerceGa4($ecommerce_data);
				}
			}
			
			if ($this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'AddToCart';
				$facebook_data['custom_data'] = [
					'value' => $json['remarketing']['facebook_price'],
					'currency' => $this->config->get('remarketing_facebook_currency'),
					'content_ids' => [
						$json['remarketing']['facebook_product_id']
					],
					'content_name'     => addslashes($product_info['name']),
					'content_category' => $categories,
					'content_type'     => 'product',
					'opt_out'          => false
				];
				$facebook_data['time'] = $fb_time;
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
			
			if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged() && isset($this->session->data['esputnik_email'])) {
				$event = new stdClass();
				$event->eventTypeKey = 'cartUpdated'; 
				$event->keyValue = $this->session->data['esputnik_email'];
				$event->params = [];
				if (isset($this->session->data['esputnik_telephone'])) {
					$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
				}
				$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
				
				$event->params[] = ['name' => 'currencyCode', 'value' => $this->session->data['currency']];
				
				if ($this->customer->isLogged()) {
					$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->isLogged()];

					if ($this->customer->getFirstName()) {
						$event->params[] = ['name' => 'firstName', 'value' => $this->customer->getFirstName()];
					}
					if ($this->customer->getLastName()) {
						$event->params[] = ['name' => 'lastName', 'value' => $this->customer->getLastName()];
					}
				}
				$items = [];
				
				$this->load->model('tool/image');
				$products = $this->cart->getProducts();
				foreach ($products as $product) {
					$items[] = [
						'productId' => $product['product_id'],
						'name'      => $product['name'],
						'quantity'  => $product['quantity'],
						'price'     => $product['price']
					];
				}
				if (!isset($this->session->data['esputnik_uniq'])) {
					$this->session->data['esputnik_uniq'] = uniqid();
				}
				$event->params[] = ['name' => 'recycleStateId', 'value' => $this->session->data['esputnik_uniq']];
				$event->params[] = ['name' => 'products', 'value' => json_encode($items)];
				
				$this->model_tool_remarketing->sendEsputnik($event);
			}
		}
	  

                    $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

                    // Unset all shipping and payment methods
                    unset($this->session->data['shipping_method']);
                    unset($this->session->data['shipping_methods']);
                    unset($this->session->data['payment_method']);
                    unset($this->session->data['payment_methods']);

                    // Totals
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

                    $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
                } else {
                    $json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
                }
            }
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function updateCart()
    {
        $this->cart->update($this->request->post['key'], $this->request->post['quantity']);
        $json['success'] = true;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	public function edit() {
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();
		// Remove
        $this->load->model('catalog/product');
		if (isset($this->request->post['key'])) {
		    if (( isset($this->session->data['promo']['coupon_id']) || isset($this->session->data['promo_gift']['coupon_id']) ) && isset($this->request->post['product_id'])) {
		        $coupon_id = isset($this->session->data['promo']['coupon_id']) ? $this->session->data['promo']['coupon_id'] : $this->session->data['promo_gift']['coupon_id'];
                if ( $this->model_catalog_product->deleteCouponSession($coupon_id, $this->request->post['product_id']) ) {
                    if (isset($this->session->data['promo'])) {
                        unset($this->session->data['promo']);
                    }
                    if (isset($this->session->data['promo_gift'])) {
                        unset($this->session->data['promo_gift']);
                    }
                }
            }
		    if (isset($this->request->post['certificate_id'])) {
		        $this->model_catalog_product->deleteCertificate($this->request->post['certificate_id']);
            }

	    // remarketing all in one
		$this->load->model('tool/remarketing');
	    if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$this->load->model('catalog/product');
			
			foreach ($this->cart->getProducts() as $product) {
				if ($product['cart_id'] == $this->request->post['key']) {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					$quantity = $product['quantity'];
				}
			}
			
			$json['remarketing'] = [];
			if (!empty($product_info)) {
				$categories = $this->model_catalog_product->getRemarketingCategories($product_info['product_id']);
				$json['remarketing']['google_product_id'] = $this->config->get('remarketing_google_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['google_identifier'] = $this->config->get('remarketing_google_identifier');;
				$json['remarketing']['facebook_product_id'] = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['mytarget_product_id'] = $this->config->get('remarketing_mytarget_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['vk_product_id'] = $this->config->get('remarketing_vk_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['vk_identifier'] = $this->config->get('remarketing_vk_identifier');
				$json['remarketing']['ecommerce_product_id'] = $this->config->get('remarketing_ecommerce_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['ecommerce_ga4_product_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
				$json['remarketing']['ecommerce_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
				$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
				$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
				$json['remarketing']['google_status'] = $this->config->get('remarketing_google_status');
				$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
				$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
				$json['remarketing']['vk_status'] = $this->config->get('remarketing_vk_status');
				$json['remarketing']['quantity'] = $quantity; 
				$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				$json['remarketing']['price'] = $this->currency->format($current_price, $this->session->data['currency'], '', false);
				$json['remarketing']['google_price'] = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
				$json['remarketing']['facebook_price'] = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
				$json['remarketing']['ecommerce_price'] = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
				$json['remarketing']['brand'] = addslashes($product_info['manufacturer']);
				$json['remarketing']['name'] = addslashes($product_info['name']);
				$json['remarketing']['category'] = addslashes($categories);
				$json['remarketing']['currency'] = $this->session->data['currency'];
				$json['remarketing']['google_currency'] = $this->config->get('remarketing_google_currency');
				$json['remarketing']['facebook_currency'] = $this->config->get('remarketing_facebook_currency');
				$json['remarketing']['ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
				$ecommerce_product = [
					'name' => $json['remarketing']['name'],
					'id' => [$json['remarketing']['ecommerce_product_id']],
					'price' => $json['remarketing']['ecommerce_price'],
					'quantity' => $json['remarketing']['quantity']
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_product['brand'] = $json['remarketing']['brand'];
				if (!empty($json['remarketing']['category'])) $ecommerce_product['category'] = $json['remarketing']['category'];
				$json['remarketing']['ecommerce_product'] = $ecommerce_product;

				$ecommerce_ga4_product = [
					'item_name' => $json['remarketing']['name'],
					'index' => 1,
					'price' => $json['remarketing']['ecommerce_price'],
					'quantity' => $json['remarketing']['quantity']
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_ga4_product['item_brand'] = $json['remarketing']['brand'];
				if (!empty($json['remarketing']['category'])) $ecommerce_ga4_product['item_category'] = $json['remarketing']['category'];
				$json['remarketing']['ecommerce_ga4_event'] = [
					'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
					'currency' => $json['remarketing']['ecommerce_currency'],
					'items' => [$ecommerce_ga4_product]
				];
				
				$json['remarketing']['google_gtag_event'] = [
					'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
					'value'   => $json['remarketing']['ecommerce_price'],
					'currency'   => $json['remarketing']['ecommerce_currency'],
					'items' => [$json['remarketing']['ecommerce_product']]
				];
			
				if ($this->config->get('remarketing_ecommerce_measurement_status')) {
					if (!empty($this->session->data['uuid'])) {
					$uuid = $this->session->data['uuid'];		
					$ecommerce_data = [
						'ec'    => 'Enhanced Ecommerce',
						'ea'    => 'Removing a Product from a Shopping Cart',
						'ni'    => 1,
						'cu'    => $json['remarketing']['ecommerce_currency'],
						'pa'    => 'remove',
						'pr1nm' => $product_info['name'],
						'pr1id' => ($this->config->get('remarketing_ecommerce_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
						'pr1pr' => $json['remarketing']['ecommerce_price'],
						'pr1qt' => $quantity
					];
					if (!empty($json['remarketing']['brand'])) $ecommerce_data['pr1br'] = $json['remarketing']['brand'];
					if (!empty($categories)) $ecommerce_data['pr1ca'] = $categories;

					$this->model_tool_remarketing->sendEcommerce($ecommerce_data);
					}
				}
				
				if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
					if (!empty($this->session->data['uuid'])) {
					$uuid = $this->session->data['uuid'];		
					$item = [
						// Google refuses id 'item_id' => ($this->config->get('remarketing_ecommerce_ga4_measurement_id') == 'id') ? $product_info['product_id'] : $product_info['model'],
						'item_name' => $product_info['name'],
						'affiliation' => $this->config->get('config_name'),
						'price' => $json['remarketing']['ecommerce_price'],
						'currency' => $this->config->get('remarketing_ecommerce_currency'),
						'quantity' => 1,
					];
					if(!empty($json['remarketing']['brand'])) $item['item_brand'] = addslashes($json['remarketing']['brand']);
					if(!empty($categories)) $item['item_category'] = $item['item_list_name'] = addslashes($categories);

				$ecommerce_data = [
					'client_id' => $uuid,
					'events' => [[
						'name' => 'remove_from_cart',
						'params' => [
							'currency' => $this->config->get('remarketing_ecommerce_currency'),
							'items' => [$item],
							'value' => $json['remarketing']['ecommerce_price']
						]],
					],
				];
				
					$this->model_tool_remarketing->sendEcommerceGa4($ecommerce_data);
				}
			}
				
				if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged() && isset($this->session->data['esputnik_email'])) {
					$event = new stdClass();
					$event->eventTypeKey = 'cartUpdated';
					$event->keyValue = $this->session->data['esputnik_email'];
					$event->params = [];
					if (isset($this->session->data['esputnik_telephone'])) {
						$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
					}
					$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
					
					$event->params[] = ['name' => 'currencyCode', 'value' => $this->session->data['currency']];
					
					if ($this->customer->isLogged()) {
						$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->isLogged()];
					
						if ($this->customer->getFirstName()) {
							$event->params[] = ['name' => 'firstName', 'value' => $this->customer->getFirstName()];
						}
					
						if ($this->customer->getLastName()) {
							$event->params[] = ['name' => 'lastName', 'value' => $this->customer->getLastName()];
						}
					}
					$items = [];
					
					$this->load->model('tool/image');
					$products = $this->cart->getProducts();
					foreach ($products as $product) {
						$items[] = [
							'productId' => $product['product_id'],
							'name'      => $product['name'],
							'quantity'  => $product['quantity'],
							'price'     => $product['price'],
						];
					}
					if (!isset($this->session->data['esputnik_uniq'])) {
						$this->session->data['esputnik_uniq'] = uniqid();
					}
					$event->params[] = ['name' => 'recycleStateId', 'value' => $this->session->data['esputnik_uniq']];
					$event->params[] = ['name' => 'products', 'value' => json_encode($items)];
					
					$this->model_tool_remarketing->sendEsputnik($event);
				}
			}
		}
	  
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);

			$json['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
			unset($this->session->data['certificate_code']);

			// Totals
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

			$json['total'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
			if (!$json['total'] && isset($this->session->data['promo'])) {
			    unset($this->session->data['promo']);
            }
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function promo()
    {
        if (isset($this->request->post['language'])) {
            $language = new Language($this->request->post['language']);
            $language->load($this->request->post['language']);
            $language->load('api/voucher');

            $this->load->model('catalog/product');
            $this->load->model('tool/image');

            $json = [];

            if ((utf8_strlen($this->request->post['promo']) <= 0)) {
                $json['error'] = $language->get('error_voucher');
            }

            $categories = [];

            if ( $this->request->post['categories'] ) {
                $categories = explode(',', $this->request->post['categories']);
            }

            $products = [];

            if ( $this->request->post['products'] ) {
                $products = explode(',', $this->request->post['products']);
            }

            $promo = $this->model_catalog_product->getCertificate($this->request->post['promo'], $categories, $products);
//            print_r(json_encode($promo));exit;

            if ($promo['success'] === false) {
                $json = [
                    'success' => false,
                    'error' => $language->get($promo['error'])
                ];
            } else if ( round( $this->request->post['total'], 2 ) < round( $promo['total'], 2 ) ) {
                $json = [
                    'success' => false,
                    'error' => $language->get('error_code_not_amount')
                ];
            } else if ( date('Y-m-d') > date('Y-m-d', strtotime($promo['date_end'])) ) {
                $json = [
                    'success' => false,
                    'error' => $language->get('error_code_date_not_available')
                ];
            } else if ( array_key_exists('type', $promo) ) {
                if ( $promo['type'] === 'G' ) {
                    $__products__ = [];

                    if ( $promo['products'] ) {
                        foreach ($promo['products'] as $id => $product) {
                            $__products__[] = [
                                'href' => $this->url->link('product/product', 'product_id=' . $id),
                                'name' => $product['name'],
                                'image' => $this->model_tool_image->resize($product['image'], 100, 100)
                            ];
                        }
                    }
                    $json = [
                        'coupon_id'     => $promo['coupon_id'],
                        'text'          => $language->get('text_your_gift'),
                        'type'          => 'gift',
                        'products'      => $__products__,
                    ];

                    $this->session->data['promo_gift'] = $json;

                } else {
                    $_price_ = $promo['type'] === 'F' ? $promo['discount'] : round( $this->request->post['total'] * (int)$promo['discount'] / 100, 2 );
                    if ( array_key_exists('promo_products', $this->session->data) ) {
                        $json['text'] = "Промокод уже действет. \nПовторное использование невозможно.";
                    } else {
                        $json['text'] = 'Промокод успешно применен';
                    }
                    if ( !(int)$promo['sum_order_products'] ) {
                        $this->session->data['promo'] = [
                            'coupon' => true,
                            'sum_order_products'        => $promo['sum_order_products'],
                            'coupon_id'                 => $promo['coupon_id'],
                            'certificate_key'           => $promo['code'],
                            'certificate_price'         => $_price_,
                            'certificate_price_html'    => $this->currency->format($_price_, $this->session->data['currency'])
                        ];
                    } else {
                        $this->session->data['promo_products'] = [
                            'price' => $_price_,
                            'coupon_id'                 => $promo['coupon_id'],
                            'code' => $promo['code'],
                            'products' => $promo['products'],
                            'categories' => $promo['categories'],
                        ];
                    }

                    $json['sum_order_products'] = (int)$promo['sum_order_products'] ? 'products' : 'order';
                }
            } else if (!$promo) {
                $json['error'] = $language->get('error_voucher');
            } else {
                $current_currency = isset($this->session->data['currency']) ? $this->session->data['currency'] : '';
                if ($current_currency !== $promo['current_currency']) {
                    $json['error'] = sprintf($language->get('error_voucher_currency'), $promo['current_currency']);
                } else {
                    $date_expiration = date('Y-m-d', strtotime($promo['date_expiration']));

                    if ($date_expiration < date('Y-m-d')) {
                        $json['error'] = $language->get('error_voucher');
                    } else {
                        $this->session->data['promo'] = [
                            'certificate_key' => $this->request->post['promo'],
                            'certificate_price' => $promo['price'],
                            'certificate_price_html' => $this->currency->format($promo['price'], $this->session->data['currency'])
                        ];
                        // TODO ПЕренести в метод success
                        $this->model_catalog_product->updateCertificateStatus($promo['certificate_id']);
                    }
                }
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }
}
