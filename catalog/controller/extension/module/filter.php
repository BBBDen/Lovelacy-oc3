<?php
class ControllerExtensionModuleFilter extends Controller {
	public function index() {
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$category_id = end($parts);

		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->load->language('extension/module/filter');

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

			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$data['filter_category'] = array();
			}

			switch ($category_info['category_id']) {
                case 72:
                    $data['text_all_linen'] = $this->language->get('all_access');
                    break;
                case 74:
                    $data['text_all_linen'] = $this->language->get('all_clothes');
                    break;
                default:
                    $data['text_all_linen'] = $this->language->get('all_linen');
            }

			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getRelatedCategoryFilters($category_id);

            $data['category_children'] = [];

			if ((int) $category_id !== (int) $this->__get_main_category_id__()) {
                $children = $this->model_catalog_category->getCategories($category_id);


                if ($children) {
                    foreach ($children as $child) {
                        if ($child['top']) {
                            $filter_data = ['filter_category_id' => $child['category_id'], 'filter_sub_category' => true];

                            $data['category_children'][] = [
                                'href' => $this->url->link('product/category', 'path=' . $category_id . '_' . $child['category_id']),
                                'category_id' => $child['category_id'],
                                'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
                            ];
                        }
                    }
                }
            }

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => $filter['filter_id']
						);

						if ($filter['image'] && $filter['image'] !== 'no_image.png') {
                           $image = $this->model_tool_image->resize($filter['image'], 44, 44);
                        } else {
						    $image = null;
                        }


						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'image'     => $image,
							'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $childen_data
					);
				}
//                debug($data['filter_groups']);

				return $this->load->view('extension/module/filter', $data);
			}
		}
	}

    public function filter()
    {

        if ($this->request->get['filter'] || (array_key_exists('priceFrom', $this->request->get) && array_key_exists('priceTo', $this->request->get))) {
            $this->load->language('product/category');

            $this->load->model('catalog/category');

            $this->load->model('catalog/product');

            $this->load->model('tool/image');

            if ($this->config->get('config_noindex_disallow_params')) {
                $params = explode("\r\n", $this->config->get('config_noindex_disallow_params'));
                if (!empty($params)) {
                    $disallow_params = $params;
                }
            }


            if (isset($this->request->get['filter'])) {
                $filter = $this->request->get['filter'];
                if (!in_array('filter', $disallow_params, true) && $this->config->get('config_noindex_status')) {
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
                $order = 'ASC';
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

            $filter_data = [
                'filter_category_id' => isset($this->request->get['category_id']) ? $this->request->get['category_id'] : $this->__get_main_category_id__(),
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                'language_id' => $this->request->get['language_id'],
                'store_id' => $this->request->get['store_id'],
                'group_id' => $this->request->get['group_id'],
                'price_from' => $this->request->get['priceFrom'],
                'price_to' => $this->request->get['priceTo'],
            ];

            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

            $results = $this->model_catalog_product->getProducts($filter_data);
//            debug($results, true);

            $data['products'] = [];

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if (!is_null($result['special']) && (float)$result['special'] >= 0) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
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

                $product_in_favorite = '';

                if (isset($this->session->data['wishlist']) && in_array($result['product_id'], $this->session->data['wishlist'])) {
                    $product_in_favorite = ' toFavorite_active';
                }

                $data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating' => $result['rating'],
                    'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id']),
                    'hover_image' => $hover_image,
                    'attributes' => $attributes,
                    'wishlist' => $product_in_favorite,
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

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['pagination_page'] = $filter_data['start'] + 1;

            $this->response->setOutput($this->load->view('extension/module/filter_data', $data));
        }
    }
}
