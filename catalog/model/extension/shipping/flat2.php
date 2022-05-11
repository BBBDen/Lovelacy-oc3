<?php
class ModelExtensionShippingFlat2 extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/flat2');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('shipping_flat_geo_zone_id') . "' AND country_id = '" . (isset($address['country_id']) ? (int)$address['country_id'] : '20') . "' AND (zone_id = '" . (isset($address['zone_id']) ? (int)$address['zone_id'] : '339') . "' OR zone_id = '0')");

		if (!$this->config->get('shipping_flat_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$quote_data['flat2'] = array(
				'code'         => 'flat2.flat2',
				'title'        => $this->language->get('text_description'),
				'cost'         => $this->config->get('shipping_flat2_cost'),
				'tax_class_id' => $this->config->get('shipping_flat_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($this->config->get('shipping_flat2_cost'), $this->config->get('shipping_flat_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'flat2',
				'title'      => $this->language->get('text_title') . '— ' . $this->currency->format($this->tax->calculate($this->config->get('shipping_flat2_cost'), $this->config->get('shipping_flat_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('shipping_flat2_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
