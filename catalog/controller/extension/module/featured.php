<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featured');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

        if (isset($setting['name_title']) && $setting['name_title']) {
            $data['heading_title'] = $setting['name_title'];
        } else {
            $data['heading_title'] = $this->request->language('heading_title');
        }

        if (isset($setting['btn_title']) && $setting['btn_title']) {
            $data['btn_title'] = $setting['btn_title'];
        } else {
            $data['btn_title'] = '';
        }

        if (isset($setting['btn_link']) && $setting['btn_link']) {
            $data['btn_link'] = $setting['btn_link'];
        } else {
            $data['btn_link'] = '';
        }

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
                    $attributes = [];

					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					$product_first_img_from_gallery = $this->model_catalog_product->getProductFirstImage($product_id);

					if ($product_first_img_from_gallery) {
					    $hover_image = $this->model_tool_image->resize($product_first_img_from_gallery['image'], $setting['width'], $setting['height']);
                    } else {
                        $hover_image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                    }

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if (!is_null($product_info['special']) && (float)$product_info['special'] >= 0) {
					    $percent = $product_info['price'] - (($product_info['special'] * 100) / $product_info['price']);
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$tax_price = (float)$product_info['special'];
					} else {
                        $percent = false;
						$special = false;
						$tax_price = (float)$product_info['price'];
					}

					if ($percent) {
					    $attributes[] = [
					        'class' => 'discount',
                            'text' => "-{$percent}%"
                        ];
                    }

                    $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

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
		
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format($tax_price, $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['text_catalog'] = $this->language->get('text_catalog');
					$data['catalog_link'] = '###';


                    $product_in_favorite = '';


                    if ($this->customer->isLogged()) {
                        $this->load->model('account/wishlist');
                        $wishList = $this->model_account_wishlist->getWishlist();

                        $data['wish_lists'] = [];

                        if ($wishList) {
                            foreach ($wishList as $item) {
                                $data['wish_lists'][] = $item['product_id'];
                            }
                        }

                        if ($data['wish_lists'] && in_array($product_info['product_id'], $data['wish_lists'])) {

                            $product_in_favorite = ' toFavorite_active';
                        }
                    } else if (isset($this->session->data['wishlist']) && in_array($product_info['product_id'], $this->session->data['wishlist'])) {
                        $product_in_favorite = ' toFavorite_active';
                    }
					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'hover_image' => $hover_image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'attributes'  => $attributes,
						'rating'      => $rating,
						'wishlist'    => $product_in_favorite,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
	}
}
