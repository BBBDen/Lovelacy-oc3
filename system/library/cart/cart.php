<?php
namespace Cart;
class Cart {
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		// Remove all the expired carts with no customer ID
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (api_id > '0' OR customer_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

		if ($this->customer->getId()) {
			// We want to change the session ID on all the old items in the customers cart
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE api_id = '0' AND customer_id = '" . (int)$this->customer->getId() . "'");

			// Once the customer is logged in we want to update the customers cart
			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '0' AND customer_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

			foreach ($cart_query->rows as $cart) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart['product_id'], $cart['quantity'], json_decode($cart['option']), $cart['recurring_id']);
			}
		}
	}

    public function __get_certificate_product_id__()
    {
        return 50;
    }

	public function getProducts() {
		$product_data = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {

			$stock = true;

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;
                $promo_products_coupon_price = 0;

				$option_data = array();
                if ((int)$cart['product_id'] === $this->__get_certificate_product_id__()) {
                    $option_data = json_decode($cart['option'], true);
                } else {
//                    debug($product_query->row);
                    foreach (json_decode($cart['option']) as $product_option_id => $value) {
                        $sql = "SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' ";

                        if ( array_key_exists('complect', $product_query->row) && (int)$product_query->row['complect'] === 1 ) {
                            $sql .= "AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                        } else {
                            $sql .= "AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                        }

                        $option_query = $this->db->query($sql);
                        if ($option_query->num_rows) {
                            if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
                                $option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                                if ($option_value_query->num_rows) {
                                    if ($option_value_query->row['price_prefix'] == '+') {
                                        $option_price += $option_value_query->row['price'];
                                    } elseif ($option_value_query->row['price_prefix'] == '-') {
                                        $option_price -= $option_value_query->row['price'];
                                    }

                                    if ($option_value_query->row['points_prefix'] == '+') {
                                        $option_points += $option_value_query->row['points'];
                                    } elseif ($option_value_query->row['points_prefix'] == '-') {
                                        $option_points -= $option_value_query->row['points'];
                                    }

                                    if ($option_value_query->row['weight_prefix'] == '+') {
                                        $option_weight += $option_value_query->row['weight'];
                                    } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                        $option_weight -= $option_value_query->row['weight'];
                                    }

                                    if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'product_option_id'       => $product_option_id,
                                        'product_option_value_id' => $value,
                                        'option_id'               => $option_query->row['option_id'],
                                        'option_value_id'         => $option_value_query->row['option_value_id'],
                                        'name'                    => $option_query->row['name'],
                                        'value'                   => $option_value_query->row['name'],
                                        'type'                    => $option_query->row['type'],
                                        'quantity'                => $option_value_query->row['quantity'],
                                        'subtract'                => $option_value_query->row['subtract'],
                                        'price'                   => $option_value_query->row['price'],
                                        'price_prefix'            => $option_value_query->row['price_prefix'],
                                        'points'                  => $option_value_query->row['points'],
                                        'points_prefix'           => $option_value_query->row['points_prefix'],
                                        'weight'                  => $option_value_query->row['weight'],
                                        'weight_prefix'           => $option_value_query->row['weight_prefix']
                                    );
                                }
//                                debug($option_data);
                            } elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
                                foreach ($value as $product_option_value_id) {
                                    $option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                                    if ($option_value_query->num_rows) {
                                        if ($option_value_query->row['price_prefix'] == '+') {
                                            $option_price += $option_value_query->row['price'];
                                        } elseif ($option_value_query->row['price_prefix'] == '-') {
                                            $option_price -= $option_value_query->row['price'];
                                        }

                                        if ($option_value_query->row['points_prefix'] == '+') {
                                            $option_points += $option_value_query->row['points'];
                                        } elseif ($option_value_query->row['points_prefix'] == '-') {
                                            $option_points -= $option_value_query->row['points'];
                                        }

                                        if ($option_value_query->row['weight_prefix'] == '+') {
                                            $option_weight += $option_value_query->row['weight'];
                                        } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                            $option_weight -= $option_value_query->row['weight'];
                                        }

                                        if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
                                            $stock = false;
                                        }

                                        $option_data[] = array(
                                            'product_option_id'       => $product_option_id,
                                            'product_option_value_id' => $product_option_value_id,
                                            'option_id'               => $option_query->row['option_id'],
                                            'option_value_id'         => $option_value_query->row['option_value_id'],
                                            'name'                    => $option_query->row['name'],
                                            'value'                   => $option_value_query->row['name'],
                                            'type'                    => $option_query->row['type'],
                                            'quantity'                => $option_value_query->row['quantity'],
                                            'subtract'                => $option_value_query->row['subtract'],
                                            'price'                   => $option_value_query->row['price'],
                                            'price_prefix'            => $option_value_query->row['price_prefix'],
                                            'points'                  => $option_value_query->row['points'],
                                            'points_prefix'           => $option_value_query->row['points_prefix'],
                                            'weight'                  => $option_value_query->row['weight'],
                                            'weight_prefix'           => $option_value_query->row['weight_prefix']
                                        );
                                    }
                                }
                            } elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
                                $option_data[] = array(
                                    'product_option_id'       => $product_option_id,
                                    'product_option_value_id' => '',
                                    'option_id'               => $option_query->row['option_id'],
                                    'option_value_id'         => '',
                                    'name'                    => $option_query->row['name'],
                                    'value'                   => $value,
                                    'type'                    => $option_query->row['type'],
                                    'quantity'                => '',
                                    'subtract'                => '',
                                    'price'                   => '',
                                    'price_prefix'            => '',
                                    'points'                  => '',
                                    'points_prefix'           => '',
                                    'weight'                  => '',
                                    'weight_prefix'           => ''
                                );
                            }
                        }
                    }
                }

                if ((int)$cart['product_id'] === $this->__get_certificate_product_id__()) {
                    $__option__ = json_decode($cart['option'], true);
                    $__price__ = $this->db->query("SELECT price FROM " . DB_PREFIX . "certificate WHERE certificate_key = '".$this->db->escape($__option__['certificate_key'])."' AND session_id = '".$this->db->escape($this->session->getId())."'");
                    $price = $__price__->row['price'];
                } else {
                    if ( array_key_exists('promo_products', $this->session->data) &&
                        $this->session->data['promo_products']['price'] > 0 && (in_array( (int)$product_query->row['product_id'], $this->session->data['promo_products']['products'] ) || ( count($this->session->data['promo_products']['categories']) && $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_query->row['product_id'] . "' AND category_id IN (".implode(',', $this->session->data['promo_products']['categories']).")")->num_rows
                            ) ) ) {
                        $promo_products_coupon_price = $this->session->data['promo_products']['price'];
                    }
                    $price = $product_query->row['price'] - $promo_products_coupon_price;
                }

				// Product Discounts
				$discount_quantity = 0;

				foreach ($cart_query->rows as $cart_2) {
					if ($cart_2['product_id'] == $cart['product_id']) {
						$discount_quantity += $cart_2['quantity'];
					}
				}

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

				if ($product_discount_query->num_rows) {
					$price = $product_discount_query->row['price'];
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

				if ($product_special_query->num_rows) {
					$price = $product_special_query->row['price'];
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Downloads
				$download_data = array();

				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				foreach ($download_query->rows as $download) {
					$download_data[] = array(
						'download_id' => $download['download_id'],
						'name'        => $download['name'],
						'filename'    => $download['filename'],
						'mask'        => $download['mask']
					);
				}

				// Stock
				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
					$stock = false;
				}

				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($recurring_query->num_rows) {
					$recurring = array(
						'recurring_id'    => $cart['recurring_id'],
						'name'            => $recurring_query->row['name'],
						'frequency'       => $recurring_query->row['frequency'],
						'price'           => $recurring_query->row['price'],
						'cycle'           => $recurring_query->row['cycle'],
						'duration'        => $recurring_query->row['duration'],
						'trial'           => $recurring_query->row['trial_status'],
						'trial_frequency' => $recurring_query->row['trial_frequency'],
						'trial_price'     => $recurring_query->row['trial_price'],
						'trial_cycle'     => $recurring_query->row['trial_cycle'],
						'trial_duration'  => $recurring_query->row['trial_duration']
					);
				} else {
					$recurring = false;
				}

				$img = $product_query->row['image'];

				if ( isset($product_query->row['complect']) && (int)$product_query->row['complect'] === 1 && $product_query->row['price'] <= 0 ) {
				    $sum = 0;
                    $results = $this->getProductComplect($product_query->row['product_id']);
                    if ( $results ) {
                        foreach ($results as $result) {
                            $sum += ($result['special'] <= 0 && !$result['special']) ? $result['price'] : $result['special'];
                        }
                    }

                    if ( $sum ) {
                        $price = $sum;
                    }

                    $img = ( isset($results[0]['image']) && $results[0]['image'] ) ? $results[0]['image'] : $product_query->row['image'];
                }

				$product_data[] = array(
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'name'            => $product_query->row['name'],
					'complect'        => $product_query->row['complect'],
					'model'           => $product_query->row['model'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $img,
					'option'          => $option_data,
					'download'        => $download_data,
					'quantity'        => $cart['quantity'],
					'minimum'         => $product_query->row['minimum'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'promo'           => false,
					'price'           => ($price + $option_price),
					'total'           => ($price + $option_price) * $cart['quantity'],
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring
				);
			} else {
				$this->remove($cart['cart_id']);
			}
		}

        $promo_is_enabled = (int)$this->config->get('config_promo');
        $count = 0;
        $products_with_promo = [];
        $admin = array_key_exists('user_id', $this->session->data) && (int)$this->session->data['user_id'] === 1;
        if ( $promo_is_enabled ) {

            $need_promo_categories = [61, 62];
            $__categories__ = [];
            foreach ($product_data as $v) {
                $__categories__[] = [
                    'categories' => $this->getCategoriesPromo($v['product_id']),
                    'product_id' => $v['product_id'],
                    'price' => (array_key_exists('special', $v) && $v['special']) ? $v['special'] : $v['price']
                ];
            }

            $result_promo_products = [];
            for ($c = 0; $c < count( $__categories__ ); $c++) {
                for ($c2 = 0; $c2 < count( $__categories__[$c]['categories'] ); $c2++) {
                    if ( in_array($__categories__[$c]['categories'][$c2], $need_promo_categories) ) {
                        $result_promo_products[$__categories__[$c]['categories'][$c2]][] = [
                            'product_id' => $__categories__[$c]['product_id'],
                            'price' => $__categories__[$c]['price']
                        ];
                        $count++;
                    }
                }
            }
            foreach ($result_promo_products as $result_promo_product) {
                if (count($result_promo_product) === 2) {
                    $search_by_price = array_column($result_promo_product, 'price');
                    $need_index = array_search(min( $search_by_price ), $search_by_price);
                    if ( $need_index !== false ) {
                        $products_with_promo[] = $result_promo_product[$need_index]['product_id'];
                    }
                }
            }
        }

        if ($count === 4 && $products_with_promo) {
            for ($k = 0; $k < count($product_data); $k++) {
                if ( in_array( $product_data[$k]['product_id'], $products_with_promo ) ) {
                    $product_data[$k]['total'] = 0;
                    $product_data[$k]['price'] = 0;
                    $product_data[$k]['promo'] = true;
                    $product_data[$k]['special'] = null;
                }
            }
        }

		return $product_data;
	}

    private function getProductComplect($product_id)
    {
        $product_data = [];

        $query = $this->db->query("SELECT complect_id AS product_id FROM " . DB_PREFIX . "product_to_complect WHERE product_id = '" . (int)$product_id . "'");
        foreach ($query->rows as $res) {
            $product_data[] = $this->getProduct($res['product_id']);
        }

        return $product_data;
    }

    private function getProduct($product_id)
    {
        $query = $this->db->query("SELECT DISTINCT p.price, p.product_id, p.status, p.image, p.complect, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return array(
                'product_id'       => $query->row['product_id'],
                'complect'         => $query->row['complect'],
                'image'            => $query->row['image'],
                'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
                'special'          => $query->row['special'],
                'sort_order'       => $query->row['sort_order'],
                'status'           => $query->row['status'],
            );
        } else {
            return false;
        }
    }

    public function getCategoriesPromo($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        $results = [];

        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $results[] = $row['category_id'];
            }
        }
        return $results;
    }

	public function add($product_id, $quantity = 1, $option = array(), $recurring_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");

		if (!$query->row['total']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cart SET api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "', customer_id = '" . (int)$this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', product_id = '" . (int)$product_id . "', recurring_id = '" . (int)$recurring_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int)$quantity . ") WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");
		}
	}

	public function update($cart_id, $quantity) {
		$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int)$quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function remove($cart_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function clear() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function getRecurringProducts() {
		$product_data = array();

		foreach ($this->getProducts() as $value) {
			if ($value['recurring']) {
				$product_data[] = $value;
			}
		}

		return $product_data;
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->getProducts());
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				return false;
			}
		}

		return true;
	}

	public function hasShipping() {
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				return true;
			}
		}

		return false;
	}

	public function hasDownload() {
		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				return true;
			}
		}

		return false;
	}
}
