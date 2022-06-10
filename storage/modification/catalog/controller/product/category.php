<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/font-awesome/css/font-awesome.min.css');

		$data['text_empty'] = $this->language->get('text_empty');

        if ($this->config->get('config_noindex_disallow_params')) {
            $params = explode ("\r\n", $this->config->get('config_noindex_disallow_params'));
            if(!empty($params)) {
                $disallow_params = $params;
            }
        }

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
			if (!in_array('filter', $disallow_params, true) && $this->config->get('config_noindex_status')){
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
            if (!in_array('sort', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
            if (!in_array('order', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
            if (!in_array('page', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
            if (!in_array('limit', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
		    $data['request_path'] = $this->request->get['path'];

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
            $data['request_path'] = $this->__get_main_category_id__();
		}

		$data['store_id'] = $this->config->get('config_store_id');
		$data['group_id'] = $this->config->get('config_customer_group_id');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		$data['main_category'] =  $this->url->link('product/category', 'path=' . $this->__get_main_category_id__());

		if ($category_info) {

			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			if ($category_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');
			$data['description_more'] = $this->language->get('text_more');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
//			debug($filter_data);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

	  $data['remarketing_google_ids'] = [];
	  $data['remarketing_facebook_ids'] = [];
	  $data['remarketing_target_ids'] = [];
	  $data['remarketing_vk_ids'] = [];
	  

			$results = $this->model_catalog_product->getProducts($filter_data);
//			debug($results);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'] ? $result['price'] : 0, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if (!is_null($result['special']) && (float)$result['special'] >= 0) {
					$special = $this->currency->format($this->tax->calculate($result['special'] ? $result['special'] : 0, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$tax_price = (float)$result['special'];
				} else {
					$special = false;
					$tax_price = (float)$result['price'];
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format($tax_price, $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$attributes = [];

                if (!is_null($result['special']) && (float)$result['special'] >= 0) {
                    $percent = $this->__get_percent__($result['price'], $result['special']);
                    $_special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $tax_price = (float)$result['special'];
                } else {
                    $percent = false;
                    $_special = false;
                    $tax_price = (float)$result['price'];
                }

                if ($percent) {
                    $attributes[] = [
                        'class' => 'discount',
                        'text' => "-{$percent}%"
                    ];
                }

                $attribute_groups = $this->model_catalog_product->getProductAttributes($result['product_id']);

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

                $product_first_img_from_gallery = $this->model_catalog_product->getProductFirstImage($result['product_id']);

                if ($product_first_img_from_gallery) {
                    $hover_image = $this->model_tool_image->resize($product_first_img_from_gallery['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                } else {
                    $hover_image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                }

                if ( (int)$result['complect'] ) {
                    $sum = 0;
                    $complects = $this->model_catalog_product->getProductComplect($result['product_id']);
//				    debug($complects);
                    if ( isset($complects[0]['image']) && $complects[0]['image'] ) {
                        $image = $this->model_tool_image->resize($complects[0]['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    }

                    if ( isset($complects[1]['image']) && $complects[1]['image'] ) {
                        $hover_image = $this->model_tool_image->resize($complects[1]['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    }
                    if ( $complects ) {
                        foreach ($complects as $complect) {
                            $sum += ($complect['special'] <= 0 && !$complect['special']) ? $complect['price'] : $complect['special'];
                        }
                    }

                    if ($sum && $result['price'] <= 0) {
                        $price = $this->currency->format($this->tax->calculate($sum, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    }
                }

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

                    if ($data['wish_lists'] && in_array($result['product_id'], $data['wish_lists'])) {

                        $product_in_favorite = ' toFavorite_active';
                    }
                } else if (isset($this->session->data['wishlist']) && in_array($result['product_id'], $this->session->data['wishlist'])) {
                    $product_in_favorite = ' toFavorite_active';
                }


	  $data['remarketing_google_ids'][] = $this->config->get('remarketing_google_id') == 'id' ? $result['product_id'] : $result['model'];
	  $data['remarketing_facebook_ids'][] = $this->config->get('remarketing_facebook_id') == 'id' ? $result['product_id'] : $result['model'];
	  $data['remarketing_target_ids'][] = $this->config->get('remarketing_mytarget_id') == 'id' ? $result['product_id'] : $result['model'];
	  $data['remarketing_vk_ids'][] = $this->config->get('remarketing_vk_id') == 'id' ? $result['product_id'] : $result['model'];
	  
				$data['products'][] = array(

	 'manufacturer'    => !empty($result['manufacturer']) ? $result['manufacturer'] : '',
	 'brand'           => !empty($result['manufacturer']) ? $result['manufacturer'] : '',
	 'product_id'      => $result['product_id'],
	 'model'           => $result['model'],
	 'clear_price'     => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->session->data['currency'], '', false),
	 'google_price'    => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_google_currency'), '', false),
	 'facebook_price'  => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_facebook_currency'), '', false),
	 'ecommerce_price' => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_ecommerce_currency'), '', false),
	  
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
                    'hover_image' => $hover_image,
                    'attributes'  => $attributes,
                    'wishlist'    => $product_in_favorite,
				);
			}
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['category_id'] = $category_id;

			$data['sorts'] = array();

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_name_asc'),
                'value' => 'p.sort_order-DESC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=DESC' . $url)
            );

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.popular-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.popular&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_date_available'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.date_added&order=DESC' . $url)
			);



//			$data['sorts'][] = array(
//				'text'  => $this->language->get('text_name_desc'),
//				'value' => 'pd.name-DESC',
//				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
//			);


            $data['sorts'][] = array(
                'text'  => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );


//			if ($this->config->get('config_review_status')) {
//				$data['sorts'][] = array(
//					'text'  => $this->language->get('text_rating_desc'),
//					'value' => 'rating-DESC',
//					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
//				);
//
//				$data['sorts'][] = array(
//					'text'  => $this->language->get('text_rating_asc'),
//					'value' => 'rating-ASC',
//					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
//				);
//			}
//
//			$data['sorts'][] = array(
//				'text'  => $this->language->get('text_model_asc'),
//				'value' => 'p.model-ASC',
//				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
//			);
//
//			$data['sorts'][] = array(
//				'text'  => $this->language->get('text_model_desc'),
//				'value' => 'p.model-DESC',
//				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
//			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

	  // remarketing all in one
	  $search_page = (!empty($this->request->get['route']) && $this->request->get['route'] == 'product/search' && !empty($this->request->get['search'])) ? true : false;
	  if (empty($data['heading_title'])) $data['heading_title'] = $this->language->get('heading_title');
	  
	  $data['remarketing_target_code'] = '';
	  $data['facebook_remarketing_code'] = '';
	  $data['target_page'] = 'category';
	  $data['google_page'] = 'view_item_list';
	  $data['vk_page'] = 'view_category';
	  $data['remarketing_vk_code'] = '';
	  
	  if ($search_page) {
	      $data['google_page'] = 'view_search_results';
	      $data['target_page'] = 'category';
		  $data['vk_page'] = 'view_search';
		  $data['view_search_results'] = true;
		  $data['search_term'] = $this->request->get['search'];
	  }
	  
	  $this->load->model('tool/remarketing');
	  
	  if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
	  if ($this->config->get('remarketing_google_status') && $this->config->get('remarketing_google_identifier')) {
		  $data['remarketing_google_json'] = [];
		  if ($data['google_page']) {
			$items = [];
			if (isset($data['remarketing_google_ids']) && count($data['remarketing_google_ids']) > 0) {
				foreach ($data['remarketing_google_ids'] as $item) {
					$items[] = [
						'id' => $item, 
						'google_business_vertical' => 'retail'
					];
				}
			}
			$data['remarketing_google_json'] = [
				'event' => $data['google_page'],
				'data'  => [
					'send_to' => $this->config->get('remarketing_google_identifier'),
					'items'   => $items
				]
			];
			}
	  }
	  
	  $fb_time = time();
	   
	  if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_identifier') && $this->config->get('remarketing_facebook_pixel_status')) {
	  	  $data['facebook_remarketing_status'] = true;
	  	  $data['facebook_remarketing_code'] .= '<script>' . "\n";
	  	  $data['facebook_remarketing_code'] .= "$(document).ready(function() {" . "\n";
	  	  $data['facebook_remarketing_code'] .= "if (typeof fbq != 'undefined') {"."\n";
		  if (!$search_page) {
			  $data['facebook_remarketing_code'] .= "fbq('trackCustom', 'ViewCategory', {" . "\n";
		  } else {
			  $data['facebook_remarketing_code'] .= "fbq('track', 'Search', {" . "\n";
			  $data['facebook_remarketing_code'] .= "search_string: '" . $this->request->get['search'] . "'," . "\n";
		  }
	  	  $data['facebook_remarketing_code'] .= "content_name: '" . $data['heading_title'] . "'," . "\n";
	  	  if (!empty($data['remarketing_facebook_ids'])) {
			  $data['facebook_remarketing_code'] .= "content_ids: ['" . implode('\',\'', $data['remarketing_facebook_ids']) . "']," . "\n";
	  	  }
	  	  $data['facebook_remarketing_code'] .= "content_type: 'product'," . "\n";
	  	  $data['facebook_remarketing_code'] .= "currency: '" . $this->config->get('remarketing_facebook_currency') ."'," . "\n";
	  	  $data['facebook_remarketing_code'] .= "value: 0" . "\n";
	  	  $data['facebook_remarketing_code'] .= '}, {eventID: ' . $fb_time . '})}});' . "\n</script>\n";
	  }
	
	  if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
		  $data['facebook_remarketing_status'] = true;
		  $content_ids = [];
		  if (isset($data['remarketing_facebook_ids']) && count($data['remarketing_facebook_ids']) > 0) {
			foreach ($data['remarketing_facebook_ids'] as $id) {
				$content_ids[] = $id;
			}
	  	  }
		if (!$search_page) {
			$data['facebook_data_json_category']['products'] = [
				'value'            => 0,
				'currency'         => $this->config->get('remarketing_facebook_currency'),
				'content_ids'      => $content_ids,
				'content_type'     => 'product',
				'content_name'     => addslashes($data['heading_title']),
				'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
				'opt_out'          => false
			];
		} else {
			$data['facebook_data_json_category']['products'] = [
				'value'            => 0,
				'currency'         => $this->config->get('remarketing_facebook_currency'),
				'content_ids'      => $content_ids,
				'content_type'     => 'product',
				'content_name'     => addslashes($data['heading_title']),
				'search_string'    => $this->request->get['search'],
				'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
				'opt_out'          => false
			];
		}
		$data['facebook_data_json_category']['time'] = $fb_time;
	  }
	  
	  if ($this->config->get('remarketing_mytarget_status') && $this->config->get('remarketing_mytarget_identifier') && $data['target_page']) {	
		  if (count($data['remarketing_target_ids']) > 1) {
			  $target_itemid = '[\'' . implode('\',\'', $data['remarketing_target_ids']) . '\']';
		  } elseif (!empty($data['remarketing_target_ids'])) {
			  $target_itemid = "'" . $data['remarketing_target_ids'][0] . "'";
		  } else {
	          $target_itemid = '';
		  }
		  $data['remarketing_target_code'] .= '<!-- Rating@Mail.ru counter dynamic remarketing appendix -->' . "\n";
		  $data['remarketing_target_code'] .= '<script>' . "\n";
		  $data['remarketing_target_code'] .= 'var _tmr = _tmr || [];' . "\n";
		  $data['remarketing_target_code'] .= '_tmr.push({' . "\n";
		  $data['remarketing_target_code'] .= "type: 'itemView'," . "\n";
		  if (!empty($target_itemid)) $data['remarketing_target_code'] .= "productid: " . $target_itemid . "," . "\n";
		  if (!empty($data['target_page'])) $data['remarketing_target_code'] .= "pagetype: '" . $data['target_page'] . "'," . "\n"; 
		  $data['remarketing_target_code'] .= "list: '" . $this->config->get('remarketing_mytarget_identifier') . "'," . "\n";
		  $data['remarketing_target_code'] .= '});' . "\n"; 
		  $data['remarketing_target_code'] .= '</script>' . "\n";
		  $data['remarketing_target_code'] .= '<!-- // Rating@Mail.ru counter dynamic remarketing appendix -->' . "\n";
	  }
	  
	  if ($this->config->get('remarketing_vk_status') && $this->config->get('remarketing_vk_identifier') && $data['vk_page']) {	
		  if (!empty($data['products'])) {
			 $eventParams = [];
			 $eventParams['currency_code'] = $this->session->data['currency'];
			 foreach ($data['products'] as $product) {
			 $eventParams['products'][] = [
				'id'    =>  $this->config->get('remarketing_vk_id') == 'id' ? $result['product_id'] : $result['model'],
				'price' => $product['clear_price']
				]; 
			 }
			 $data['remarketing_vk_code'] .= '<script>' . "\n";
			 $data['remarketing_vk_code'] .= "$(document).ready(function() { setTimeout(function() { if (typeof VK != 'undefined') {" . "\n";
			 $data['remarketing_vk_code'] .= "VK.Retargeting.ProductEvent(" . $this->config->get('remarketing_vk_identifier') . ", '" . $data['vk_page'] . "', " . json_encode($eventParams) . ");" . "\n";
			 $data['remarketing_vk_code'] .= '}}, 1000)})' . "\n";
			 $data['remarketing_vk_code'] .= '</script>' . "\n";
		  }
	  }
	
	if ($this->config->get('remarketing_ecommerce_status') || $this->config->get('remarketing_ecommerce_measurement_status') || $this->config->get('remarketing_ecommerce_gtag_status')) {
			$data['remarketing_ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$data['remarketing_ecommerce_gtag_status'] = $this->config->get('remarketing_ecommerce_gtag_status');
			$data['remarketing_ecommerce_json'] = [];
			$data['measurement_status'] = $this->config->get('remarketing_ecommerce_measurement_status');
			$currency = $this->config->get('remarketing_ecommerce_currency');
			$i = 0;
			foreach ($data['products'] as $product) {
				$data['remarketing_ecommerce_json'][$i] = [];
				$data['remarketing_ecommerce_json'][$i]['name'] = addslashes($product['name']);
				$data['remarketing_ecommerce_json'][$i]['id'] = ($this->config->get('remarketing_ecommerce_id') == 'id' ? $product['product_id'] : $product['model']);
				$data['remarketing_ecommerce_json'][$i]['price'] = $product['ecommerce_price'];
				$data['remarketing_ecommerce_json'][$i]['brand'] = addslashes($product['brand']);
				$data['remarketing_ecommerce_json'][$i]['list'] = addslashes($data['heading_title']);
				$data['remarketing_ecommerce_json'][$i]['list_name'] = addslashes($data['heading_title']);
				$data['remarketing_ecommerce_json'][$i]['currency'] = $currency;
				$data['remarketing_ecommerce_json'][$i]['category'] = addslashes($data['heading_title']);
				$data['remarketing_ecommerce_json'][$i]['position'] = $i+1;
				$i++; 
			}
			
			if ($this->config->get('remarketing_ecommerce_gtag_status')) {
				$data['gtag_event'] = $search_page ? 'view_search_results' : 'view_item_list';
				$data['gtag_event_params'] = [
					'send_to' => $this->config->get('remarketing_ecommerce_analytics_id'),
					'items' => $data['remarketing_ecommerce_json']
				];
				if ($search_page) $data['gtag_event_params']['search_term'] = $data['search_term'];
			}			
		
			$data['ecommerce_selector'] = $this->config->get('remarketing_ecommerce_selector');
		}
		
		
		
		if ($this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$data['ecommerce_ga4_status'] = true;
			$data['remarketing_ecommerce_ga4_json'] = [];
			$data['measurement_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_measurement_status');
			
			$currency = $this->config->get('remarketing_ecommerce_currency');
			$i = 0;
			foreach ($data['products'] as $product) {
				$data['remarketing_ecommerce_ga4_json'][$i] = [];
				$data['remarketing_ecommerce_ga4_json'][$i]['item_name'] = addslashes($product['name']);
				$data['remarketing_ecommerce_ga4_json'][$i]['item_id'] = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product['product_id'] : $product['model']);
				$data['remarketing_ecommerce_ga4_json'][$i]['price'] = $product['ecommerce_price'];
				if (!empty($product['brand'])) $data['remarketing_ecommerce_ga4_json'][$i]['item_brand'] = addslashes($product['brand']);
				$data['remarketing_ecommerce_ga4_json'][$i]['item_list_name'] = addslashes($data['heading_title']);
				$data['remarketing_ecommerce_ga4_json'][$i]['item_category'] = addslashes($data['heading_title']);
				$data['remarketing_ecommerce_ga4_json'][$i]['index'] = $i+1;
				$data['remarketing_ecommerce_ga4_json'][$i]['quantity'] = 1;
				$i++;
			}

			$data['remarketing_ecommerce_ga4_selector'] = $this->config->get('remarketing_ecommerce_ga4_selector');
		}
		
		if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
			$data['esputnik_remarketing_status'] = true;
			$data['esputnik_data_category_json'] = [
				'productCategoryId' => addslashes($data['heading_title'])
			];
		} 
	}

	  

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            if (!$this->config->get('config_canonical_method')) {
                // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
                if ($page == 1) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'canonical');
                } elseif ($page == 2) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'prev');
                } else {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1)), 'prev');
                }

                if ($limit && ceil($product_total / $limit) > $page) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1)), 'next');
                }
            } else {

                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $server = $this->config->get('config_ssl');
                } else {
                    $server = $this->config->get('config_url');
                };

                $request_url = rtrim($server, '/') . $this->request->server['REQUEST_URI'];
                $canonical_url = $this->url->link('product/category', 'path=' . $category_info['category_id']);

                if (($request_url != $canonical_url) || $this->config->get('config_canonical_self')) {
                    $this->document->addLink($canonical_url, 'canonical');
                }

                if ($this->config->get('config_add_prevnext')) {

                    if ($page == 2) {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'prev');
                    } elseif ($page > 2)  {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1)), 'prev');
                    }

                    if ($limit && ceil($product_total / $limit) > $page) {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1)), 'next');
                    }
                }
            }

            $data['config_catalog_limit'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
            $data['category_data'] = $category_id;
            $data['url_category'] = $this->url->link('product/category/more');
            $data['path'] = $this->request->get['path'];
            $data['filter'] = $filter;
            $data['ttl'] = $product_total;
            $data['page'] = $page;

            if ((int) ($product_total / $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit')) === (int) $page) {
                $data['render_btn'] = 'hide';
            } else {
                $data['render_btn'] = 'show';
            }

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

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

}
