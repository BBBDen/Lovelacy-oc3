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

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
