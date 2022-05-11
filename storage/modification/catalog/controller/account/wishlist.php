<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
//			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', true);

//			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/wishlist');

		$this->load->model('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['remove'])) {
			// Remove Wishlist
			$this->model_account_wishlist->deleteWishlist($this->request->get['remove']);

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/wishlist'));
		}

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/wishlist')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();

		if ($this->customer->isLogged()) {

            $results = $this->model_account_wishlist->getWishlist();
        } else {
		    $results = (isset($this->session->data['wishlist']) ? $this->session->data['wishlist'] : []);
        }


        foreach ($results as $result) {
            if ($this->customer->isLogged()) {
                $product_id = $result['product_id'];
            } else {
                $product_id = $result;
            }
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

                $attributes = [];

                if (isset($product_info['special']) && !is_null($product_info['special']) && (float)$product_info['special'] >= 0) {
                    $percent = $product_info['price'] - (($product_info['special'] * 100) / $product_info['price']);

                } else {
                    $percent = false;

                }

                if ($percent) {
                    $attributes[] = [
                        'class' => 'discount',
                        'text' => "-{$percent}%"
                    ];
                }

                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_info['product_id']);

                if ($attribute_groups) {
                    foreach ($attribute_groups as $attribute_group) {
                        if ($attribute_group['attribute'] && (int)$attribute_group['attribute_group_id'] === $this->__get_product_attribute__()) {
                            foreach ($attribute_group['attribute'] as $item) {
                                $attributes[] = [
                                    'class' => $item['name'],
                                    'text' => $item['text']
                                ];
                            }
                        }
                    }
                }

                $product_first_img_from_gallery = $this->model_catalog_product->getProductFirstImage($product_info['product_id']);

                if ($product_first_img_from_gallery) {
                    $hover_image = $this->model_tool_image->resize($product_first_img_from_gallery['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                } else {
                    $hover_image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                }

                if ( array_key_exists('complect', $product_info) && (int)$product_info['complect'] === 1 ) {
                    $results = $this->model_catalog_product->getProductComplect($product_info['product_id']);

                    if ($results && !$product_info['image']) {
                        $image = $this->model_tool_image->resize($results[0]['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));

                        $hover_image = $this->model_tool_image->resize($results[1]['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    }

                    $sum = 0;

                    foreach ($results as $complect) {
                        $sum += ($complect['special'] <= 0 && !$complect['special']) ? $complect['price'] : $complect['special'];
                    }

                    if ($sum && $product_info['price'] <= 0) {
                        $price = $this->currency->format($this->tax->calculate($sum, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    }
                }

				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']),
                    'hover_image' => $hover_image,
                    'attributes'  => $attributes,
				);
			} else {
				$this->model_account_wishlist->deleteWishlist($result['product_id']);
			}
		}

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['text_empty'] = sprintf($this->language->get('text_empty'), $this->url->link('product/category', 'path=' . $this->__get_main_category_id__()));
		$data['text_back_button'] = sprintf($this->language->get('text_back_button'), (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'));

		$this->response->setOutput($this->load->view('account/wishlist', $data));
	}

	public function add() {
		$this->load->language('account/wishlist');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/wishlist');

				$this->model_account_wishlist->addWishlist($this->request->post['product_id']);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = $this->model_account_wishlist->getTotalWishlist() > 0 ? ' added' : '';
			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = isset($this->session->data['wishlist']) ? ' added' : '';
			}
		}


			// remarketing all in one
			$this->load->model('tool/remarketing');
			if ($this->config->get('remarketing_status') && $product_info && !$this->model_tool_remarketing->isBot()) {
				$categories = $this->model_catalog_product->getRemarketingCategories($product_info['product_id']);
				$json['remarketing'] = [];
				$json['remarketing']['facebook_product_id'] = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['ecommerce_product_id'] = $this->config->get('remarketing_ecommerce_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['vk_product_id'] = $this->config->get('remarketing_vk_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['product_id'] = $product_info['product_id'];
				$json['remarketing']['vk_identifier'] = $this->config->get('remarketing_vk_identifier');
				$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
				$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
				$json['remarketing']['vk_status'] = $this->config->get('remarketing_vk_status');
				$json['remarketing']['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
				$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				$json['remarketing']['price'] = $this->currency->format($current_price, $this->session->data['currency'], '', false);
				$json['remarketing']['google_price'] = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
				$json['remarketing']['facebook_price'] = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
				$json['remarketing']['ecommerce_price'] = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
				$json['remarketing']['brand'] = addslashes($product_info['manufacturer']);
				$json['remarketing']['name'] = addslashes($product_info['name']);
				$json['remarketing']['category'] = addslashes($categories);
				$json['remarketing']['currency'] = $this->session->data['currency'];
				$json['remarketing']['quantity'] = 1;
				$json['remarketing']['google_currency'] = $this->config->get('remarketing_google_currency');
				$json['remarketing']['facebook_currency'] = $this->config->get('remarketing_facebook_currency');
				$json['remarketing']['ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
				$fb_time = time();
				$json['remarketing']['time'] = $fb_time;
				$json['remarketing']['google_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
				$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
				$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
				$json['remarketing']['ecommerce_ga4_product_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				
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
				
				$ecommerce_product = [
					'id' => $json['remarketing']['ecommerce_product_id'],
					'name' => $json['remarketing']['name'],
					'price' => $json['remarketing']['ecommerce_price'],
					'quantity' => $json['remarketing']['quantity']
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_product['brand'] = $json['remarketing']['brand'];
				if (!empty($json['remarketing']['category'])) $ecommerce_product['category'] = $json['remarketing']['category'];

				$json['remarketing']['ecommerce_gtag_event'] = [
					'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
					'currency' => $json['remarketing']['ecommerce_currency'],
					'value' => $json['remarketing']['ecommerce_price'],
					'items' => [$ecommerce_product]
				];
				
				if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
					$facebook_data['event_name'] = 'AddToWishlist';
					$facebook_data['custom_data'] = [
						'value' => $json['remarketing']['facebook_price'],
						'currency' => $json['remarketing']['facebook_currency'],
						'content_ids' => [
							$json['remarketing']['facebook_product_id']
						],
						'content_name' => addslashes($product_info['name']),
						'content_category' => $categories,
						'content_type' => 'product',
						'opt_out' => false
					];
					$facebook_data['time'] = $fb_time;
					
					$this->model_tool_remarketing->sendFacebook($facebook_data);
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
						'name' => 'add_to_wishlist',
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
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove()
    {
        $json = [];
        if (!$this->customer->isLogged()) {
            if (isset($this->session->data['wishlist'])) {
                foreach ($this->session->data['wishlist'] as $key => $item) {
                    if ($item === $this->request->post['product_id']) {
                        unset($this->session->data['wishlist'][$key]);
                    }
                }

                $json['total'] = (isset($this->session->data['wishlist']) && count($this->session->data['wishlist'])) ? ' added' : 0;
            }
        } else {
            $this->load->model('account/wishlist');
            $this->model_account_wishlist->deleteWishlist($this->request->post['product_id']);
            $json['total'] = (int)$this->model_account_wishlist->getTotalWishlist() ? ' added' : 0;
        }


			// remarketing all in one
			$this->load->model('tool/remarketing');
			if ($this->config->get('remarketing_status') && $product_info && !$this->model_tool_remarketing->isBot()) {
				$categories = $this->model_catalog_product->getRemarketingCategories($product_info['product_id']);
				$json['remarketing'] = [];
				$json['remarketing']['facebook_product_id'] = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['ecommerce_product_id'] = $this->config->get('remarketing_ecommerce_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['vk_product_id'] = $this->config->get('remarketing_vk_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$json['remarketing']['product_id'] = $product_info['product_id'];
				$json['remarketing']['vk_identifier'] = $this->config->get('remarketing_vk_identifier');
				$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
				$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
				$json['remarketing']['vk_status'] = $this->config->get('remarketing_vk_status');
				$json['remarketing']['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
				$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				$json['remarketing']['price'] = $this->currency->format($current_price, $this->session->data['currency'], '', false);
				$json['remarketing']['google_price'] = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
				$json['remarketing']['facebook_price'] = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
				$json['remarketing']['ecommerce_price'] = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
				$json['remarketing']['brand'] = addslashes($product_info['manufacturer']);
				$json['remarketing']['name'] = addslashes($product_info['name']);
				$json['remarketing']['category'] = addslashes($categories);
				$json['remarketing']['currency'] = $this->session->data['currency'];
				$json['remarketing']['quantity'] = 1;
				$json['remarketing']['google_currency'] = $this->config->get('remarketing_google_currency');
				$json['remarketing']['facebook_currency'] = $this->config->get('remarketing_facebook_currency');
				$json['remarketing']['ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
				$fb_time = time();
				$json['remarketing']['time'] = $fb_time;
				$json['remarketing']['google_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
				$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
				$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
				$json['remarketing']['ecommerce_ga4_product_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				
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
				
				$ecommerce_product = [
					'id' => $json['remarketing']['ecommerce_product_id'],
					'name' => $json['remarketing']['name'],
					'price' => $json['remarketing']['ecommerce_price'],
					'quantity' => $json['remarketing']['quantity']
				];
				if (!empty($json['remarketing']['brand'])) $ecommerce_product['brand'] = $json['remarketing']['brand'];
				if (!empty($json['remarketing']['category'])) $ecommerce_product['category'] = $json['remarketing']['category'];

				$json['remarketing']['ecommerce_gtag_event'] = [
					'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
					'currency' => $json['remarketing']['ecommerce_currency'],
					'value' => $json['remarketing']['ecommerce_price'],
					'items' => [$ecommerce_product]
				];
				
				if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
					$facebook_data['event_name'] = 'AddToWishlist';
					$facebook_data['custom_data'] = [
						'value' => $json['remarketing']['facebook_price'],
						'currency' => $json['remarketing']['facebook_currency'],
						'content_ids' => [
							$json['remarketing']['facebook_product_id']
						],
						'content_name' => addslashes($product_info['name']),
						'content_category' => $categories,
						'content_type' => 'product',
						'opt_out' => false
					];
					$facebook_data['time'] = $fb_time;
					
					$this->model_tool_remarketing->sendFacebook($facebook_data);
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
						'name' => 'add_to_wishlist',
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
	
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
